<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\BaseControllerConcerns;
use App\Http\Controllers\Controller;
use App\Models\SalaryRange;
use Illuminate\Http\Request;
use Illuminate\View\View;
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

    // Input validation to avoid overlapping values
    protected function prepareForValidation(Request $request)
    {
        $request->merge([
            'minimum' => floatval($request->input('minimum')),
            'maximum' => floatval($request->input('maximum')),
        ]);
    }
    public function show($id): View
    {
        $salaryRange = SalaryRange::with(['jobs'])->findOrFail($id);

        return view('admin.salary_ranges.show', compact('salaryRange'));
    }
}

