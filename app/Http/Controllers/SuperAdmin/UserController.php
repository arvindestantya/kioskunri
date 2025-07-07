<?php

namespace App\Http\Controllers\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Faculty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    /**
     * Menampilkan daftar semua user (selain Super Admin itu sendiri).
     */
    public function index()
    {
        // Ambil semua user yang BUKAN Super Admin
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', '!=', 'Super Admin');
        })->with('faculty')->latest()->paginate(10);
        
        return view('superadmin.users.index', compact('users'));
    }

    /**
     * Menampilkan form untuk membuat user baru.
     */
    public function create()
    {
        $faculties = Faculty::orderBy('name')->get();
        return view('superadmin.users.create', compact('faculties'));
    }

    /**
     * Menyimpan user baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'faculty_id' => ['required', 'exists:faculties,id'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'faculty_id' => $request->faculty_id,
        ]);

        // Berikan peran "Faculty Admin" secara otomatis
        $facultyAdminRole = Role::findByName('Faculty Admin');
        $user->assignRole($facultyAdminRole);

        return redirect()->route('superadmin.users.index')
                         ->with('success', 'User Admin Fakultas berhasil dibuat.');
    }

    /**
     * Menampilkan form untuk mengedit user.
     */
    public function edit(User $user)
    {
        $faculties = Faculty::orderBy('name')->get();
        return view('superadmin.users.edit', compact('user', 'faculties'));
    }

    /**
     * Memperbarui data user di database.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class.',email,'.$user->id],
            'faculty_id' => ['required', 'exists:faculties,id'],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'faculty_id' => $request->faculty_id,
        ]);

        // Hanya update password jika diisi
        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('superadmin.users.index')
                         ->with('success', 'User Admin Fakultas berhasil diperbarui.');
    }

    /**
     * Menghapus user dari database.
     */
    public function destroy(User $user)
    {
        // Tambahkan perlindungan agar tidak bisa menghapus diri sendiri
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak bisa menghapus akun Anda sendiri.');
        }

        $user->delete();

        return redirect()->route('superadmin.users.index')
                         ->with('success', 'User Admin Fakultas berhasil dihapus.');
    }
}