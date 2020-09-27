<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasPermissions;

class Role extends Model
{
    use HasFactory, HasPermissions;

    public function hasPermissionTo(...$permissions) {        
        return $this->permissions()->whereIn('slug', $permissions)->count();
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'roles_permissions');
    }

    public function scopeClient($query)
    {
        return $query->where('slug', 'client');
    }

    public function scopeAdmin($query)
    {
        return $query->where('slug', 'admin');
    }
}
