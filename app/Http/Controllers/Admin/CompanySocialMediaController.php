<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanySocialMediaController extends Controller
{
    public function index()
    {
        $settings = DB::table('company_social_media_settings')
            ->pluck('value', 'key')
            ->toArray();

        return view('admin.company-social-media.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'instagram_url' => 'nullable|url|max:500',
            'facebook_url' => 'nullable|url|max:500',
            'tiktok_url' => 'nullable|url|max:500',
            'x_url' => 'nullable|url|max:500',
            'linkedin_url' => 'nullable|url|max:500',
            'youtube_url' => 'nullable|url|max:500',
            'whatsapp_number' => 'nullable|string|max:50',
        ]);

        foreach ($validated as $key => $value) {
            DB::table('company_social_media_settings')
                ->where('key', $key)
                ->update(['value' => $value, 'updated_at' => now()]);
        }

        return redirect()->route('admin.company-social-media.index')
            ->with('success', 'Sosyal medya ayarları güncellendi.');
    }
}
