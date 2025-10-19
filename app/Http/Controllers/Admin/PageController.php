<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\Language;
use App\Models\Category;
use App\Models\PageTranslation;
use Illuminate\Support\Facades\Storage;

class PageController extends Controller
{
    public function index()
    {
        $pages = Page::with(['translations.language', 'categories.translations'])
            ->orderBy('sort_order')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('admin.pages.index', compact('pages'));
    }

    public function create()
    {
        $languages = Language::where('is_active', true)->orderBy('sort_order')->get();
        $categories = Category::with('translations')->where('is_active', true)->get();
        $templates = ['default', 'full-width', 'sidebar-left', 'sidebar-right'];
        
        return view('admin.pages.create', compact('languages', 'categories', 'templates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'slug' => 'required|unique:pages,slug',
            'template' => 'required',
            'image' => 'nullable|image|max:2048',
            'translations' => 'required|array',
            'translations.*.title' => 'nullable|string|max:255',
            'categories' => 'nullable|array',
        ]);

        // Resim yükleme
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('pages', 'public');
        }

        $page = Page::create([
            'slug' => $request->slug,
            'template' => $request->template,
            'image' => $imagePath,
            'is_active' => $request->has('is_active'),
            'sort_order' => $request->sort_order ?? 0
        ]);

        foreach ($request->translations as $languageId => $translation) {
            if (!empty($translation['title'])) {
                PageTranslation::create([
                    'page_id' => $page->id,
                    'language_id' => $languageId,
                    'title' => $translation['title'],
                    'content' => $translation['content'] ?? '',
                    'meta_title' => $translation['meta_title'] ?? $translation['title'],
                    'meta_description' => $translation['meta_description'] ?? '',
                    'meta_keywords' => $translation['meta_keywords'] ?? ''
                ]);
            }
        }

        // Kategorileri ilişkilendir
        if ($request->categories) {
            $page->categories()->sync($request->categories);
        }

        return redirect()->route('admin.pages.index')
            ->with('success', 'Sayfa başarıyla oluşturuldu.');
    }

    public function show(Page $page)
    {
        $page->load(['translations.language', 'categories.translations']);
        
        return view('admin.pages.show', compact('page'));
    }

    public function edit(Page $page)
    {
        $page->load(['translations', 'categories']);
        $languages = Language::where('is_active', true)->orderBy('sort_order')->get();
        $categories = Category::with('translations')->where('is_active', true)->get();
        $templates = ['default', 'full-width', 'sidebar-left', 'sidebar-right'];
        
        // Her dil için translation var mı kontrol et, yoksa boş obje oluştur
        $translations = [];
        foreach ($languages as $language) {
            $translation = $page->translations->where('language_id', $language->id)->first();
            $translations[$language->id] = $translation ?: new PageTranslation(['language_id' => $language->id]);
        }
        
        return view('admin.pages.edit', compact('page', 'languages', 'categories', 'translations', 'templates'));
    }

   public function update(Request $request, Page $page)
{
    $request->validate([
        'slug' => 'required|unique:pages,slug,' . $page->id,
        'template' => 'required',
        'image' => 'nullable|image|max:2048',
        'translations' => 'required|array',
        'translations.*.title' => 'nullable|string|max:255',
        'categories' => 'nullable|array',
    ]);

    $updateData = [
        'slug' => $request->slug,
        'template' => $request->template,
        'is_active' => $request->has('is_active'),
        'sort_order' => $request->sort_order ?? 0
    ];

    // Resim yükleme
    if ($request->hasFile('image')) {
        // Eski resmi sil
        if ($page->image) {
            Storage::disk('public')->delete($page->image);
        }
        $updateData['image'] = $request->file('image')->store('pages', 'public');
    }

    $page->update($updateData);

    foreach ($request->translations as $languageId => $translation) {
        if (!empty($translation['title'])) {
            PageTranslation::updateOrCreate(
                [
                    'page_id' => $page->id,
                    'language_id' => $languageId
                ],
                [
                    'title' => $translation['title'],
                    'content' => $translation['content'] ?? '',
                    'meta_title' => $translation['meta_title'] ?? $translation['title'],
                    'meta_description' => $translation['meta_description'] ?? '',
                    'meta_keywords' => $translation['meta_keywords'] ?? ''
                ]
            );
        }
    }

    // Kategorileri güncelle
    if ($request->has('categories')) {
        $page->categories()->sync($request->categories);
    } else {
        $page->categories()->detach();
    }

    return redirect()->route('admin.pages.index')
        ->with('success', 'Sayfa başarıyla güncellendi.');
}

    public function destroy(Page $page)
    {
        // Resmi sil
        if ($page->image) {
            Storage::disk('public')->delete($page->image);
        }
        
        $page->categories()->detach();
        $page->translations()->delete();
        $page->delete();

        return redirect()->route('admin.pages.index')
            ->with('success', 'Sayfa başarıyla silindi.');
    }
}