<?php

namespace  App\Services;

abstract class MessengerBase
{
    const SENT      = 1;
    const FAILED    = 2;
    const SUCCESS   = 2;

    protected int $id;
    protected int $name;

    protected abstract function send_in_socket( string $address, string $message) : int;

    /**
     * Create object of class messenger (namespace App\Services\Messengers)
     * @param int|string $messenger Value of field of table messengers: `id` if int, `name` id string
     * @return object|null
     */
    public static function createInstance(int|string $messenger) : object|null
    {
        $obj = null;
        if( is_int($marker) ){
            $obj = self::createInstanceInt($marker);
        }
        elseif( is_string($marker ) ){
            $obj = self::createInstanceString($marker);
        }

        return $obj;

    }

    public static function send(string $address, string $message, int|string $messenger) : int
    {
        $status = 0;
        try{

            self::send_to_socket($address, $message,$messenger);
            $status = self::SENT;

        } catch(\Exception $e){
            $status = self::SENT;
        }

    }

    protected static function send_to_socket(string $address, string $message, int|string $messenger)
    {
    }

    protected static function createInstanceInt(int $marker): object|null
    {
    }

    protected static function createInstanceString(string $marker): object|null
    {
    }


}
