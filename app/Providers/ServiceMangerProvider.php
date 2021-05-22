<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Classes\{
    CacheService,
    AgeListService,
    AppSettingsService,
    TherapistService,
    DegreeListService,
    LanguageListService,
    ExpertiesListService,
    TherapyProfileListService,
    SpectrumSpecializationListService,
};
use App\Services\Interfaces\{
    ICacheService,
    IAgeListService,
    IAppSettingsService,
    ITherapistService,
    IDegreeListService,
    ILanguageListService,
    IExpertiesListService,
    ITherapyProfileListService,
    ISpectrumSpecializationListService,
};


class ServiceMangerProvider extends ServiceProvider
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
         *  binding the service interfaces with its concrete implementation
         */
        $this->app->bind(ITherapistService::class, TherapistService::class);
        $this->app->bind(IAgeListService::class, AgeListService::class);
        $this->app->bind(IDegreeListService::class, DegreeListService::class);
        $this->app->bind(IExpertiesListService::class, ExpertiesListService::class);
        $this->app->bind(ILanguageListService::class, LanguageListService::class);
        $this->app->bind(ISpectrumSpecializationListService::class, SpectrumSpecializationListService::class);
        $this->app->bind(ITherapyProfileListService::class, TherapyProfileListService::class);
        $this->app->bind(IAppSettingsService::class, AppSettingsService::class);
        $this->app->bind(ICacheService::class, CacheService::class);
    }
}
