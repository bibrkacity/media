<?php

namespace  App\Services;

use App\Models\Messenger;
use Exception;
use Illuminate\Http\Request;

abstract class MessengerBase
{
    const SENT      = 1;
    const FAILED    = 2;
    const SUCCESS   = 3;


    protected int $id;
    protected string $name;
    protected string $display_name;
    protected string $address_field_name;

    public function __get($property)
    {
        if(property_exists($this, $property))
            return $this->$property;
    }

    /**
     * Sending of message
     * @param string $address
     * @param string $message
     * @return int
     */
    public abstract function send(string $address, string $message) : int;

    /**
     * Part of form for send a citation
     * @return string
     */
    public function form_fields():string
    {
        return <<<QWE
        <div>
            <div>E-mail</div>
            <div><input type="email" name="$this->address_field_name" /></div>
        </div>
QWE;
    }

    /**
     * Rules for validation of send-form
     * @return array
     */
    public abstract function rules() : array;

    /**
     * Create object of class messenger (namespace App\Services\Messengers)
     * @param string $messengerName Value of field of table messengers: `name`
     * @return object|null
     */
    public static function createInstance(string $messengerName) : object|null
    {
        $className = '\App\Services\Messengers\\'.$messengerName;
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
