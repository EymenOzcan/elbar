<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\StaticPageResource;
use App\Models\StaticPage;
use Illuminate\Http\Request;

class StaticPageController extends Controller
{
    /**
     * Display a listing of all static pages.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $staticPages = StaticPage::with(['translations.language', 'contact'])
            ->where('is_active', true)
            ->get();

        return response()->json([
            'success' => true,
            'data' => StaticPageResource::collection($staticPages),
            'message' => 'Sabit sayfalar başarıyla getirildi.'
        ], 200);
    }

    /**
     * Display the specified static page by type or slug.
     *
     * @param  string  $type
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($type)
    {
        $staticPage = StaticPage::with(['translations.language', 'contact'])
            ->where('is_active', true)
            ->where(function($query) use ($type) {
                $query->where('page_type', $type)
                      ->orWhere('slug', $type);
            })
            ->first();

        if (!$staticPage) {
            return response()->json([
                'success' => false,
                'message' => 'Sayfa bulunamadı.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new StaticPageResource($staticPage),
            'message' => 'Sayfa bilgileri başarıyla getirildi.'
        ], 200);
    }
}
