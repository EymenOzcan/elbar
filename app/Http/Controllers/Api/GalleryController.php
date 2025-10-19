<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\GalleryResource;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    /**
     * Display a listing of all galleries.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $galleries = Gallery::with(['images' => function($query) {
                $query->orderBy('sort_order');
            }])
            ->where('is_active', true)
            ->withCount('images')
            ->get();

        return response()->json([
            'success' => true,
            'data' => GalleryResource::collection($galleries),
            'message' => 'Galeriler başarıyla getirildi.'
        ], 200);
    }

    /**
     * Display the specified gallery with all images.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $gallery = Gallery::with(['images' => function($query) {
                $query->orderBy('sort_order');
            }])
            ->where('is_active', true)
            ->find($id);

        if (!$gallery) {
            return response()->json([
                'success' => false,
                'message' => 'Galeri bulunamadı.'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new GalleryResource($gallery),
            'message' => 'Galeri bilgileri başarıyla getirildi.'
        ], 200);
    }
}
