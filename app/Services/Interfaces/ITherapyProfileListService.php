<?php

namespace App\Services\Interfaces;

interface ITherapyProfileListService{
    public function addNewTherapyProfile($data);
    public function getAllTherapyProfiles();
}