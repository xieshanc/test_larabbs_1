<?php

namespace App\Models;

use Auth;
use Illuminate\Notifications\Notifiable;

class Reply extends Model
{
    use Notifiable;

    protected $fillable = ['content'];

    public function topic()
    {
        return $this->belongsTo(Topic::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function topicRepliesNotify($instance)
    {
        if ($this->topic->user_id == Auth::id()) return;

        if (method_exists($instance, 'toDatabase')) {
            $this->topic->user->increment('notification_count');
        }

        $this->notify($instance);
    }
}
