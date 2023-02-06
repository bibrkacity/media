<?php
namespace  App\Services\Messengers;

use App\Services\MessengerBase;

class telegram extends MessengerBase
{
    public function __construct()
    {
        $this->id = 4;
        $this->name = 'telegram';
        $this->display_name = 'Telegram';
        $this->address_field_name = 'telegram';
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
