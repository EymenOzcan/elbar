<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PageResource;
use App\Models\Page;
use App\Models\PageTranslation;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display a listing of all active pages.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = Page::with(['translations.language', 'category'])
            ->where('is_active', true);

        // Filter by category if provided
        if ($request->has('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $pages = $query->latest()->get();

        return response()->json([
            'success' => true,
            'data' => PageResource::collection($pages),
            'message' => 'Sayfa listesi başarıyla getirildi.'
        ], 200);
    }

    /**
     * Display the specified page by slug.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($slug)
    {
        // Find page translation by slug
        $pageTranslation = PageTranslation::with(['page.translations.language', 'page.category'])
            ->where('slug', $slug)
            ->first();

        if (!$pageTranslation || !$pageTranslation->page->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'Sayfa bulunamadı.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new PageResource($pageTranslation->page),
            'message' => 'Sayfa bilgileri başarıyla getirildi.'
        ], 200);
    }
}
