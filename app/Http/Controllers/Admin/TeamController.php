<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\TeamPersonel;
use App\Models\Personel;
use App\Models\User;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    /**
     * Display a listing of all teams
     */
    public function index()
    {
        $user = auth()->user();
        
        // Rol kontrolü
        if ($user->hasRole('group-leader')) {
            // Grup lideri: sadece kendi takımlarını görsün
            $teams = Team::where('group_leader_id', $user->id)
                ->with(['leader', 'groupLeader', 'personels.personel'])
                ->withCount('personels')
                ->orderBy('created_at', 'desc')
                ->paginate(20);
        } elseif ($user->hasRole('team-leader')) {
            // Takım lideri: sadece kendi takımını görsün
            $teams = Team::where('leader_id', $user->id)
                ->with(['leader', 'groupLeader', 'personels.personel'])
                ->withCount('personels')
                ->orderBy('created_at', 'desc')
                ->paginate(20);
        } else {
            // Super admin / admin: tümünü görsün
            $teams = Team::with(['leader', 'groupLeader', 'personels.personel'])
                ->withCount('personels')
                ->orderBy('created_at', 'desc')
                ->paginate(20);
        }

        $stats = [
            'total_teams' => Team::count(),
            'active_teams' => Team::where('is_active', true)->count(),
            'total_personels_in_teams' => TeamPersonel::count(),
        ];

        return view('admin.teams.index', compact('teams', 'stats'));
    }

    /**
     * Show the form for creating a new team
     */
    public function create()
    {
        $groupLeaders = User::all()->filter(function($user) {
            return $user->hasRole('group-leader');
        })->sortBy('name')->values();
        
        $teamLeaders = User::all()->filter(function($user) {
            return $user->hasRole('team-leader');
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
        
        return view('admin.teams.create', compact('groupLeaders', 'teamLeaders', 'users', 'personels'));
    }

    /**
     * Store a newly created team in storage
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:teams,name',
            'description' => 'nullable|string',
            'group_leader_id' => 'nullable|exists:users,id',
            'leader_id' => 'nullable|exists:users,id',
            'personel_ids' => 'nullable|array',
            'personel_ids.*' => 'string', // user_ID format: "user_123"
        ]);

        $team = Team::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'group_leader_id' => $validated['group_leader_id'],
            'leader_id' => $validated['leader_id'],
        ]);

        // Add users to team (convert users to personels)
        if (!empty($validated['personel_ids'])) {
            foreach ($validated['personel_ids'] as $index => $itemId) {
                // Extract user ID from "user_123" format
                if (strpos($itemId, '_') !== false) {
                    [$type, $userId] = explode('_', $itemId);
                    
                    if ($type === 'user') {
                        // Find or create personel from user
                        $user = User::findOrFail($userId);
                        $personel = Personel::where('email', $user->email)->first();
                        
                        if (!$personel) {
                            // Adı ve soyadı ayır
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
                        
                        $personelId = $personel->id;
                        
                        // Check if already exists
                        $exists = TeamPersonel::where('team_id', $team->id)
                            ->where('personel_id', $personelId)
                            ->exists();
                        
                        if (!$exists) {
                            TeamPersonel::create([
                                'team_id' => $team->id,
                                'personel_id' => $personelId,
                                'order' => $index,
                            ]);
                        }
                    }
                }
            }
        }

        return redirect()->route('admin.teams.show', $team)
            ->with('success', 'Takım başarıyla oluşturuldu.');
    }

    /**
     * Display the specified team
     */
    public function show(Team $team)
    {
        $team->load('leader', 'groupLeader', 'personels.personel');
        return view('admin.teams.show', compact('team'));
    }

    /**
     * Show the form for editing the team
     */
    public function edit(Team $team)
    {
        $team->load('personels.personel');
        
        $groupLeaders = User::all()->filter(function($user) {
            return $user->hasRole('group-leader');
        })->sortBy('name')->values();
        
        $teamLeaders = User::all()->filter(function($user) {
            return $user->hasRole('team-leader');
        })->sortBy('name')->values();
        
        // Takımda zaten olan personellerin email'lerini al
        $teamPersonelEmails = $team->personels->pluck('personel.email')->toArray();
        
        // Sadece personnel rolü olanları göster (admin hariç) - takıma eklenenler hariç
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
        $personels = Personel::orderBy('name')->get();
        $teamPersonelIds = $team->personels->pluck('personel_id')->toArray();

        return view('admin.teams.edit', compact('team', 'groupLeaders', 'teamLeaders', 'users', 'personels', 'teamPersonelIds'));
    }

    /**
     * Update the specified team in storage
     */
    public function update(Request $request, Team $team)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:teams,name,' . $team->id,
            'description' => 'nullable|string',
            'group_leader_id' => 'nullable|exists:users,id',
            'leader_id' => 'nullable|exists:users,id',
            'personel_ids' => 'nullable|array',
            'personel_ids.*' => 'string', // user_ID format: "user_123"
            'is_active' => 'boolean',
        ]);

        $team->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'group_leader_id' => $validated['group_leader_id'],
            'leader_id' => $validated['leader_id'],
            'is_active' => $validated['is_active'] ?? true,
        ]);

        // Update personels (convert users to personels)
        $newPersonelIds = [];
        if (!empty($validated['personel_ids'])) {
            foreach ($validated['personel_ids'] as $index => $itemId) {
                // Extract user ID from "user_123" format
                if (strpos($itemId, '_') !== false) {
                    [$type, $userId] = explode('_', $itemId);
                    
                    if ($type === 'user') {
                        // Find or create personel from user
                        $user = User::findOrFail($userId);
                        $personel = Personel::where('email', $user->email)->first();
                        
                        if (!$personel) {
                            // Adı ve soyadı ayır
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
                        
                        $personelId = $personel->id;
                        $newPersonelIds[] = $personelId;
                        
                        // Create if doesn't exist
                        TeamPersonel::firstOrCreate(
                            [
                                'team_id' => $team->id,
                                'personel_id' => $personelId,
                            ],
                            ['order' => $index]
                        );
                    }
                }
            }
        }

        // Get existing personel IDs to preserve those not in the form
        $existingPersonelIds = $team->personels()->pluck('personel_id')->toArray();
        
        // Combine new IDs with existing ones to prevent deletion
        $allPersonelIds = array_merge($newPersonelIds, $existingPersonelIds);
        
        // Remove personels only if they were explicitly removed (optional - currently we only add, don't remove)
        // $team->personels()->whereNotIn('personel_id', $allPersonelIds)->delete();

        return redirect()->route('admin.teams.show', $team)
            ->with('success', 'Takım güncellendi.');
    }

    /**
     * Remove the specified team from storage
     */
    public function destroy(Team $team)
    {
        $team->delete();
        return redirect()->route('admin.teams.index')
            ->with('success', 'Takım silindi.');
    }

    /**
     * Add personel to team
     */
    public function addPersonel(Request $request, Team $team)
    {
        $validated = $request->validate([
            'personel_id' => 'required|exists:personels,id|unique:team_personels,personel_id,null,id,team_id,' . $team->id,
        ]);

        $maxOrder = $team->personels()->max('order') ?? -1;

        TeamPersonel::create([
            'team_id' => $team->id,
            'personel_id' => $validated['personel_id'],
            'order' => $maxOrder + 1,
        ]);

        return back()->with('success', 'Personel ekip\'e eklendi.');
    }

    /**
     * Remove personel from team
     */
    public function removePersonel(Team $team, TeamPersonel $teamPersonel)
    {
        if ($teamPersonel->team_id !== $team->id) {
            abort(403);
        }

        $teamPersonel->delete();
        return back()->with('success', 'Personel ekipten çıkarıldı.');
    }

    /**
     * Reorder personels in team
     */
    public function reorderPersonels(Request $request, Team $team)
    {
        $validated = $request->validate([
            'orders' => 'required|array',
            'orders.*' => 'integer',
        ]);

        foreach ($validated['orders'] as $index => $teamPersonelId) {
            TeamPersonel::where('id', $teamPersonelId)
                ->where('team_id', $team->id)
                ->update(['order' => $index]);
        }

        return response()->json(['success' => true]);
    }

    /**
     * Search for users (admin personel selection)
     */
    public function searchPersonels(Request $request)
    {
        $query = $request->input('q', '');
        
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        // Search in Users table only
        $users = User::where(function ($q) use ($query) {
            $q->whereRaw("LOWER(name) LIKE ?", ['%' . strtolower($query) . '%'])
              ->orWhere('email', 'like', '%' . $query . '%');
        })
        ->limit(10)
        ->get()
        ->map(fn($u) => [
            'id' => $u->id,
            'type' => 'user',
            'name' => $u->name,
            'email' => $u->email,
        ]);

        return response()->json($users->toArray());
    }
}
