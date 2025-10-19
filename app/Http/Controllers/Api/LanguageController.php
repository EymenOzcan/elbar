<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\LanguageResource;
use App\Models\Language;
use Illuminate\Http\Request;

class LanguageController extends Controller
{
    /**
     * Display a listing of all active languages.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $languages = Language::where('is_active', true)
            ->orderBy('is_default', 'desc')
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'data' => LanguageResource::collection($languages),
            'message' => 'Dil listesi başarıyla getirildi.'
        ], 200);
    }
}
