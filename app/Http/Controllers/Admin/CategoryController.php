<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Language;
use App\Models\CategoryTranslation;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with(['translations.language'])
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->paginate(10);
        
        $languages = Language::where('is_active', true)->get();
        
        return view('admin.categories.index', compact('categories', 'languages'));
    }

    public function create()
    {
        $languages = Language::where('is_active', true)->orderBy('sort_order')->get();
        $parentCategories = Category::whereNull('parent_id')->with('translations')->get();
        
        return view('admin.categories.create', compact('languages', 'parentCategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'slug' => 'required|unique:categories,slug',
            'translations' => 'required|array',
            'translations.*.name' => 'required|string|max:255',
        ]);

        $category = Category::create([
            'slug' => $request->slug,
            'icon' => $request->icon,
            'color' => $request->color,
            'parent_id' => $request->parent_id,
            'is_active' => $request->has('is_active'),
            'show_in_menu' => $request->has('show_in_menu'),
            'show_in_home' => $request->has('show_in_home'),
            'sort_order' => $request->sort_order ?? 0
        ]);

        // Resim yükleme
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('categories', 'public');
            $category->update(['image' => $imagePath]);
        }

        foreach ($request->translations as $languageId => $translation) {
            if (!empty($translation['name'])) {
                CategoryTranslation::create([
                    'category_id' => $category->id,
                    'language_id' => $languageId,
                    'name' => $translation['name'],
                    'description' => $translation['description'] ?? '',
                    'meta_title' => $translation['meta_title'] ?? $translation['name'],
                    'meta_description' => $translation['meta_description'] ?? '',
                    'meta_keywords' => $translation['meta_keywords'] ?? ''
                ]);
            }
        }

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori başarıyla oluşturuldu.');
    }

    public function show(Category $category)
    {
        $category->load(['translations.language', 'children.translations', 'services.translations']);
        return view('admin.categories.show', compact('category'));
    }

    public function edit(Category $category)
    {
        $languages = Language::where('is_active', true)->orderBy('sort_order')->get();
        $parentCategories = Category::whereNull('parent_id')
            ->where('id', '!=', $category->id)
            ->with('translations')
            ->get();
        
        $category->load('translations');
        
        // Her dil için translation var mı kontrol et
        $translations = [];
        foreach ($languages as $language) {
            $translation = $category->translations->where('language_id', $language->id)->first();
            $translations[$language->id] = $translation ?: new CategoryTranslation(['language_id' => $language->id]);
        }
        
        return view('admin.categories.edit', compact('category', 'languages', 'translations', 'parentCategories'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'slug' => 'required|unique:categories,slug,' . $category->id,
            'translations' => 'required|array',
            'translations.*.name' => 'required|string|max:255',
        ]);

        $category->update([
            'slug' => $request->slug,
            'icon' => $request->icon,
            'color' => $request->color,
            'parent_id' => $request->parent_id,
            'is_active' => $request->has('is_active'),
            'show_in_menu' => $request->has('show_in_menu'),
            'show_in_home' => $request->has('show_in_home'),
            'sort_order' => $request->sort_order ?? 0
        ]);

        // Resim yükleme
        if ($request->hasFile('image')) {
            // Eski resmi sil
            if ($category->image && \Storage::disk('public')->exists($category->image)) {
                \Storage::disk('public')->delete($category->image);
            }
            
            $imagePath = $request->file('image')->store('categories', 'public');
            $category->update(['image' => $imagePath]);
        }

        foreach ($request->translations as $languageId => $translation) {
            if (!empty($translation['name'])) {
                CategoryTranslation::updateOrCreate(
                    [
                        'category_id' => $category->id,
                        'language_id' => $languageId
                    ],
                    [
                        'name' => $translation['name'],
                        'description' => $translation['description'] ?? '',
                        'meta_title' => $translation['meta_title'] ?? $translation['name'],
                        'meta_description' => $translation['meta_description'] ?? '',
                        'meta_keywords' => $translation['meta_keywords'] ?? ''
                    ]
                );
            }
        }

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori başarıyla güncellendi.');
    }

    public function destroy(Category $category)
    {
        // Alt kategorileri kontrol et
        if ($category->children()->exists()) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Bu kategorinin alt kategorileri var. Önce onları silmelisiniz.');
        }

        // Hizmetleri kontrol et
        if ($category->services()->exists()) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Bu kategoriye ait hizmetler var. Önce onları silmelisiniz.');
        }

        // Resmi sil
        if ($category->image && \Storage::disk('public')->exists($category->image)) {
            \Storage::disk('public')->delete($category->image);
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Kategori başarıyla silindi.');
    }
}