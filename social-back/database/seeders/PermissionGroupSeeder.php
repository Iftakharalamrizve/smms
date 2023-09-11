<?php
namespace Database\Seeders;

use App\Helpers\Helper;
use App\Models\PermissionGroup;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class PermissionGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        PermissionGroup::truncate();

        $groups = [
            'User',
            'Permission',
            'Role',
            'Agent',
            'Social Platform'
        ];


        foreach ($groups as $group) {

            $id = rand(1000, 9999) . rand(1000, 9999) . rand(10, 99);
            PermissionGroup::Create([
                'id' => $id,
                'name' => $group,
                'slug' => Helper::slugify($group),
                'created_at' => Carbon::now()->timestamp,
                'updated_at' => Carbon::now()->timestamp,
            ]);

        }

        Schema::enableForeignKeyConstraints();
    }
}
