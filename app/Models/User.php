<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * Relationship with Role
     */
    public function roleModel()
    {
        return $this->belongsTo(Role::class, 'role', 'slug');
    }

    /**
     * Role Helper Methods
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isStaff(): bool
    {
        return $this->role === 'staff';
    }

    public function isPenulis(): bool
    {
        return $this->role === 'penulis';
    }

    public function hasRole(...$roles): bool
    {
        $allowed = is_array($roles[0] ?? null) ? $roles[0] : $roles;
        return in_array($this->role, $allowed, true);
    }

    protected ?Role $cachedRoleInstance = null;

    public function getRoleInstance(): ?Role
    {
        if ($this->cachedRoleInstance === null) {
            $this->cachedRoleInstance = Role::where('slug', $this->role)->first();
        }
        return $this->cachedRoleInstance;
    }

    /**
     * Check if user has specific permission
     */
    public function hasPermission(string $permission): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        $roleObj = $this->getRoleInstance();
        if ($roleObj && is_array($roleObj->permissions)) {
            return in_array($permission, $roleObj->permissions, true);
        }

        return false;
    }

    /**
     * Check if user has any of the specified permissions
     */
    public function hasAnyPermission(...$permissions): bool
    {
        if ($this->isAdmin()) {
            return true;
        }

        $perms = is_array($permissions[0] ?? null) ? $permissions[0] : $permissions;
        foreach ($perms as $p) {
            if ($this->hasPermission($p)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Human readable role name.
     */
    public function getRoleLabelAttribute(): string
    {
        $roleObj = Role::where('slug', $this->role)->first();
        if ($roleObj) {
            return $roleObj->name;
        }

        return match ($this->role) {
            'admin' => 'Super Admin',
            'staff' => 'Staff PSB & Berita',
            'penulis' => 'Penulis Berita',
            default => ucfirst(str_replace('_', ' ', $this->role ?? 'User')),
        };
    }

    /**
     * Badge class for UI.
     */
    public function getRoleBadgeClassAttribute(): string
    {
        return match ($this->role) {
            'admin' => 'badge-emerald',
            'staff' => 'badge-blue',
            'penulis' => 'badge-amber',
            default => 'badge-slate',
        };
    }
}
