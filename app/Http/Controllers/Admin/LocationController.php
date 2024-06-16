<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\BaseControllerConcerns;
use App\Http\Controllers\Controller;

class LocationController extends Controller
{
    use BaseControllerConcerns;

    private static function resourceClassName()
    {
        return 'Location';
    }

    private static function createRules()
    {
        return [
            'name' => 'required',
        ];
    }

    private static function updateRules()
    {
        return [
            'name' => 'required',
        ];
    }
}
