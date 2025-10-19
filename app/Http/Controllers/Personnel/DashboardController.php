<?php

namespace App\Http\Controllers\Personnel;

use App\Http\Controllers\Controller;
use App\Models\TeamPersonel;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show the personnel dashboard with team colleagues
     */
    public function index(): View
    {
        $user = auth()->user();
        
        // Find if this user has a linked personel record
        // First try to find by email
        $personel = \App\Models\Personel::where('email', $user->email)->first();
        
        if (!$personel) {
            // If no personel found, redirect to home
            return redirect()->route('dashboard')->with('error', 'Personel kaydı bulunamadı.');
        }
        
        // Find the team this personel belongs to
        $teamPersonel = TeamPersonel::where('personel_id', $personel->id)
            ->with('team')
            ->first();
        
        $team = $teamPersonel?->team;
        $colleagues = collect();
        $teamStats = [
            'total_colleagues' => 0,
            'team_leader' => null,
            'group_leader' => null,
        ];
        
        if ($team) {
            // Get all personnel in the same team (excluding self)
            $colleagues = $team->personels()
                ->with('personel')
                ->where('personel_id', '!=', $personel->id)
                ->orderBy('order')
                ->get()
                ->map(fn($tp) => $tp->personel);
            
            $teamStats['total_colleagues'] = $team->personels()->count();
            $teamStats['team_leader'] = $team->leader;
            $teamStats['group_leader'] = $team->groupLeader;
        }
        
        return view('personnel.dashboard', [
            'personel' => $personel,
            'team' => $team,
            'colleagues' => $colleagues,
            'teamStats' => $teamStats,
        ]);
    }

    /**
     * Leave the team
     */
    public function leaveTeam()
    {
        $user = auth()->user();
        
        // Find personel by email
        $personel = \App\Models\Personel::where('email', $user->email)->first();
        
        if (!$personel) {
            return redirect()->back()->with('error', 'Personel kaydı bulunamadı.');
        }
        
        // Find and delete team personel record
        $teamPersonel = TeamPersonel::where('personel_id', $personel->id)->first();
        
        if ($teamPersonel) {
            $teamPersonel->delete();
            return redirect()->route('personnel.dashboard')->with('success', 'Takımdan başarıyla ayrıldınız.');
        }
        
        return redirect()->back()->with('error', 'Takım kaydı bulunamadı.');
    }
}
