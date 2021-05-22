<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\DAL\{
    AgeListRepository,
    AppSettingsRepository,
    TherapistRepository,
    DegreeListRepository,
    LanguageListRepository,
    ExpertiesListRepository,
    TherapyProfileListRepository,
    SpectrumSpecializationListRepository,
};

use App\Repositories\Contracts\{
    AgeListContract,
    AppSettingsContract,
    TherapistContract,
    DegreeListContract,
    LanguageListContract,
    ExpertiesListContract,
    TherapyProfileListContract,
    SpectrumSpecializationListContract
};

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         *  binding the contract with its concrete implementation
         */
        $this->app->bind(TherapistContract::class, TherapistRepository::class);
        $this->app->bind(AgeListContract::class, AgeListRepository::class);
        $this->app->bind(LanguageListContract::class, LanguageListRepository::class);
        $this->app->bind(DegreeListContract::class, DegreeListRepository::class);
        $this->app->bind(ExpertiesListContract::class, ExpertiesListRepository::class);
        $this->app->bind(SpectrumSpecializationListContract::class, SpectrumSpecializationListRepository::class);
        $this->app->bind(TherapyProfileListContract::class, TherapyProfileListRepository::class);
        $this->app->bind(AppSettingsContract::class, AppSettingsRepository::class);
    }
}
