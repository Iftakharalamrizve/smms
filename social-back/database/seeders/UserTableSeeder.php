<?php
namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use App\Models\UserDetail;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Str;
use App\Helpers\Helper;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Schema::disableForeignKeyConstraints();
       // User::truncate();
        $userPermission = Permission::all();
        $userRole = Role::where('slug', 'admin')->first();

        DB::table('users')->truncate();
        DB::table('user_details')->truncate();

        DB::table('users_roles')->truncate();
        DB::table('roles_permissions')->truncate();
        DB::table('users_permissions')->truncate();

        $userRole->permissions()->attach($userPermission);

        $user = User::where('username', 'admin')->first();

        if(!$user){

            $userId = Helper::idGenarator();

            User::create([
                'id'                => $userId,
                'username'          => 'root',
                'password'          => bcrypt('welcome2244'),
                'status'            => 1,
                'email_verified_at' => now(),
                'remember_token'    => Str::random(10),
                'created_at'        => Carbon::now()->timestamp,
                'updated_at'        => Carbon::now()->timestamp,
            ]);

            // Create crm api user


            UserDetail::create([
                'id' => $userId,
                'first_name' => 'Crm Api User',
                'last_name'  => 'Crm Api User',
                'mobile'     => '1234567890',
                // 'slug'       => 'crm-api-user',
                'email'      => 'ziaur@genusys.us',
                'created_at' => Carbon::now()->timestamp,
                'updated_at' => Carbon::now()->timestamp,
            ]);

            $user = User::where('username', 'root')->first();
            $user->roles()->attach($userRole);


        }

        Schema::enableForeignKeyConstraints();

    }
}
