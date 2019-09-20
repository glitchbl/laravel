<?php

namespace App\Services;

use Illuminate\Support\Facades\Session;

class Message
{
    public function add($type, $message)
    {
        $messages = Session::get('messages', []);
        $messages[] = [
            'type' => $type,
            'message' => $message
        ];

        Session::put('messages', $messages);
    }

    public function success($message)
    {
        $this->add('success', $message);
    }

    public function warning($message)
    {
        $this->add('warning', $message);
    }

    public function error($message)
    {
        $this->add('danger', $message);
    }

    public function info($message)
    {
        $this->add('info', $message);
    }

    public function get()
    {
        $messages = Session::get('messages', []);

        Session::forget('messages');

        return $messages;
    }
}