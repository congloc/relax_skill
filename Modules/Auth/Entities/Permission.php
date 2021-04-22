<?php

namespace Modules\Auth\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Permissions\Entities\PermissionRoles;
use Modules\Roles\Entities\Role;

class Permission extends Model
{

    protected $table = 'permission';

    protected $fillable = [
        'name',
        'created_at',
        'updated_at'
    ];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function permission_roles()
    {
        return $this->hasMany(PermissionRoles::class, 'permission_id', 'id');
    }
}
