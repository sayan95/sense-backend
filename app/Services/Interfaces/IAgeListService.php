<?php

namespace App\Services\Interfaces;

interface IAgeListService {
    public function addNewAgeGroup($data);
    public function getAllAgeGroups();
}