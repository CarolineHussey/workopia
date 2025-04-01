<?php

namespace App\Providers;

use App\Models\Job;
use App\Policies\JobPolicy;
//use the AuthServiceProvider instead of the default Service provider because it gives access to specific methods (as well as importing the service provider that the default import does)
//use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    //create a policies property
    //connect Job model to JobPolicy
    protected $policies = [
        Job::class => JobPolicy::class
    ];
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //registers the JobPolicy to the Job model
        $this->registerPolicies();
    }
}