<?php

namespace App\Http\Controllers\TeamLeader;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\Personel;
use App\Models\TeamPersonel;
use App\Models\User;
use Illuminate\Http\Request;

class PersonelController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Takım liderine ait takım
        $team = Team::where('leader_id', $user->id)->first();
        
        if (!$team) {
            return redirect()->back()->with('error', 'Bir takıma atanmamışsınız.');
        }

        // Takıma ait personeller
        $personels = $team->personels()
            ->with('personel')
            ->orderBy('order')
            ->get();
        
        // Takımda zaten olan personellerin email'lerini al
        $teamPersonelEmails = $personels->pluck('personel.email')->toArray();
        
        // Sadece personnel rolü olanları ve takımda olmayanları göster (admin hariç)
        $allUsers = User::all()
            ->filter(function($user) use ($teamPersonelEmails) {
                // Personnel rolü var mı kontrol et, admin/super-admin değil mi
                $hasPersonnel = $user->hasRole('personnel');
                $isAdmin = $user->hasRole('admin') || $user->hasRole('super-admin');
                return ($hasPersonnel || $isAdmin) && 
                       !$user->hasRole('team-leader') && 
                       !$user->hasRole('group-leader') &&
                       !in_array($user->email, $teamPersonelEmails);
            })
            ->sortBy('name')
            ->values();

        return view('team-leader.personel', compact('team', 'personels', 'allUsers'));
    }

    /**
     * Search for personels and users by name
     */
    public function search(Request $request, Team $team)
    {
        $query = $request->get('q', '');
        
        // Takım liderine kontrol - sadece kendi takımını yönetebilir
        if ($team->leader_id !== auth()->id()) {
            abort(403, 'Bu takımı yönetme yetkiniz yok.');
        }

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        // Hem Personel hem User tablosundan ara
        $personels = Personel::where(function ($q) use ($query) {
                $q->whereRaw("LOWER(CONCAT(name, ' ', surname)) LIKE ?", ['%' . strtolower($query) . '%'])
                  ->orWhere('email', 'like', '%' . $query . '%');
            })
            ->where('is_active', true)
            ->get()
            ->map(function ($p) {
                return [
                    'id' => 'personel_' . $p->id,
                    'type' => 'personel',
                    'name' => $p->full_name,
                    'email' => $p->email,
                    'phone' => $p->phone,
                ];
            });

        $users = User::where(function ($q) use ($query) {
                $q->whereRaw("LOWER(name) LIKE ?", ['%' . strtolower($query) . '%'])
                  ->orWhere('email', 'like', '%' . $query . '%');
            })
            ->get()
            ->map(function ($u) {
                return [
                    'id' => 'user_' . $u->id,
                    'type' => 'user',
                    'name' => $u->name,
                    'email' => $u->email,
                    'phone' => null,
                ];
            });

        return response()->json(array_merge($personels->toArray(), $users->toArray()));
    }

    /**
     * Add personel or user to team
     */
    public function store(Request $request, Team $team)
    {
        // Takım liderine kontrol
        if ($team->leader_id !== auth()->id()) {
            abort(403, 'Bu takımı yönetme yetkiniz yok.');
        }

        $validated = $request->validate([
            'item_id' => 'required|array',
            'item_id.*' => 'string',
        ]);

        $itemIds = $validated['item_id'];
        $addedCount = 0;
        $errors = [];

        foreach ($itemIds as $itemId) {
            // item_id formatı: "personel_123" veya "user_123"
            if (!strpos($itemId, '_')) {
                continue;
            }
            
            [$type, $id] = explode('_', $itemId);

            if ($type === 'personel') {
                // Personel var mı kontrol et
                $personel = Personel::find($id);
                if (!$personel) continue;
                
                // Zaten bu takımda mı?
                $exists = TeamPersonel::where('team_id', $team->id)
                    ->where('personel_id', $personel->id)
                    ->exists();

                if ($exists) {
                    $errors[] = $personel->full_name . ' zaten takımda var.';
                    continue;
                }

                $maxOrder = $team->personels()->max('order') ?? -1;
                
                TeamPersonel::create([
                    'team_id' => $team->id,
                    'personel_id' => $personel->id,
                    'order' => $maxOrder + 1,
                ]);
                
                $addedCount++;
            } elseif ($type === 'user') {
                // User'ı personel olarak ekle
                $user = User::find($id);
                if (!$user) continue;
                
                $personel = Personel::where('email', $user->email)->first();
                
                if (!$personel) {
                    // Yeni personel oluştur
                    $nameParts = explode(' ', trim($user->name), 2);
                    $personel = Personel::create([
                        'user_id' => $user->id,
                        'name' => $nameParts[0],
                        'surname' => $nameParts[1] ?? 'Kullanıcı',
                        'email' => $user->email,
                        'employment_type' => 'kadrolu',
                        'is_active' => true,
                    ]);
                }

                // Zaten bu takımda mı?
                $exists = TeamPersonel::where('team_id', $team->id)
                    ->where('personel_id', $personel->id)
                    ->exists();

                if ($exists) {
                    $errors[] = $user->name . ' zaten takımda var.';
                    continue;
                }

                $maxOrder = $team->personels()->max('order') ?? -1;
                
                TeamPersonel::create([
                    'team_id' => $team->id,
                    'personel_id' => $personel->id,
                    'order' => $maxOrder + 1,
                ]);
                
                $addedCount++;
            }
        }

        $message = $addedCount > 0 ? "$addedCount kişi takıma eklendi." : 'Kimse eklenmedi.';
        if (!empty($errors)) {
            $message .= ' ' . implode(' ', $errors);
        }

        return back()->with('success', $message);
    }

    /**
     * Remove personel from team
     */
    public function destroy(Request $request, Team $team, TeamPersonel $teamPersonel)
    {
        // Takım liderine kontrol
        if ($team->leader_id !== auth()->id()) {
            abort(403, 'Bu takımı yönetme yetkiniz yok.');
        }

        if ($teamPersonel->team_id !== $team->id) {
            abort(403, 'Bu personel bu takımda değil.');
        }

        $personel = $teamPersonel->personel;
        $teamPersonel->delete();

        return back()->with('success', $personel->full_name . ' takımdan çıkarıldı.');
    }
}
