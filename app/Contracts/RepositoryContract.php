<?php

namespace App\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

interface RepositoryContract {
    
    public function find(int $id): ?Model;

    public function all(): Collection;

    public function store(array $data): Model;

    public function update(int $id, array $data): Model;

    public function delete(int $id): bool;
    
}