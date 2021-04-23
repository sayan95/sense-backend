<?php

namespace App\Model;

use Jenssegers\Mongodb\Eloquent\Model;

class BaseModel extends Model{
    // db connection
    protected $connection = 'mongodb';
}