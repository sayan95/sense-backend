<?php

namespace App\Services\Interfaces;

interface ILanguageListService{
    public function addNewLanguage($data);
    public function getAllLanguages();
}