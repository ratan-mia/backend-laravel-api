<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserPreferenceController extends Controller
{
    public function update(Request $request)
    {
        $user = $request->user();
        $preference = $user->preference ?? new UserPreference();

        $preference->user_id = $user->id;
        $preference->preferred_sources = $request->input('preferred_sources');
        $preference->preferred_categories = $request->input('preferred_categories');
        $preference->preferred_authors = $request->input('preferred_authors');
        $preference->save();

        return response()->json(['message' => 'Preferences updated successfully']);
    }

    public function getPreferredNews(Request $request)
    {
        $user = $request->user();
        $preference = $user->preference;

        // Make API requests to NewsAPI using preferred sources, categories, and authors
        // Fetch and return the preferred news articles

        $apiKey = env('NEWS_API_KEY');
        $url = 'https://newsapi.org/v2/everything';
        $response = Http::get($url, [
            'apiKey' => $apiKey,
            'sources' => $preference->preferred_sources,
            'categories' => $preference->preferred_categories,
            'authors' => $preference->preferred_authors,
        ]);

        $articles = $response->json()['articles'] ?? [];

        return response()->json($articles);
    }
}
