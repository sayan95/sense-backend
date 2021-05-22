<?php

namespace App\Http\Controllers\Web\App;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\App\TherapistDataService\AgeGroupResource;
use App\Http\Resources\App\TherapistDataService\DegreeResource;
use App\Http\Resources\App\TherapistDataService\ExpertiesResource;
use App\Http\Resources\App\TherapistDataService\SpecializationResource;
use App\Http\Resources\App\TherapistDataService\TherapyProfileResource;
use App\Http\Resources\App\TherapistDataService\LanguageResource;
use App\Services\Interfaces\IAgeListService;
use App\Services\Interfaces\ICacheService;
use App\Services\Interfaces\IDegreeListService;
use App\Services\Interfaces\ILanguageListService;
use App\Services\Interfaces\IExpertiesListService;
use App\Services\Interfaces\ITherapyProfileListService;
use App\Services\Interfaces\ISpectrumSpecializationListService;

class TherapistServiceSupportController extends Controller
{
    private $ageTableService;
    private $degreeTableService;
    private $therapyProfileTableService;
    private $languageTableService;
    private $expertiesTableService;
    private $specSpecializationTableService;
    private $cacheService;

    // constructor
    public function __construct(IAgeListService $ageTableService,
        IDegreeListService $degreeTableService,
        ITherapyProfileListService $therapyProfileTableService,
        ILanguageListService $languageTableService,
        IExpertiesListService $expertiesTableService,
        ISpectrumSpecializationListService $specSpecializationTableService,
        ICacheService $cacheService
    ){
        $this->ageTableService = $ageTableService;
        $this->degreeTableService = $degreeTableService;
        $this->therapyProfileTableService = $therapyProfileTableService;
        $this->languageTableService = $languageTableService;
        $this->expertiesTableService = $expertiesTableService;
        $this->specSpecializationTableService = $specSpecializationTableService;
        $this->cacheService = $cacheService;
    }

    // function that returns the table data for therapist profile creation page
    public function getTherapistServiceData(){

        // cache the data for 12 hours
        $therapistServiceData = $this->cacheService->rememberCache('therapistServiceData', 60*12, [   
            'ageGroups' => AgeGroupResource::collection($this->ageTableService->getAllAgeGroups()),
            'degrees' => DegreeResource::collection($this->degreeTableService->getAllDegrees()),
            'therapyProfiles' => TherapyProfileResource::collection($this->therapyProfileTableService->getAllTherapyProfiles()),
            'languages' => LanguageResource::collection($this->languageTableService->getAllLanguages()),
            'specializations' => SpecializationResource::collection($this->specSpecializationTableService->getAllSpecializations()),
            'experties' => ExpertiesResource::collection($this->expertiesTableService->getAllExperties())
        ]);
        
        // return cached data
        return response()->json($therapistServiceData, 200);
    }
}
