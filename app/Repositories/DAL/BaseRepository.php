<?php 

namespace App\Repositories\DAL;

use Illuminate\Support\Arr;
use App\Repositories\Criterias\Criteria;
use App\Repositories\Contracts\BaseContract;

abstract class BaseRepository implements BaseContract, Criteria{

    protected $model;

    public function __construct() {
        $this->model = $this->getModelClass();
    }   

    /**
     *  applies criterias for filtering
    */
    public function withCriterias(...$criterias)
    {
        $criterias = Arr::flatten($criterias); 
        foreach($criterias as $criteria){
            $this->model = $criteria->apply($this->model);  
        }
        return $this;
    }

    /**
     * get the model class
     */
    private function getModelClass(){
        if ( ! method_exists($this, 'model')){
           return 'error';
        }   
        return app()->make($this->model());
    }

    /**
     *  Select all the records
     */
    public function all(){
        return $this->model->all();
    }

    /**
     *  find a record by its id
     */
    public function find($id){
        return $this->model->findOrFail($id);
    }

    /**
     *  find all records which value is matched with the given col value 
     */
    public function findWhere($col, $val){
        return $this->model->where([$col => $val])->get();
    }

    /**
     *  find the first record which value is matched with the given col value 
     */
    public function findWhereFirst($col, $val){
        return $this->model->where([$col => $val])->first();
    }

    /**
     *  Insert new record
     */
    public function create(array $data){
        return $this->model->create($data);
    }

    /**
     *  update existing record
     */
    public function update($id, array $data){
        $entity = $this->find($id);
        $entity->update($data);
        return $entity;
    }

    /**
     *  delete record
     */
    public function delete($id){

    }
}