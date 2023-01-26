<?php

namespace App\Interfaces;

interface CacheInterface
{
    public function get($key);

    public function set($key, $data);
}
