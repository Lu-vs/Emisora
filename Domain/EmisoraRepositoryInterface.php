<?php
namespace Domain;


interface EmisoraRepositoryInterface {
    public function save(Emisora $emisora);
    public function delete($id);
    public function getAll();
    public function findById($id);
    public function update(Emisora $emisora): void;

}


