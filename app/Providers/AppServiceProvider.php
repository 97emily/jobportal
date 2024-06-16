<?php

namespace App\Providers;

use App\Rules\DistinctSalaryRange;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    {
        Validator::extend('distinct_salary_range', function ($attribute, $value, $parameters, $validator) {
            $data = $validator->getData();
            $minimum = $data['minimum'] ?? 0;
            $maximum = $data['maximum'] ?? 0;

            return (new DistinctSalaryRange($minimum, $maximum))->passes($attribute, $value);
        });
    }
}
