<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class PeternakController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query()->where('role', 'peternak');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $perPage = $request->input('per_page', 1);
        $users = $query->latest()->paginate($perPage)->withQueryString();

        return view('peternak.index', compact('users'));
    }

    public function create()
    {
        return view('peternak.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'status' => ['required', 'string', 'in:active,inactive'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'peternak', // Hardcoded role
            'status' => $request->status,
        ]);

        return redirect()->route('peternak.index')->with('success', 'Akun Peternak berhasil ditambahkan.');
    }

    public function edit(User $peternak)
    {
        if ($peternak->role !== 'peternak') {
            abort(403, 'Aksi ditolak.');
        }
        return view('peternak.edit', compact('peternak'));
    }

    public function update(Request $request, User $peternak)
    {
        if ($peternak->role !== 'peternak') {
            abort(403, 'Aksi ditolak.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $peternak->id,
            'password' => 'nullable|string|min:8|confirmed',
            'status' => 'required|in:active,inactive',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'status' => $request->status,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $peternak->update($data);

        return redirect()->route('peternak.index')->with('success', 'Data Peternak berhasil diperbarui.');
    }

    public function destroy(User $peternak)
    {
        if ($peternak->role !== 'peternak') {
            abort(403, 'Aksi ditolak.');
        }

        $peternak->delete();

        return redirect()->route('peternak.index')->with('success', 'Akun Peternak berhasil dihapus secara permanen.');
    }
}
