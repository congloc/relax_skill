<?php
namespace Modules\Location\Repositories;

use Illuminate\Http\Request;

use Modules\Location\Models\Ward;
use Modules\Location\Models\Customer;

class WardRepository
{
    /**
     * Get data of ward with pagination.
     *
     * @return Ward
     */
    public function getData()
    {
        //return Ward::all();
        return Ward::with(['province'])->get();
    } 
}