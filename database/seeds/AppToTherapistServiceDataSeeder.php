<?php

use App\Services\Interfaces\IAgeListService;
use App\Services\Interfaces\IDegreeListService;
use App\Services\Interfaces\IExpertiesListService;
use App\Services\Interfaces\ILanguageListService;
use App\Services\Interfaces\ISpectrumSpecializationListService;
use App\Services\Interfaces\ITherapyProfileListService;
use Illuminate\Database\Seeder;

class AppToTherapistServiceDataSeeder extends Seeder
{
    private $ageTableService;
    private $degreeTableService;
    private $therapyProfileTableService;
    private $languageTableService;
    private $expertiesTableService;
    private $specSpecializationTableService;

    public function __construct(IAgeListService $ageTableService,
        IDegreeListService $degreeTableService,
        ITherapyProfileListService $therapyProfileTableService,
        ILanguageListService $languageTableService,
        IExpertiesListService $expertiesTableService,
        ISpectrumSpecializationListService $specSpecializationTableService
    )
    {
        $this->ageTableService = $ageTableService;
        $this->degreeTableService = $degreeTableService;
        $this->therapyProfileTableService = $therapyProfileTableService;
        $this->languageTableService = $languageTableService;
        $this->expertiesTableService = $expertiesTableService;
        $this->specSpecializationTableService = $specSpecializationTableService;
    }

    public function run()
    {
        $age_groups = ['below 12','12-18','18-35','35-55','55+'];
        $language_list = ['English', 'Hindi', 'Telegu', 'Tamil', 'Marathi', 'Bengali', 'Kashmiri', 'Nepali', 'Odiya'];
        $degree_list = ['Mphil', 'MD', 'Clinical Counseling', 'Diploma', 'MD'];
        $experties_list = ['Psychotherapy','CBT/REBT','play therapy','art therapy','hypnotherapy','EMDR','Transactional and analysis therapy','Mindfulness','Tarrots'];
        $specialization_list = ['Psychosis','Eating Disorder','Anxiety','Gender/Sexuality','Mood Disorders','Family and Environmental Stress','Trauma(PTSD)','Neurocognitive','Autism','personality disorders','learning disability','Substance Abuse'];
        $therapy_profile_list = ['Psychiatrist','Clinical Psychologist','Child Psychologist','Special Educator','Neuropsychologist','Sex therapist','Family/Marriage Counselor','Addiction therapist','Trauma therapist'];


       // seed to age list 
       foreach( $age_groups as $age_group){
        $this->ageTableService->addNewAgeGroup([
            'age_group' => $age_group
        ]);
       }
       // seed the languages
       foreach($language_list as $language){
           $this->languageTableService->addNewLanguage([
               'language' => $language
           ]);
       }
       // seed the degrees
       foreach($degree_list as $degree){
           $this->degreeTableService->addNewDegree([
               'degree_name' => $degree
           ]);
       }
       //seed the experties
       foreach($experties_list as $experties){
           $this->expertiesTableService->addNewExperties([
            'experties' => $experties
           ]);
       }
       // seed the specialization
       foreach($specialization_list as $specialization){
           $this->specSpecializationTableService->addNewSpecializations([
               'spectrum_specialization' => $specialization
           ]);
       }
       // seed the therapy profiles
       foreach($therapy_profile_list as $therapyProfile){
           $this->therapyProfileTableService->addNewTherapyProfile([
               'therapy_profile' => $therapyProfile
           ]);
       }
    }
}
