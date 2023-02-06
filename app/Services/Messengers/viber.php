<?php
namespace  App\Services\Messengers;

use App\Services\MessengerBase;

class viber extends MessengerBase
{
    public function __construct()
    {
        $this->id = 3;
        $this->name = 'viber';
        $this->display_name = 'Viber';
        $this->address_field_name = 'phone';
    }

    public function form_fields():string
    {
        return parent::form_fields();
    }

    public function rules(): array
    {
        return [
            $this->address_field_name => 'required|string'
        ];
    }

    public function send( string $address, string $message): int
    {
        sleep(10);
        return MessengerBase::SUCCESS;
    }


}
