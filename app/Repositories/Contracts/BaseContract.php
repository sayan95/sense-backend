<?php

namespace App\Repositories\Contracts;

interface BaseContract{
    public function all();
    public function find($id);
    public function findWhere($col, $val);
    public function findWhereFirst($col, $val);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}