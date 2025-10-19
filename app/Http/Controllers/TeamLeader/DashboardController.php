<?php

namespace App\Http\Controllers\TeamLeader;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\TeamPersonel;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        // Takım liderine ait takım
        $team = Team::where('leader_id', $user->id)
            ->with(['groupLeader', 'personels.personel'])
            ->withCount('personels')
            ->first();

        $stats = [
            'total_personels' => $team ? $team->personels_count : 0,
            'team_name' => $team ? $team->name : 'Atanmış takım yok',
        ];

        return view('team-leader.dashboard', compact('team', 'stats'));
    }
}
