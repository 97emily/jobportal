<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\BaseControllerConcerns;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\Validation\Rule;

class SalaryRangeController extends Controller
{
    use BaseControllerConcerns;

    private static function resourceClassName()
    {
        return 'SalaryRange';
    }

    private static function createRules()
    {
        return [
            'minimum' => ['required', 'numeric', 'lt:maximum', 'distinct_salary_range'],
            'maximum' => ['required', 'numeric', 'gt:minimum', 'distinct_salary_range'],
        ];
    }

    private static function updateRules()
    {
        return [
            'minimum' => ['required', 'numeric', 'lt:maximum', 'distinct_salary_range'],
            'maximum' => ['required', 'numeric', 'gt:minimum', 'distinct_salary_range'],
        ];
    }

    protected function prepareForValidation(Request $request)
    {
        $request->merge([
            'minimum' => floatval($request->input('minimum')),
            'maximum' => floatval($request->input('maximum')),
        ]);
    }
}

