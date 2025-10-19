<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SecretWallEntry;
use Illuminate\Http\Request;

class SecretWallController extends Controller
{
    // Liste
    public function index(Request $request)
    {
        $query = SecretWallEntry::query()->withTrashed();

        // Filtreleme
        if ($request->has('status')) {
            if ($request->status === 'pending') {
                $query->pending();
            } elseif ($request->status === 'approved') {
                $query->active();
            } elseif ($request->status === 'deleted') {
                $query->onlyTrashed();
            }
        }

        // Arama
        if ($request->has('search') && !empty($request->search)) {
            $query->where('isimsoyisim', 'like', '%' . $request->search . '%');
        }

        $entries = $query->with('approvedBy')->recent()->paginate(20);
        
        $stats = [
            'total' => SecretWallEntry::count(),
            'pending' => SecretWallEntry::pending()->count(),
            'approved' => SecretWallEntry::active()->count(),
            'deleted' => SecretWallEntry::onlyTrashed()->count(),
            'today' => SecretWallEntry::whereDate('created_at', today())->count(),
        ];

        return view('admin.secret-wall.index', compact('entries', 'stats'));
    }

    // Detay
        public function show($id)
        {
            $entry = SecretWallEntry::withTrashed()->findOrFail($id);
            return view('admin.secret-wall.show', compact('entry'));
        }

    // Onayla
    public function approve(SecretWallEntry $secretWall)
    {
        $secretWall->approve(auth()->id());

        return back()->with('success', '✓ Kayıt başarıyla onaylandı ve yayına alındı.');
    }

    // Reddet
    public function reject(SecretWallEntry $secretWall)
    {
        $secretWall->reject();

        return back()->with('warning', 'Kayıt onayı iptal edildi.');
    }

    // Sil (Soft Delete)
    public function destroy(SecretWallEntry $secretWall)
    {
        $secretWall->delete();

        return redirect()->route('admin.secret-wall.index')
            ->with('success', 'Kayıt çöp kutusuna taşındı.');
    }

    // Kalıcı Sil
    public function forceDelete($id)
    {
        $secretWall = SecretWallEntry::withTrashed()->findOrFail($id);
        $secretWall->forceDelete();

        return redirect()->route('admin.secret-wall.index')
            ->with('success', 'Kayıt kalıcı olarak silindi.');
    }

    // Geri Yükle
    public function restore($id)
    {
        $secretWall = SecretWallEntry::withTrashed()->findOrFail($id);
        $secretWall->restore();

        return redirect()->route('admin.secret-wall.index')
            ->with('success', 'Kayıt geri yüklendi.');
    }

    // Toplu Onaylama
    public function bulkApprove(Request $request)
    {
        $ids = $request->input('ids', []);
        
        SecretWallEntry::whereIn('id', $ids)->each(function($entry) {
            $entry->approve(auth()->id());
        });

        return back()->with('success', count($ids) . ' kayıt onaylandı.');
    }

    // Toplu Silme
    public function bulkDelete(Request $request)
    {
        $ids = $request->input('ids', []);
        SecretWallEntry::whereIn('id', $ids)->delete();

        return back()->with('success', count($ids) . ' kayıt silindi.');
    }

    // İstatistikler
    public function statistics()
    {
        $stats = [
            'total' => SecretWallEntry::count(),
            'approved' => SecretWallEntry::active()->count(),
            'pending' => SecretWallEntry::pending()->count(),
            'rejected' => SecretWallEntry::onlyTrashed()->count(),
            'today_entries' => SecretWallEntry::whereDate('created_at', today())->count(),
            'this_week' => SecretWallEntry::whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])->count(),
            'this_month' => SecretWallEntry::whereMonth('created_at', now()->month)->count(),
        ];

        return view('admin.secret-wall.statistics', compact('stats'));
    }
}