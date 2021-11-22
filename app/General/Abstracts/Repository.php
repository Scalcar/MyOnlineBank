<?php

namespace App\General\Abstracts;

use App\General\Interfaces\IRepository;

abstract class Repository implements IRepository
{
    protected $model;

    public function getAll()
    {
        return $this->model::all();
    }

    public function store(array $args)
    {
        $model = new $this->model($args);

        if($model->save()){
            return $model;
        }else{
            return null;
        }
    }

    public function getById(int $id)
    {
        return $this->model::where('id',$id)->first();
    }

    public function update(array $args)
    {
        $model = $this->getById($args['modelId']);

        unset($args['modelId']);

        if($model->update($args)){
            return $model;
        }else{
            return null;
        }
    }

    public function delete(array $args)
    {
        $model = $this->getById($args['modelId']);

        if($model->delete())
            return $model;
        else
            return null;
    }
}