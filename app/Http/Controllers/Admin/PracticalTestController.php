<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\PracticalTest;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PracticalTestController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $tests = PracticalTest::latest()->paginate(config('constants.posts_per_page'));
        return view('admin.practical_tests.index', compact('tests', 'categories'))
        ->with('i', (request()->input('page', 1) - 1) * config('constants.posts_per_page'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.practical_tests.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'instructions' => 'required|string',
            'deadline' => 'required|date',
            'category_id' => 'required|exists:categories,id',
        ]);

        PracticalTest::create($request->all());

        return redirect()->route('practical_tests.index');
    }

    public function show(PracticalTest $practicalTest)
    {
        return view('admin.practical_tests.show', compact('practicalTest'));
    }

    public function edit(PracticalTest $practicalTest)
    {
        return view('admin.practical_tests.edit', compact('practicalTest'));
    }

    public function update(Request $request, PracticalTest $practicalTest)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'instructions' => 'required|string',
            'deadline' => 'required|date',
            'category_id' => 'required|exists:categories,id',
        ]);

        $practicalTest->update($request->all());

        return redirect()->route('practical_tests.index');
    }

    public function destroy(PracticalTest $practicalTest)
    {
        $practicalTest->delete();

        return redirect()->route('practical_tests.index');
    }
}
