<?php 

namespace App\Repositories\Criterias;

use App\Repositories\Criterias\Criterion;

interface Criteria{
    public function withCriterias(...$criterias);
}