<?php
namespace  App\Services\Messengers;

use App\Services\MessengerBase;

class email extends MessengerBase
{
    public function __construct()
    {
        $this->id = 3;
        $this->name = 'email';
        $this->display_name = 'E-mail';
        $this->address_field_name = 'email';
    }

    public function form_fields():string
    {
        return parent::form_fields();
    }

    public function rules(): array
    {
        return [
            $this->address_field_name => 'required|email'
        ];
    }

    public function send( string $address, string $message): int
    {
        sleep(10);
        return MessengerBase::SUCCESS;
    }


}
