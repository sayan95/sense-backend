<?php

namespace App\Services\Interfaces;

interface ITherapistService {
    public function findTherapistBySpecificField($col, $value, array $relations);
    public function findTherapistById($id, array $relations);
    public function addTherpistProfile($email, array $data);
    public function addTherapist(array $data);
    public function updateTherapistDetails($id, array $data);
    public function deleteTherapistAccountById($id);
    public function deleteTherapistAccountByField($col, $value);
}