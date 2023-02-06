<?php

namespace App\Http\Controllers\Citations;

use App\Http\Controllers\Controller;
use App\Models\Citation;
use App\Models\User;
use App\Services\CitationService;
use App\Services\MessengerBase;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class CitationController extends Controller
{

    public function index( string $per_page='25'): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        try{
            $perPage = (int)$per_page;
            $perPage = $perPage ? $perPage :25;

            $data=['error' => ''];
            $paginator = CitationService::index_web($perPage);
            $data['citations'] = $paginator->items();
            $data['links'] = $paginator->links('vendor.pagination.simple-tailwind');
            $data['messengers'] = CitationService::messengers();

        }
        catch(\Exception $e){
            \Log::info( $e->getMessage() . "\nfile " . $e->getFile() . "\nline ".$e->getLine() );
            $data['error'] = 'Unexpected error: '.$e->getMessage();
        }

        return view('citations.index', ['data'=>$data]);
    }

    public function create(): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        return view('citations.create');
    }

    public function edit(string $id): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {
        $citation_id = (int)$id;

        $citation = Citation::find($citation_id);

        $data = [
            'id' => $citation_id,
            'citation' => $citation->citation
        ];

        return view('citations.edit',['data' => $data]);
    }

    public function update(string $id, Request $request): \Illuminate\Http\RedirectResponse
    {
        try{
            $rules = [
                'citation'=>'required|string|max:500',
            ];
            $validator = Validator::make($request->all() , $rules);

            if( $validator->fails() )
                return response()->redirectTo( route('citations.create') )
                    ->withErrors($validator);

            $citation_id = (int)$id;

            $citation = Citation::find($citation_id);
            $citation->citation = $request->citation;
            $citation->save();

            return response()->redirectTo( route( 'citations.edit',['id'=>$citation->id] ) );

        } catch(QueryException $e){
            return response()->redirectTo( route('citations.edit',['id'=>$citation_id]) )
                ->withErrors('Changes are not saved: perhaps non-unique text');
        } catch(\Exception $e){
            return response()->redirectTo( route('citations.edit',['id'=>$citation_id]) )
                ->withErrors(get_class($e).' '.$e->getMessage());
        }
    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        try{
            $rules = [
                'citation'=>'required|string|max:500|unique:App\Models\Citation,citation',
            ];
            $validator = Validator::make($request->all() , $rules);

            if( $validator->fails() )
                return response()->redirectTo( route('citations.create') )
                    ->withErrors($validator);

            $citation = Citation::create([
                'user_id'   =>  Auth::id(),
                'citation'  => $request->citation,
            ]);
            return response()->redirectTo( route( 'citations.edit',['id'=>$citation->id] ) );

        } catch(\Exception $e){
            return response()->redirectTo( route('citations.create') )
                ->withErrors($e->getMessage());
        }
    }

    public  function send_fields(Request $request): string
    {
        $name = $request->name;
        $messenger = MessengerBase::createInstance($name);
        $html = '';
        if($messenger)
            $html = $messenger->form_fields();

        return $html;
    }

    public  function send(Request $request): \Illuminate\Http\JsonResponse
    {
        try{

            $data = [
                'status'=>MessengerBase::SENT
            ];

            $http_code = 200;

            $input = $request->all();

            $rules = [
                'citation_id' => 'required|integer|min:1',
                'messenger_name' => 'required|string',
            ];
            $validator = Validator::make($input , $rules);
            if( $validator->fails() )
                throw new ValidationException($validator);

            $messenger = MessengerBase::createInstance($request->messenger_name);

            $rules = $messenger->rules();
            $validator = Validator::make($input , $rules);
            if( $validator->fails() )
                throw new ValidationException($validator);

            $citation = Citation::find($input['citation_id']);

            $address_name = $messenger->address_field_name;
            $address = $input[$address_name];

            $status = $messenger->send($address, $citation->citation );

            $citation->Messengers()->attach($messenger->id,[
                    'user_id'=>Auth::id(),
                    'address'=>$address,
                    'status'=>$status,
                ]);

            $data['status'] = $status;

        }catch(Exception|ValidationException $e){
            $data['error'] = $e->getMessage();
            $http_code=400;
        }

        return response()->json($data, $http_code);
    }

}
