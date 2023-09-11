<?php
namespace Database\Seeders;

use App\Helpers\Helper;
use App\Models\Permission;
use App\Models\PermissionGroup;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class PermissionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Permission::truncate();

        $group_and_permission = [

            'user' => [
                'User List',
                'User Create',
                'User Store',
                'User Edit',
                'User Update',
                'User Delete',
            ],
            'permission' => [
                'Permission List',
                'Permission Create',
                'Permission Store',
                'Permission Edit',
                'Permission Update',
                'Permission Delete'
            ],
            'role' => [
                'Role List',
                'Role Create',
                'Role Store',
                'Role Edit',
                'Role Update',
                'Role Delete'
            ],
            'agent' => [
                'Agent List',
                'Agent Create',
                'Agent Store',
                'Agent Edit',
                'Agent Update',
                'Agent Delete'
            ],
            'social-platform' => [
                'Social Platform List',
                'Social Platform Create',
                'Social Platform Store',
                'Social Platform Edit',
                'Social Platform Update',
                'Social Platform Delete'
            ],

        ];

        foreach ($group_and_permission as $group => $Permissions) {

            if($id = PermissionGroup::where('slug', $group)->first()->id){
                foreach($Permissions as $Permission){
                    Permission::Create([
                        'id'=>rand(1000, 9999) . rand(1000, 9999) . rand(10, 99),
                        'permission_group_id'=>$id,
                        'name' => $Permission, 'slug' => Helper::slugify($Permission),
                        'created_at' => Carbon::now()->timestamp,
                        'updated_at' => Carbon::now()->timestamp,
                    ]);
                }
            }

        }

        Schema::enableForeignKeyConstraints();
    }
}
