<?php

namespace App\Services\Classes;

use Illuminate\Support\Facades\Cache;
use App\Services\Interfaces\ICacheService;

class CacheService implements ICacheService{
    // remembers cache and updates automatically 
    public function rememberCache($key, $ttl, array $data){
        return Cache::remember($key, $ttl, function() use ($data) {
            return $data;
        });
    }
}