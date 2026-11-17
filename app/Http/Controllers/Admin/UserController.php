<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:user,petugas',
        ]);

        User::create($data);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Akun berhasil ditambahkan.');
    }

    public function edit(User $user)
    {
        if ($user->role === 'admin') {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'Akun Admin tidak dapat diedit dari menu ini.');
        }

        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if ($user->role === 'admin') {
            return redirect()
                ->route('admin.users.index')
                ->with('error', 'Akun Admin tidak dapat diubah dari menu ini.');
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'role' => 'required|in:user,petugas',
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        if (empty($data['password'])) {
            unset($data['password']);
        }

        $user->update($data);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Data akun berhasil diperbarui.');
    }

    public function destroy(User $user)
    {
        if ($user->role === 'admin') {
            return back()->with('error', 'Akun Admin tidak boleh dihapus.');
        }

        if ($user->id === auth()->id()) {
            return back()->with('error', 'Kamu tidak dapat menghapus akun sendiri.');
        }

        if ($user->peminjamans()->exists()) {
            return back()->with(
                'error',
                'Akun tidak dapat dihapus karena masih memiliki riwayat peminjaman.'
            );
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'Akun berhasil dihapus.');
    }
}
