<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function index()
    {
        $modules = Module::orderBy('sort_order')->get();
        return view('admin.modules.index', compact('modules'));
    }

    public function toggleStatus(Module $module)
    {
        // Deactivate all other modules if activating this one
        if (!$module->is_active) {
            Module::where('id', '!=', $module->id)->update(['is_active' => false]);
        }

        // Toggle the current module
        $module->update(['is_active' => !$module->is_active]);

        return redirect()->route('admin.modules.index')
            ->with('success', 'Modül durumu güncellendi.');
    }
}
