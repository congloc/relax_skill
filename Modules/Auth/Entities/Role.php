<?php

namespace Modules\Auth\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Permission\Entities\Permission;
use Modules\User\Entities\User;
use Modules\Permission\Entities\PermissionRoles;
use Modules\Users\Entities\UserRole;

class Role extends Model
{
    protected $table = 'roles';

    protected $fillable = [
        'id',
        'name',
        'created_at',
        'updated_at',
    ];

    public function user_roles()
    {
        return $this->hasMany(UserRole::class, 'role_id', 'id');
    }

    public function permission_roles()
    {
        return $this->hasMany(PermissionRoles::class, 'role_id', 'id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
