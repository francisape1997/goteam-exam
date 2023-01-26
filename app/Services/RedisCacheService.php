<?php

namespace App\Services;

use Illuminate\Support\Facades\Redis;
use App\Interfaces\CacheInterface;

class RedisCacheService implements CacheInterface
{
    /**
     * Get data from cache
     *
     * @return mixed
     */
    public function get($key)
    {
        return Redis::get($key);
    }

    /**
     * Store data in cache
     *
     * @param $data
     */
    public function set($key, $data)
    {
        Redis::set($key, $data);
    }
}
