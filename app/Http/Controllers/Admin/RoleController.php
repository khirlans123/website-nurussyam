<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Services\ActivityLogger;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    /**
     * Display a listing of roles.
     */
    public function index()
    {
        $roles = Role::withCount('users')->orderBy('is_system', 'desc')->orderBy('name', 'asc')->get();
        $permissions = Role::availablePermissions();

        return view('admin.roles.index', compact('roles', 'permissions'));
    }

    /**
     * Store a newly created role.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:roles,name',
            'description' => 'nullable|string|max:500',
            'permissions' => 'nullable|array',
            'permissions.*' => 'string',
        ], [
            'name.required' => 'Nama role wewenang wajib diisi.',
            'name.unique' => 'Nama role ini sudah digunakan.',
        ]);

        $baseSlug = Str::slug($validated['name'], '_');
        $slug = $baseSlug;
        $counter = 1;
        while (Role::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '_' . (++$counter);
        }

        $role = Role::create([
            'name' => $validated['name'],
            'slug' => $slug,
            'description' => $validated['description'] ?? null,
            'permissions' => $validated['permissions'] ?? [],
            'is_system' => false,
        ]);

        ActivityLogger::log(
            'ROLE_CREATE',
            'Membuat role akses baru: "' . $role->name . '" (Slug: ' . $role->slug . ', ' . count($role->permissions ?? []) . ' izin hak akses)'
        );

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role akses baru "' . $role->name . '" berhasil ditambahkan ke sistem!');
    }

    /**
     * Update the specified role.
     */
    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100', Rule::unique('roles')->ignore($role->id)],
            'description' => 'nullable|string|max:500',
            'permissions' => 'nullable|array',
            'permissions.*' => 'string',
        ], [
            'name.required' => 'Nama role wewenang wajib diisi.',
            'name.unique' => 'Nama role ini sudah digunakan.',
        ]);

        if (!$role->is_system) {
            $role->name = $validated['name'];
        }
        $role->description = $validated['description'] ?? $role->description;
        
        // Don't strip permissions from super admin
        if ($role->slug !== 'admin') {
            $role->permissions = $validated['permissions'] ?? [];
        }

        $role->save();

        ActivityLogger::log(
            'ROLE_UPDATE',
            'Memperbarui hak akses role: "' . $role->name . '"'
        );

        return redirect()->route('admin.roles.index')
            ->with('success', 'Hak akses role "' . $role->name . '" berhasil diperbarui!');
    }

    /**
     * Remove the specified role.
     */
    public function destroy(Role $role)
    {
        if ($role->is_system) {
            return back()->with('error', 'Role bawaan sistem (' . $role->name . ') tidak dapat dihapus.');
        }

        if ($role->users()->count() > 0) {
            return back()->with('error', 'Role ini masih digunakan oleh ' . $role->users()->count() . ' pengguna. Alihkan role pengguna tersebut sebelum menghapus.');
        }

        $name = $role->name;
        $role->delete();

        ActivityLogger::log('ROLE_DELETE', 'Menghapus role akses: "' . $name . '"');

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role "' . $name . '" berhasil dihapus dari sistem.');
    }
}
