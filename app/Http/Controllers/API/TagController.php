<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller
{
    public function index(): JsonResponse
    {
        $tags = Tag::all();
        return response()->json($tags);
    }

    public function show($id): JsonResponse
    {
        $tag = Tag::find($id);
        if ($tag) {
            return response()->json($tag);
        } else {
            return response()->json(['message' => 'Tag not found'], 404);
        }
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), self::createRules(), self::createRuleMessages());
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $tag = Tag::create($request->all());
        return response()->json(['message' => 'Tag created successfully', 'data' => $tag], 201);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $validator = Validator::make($request->all(), self::updateRules(), self::createRuleMessages());
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $tag = Tag::find($id);
        if ($tag) {
            $tag->update($request->all());
            return response()->json(['message' => 'Tag updated successfully', 'data' => $tag]);
        } else {
            return response()->json(['message' => 'Tag not found'], 404);
        }
    }

    public function destroy($id): JsonResponse
    {
        $tag = Tag::find($id);
        if ($tag) {
            $tag->delete();
            return response()->json(['message' => 'Tag deleted successfully']);
        } else {
            return response()->json(['message' => 'Tag not found'], 404);
        }
    }

    public static function resourceClassName()
    {
        return 'Tag';
    }

    private static function createRules()
    {
        return [
            'name' => 'required|string|max:255',
        ];
    }

    private static function updateRules()
    {
        return [
            'name' => 'required|string|max:255',
        ];
    }

    private static function createRuleMessages()
    {
        return [
            'name.required' => 'Name is required',
        ];
    }
}
