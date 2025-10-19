<?php

namespace App\Http\Controllers\GroupLeader;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\TeamPersonel;
use App\Models\Personel;
use App\Models\User;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        $teams = Team::where('group_leader_id', $user->id)
            ->with(['leader', 'personels.personel'])
            ->withCount('personels')
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('group-leader.teams.index', compact('teams'));
    }

    public function create()
    {
        $user = auth()->user();
        
        $teamLeaders = User::all()->filter(function($u) {
            return $u->hasRole('team-leader');
        })->sortBy('name')->values();
        
        // Sadece personnel rolü olanları göster (admin hariç)
        $personels = Personel::orderBy('name')->get();
        $users = User::all()
            ->filter(function($user) {
                // Personnel rolü var mı kontrol et, admin/super-admin değil mi
                $hasPersonnel = $user->hasRole('personnel');
                $isAdmin = $user->hasRole('admin') || $user->hasRole('super-admin');
                return ($hasPersonnel || $isAdmin) && !$user->hasRole('team-leader') && !$user->hasRole('group-leader');
            })
            ->sortBy('name')
            ->values();
        
        return view('group-leader.teams.create', compact('teamLeaders', 'personels', 'users', 'user'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:teams,name',
            'description' => 'nullable|string',
            'leader_id' => 'nullable|exists:users,id',
            'personel_ids' => 'nullable|array',
            'personel_ids.*' => 'string',
        ]);

        $validated['group_leader_id'] = $user->id;
        $personelIds = $validated['personel_ids'] ?? [];
        unset($validated['personel_ids']);

        $team = Team::create($validated);

        // Add users/personels to team (convert users to personels if needed)
        if (!empty($personelIds)) {
            foreach ($personelIds as $index => $itemId) {
                if (strpos($itemId, '_') !== false) {
                    // "user_123" format - convert to personel
                    [$type, $userId] = explode('_', $itemId);
                    
                    if ($type === 'user') {
                        $user = User::findOrFail($userId);
                        $personel = Personel::where('email', $user->email)->first();
                        
                        if (!$personel) {
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
                        
                        TeamPersonel::create([
                            'team_id' => $team->id,
                            'personel_id' => $personel->id,
                            'order' => $index,
                        ]);
                    }
                } else {
                    // Direct personel ID
                    TeamPersonel::create([
                        'team_id' => $team->id,
                        'personel_id' => $itemId,
                        'order' => $index,
                    ]);
                }
            }
        }

        return redirect()->route('group-leader.teams.show', $team)
            ->with('success', 'Takım başarıyla oluşturuldu.');
    }

    public function show(Team $team)
    {
        $user = auth()->user();
        
        // Grup liderinin kendi takımını görebilmesini kontrol et
        if ($team->group_leader_id !== $user->id) {
            abort(403);
        }

        $team->load('leader', 'personels.personel');
        return view('group-leader.teams.show', compact('team'));
    }

    public function edit(Team $team)
    {
        $user = auth()->user();
        
        // Grup liderinin kendi takımını düzenleyebilmesini kontrol et
        if ($team->group_leader_id !== $user->id) {
            abort(403);
        }

        $team->load('personels.personel');
        
        $teamLeaders = User::all()->filter(function($u) {
            return $u->hasRole('team-leader');
        })->sortBy('name')->values();
        
        // Takımda zaten olan personellerin email'lerini al
        $teamPersonelEmails = $team->personels->pluck('personel.email')->toArray();
        
        // Sadece personnel rolü olanları göster (admin hariç) - takıma eklenenler hariç
        $personels = Personel::orderBy('name')->get();
        $users = User::all()
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
        $teamPersonelIds = $team->personels->pluck('personel_id')->toArray();

        return view('group-leader.teams.edit', compact('team', 'teamLeaders', 'personels', 'users', 'teamPersonelIds'));
    }

    public function update(Request $request, Team $team)
    {
        $user = auth()->user();
        
        // Grup liderinin kendi takımını güncelleyebilmesini kontrol et
        if ($team->group_leader_id !== $user->id) {
            abort(403);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:teams,name,' . $team->id,
            'description' => 'nullable|string',
            'leader_id' => 'nullable|exists:users,id',
            'personel_ids' => 'nullable|array',
            'personel_ids.*' => 'string',
            'is_active' => 'boolean',
        ]);

        $personelIds = $validated['personel_ids'] ?? [];
        unset($validated['personel_ids']);

        $team->update($validated);

        // Get existing personel IDs to preserve those not in the form
        $existingPersonelIds = $team->personels()->pluck('personel_id')->toArray();
        
        // Update personels - only add new ones
        $newPersonelIds = [];
        if (!empty($personelIds)) {
            foreach ($personelIds as $index => $itemId) {
                if (strpos($itemId, '_') !== false) {
                    // "user_123" format - convert to personel
                    [$type, $userId] = explode('_', $itemId);
                    
                    if ($type === 'user') {
                        $user = User::findOrFail($userId);
                        $personel = Personel::where('email', $user->email)->first();
                        
                        if (!$personel) {
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
                        
                        $newPersonelIds[] = $personel->id;
                        TeamPersonel::firstOrCreate(
                            [
                                'team_id' => $team->id,
                                'personel_id' => $personel->id,
                            ],
                            ['order' => $index]
                        );
                    }
                } else {
                    // Direct personel ID
                    $newPersonelIds[] = $itemId;
                    TeamPersonel::firstOrCreate(
                        [
                            'team_id' => $team->id,
                            'personel_id' => $itemId,
                        ],
                        ['order' => $index]
                    );
                }
            }
        }

        // Combine new IDs with existing ones to prevent deletion
        $allPersonelIds = array_merge($newPersonelIds, $existingPersonelIds);
        
        // Remove personels only if they were explicitly removed (optional - currently we only add, don't remove)
        // $team->personels()->whereNotIn('personel_id', $allPersonelIds)->delete();

        return redirect()->route('group-leader.teams.show', $team)
            ->with('success', 'Takım güncellendi.');
    }

    public function destroy(Team $team)
    {
        $user = auth()->user();
        
        // Grup liderinin kendi takımını silebilmesini kontrol et
        if ($team->group_leader_id !== $user->id) {
            abort(403);
        }

        $team->delete();
        return redirect()->route('group-leader.teams.index')
            ->with('success', 'Takım silindi.');
    }

    /**
     * Remove personel from team
     */
    public function removePersonel(Team $team, TeamPersonel $teamPersonel)
    {
        $user = auth()->user();
        
        // Grup liderinin kendi takımından personel silebilmesini kontrol et
        if ($team->group_leader_id !== $user->id) {
            abort(403);
        }

        if ($teamPersonel->team_id !== $team->id) {
            abort(403);
        }

        $teamPersonel->delete();
        return back()->with('success', 'Personel ekipten çıkarıldı.');
    }
}
