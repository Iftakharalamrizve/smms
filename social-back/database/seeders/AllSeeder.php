<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AllSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([

            PermissionGroupSeeder::class,
            PermissionTableSeeder::class,
            RoleTableSeeder::class,
            // BulkUserTableSeeder::class,
            //GroupSeeder::class,
            UserTableSeeder::class,

        ]);
    }
}
