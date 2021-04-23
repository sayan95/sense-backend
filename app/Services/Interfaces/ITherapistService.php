<?php

namespace App\Services\Interfaces;

interface ITherapistService {
    public function findTherapistBySpecificField($col, $value);
    public function findTherapistById($id);
    public function addTherpistProfile($email, array $data);
    public function addTherapist(array $data);
    public function updateTherapistDetails($id, array $data);
}