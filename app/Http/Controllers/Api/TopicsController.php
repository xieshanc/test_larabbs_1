<?php

namespace App\Http\Controllers\Api;

use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Requests\Api\TopicRequest;
use App\Http\Resources\TopicResource;

class TopicsController extends Controller
{
    public function store(TopicRequest $request, Topic $topic)
    {
        $topic->fill($request->all());
        $topic->user_id = $request->user()->id;
        $topic->save();

        return new TopicResource($topic);
    }
}
