<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Personel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PersonelController extends Controller
{
    public function index()
    {
        $personels = Personel::withCount('socialMediaFollows')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $stats = [
            'total' => Personel::count(),
            'active' => Personel::active()->count(),
            'primli' => Personel::primli()->count(),
            'kadrolu' => Personel::kadrolu()->count(),
            'total_follows' => DB::table('social_media_follows')->count(),
        ];

        return view('admin.personel.index', compact('personels', 'stats'));
    }

    public function create()
    {
        $languages = \App\Models\Language::where('is_active', true)->orderBy('sort_order')->get();
        return view('admin.personel.create', compact('languages'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|unique:personels,email',
            'employment_type' => 'required|in:primli,kadrolu',
            'instagram_username' => 'nullable|string|max:255',
            'facebook_username' => 'nullable|string|max:255',
            'tiktok_username' => 'nullable|string|max:255',
            'x_username' => 'nullable|string|max:255',
            'linkedin_username' => 'nullable|string|max:255',
            'youtube_username' => 'nullable|string|max:255',
            'whatsapp_number' => 'nullable|string|max:20',
            'translations' => 'nullable|array',
            'translations.*.position' => 'nullable|string|max:255',
            'translations.*.description' => 'nullable|string',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $personel = Personel::create($validated);

        // Save translations
        if ($request->has('translations')) {
            foreach ($request->translations as $languageId => $translation) {
                $personel->translations()->create([
                    'language_id' => $languageId,
                    'position' => $translation['position'] ?? null,
                    'description' => $translation['description'] ?? null,
                ]);
            }
        }

        return redirect()->route('admin.personel.index')
            ->with('success', 'Personel başarıyla eklendi.');
    }

    public function show(Personel $personel)
    {
        $personel->load('socialMediaFollows');

        // Platform bazında istatistikler
        $platformStats = DB::table('social_media_follows')
            ->select('platform', DB::raw('COUNT(*) as count'))
            ->where('personel_id', $personel->id)
            ->groupBy('platform')
            ->get()
            ->pluck('count', 'platform')
            ->toArray();

        // Son 30 günlük grafik verisi
        $dailyStats = DB::table('social_media_follows')
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(*) as count'))
            ->where('personel_id', $personel->id)
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        return view('admin.personel.show', compact('personel', 'platformStats', 'dailyStats'));
    }

    public function edit(Personel $personel)
    {
        $languages = \App\Models\Language::where('is_active', true)->orderBy('sort_order')->get();
        $personel->load('translations');
        return view('admin.personel.edit', compact('personel', 'languages'));
    }

    public function update(Request $request, Personel $personel)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|unique:personels,email,' . $personel->id,
            'employment_type' => 'required|in:primli,kadrolu',
            'instagram_username' => 'nullable|string|max:255',
            'facebook_username' => 'nullable|string|max:255',
            'tiktok_username' => 'nullable|string|max:255',
            'x_username' => 'nullable|string|max:255',
            'linkedin_username' => 'nullable|string|max:255',
            'youtube_username' => 'nullable|string|max:255',
            'whatsapp_number' => 'nullable|string|max:20',
            'translations' => 'nullable|array',
            'translations.*.position' => 'nullable|string|max:255',
            'translations.*.description' => 'nullable|string',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $personel->update($validated);

        // Update translations
        if ($request->has('translations')) {
            foreach ($request->translations as $languageId => $translation) {
                $personel->translations()->updateOrCreate(
                    ['language_id' => $languageId],
                    [
                        'position' => $translation['position'] ?? null,
                        'description' => $translation['description'] ?? null,
                    ]
                );
            }
        }

        return redirect()->route('admin.personel.index')
            ->with('success', 'Personel bilgileri güncellendi.');
    }

    public function destroy(Personel $personel)
    {
        $personel->delete();

        return redirect()->route('admin.personel.index')
            ->with('success', 'Personel silindi.');
    }

    public function statistics(Request $request)
    {
        // Tarih filtreleme
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $query = DB::table('social_media_follows');

        if ($startDate) {
            $query->where('created_at', '>=', $startDate . ' 00:00:00');
        }

        if ($endDate) {
            $query->where('created_at', '<=', $endDate . ' 23:59:59');
        }

        // En çok takipçi toplayan personeller
        $topPersonels = Personel::withCount(['socialMediaFollows' => function($q) use ($startDate, $endDate) {
                if ($startDate) {
                    $q->where('created_at', '>=', $startDate . ' 00:00:00');
                }
                if ($endDate) {
                    $q->where('created_at', '<=', $endDate . ' 23:59:59');
                }
            }])
            ->orderBy('social_media_follows_count', 'desc')
            ->limit(10)
            ->get();

        // Platform bazında toplam
        $platformTotals = (clone $query)
            ->select('platform', DB::raw('COUNT(*) as count'))
            ->groupBy('platform')
            ->get()
            ->pluck('count', 'platform')
            ->toArray();

        // Son takipler
        $recentFollows = DB::table('social_media_follows')
            ->join('personels', 'social_media_follows.personel_id', '=', 'personels.id')
            ->select('personels.name', 'personels.surname', 'social_media_follows.platform', 'social_media_follows.created_at')
            ->when($startDate, function($q) use ($startDate) {
                return $q->where('social_media_follows.created_at', '>=', $startDate . ' 00:00:00');
            })
            ->when($endDate, function($q) use ($endDate) {
                return $q->where('social_media_follows.created_at', '<=', $endDate . ' 23:59:59');
            })
            ->orderBy('social_media_follows.created_at', 'desc')
            ->limit(50)
            ->get();

        return view('admin.personel.statistics', compact('topPersonels', 'platformTotals', 'recentFollows', 'startDate', 'endDate'));
    }
}
