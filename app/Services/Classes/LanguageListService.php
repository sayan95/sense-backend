<?php

namespace App\Services\Classes;

use App\Repositories\Contracts\LanguageListContract;
use App\Services\Interfaces\ILanguageListService;

class LanguageListService implements ILanguageListService{
    private $languageList;

    public function __construct(LanguageListContract $languageList){
        $this->languageList = $languageList;
    }

    // adds new language to the language list
    public function addNewLanguage($data){
        $this->languageList->create($data);
    }

    // get all the languages
    public function getAllLanguages(){
        return $this->languageList->all();
    }
}