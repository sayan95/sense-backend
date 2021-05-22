<?php

namespace App\Services\Interfaces;

interface ICacheService{
    public function rememberCache($key, $ttl, array $data);
}