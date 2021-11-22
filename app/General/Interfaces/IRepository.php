<?php

namespace App\General\Interfaces;

interface IRepository 
{
    public function getAll();
    public function getById(int $id);
    public function store(array $args);
    public function update(array $args);
    public function delete(array $args);
}