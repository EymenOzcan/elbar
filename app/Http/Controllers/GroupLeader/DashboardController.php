<?php

namespace App\Http\Controllers\GroupLeader;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\TeamPersonel;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Grup liderine ait takımlar
        $teams = Team::where('group_leader_id', $user->id)
            ->with(['leader', 'personels.personel'])
            ->withCount('personels')
            ->orderBy('created_at', 'desc')
            ->get();

        $stats = [
            'total_teams' => $teams->count(),
            'active_teams' => $teams->where('is_active', true)->count(),
            'total_personels' => TeamPersonel::whereIn(
                'team_id', 
                $teams->pluck('id')
            )->count(),
        ];

        return view('group-leader.dashboard', compact('teams', 'stats'));
    }
}
