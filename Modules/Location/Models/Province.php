<?php

namespace Modules\Location\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name'];

    
    /**
     * Get all of the wards for the province.
     * @return Ward
     */
    public function wards()
    {
        return $this->hasMany(Ward::class);
    }    
}
