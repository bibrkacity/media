<?php

namespace App\Http\Controllers\Api\V1\Citations;

use App\Http\Controllers\Api\V1\ApiController;
use App\Models\Citation;
use App\Services\CitationService;
use App\Services\MessengerBase;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;

class CitationController extends ApiController
{

    /**
     * @OA\Get(
     *     path="/citations",
     *     summary="List of citations",
     *     description="List of citations",
     *     tags={"Citations"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *          name="page",
     *          description="Page number",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="integer",
     *              default=1,
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="per_page",
     *          description="Coint of citations in list",
     *          required=false,
     *          in="query",
     *          @OA\Schema(
     *              type="integer",
     *              default=25,
     *          )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="The list of citations",
     *     )
     * )
     */
    public function index(Request $request): \Illuminate\Http\JsonResponse
    {
        try{
            $http_code = 200;
            $rules = [
                'page' => 'integer:min:1',
                'per_page' => 'integer|min:1',
            ];

            $validator = Validator::make($request->all(), $rules );
            if($validator->fails())            {
                throw new ValidationException($validator);
            }

            $page = isset($request->page) ? (int)$request->page : 1;
            $per_page = isset($request->per_page) ? (int)$request->per_page : 25;

            $data = [];
            $data['citations'] = CitationService::index_api($page, $per_page);

        } catch(ValidationException $e){
            $data= ['errors' => $e->getMessage()];
            $http_code = 423;
        } catch(\Exception $e){
            $data= ['errors' => $e->getMessage()];
            $http_code = 400;
        }

        return response()->json($data,$http_code);
    }

    /**
     * @OA\Put(
     *     path="/citations",
     *     summary="Update citation",
     *     description="Update citation",
     *     tags={"Citations"},
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *          name="citation_id",
     *          description="Id of citation in table `citations`",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="integer",
     *          )
     *      ),
     *     @OA\Parameter(
     *          name="citation",
     *          description="Text of citation",
     *          required=true,
     *          in="query",
     *          @OA\Schema(
     *              type="string",
     *          )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="The list of citations",
     *     )
     * )
     */
    public function update(Request $request): \Illuminate\Http\JsonResponse
    {
        try{
            $http_code = 200;
            $rules = [
                'citation_id'   => 'required|integer|exists:citations,id',
                'citation'      => 'required|string|max:500',
            ];
            $validator = Validator::make($request->all() , $rules);

            if( $validator->fails() )
                throw new ValidationException($validator);

            $citation_id = (int)$request->citation_id;

            $citation = Citation::find($citation_id);
            $citation->citation = $request->citation;
            $citation->save();
            $data = [];
        } catch(ValidationException $e){
            $data= ['errors' => $e->getMessage()];
            $http_code = 423;
        } catch(\Exception $e){
            $data= ['errors' => $e->getMessage()];
            $http_code = 400;
        }
        return response()->json($data,$http_code);
    }

    public function store(Request $request): \Illuminate\Http\JsonResponse
    {
        try{
            $http_code = 200;
            $rules = [
                'citation'=>'required|string|max:500|unique:App\Models\Citation,citation',
            ];
            $validator = Validator::make($request->all() , $rules);

            if( $validator->fails() )
                throw new ValidationException($validator);

            $citation = Citation::create([
                'user_id'   =>  Auth::id(),
                'citation'  => $request->citation,
            ]);
            $data = [
                'citation' => $citation
            ];


        } catch(ValidationException $e){
            $data= ['errors' => $e->getMessage()];
            $http_code = 423;
        } catch(\Exception $e){
            $data= ['errors' => $e->getMessage()];
            $http_code = 400;
        }
        return response()->json($data,$http_code);
    }

}
