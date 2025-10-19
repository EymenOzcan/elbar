<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ModuleResource;
use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    /**
     * Display a listing of all modules.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $modules = Module::orderBy('sort_order')->get();

        return response()->json([
            'success' => true,
            'data' => ModuleResource::collection($modules),
            'message' => 'Modül listesi başarıyla getirildi.'
        ], 200);
    }

    /**
     * Get the currently active module.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function active()
    {
        $activeModule = Module::where('is_active', true)->first();

        if (!$activeModule) {
            return response()->json([
                'success' => true,
                'data' => null,
                'message' => 'Aktif modül bulunamadı.'
            ], 200);
        }

        return response()->json([
            'success' => true,
            'data' => new ModuleResource($activeModule),
            'message' => 'Aktif modül başarıyla getirildi.'
        ], 200);
    }
}
