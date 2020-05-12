<?php

namespace App\Notifications\Channels;

use JPush\Client;
use Illuminate\Notifications\Notification;

class JPushChannel
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    // $notifiable 就是用户模型（当用 User 发送时）
    public function send($notifiable, Notification $notification)
    {
        $notification->toJPush($notifiable, $this->client->push())->send();
    }
}
