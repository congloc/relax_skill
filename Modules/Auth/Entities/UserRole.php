<?php

namespace Modules\Auth\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Users\Entities\User;
use Modules\Roles\Entities\Role;

class UserRole extends Model
{
    protected $table = "user_roles";

    protected $fillable = [
        'user_id',
        'role_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
