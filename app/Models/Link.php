<?php

namespace App\Models;

use Cache;

class Link extends Model
{
    protected $cache_key = 'larabbs_links';
    protected $cache_expire_in_seconds = 1440 * 60;

    public function getAllCached()
    {
        return Cache::remember($this->cache_key, $this->cache_expire_in_seconds, function () {
            return $this->all();
        });
    }

    public function forgetCache()
    {
        Cache::forget($this->cache_key);
    }
}
