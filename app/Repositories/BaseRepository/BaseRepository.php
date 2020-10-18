<?php

namespace App\Repositories\BaseRepository;

abstract class BaseRepository
{
   /**
   * Model class for repo.
   *
   * @var string
   */
    protected $model;

    /**
    * @param  int  $id do registro
    * @param  array $with. Array de ligações dos models, caso já queira trazer direto da consulta
    */

    public function find($id, array $with = [])
    {
        return $this->model::with($with)->find($id);
    }

    /**
    * @param  array $with. Array de ligações dos models, caso já queira trazer direto da consulta
    * @param  array $orderBy. Array de arrays para ordernação. Ex: [['descricao', 'ASC'], ['nome', 'DESC']]
    */
    public function findAll(array $with = [], array $orderBy = [])
    {
        $model = $this->model::with($with);

        if (count($orderBy)) {
            foreach ($orderBy as $order) {
                $model = $model->orderBy($order[0], $order[1]);
            }
        }
        return $model->get();
    }


    public function create(array $data)
    {
        return $this->model::create($data);
    }


    public function update(array $data, $id)
    {
        return $this->model::find($id)->update($data);
    }


    public function delete($_delete)
    {
        return is_array($_delete) ? $this->model::where($_delete)->delete() : $this->model::find($_delete)->delete();
    }


    public function findBy(array $where, array $with = [], array $orderBy = [], array $groupBy = [] , $limit = null, $offset = null, array $selects = [] )
    {
        $model = $this->model;
        
        $model = $model::with($with);

        if (!empty($selects)) {
            $model = $model->select($selects);
        }

        foreach ($where as $value) {
            switch ($value[3] ?? '') {
                case "AND":
                case "and":
                    $model = $model->where($value[0], $value[1], $value[2]);
                    break;

                case "OR":
                case "or":
                    $model = $model->orWhere($value[0], $value[1], $value[2]);
                    break;

                case "IN":
                case "in":
                    $model = $model->whereIn($value[0], $value[2]);
                    break;
                
                case "LIKE":
                case "like":
                    $model = $model->orWhere($value[0], $value[3],$value[2]);
                    
                    break;

                default:
                    $model = $model->where($value[0], $value[1], $value[2]);
                    break;
            }
        }

        if (count($orderBy)) {
            foreach ($orderBy as $order) {
                $model = $model->orderBy($order[0], $order[1]);
            }
        }

        if (count($groupBy)) {
            foreach ($groupBy as $group) {
                $model = $model->groupBy($group[0]);
            }
        }

        if (!is_null($limit)) {
            $model = $model->take((int) $limit);
        }

        if (!is_null($offset)) {
            $model = $model->skip((int) $offset);
        }
        return $model->get();
    }


    public function findOneBy(array $where, array $with = [])
    {
        return $this->findBy($where, $with)->first();
    }
}
