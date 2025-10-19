<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StaticPage;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StaticPageController extends Controller
{
    public function index()
    {
        $staticPages = StaticPage::with('translations')->get();
        return view('admin.static-pages.index', compact('staticPages'));
    }

    public function create()
    {
        $languages = Language::where('is_active', true)->orderBy('sort_order')->get();
        $pageTypes = [
            'contact' => 'İletişim',
            'about' => 'Hakkımızda',
            'privacy' => 'Gizlilik Politikası',
            'terms' => 'Kullanım Koşulları',
            'faq' => 'Sıkça Sorulan Sorular',
        ];
        return view('admin.static-pages.create', compact('languages', 'pageTypes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'page_type' => 'required|string|unique:static_pages,page_type',
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'banner_image' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
            'translations' => 'required|array',
            'translations.*.title' => 'required|string|max:255',
            'translations.*.content' => 'nullable|string',
            'translations.*.meta_description' => 'nullable|string',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_active'] = $request->has('is_active');

        // Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('static-pages', 'public');
        }

        // Handle banner image upload
        if ($request->hasFile('banner_image')) {
            $validated['banner_image'] = $request->file('banner_image')->store('static-pages', 'public');
        }

        $staticPage = StaticPage::create($validated);

        // Save translations
        if ($request->has('translations')) {
            foreach ($request->translations as $languageId => $translation) {
                $staticPage->translations()->create([
                    'language_id' => $languageId,
                    'title' => $translation['title'],
                    'content' => $translation['content'] ?? null,
                    'meta_description' => $translation['meta_description'] ?? null,
                ]);
            }
        }

        // Save contact info if page type is contact
        if ($staticPage->page_type === 'contact' && $request->has('contact')) {
            $staticPage->contact()->create($request->contact);
        }

        return redirect()->route('admin.static-pages.index')
            ->with('success', 'Sabit sayfa başarıyla oluşturuldu.');
    }

    public function edit(StaticPage $staticPage)
    {
        $languages = Language::where('is_active', true)->orderBy('sort_order')->get();
        $staticPage->load(['translations', 'contact']);

        $pageTypes = [
            'contact' => 'İletişim',
            'about' => 'Hakkımızda',
            'privacy' => 'Gizlilik Politikası',
            'terms' => 'Kullanım Koşulları',
            'faq' => 'Sıkça Sorulan Sorular',
        ];

        return view('admin.static-pages.edit', compact('staticPage', 'languages', 'pageTypes'));
    }

    public function update(Request $request, StaticPage $staticPage)
    {
        $validated = $request->validate([
            'page_type' => 'required|string|unique:static_pages,page_type,' . $staticPage->id,
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|max:2048',
            'banner_image' => 'nullable|image|max:2048',
            'is_active' => 'boolean',
            'translations' => 'required|array',
            'translations.*.title' => 'required|string|max:255',
            'translations.*.content' => 'nullable|string',
            'translations.*.meta_description' => 'nullable|string',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['is_active'] = $request->has('is_active');

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($staticPage->image) {
                \Storage::disk('public')->delete($staticPage->image);
            }
            $validated['image'] = $request->file('image')->store('static-pages', 'public');
        }

        // Handle banner image upload
        if ($request->hasFile('banner_image')) {
            // Delete old banner image if exists
            if ($staticPage->banner_image) {
                \Storage::disk('public')->delete($staticPage->banner_image);
            }
            $validated['banner_image'] = $request->file('banner_image')->store('static-pages', 'public');
        }

        $staticPage->update($validated);

        // Update translations
        if ($request->has('translations')) {
            foreach ($request->translations as $languageId => $translation) {
                $staticPage->translations()->updateOrCreate(
                    ['language_id' => $languageId],
                    [
                        'title' => $translation['title'],
                        'content' => $translation['content'] ?? null,
                        'meta_description' => $translation['meta_description'] ?? null,
                    ]
                );
            }
        }

        // Update contact info if page type is contact
        if ($staticPage->page_type === 'contact' && $request->has('contact')) {
            $staticPage->contact()->updateOrCreate(
                ['static_page_id' => $staticPage->id],
                $request->contact
            );
        }

        return redirect()->route('admin.static-pages.index')
            ->with('success', 'Sabit sayfa başarıyla güncellendi.');
    }

    public function destroy(StaticPage $staticPage)
    {
        $staticPage->delete();

        return redirect()->route('admin.static-pages.index')
            ->with('success', 'Sabit sayfa silindi.');
    }
}
