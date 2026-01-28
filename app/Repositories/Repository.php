<?php

namespace App\Repositories;

use App\Contracts\RepositoryContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Repository implements RepositoryContract 
{

    public function __construct(
        public Model $model,
    )
    {}
 
    
    public function find(int $id): ?Model {
        return $this->model->find($id) ?? null;    
    }


    public function all(): Collection {
        return $this->model->all();
    }


    public function store(array $data): Model {
        return $this->model->create($data);
    }

    
    public function update(int $id, array $data): Model {
        $e = $this->find($id);
        
        if($e) $e->update($data);

        return $e;
    }


    public function delete(int $id): bool {
        $this->find($id)->delete();

        return true;
    }
}