<?php

namespace App\Repositories\DAL\Criterias;

use App\Repositories\Criterias\Criterion;


/**
 *  Eger loads the related tables
 */
class EagerLoad implements Criterion{
    private $relationships;
    
    public function __construct($relationships)
    {
        $this->relationships = $relationships;
    }
    
    public function apply($model){
        return $model->with($this->relationships);
    }
}