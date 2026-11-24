<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DestinationController extends Controller
{
    public function index(): View
    {
        $destinations = Destination::withCount(['tours', 'hotels'])
            ->paginate(10);

        return view('destinations.index', compact('destinations'));
    }

    public function create(): View
    {
        return view('destinations.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'country' => ['required', 'string', 'max:255'],
            'region' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
        ]);

        Destination::create($validated);

        return redirect()->route('destinations.index')
            ->with('success', 'Напрямок успішно створено!');
    }

    public function edit(Destination $destination): View
    {
        return view('destinations.edit', compact('destination'));
    }

    public function update(Request $request, Destination $destination): RedirectResponse
    {
        $validated = $request->validate([
            'country' => ['required', 'string', 'max:255'],
            'region' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
        ]);

        $destination->update($validated);

        return redirect()->route('destinations.index')
            ->with('success', 'Напрямок успішно оновлено!');
    }

    public function destroy(Destination $destination): RedirectResponse
    {
        if ($destination->tours()->exists() || $destination->hotels()->exists()) {
            return redirect()->route('destinations.index')
                ->with('error', 'Напрямок містить пов’язані тури або готелі.');
        }

        $destination->delete();

        return redirect()->route('destinations.index')
            ->with('success', 'Напрямок успішно видалено!');
    }
}
