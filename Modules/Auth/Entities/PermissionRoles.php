<?php

namespace Modules\Auth\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Permissions\Entities\Permission;
use Modules\Roles\Entities\Role;

class PermissionRoles extends Model
{
    protected $table = "permission_roles";

    protected $fillable = [
        'permission_id',
        'role_id'
    ];

    public function permission()
    {
        return $this->belongsTo(Permission::class, 'permission_id');
    }

    public function roles()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
