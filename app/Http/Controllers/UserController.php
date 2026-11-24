<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        abort_unless($request->user()?->role === 'admin', 403);

        $users = User::paginate(10);

        return view('users.index', compact('users'));
    }

    public function create(Request $request): View
    {
        abort_unless($request->user()?->role === 'admin', 403);

        return view('users.create');
    }

    public function store(Request $request): RedirectResponse
    {
        abort_unless($request->user()?->role === 'admin', 403);

        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required', Rule::in(['customer', 'manager', 'admin'])],
        ]);

        User::create($validated);

        return redirect()->route('users.index')
            ->with('success', 'Користувача успішно створено!');
    }

    public function edit(Request $request, User $user): View
    {
        abort_unless($request->user()?->role === 'admin', 403);

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user): RedirectResponse
    {
        abort_unless($request->user()?->role === 'admin', 403);

        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'password' => ['nullable', 'string', 'min:8'],
            'role' => ['required', Rule::in(['customer', 'manager', 'admin'])],
        ]);

        if (empty($validated['password'])) {
            unset($validated['password']);
        }

        if ($request->user()->id === $user->id && $validated['role'] !== 'admin') {
            return redirect()->route('users.index')
                ->with('error', 'Не можна змінити власну роль адміністратора.');
        }

        $user->update($validated);

        return redirect()->route('users.index')
            ->with('success', 'Користувача успішно оновлено!');
    }

    public function destroy(Request $request, User $user): RedirectResponse
    {
        abort_unless($request->user()?->role === 'admin', 403);

        if ($request->user()->id === $user->id) {
            return redirect()->route('users.index')
                ->with('error', 'Не можна видалити власний обліковий запис.');
        }

        if (
            $user->tours()->exists() ||
            $user->bookings()->exists() ||
            $user->moderationRecords()->exists()
        ) {
            return redirect()->route('users.index')
                ->with('error', 'Користувач має пов’язані записи.');
        }

        $user->delete();

        return redirect()->route('users.index')
            ->with('success', 'Користувача успішно видалено!');
    }
}
