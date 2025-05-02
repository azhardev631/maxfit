<?php

namespace App\Providers;

use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;
use App\Repositories\API\AuthRepository;
use App\Repositories\API\OrganisationRepository;
use App\Repositories\OrganisationTypesRepository;
use App\Repositories\Contracts\UserRepositoryInterface;
use App\Repositories\MedicalAssessmentQuestionRepository;
use App\Repositories\Contracts\API\AuthRepositoryInterface;
use App\Repositories\Contracts\API\OrganisationRepositoryInterface;
use App\Repositories\Contracts\API\MedicalAssessmentAnswerInterface;
use App\Repositories\Contracts\OrganisationTypesRepositoryInterface;
use App\Repositories\OrganisationRepository as OrganisationRepositoryy;
use App\Repositories\Contracts\MedicalAssessmentQuestionRepositoryInterface;
use App\Repositories\API\MedicalAssessmentAnswerRepository;
use App\Repositories\Contracts\OrganisationRepositoryInterface as OrganisationRepositoryInterfaces;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(AuthRepositoryInterface::class,AuthRepository::class);
        $this->app->bind(OrganisationRepositoryInterface::class,OrganisationRepository::class);
        $this->app->bind(OrganisationTypesRepositoryInterface::class,OrganisationTypesRepository::class);
        $this->app->bind(OrganisationRepositoryInterfaces::class,OrganisationRepositoryy::class);
        $this->app->bind(MedicalAssessmentQuestionRepositoryInterface::class,MedicalAssessmentQuestionRepository::class);
        $this->app->bind(MedicalAssessmentAnswerInterface::class,MedicalAssessmentAnswerRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
