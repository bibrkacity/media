<?php

namespace  App\Services;

use App\Models\Messenger;
use Exception;
use Illuminate\Http\Request;

abstract class MessengerBase
{
    const SENT      = 1;
    const FAILED    = 2;
    const SUCCESS   = 2;

    protected int $id;
    protected string $name;
    protected string $display_name;

    /**
     * Sending of citation
     * @param string $address
     * @param string $message
     * @return int
     */
    protected abstract function send(string $address, string $message) : int;

    /**
     * Part of form for send a citation
     * @param int $citation_id id of citation
     * @return string
     */
    public abstract function form_fields() : string;


    /**
     * Create object of class messenger (namespace App\Services\Messengers)
     * @param string $messengerName Value of field of table messengers: `name`
     * @return object|null
     */
    public static function createInstance(string $messengerName) : object|null
    {
        $className = '\App\Services\Messengers\\'.$messengerName;
        \Log::info($className);
        if(class_exists($className)){
            return new $className();
        }
        else
            return null;
    }

    public static function submit(Request $request) : void
    {
        try{

        } catch(Exception $e){

        }
    }

    protected function store()
    {

    }


}
