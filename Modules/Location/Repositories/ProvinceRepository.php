<?php
namespace Modules\Location\Repositories;

use Illuminate\Http\Request;

use Modules\Location\Models\Province;

class ProvinceRepository
{
    /**
     * Get data of province with pagination.
     *
     * @return Province
     */
    public function getData()
    {
        return Province::with(['wards'])->get();
    }
}