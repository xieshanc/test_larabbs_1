<?php

namespace App\Models;

use Spatie\QueryBuilder\QueryBuilder;

class Topic extends Model
{
    use Traits\QueryBuilderBindable;

    // protected $queryClass = \App\Http\Queries\TopicQueryTwo::class;

    protected $fillable = ['title', 'body', 'category_id', 'excerpt', 'slug'];

    public function link($params = [])
    {
        return route('topics.show', array_merge([$this->id, $this->slug], $params));
    }

    public function scopeWithOrder($query, $order)
    {
        switch ($order) {
            case 'recent':
                $query->recent();
                break;
            default:
                $query->recentReplied();
                break;
        }
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function scopeRecentReplied($query)
    {
        return $query->orderBy('updated_at', 'desc');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function replies()
    {
        return $this->hasMany(Reply::class);
    }

    public function updateReplyCount()
    {
        $count = $this->replies()->count();
        \DB::table('topics')->where('id', $this->id)->update(['reply_count' => $count]);
    }

    // public function resolveRouteBinding($value)
    // {
    //     echo '<pre>';
    //     var_dump($this->getRouteKeyName());
    //     exit;
    //     return QueryBuilder::for(self::class)
    //         ->allowedIncludes('user', 'category')
    //         ->where($this->getRouteKeyName(), $value)
    //         ->first();
    // }

}
