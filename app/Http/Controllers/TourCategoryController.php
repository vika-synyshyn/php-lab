<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\TourCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class TourCategoryController extends Controller
{
    public function index(): View
    {
        $categories = TourCategory::withCount('tours')
            ->paginate(10);

        return view('categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:tour_categories,name'],
        ]);

        TourCategory::create($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Категорію успішно створено!');
    }

    public function edit(TourCategory $category): View
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, TourCategory $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('tour_categories', 'name')->ignore($category->id),
            ],
        ]);

        $category->update($validated);

        return redirect()->route('categories.index')
            ->with('success', 'Категорію успішно оновлено!');
    }

    public function destroy(TourCategory $category): RedirectResponse
    {
        if ($category->tours()->exists()) {
            return redirect()->route('categories.index')
                ->with('error', 'Категорія містить туристичні пропозиції.');
        }

        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Категорію успішно видалено!');
    }
}
