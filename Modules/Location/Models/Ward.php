<?php

namespace Modules\Location\Models;

use Illuminate\Database\Eloquent\Model;

class Ward extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','province_id'];

    
    /**
     * Get all of the provinces for the ward.
     * @return province
     */
    public function province()
    {
        return $this->belongsTo(Province::class);
    }    
}
