<?php
namespace Database\Seeders;

use App\Helpers\Helper;
use App\Models\Role;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
        Role::truncate();

        $roles = [
            'Admin',
            'Supervisor',
            'User',
        ];


        foreach ($roles as $role) {

            $id = rand(1000, 9999) . rand(1000, 9999) . rand(10, 99);
            Role::Create(
                [
                    'id' => $id,
                    'name' => $role,
                    'slug' => Helper::slugify($role),
                    'created_at' => Carbon::now()->timestamp,
                    'updated_at' => Carbon::now()->timestamp,
                ]);

        }

        Schema::enableForeignKeyConstraints();
    }
}
