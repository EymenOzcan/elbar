<?php

namespace App\Http\Controllers;

use App\Models\Personel;
use App\Models\SocialMediaFollow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PersonelSocialMediaController extends Controller
{
    public function index($qrCode)
    {
        $personel = Personel::where('qr_code', $qrCode)
            ->where('is_active', true)
            ->firstOrFail();

        return view('personel.social-media', compact('personel'));
    }

    public function trackFollow(Request $request, $qrCode)
    {
        $validated = $request->validate([
            'platform' => 'required|in:instagram,facebook,tiktok,x,linkedin,youtube,whatsapp',
        ]);

        $personel = Personel::where('qr_code', $qrCode)
            ->where('is_active', true)
            ->firstOrFail();

        // Takibi kaydet
        SocialMediaFollow::create([
            'personel_id' => $personel->id,
            'platform' => $validated['platform'],
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Takip kaydedildi. Teşekkürler!',
        ]);
    }
}
