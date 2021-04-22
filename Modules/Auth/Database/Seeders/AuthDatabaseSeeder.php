<?php

namespace Modules\Auth\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Auth\Entities\Permission;
use Nwidart\Modules\Facades\Module;

class AuthDatabaseSeeder extends Seeder
{
    protected $action = ['create', 'show', 'edit','delete'];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $moduleList = Module::all();
        $permissions = [];
        foreach($moduleList as $item){
            for($i = 0; $i < count($this->action);$i++){
                array_push($permissions,[
                    'name'      => strtolower($item->getName()).'_'.$this->action[$i],
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
            }
        }

        Permission::insert($permissions);
    }
}
