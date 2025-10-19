<?php

namespace App\Http\Controllers\Personnel;

use App\Http\Controllers\Controller;
use App\Models\Team;
use App\Models\TeamPersonel;
use Illuminate\View\View;

class TeamController extends Controller
{
    /**
     * Show personnel's team details
     */
    public function show(): View
    {
        $user = auth()->user();
        
        // Find personel by user email
        $personel = \App\Models\Personel::where('email', $user->email)->first();
        
        if (!$personel) {
            abort(404, 'Personel bulunamadı');
        }
        
        // Find the team
        $teamPersonel = TeamPersonel::where('personel_id', $personel->id)
            ->with('team')
            ->first();
        
        $team = $teamPersonel?->team;
        
        if (!$team) {
            abort(404, 'Takım bulunamadı');
        }
        
        // Get all personnel in team
        $personnel = $team->personels()
            ->with('personel')
            ->orderBy('order')
            ->get()
            ->map(fn($tp) => $tp->personel);
        
        return view('personnel.team', [
            'team' => $team,
            'personnel' => $personnel,
        ]);
    }
}
