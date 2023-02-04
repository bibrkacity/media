<?php
namespace  App\Services\Messengers;

use App\Models\Messenger;
use App\Services\MessengerBase;

class email extends MessengerBase
{
    public function __construct()
    {

        $this->name = 'email';
        $this->display_name = 'E-mail';

    }

    public function form_fields():string
    {
            return 'form_fields';
    }

    protected function send( string $address, string $message): int
    {
        return MessengerBase::SENT;
    }
}
