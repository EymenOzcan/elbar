<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PersonelResource;
use App\Models\Personel;
use Illuminate\Http\Request;

class PersonelController extends Controller
{
    /**
     * Display a listing of all personnel.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $personels = Personel::with(['translations.language'])
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'data' => PersonelResource::collection($personels),
            'message' => 'Personel listesi başarıyla getirildi.'
        ], 200);
    }

    /**
     * Display the specified personnel by QR code.
     *
     * @param  string  $qrCode
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($qrCode)
    {
        $personel = Personel::with(['translations.language'])
            ->where('qr_code', $qrCode)
            ->first();

        if (!$personel) {
            return response()->json([
                'success' => false,
                'message' => 'Personel bulunamadı.'
            ], 404);
        }

        // Increment followers count
        $personel->increment('followers_count');

        return response()->json([
            'success' => true,
            'data' => new PersonelResource($personel),
            'message' => 'Personel bilgileri başarıyla getirildi.'
        ], 200);
    }
}
