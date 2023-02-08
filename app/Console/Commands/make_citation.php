<?php

namespace App\Console\Commands;

use App\Models\Citation;
use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Symfony\Component\Console\Command\Command as CommandAlias;

class make_citation extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:citation'; // {citation:Text of citation} {user_id:id of user-creator}

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add citation to table `citations`';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        try{
            $input = [];
            $input['citation'] = $this->ask('Input text of citation');
            $input['user_id'] = $this->ask('Input user-creator id');

            $rules=[
                'citation' =>'required|string|max:500|unique:App\Models\Citation,citation',
                'user_id' =>'required|integer|exists:App\Models\User,id',
            ];
            $validator = Validator::make($input, $rules);

            if( $validator->fails() )
                throw new ValidationException($validator);

            $citation = Citation::create([
                'user_id'   => $input['user_id'],
                'citation'  => $input['citation'],
            ]);

            $this->info('The citation was successfully asdded, `id`='.$citation->id);

            return CommandAlias::SUCCESS;
        }catch(Exception|ValidationException $e){
            $this->error( $e->getMessage() );
            return CommandAlias::FAILURE;
        }

    }
}
