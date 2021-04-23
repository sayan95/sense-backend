<?php 

namespace App\Repositories\Criterias;

interface Criteria{
    public function withCriterias(...$criterias);
}