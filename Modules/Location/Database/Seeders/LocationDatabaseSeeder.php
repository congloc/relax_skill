<?php

namespace Modules\Location\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Support\Facades\DB;

class LocationDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call("OthersTableSeeder");

        // DB::table('locations')->insert([
        //     'id' => 1,
        //     'name' => 'Default',
        //     'name' => 'district',
        //     'district_id' => 1,
        //     'province_id' => 1,
        // ]);
    }
}
