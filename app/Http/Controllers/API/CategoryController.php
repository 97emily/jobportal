<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    private static function resourceClassName()
    {
        return 'Category';
    }

    private static function createRules()
    {
        return [
            'name' => 'required',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ];
    }

    private static function updateRules()
    {
        return [
            'name' => 'required',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        ];
    }

    public function index()
    {
        $categories = Category::all();
        return response()->json($categories, 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), self::createRules());

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $category = new Category($request->all());

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
            $category->image = $imagePath;
        }

        $category->save();

        return response()->json($category, 201);
    }

    public function show($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        return response()->json($category, 200);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), self::updateRules());

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $category->fill($request->all());

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
            $category->image = $imagePath;
        }

        $category->save();

        return response()->json($category, 200);
    }

    public function destroy($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $category->delete();

        return response()->json(['message' => 'Category deleted'], 200);
    }

    //Endpoint to fetch jobs by category ID.

    /**
     * @OA\Get(
     *     path="/api/categories/jobs",
     *     summary="Get jobs by category ID",
     *     tags={"Jobs"},
     *     @OA\Parameter(
     *         name="category_id",
     *         in="query",
     *         required=true,
     *         @OA\Schema(type="integer"),
     *         description="ID of the category"
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="jobs",
     *                 type="array",
     *                 @OA\Items(ref="#/components/schemas/JobListing")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(property="errors", type="object")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Category not found"
     *     )
     * )
     */
    public function getJobsByCategoryId(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'category_id' => 'required|integer|exists:categories,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $category_id = $request->input('category_id');
        $category = Category::with(['jobListings.tag', 'jobListings.category', 'jobListings.salaryRange', 'jobListings.location', 'jobListings.assessment'])->find($category_id);

        if (!$category) {
            return response()->json(['message' => 'Category not found'], 404);
        }

        $jobs = $category->jobListings->map(function ($job) {
            return [
                'id' => $job->id,
                'title' => $job->title,
                'job_description' => $job->job_description,
                'status' => $job->status,
                'closing_date' => $job->closing_date,
                'tag' => $job->tag ? $job->tag->name : null,
                'category_id' => $job->category_id,
                'category' => $job->category ? $job->category->name : null,
                // 'salary_range' => $job->salaryRange ? $job->salaryRange->name : null,
                'salary_range' => $job->salaryRange ? $job->salaryRange->minimum . '-' . $job->salaryRange->maximum : 'Not specified',
                'location' => $job->location ? $job->location->name : null,
                'assessment' => $job->assessment ? $job->assessment->title : null,
                // 'deleted_at' => $job->deleted_at,
                // 'created_at' => $job->created_at,
                // 'updated_at' => $job->updated_at,
            ];
        });

        return response()->json(['jobs' => $jobs], 200);
    }
}
