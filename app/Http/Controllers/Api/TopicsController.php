<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Requests\Api\TopicRequest;
use App\Http\Resources\TopicResource;
use App\Http\Queries\TopicQuery;

class TopicsController extends Controller
{
    public function index(Request $request, TopicQuery $query)
    {
        // // QueryBuilder
        // // (1) 控制要加载的字段
        // // (2) 控制要加载的关联 include=user,category
        // $topics = QueryBuilder::for(Topic::class) // 主模型
        //     ->allowedIncludes('user', 'category') // 可能要加载的关联
        //     ->allowedFilters([                    // 搜索条件
        //         'title',        // like 搜索
        //         AllowedFilter::exact('category_id'), // 精确查找
        //         AllowedFilter::scope('withOrder')->default('recentReplied'), // 使用 scope
        //     ])
        //     ->paginate();
        // return TopicResource::collection($topics);

        $topics = $query->paginate();
        return TopicResource::collection($topics);

        // $query = $topic->query();
        // if ($categoryId = $request->category_id) {
        //     $query->where('category_id', $categoryId);
        // }
        // $topics = $query->with('user', 'category')
        //     ->withOrder($request->order)
        //     ->paginate();
        // return TopicResource::collection($topics);
    }


    public function userIndex(Request $request, User $user, TopicQuery $query)
    {
        $topics = $query->where('user_id', $user->id)->paginate();
        return TopicResource::collection($topics);

        // $query = $user->topics()->query(); // 不行，在关联里要用 getQuery
        // $query = $user->topics()->getQuery();
        // $topics = QueryBuilder::for($query)
        //     ->allowedIncludes('user', 'category')
        //     ->allowedFilters([
        //         'title',
        //         AllowedFilter::exact('category_id'),
        //         AllowedFilter::scope('withOrder')->default('recentReplied'),
        //     ])
        //     ->paginate();
        // return TopicResource::collection($topics);
    }

    // public function show($topicId, TopicQuery $query)
    // {
    //     $topic = $query->findOrFail($topicId);
    //     return new TopicResource($topic);
    // }

    public function show(Topic $topic)
    {
        return new TopicResource($topic);
    }

    public function store(TopicRequest $request, Topic $topic)
    {
        $topic->fill($request->all());
        $topic->user_id = $request->user()->id;
        $topic->save();
        return new TopicResource($topic);
    }

    public function update(TopicRequest $request, Topic $topic)
    {
        $this->authorize('update', $topic);
        $topic->update($request->all());
        return new TopicResource($topic);
    }

    public function destroy(Topic $topic)
    {
        $this->authorize('destroy', $topic);

        $res = $topic->delete();

        return response(null, 204);
    }
}
