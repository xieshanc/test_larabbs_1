<?php

namespace App\Observers;

use App\Models\Topic;
use App\Handlers\TranslateHandler;

// creating, created, updating, updated, saving,
// saved,  deleting, deleted, restoring, restored

class TopicObserver
{
    public function saving(Topic $topic)
    {
        $topic->body = clean($topic->body, 'user_topic_body');
        $topic->excerpt = make_excerpt($topic->body);

        if (!$topic->slug) {
            $topic->slug = app(TranslateHandler::class)->translate($topic->title);
        }
    }
}
