<?php

namespace App\Repositories\Criterias;

interface Criterion{
    public function apply($model);
}