<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobListing;
use Illuminate\Http\Request;
use Exception;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        try {
            $query = $request->input('query');

            // Adjust the search query to correctly reference the columns and their relationships
            $results = JobListing::with(['category', 'tag', 'location'])
                ->where('title', 'ILIKE', "%$query%")
                ->orWhereHas('category', function ($q) use ($query) {
                    $q->where('name', 'ILIKE', "%$query%");
                })
                ->orWhereHas('tag', function ($q) use ($query) {
                    $q->where('name', 'ILIKE', "%$query%");
                })
                ->orWhereHas('location', function ($q) use ($query) {
                    $q->where('name', 'ILIKE', "%$query%");
                })
                ->get();

            // Return the results as JSON
            return response()->json(['success' => true, 'results' => $results], 200);
        } catch (Exception $e) {
            \Log::error('Error fetching search results: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'An error occurred while searching. Please try again later.'], 500);
        }
    }

}
