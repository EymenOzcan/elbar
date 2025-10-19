<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VisualShow;
use Illuminate\Http\Request;

class VisualShowController extends Controller
{
    public function index()
    {
        $visuals = VisualShow::ordered()->paginate(20);

        $stats = [
            'total' => VisualShow::count(),
            'active' => VisualShow::active()->count(),
        ];

        return view('admin.visual-show.index', compact('visuals', 'stats'));
    }

    public function create()
    {
        return view('admin.visual-show.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:10240', // 10MB max
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        // Resmi base64'e çevir
        $image = $request->file('image');
        $imageData = base64_encode(file_get_contents($image->getRealPath()));
        $mimeType = $image->getMimeType();
        $base64Image = 'data:' . $mimeType . ';base64,' . $imageData;

        VisualShow::create([
            'title' => $request->title,
            'description' => $request->description,
            'image_data' => $base64Image,
            'order' => $request->order ?? VisualShow::max('order') + 1,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.visual-show.index')
            ->with('success', 'Görsel başarıyla eklendi.');
    }

    public function edit(VisualShow $visualShow)
    {
        return view('admin.visual-show.edit', compact('visualShow'));
    }

    public function update(Request $request, VisualShow $visualShow)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'order' => 'nullable|integer',
            'is_active' => 'boolean',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'order' => $request->order ?? $visualShow->order,
            'is_active' => $request->has('is_active'),
        ];

        // Eğer yeni resim yüklendiyse
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageData = base64_encode(file_get_contents($image->getRealPath()));
            $mimeType = $image->getMimeType();
            $data['image_data'] = 'data:' . $mimeType . ';base64,' . $imageData;
        }

        $visualShow->update($data);

        return redirect()->route('admin.visual-show.index')
            ->with('success', 'Görsel başarıyla güncellendi.');
    }

    public function destroy(VisualShow $visualShow)
    {
        $visualShow->delete();

        return redirect()->route('admin.visual-show.index')
            ->with('success', 'Görsel başarıyla silindi.');
    }
}
