<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Concerns\BaseControllerConcerns;
use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\View\View;

class TagController extends Controller
{
    use BaseControllerConcerns;

    public static function resourceClassName()
    {
        return 'Tag';
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

    private static function createRuleMessages()
    {
        return [
            'name.required' => 'Name is required',
        ];
    }
    public function show($id): View
    {
        $tag = Tag::with(['jobs'])->findOrFail($id);

        return view('admin.tags.show', compact('tag'));
    }
}
