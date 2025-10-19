<?php

namespace App\Http\Controllers;

use App\Models\VisualShow;
use Illuminate\Http\Request;

class VisualShowPublicController extends Controller
{
    public function index()
    {
        $visuals = VisualShow::active()->ordered()->get();

        return view('visual-show.index', compact('visuals'));
    }
}
