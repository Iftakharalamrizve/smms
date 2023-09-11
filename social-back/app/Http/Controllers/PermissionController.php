<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePermissionRequest;
use App\Http\Requests\UpdatePermissionRequest;
use App\Models\Permission;
use App\Services\PermissionGroupService;
use App\Services\PermissionService;
use Illuminate\Http\Request;
use Auth;

class PermissionController extends Controller
{
    protected $permissionService;

    public function __construct()
    {

        $this->permissionService = new PermissionService();

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Auth::check()) {


            $data = new \stdClass;

            if(Auth::user()->can('permission-list')) {

                if(isset($request->perPage) && $request->perPage <= 150){
                    session(['perPage' => $request->perPage]);
                }
                $request->perPage       = session()->has('perPage') ? session('perPage') : config('others.ROW_PER_PAGE');

                $data->perPage          = $request->perPage;
                $data->data             = (new PermissionGroupService)->listItems($request)->data;
                $data->headerLink       = 'permissions.index';
                $data->routeLink        = 'permissions.create';

                return view('permission.list')->with('dataPack', $data)->withTitle('Systems Permission');
            }

            return $this->noPermissionResponse();

        }

        return redirect("login")->withSuccess('Opps! You do not have access');

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if(Auth::check()) {

            $data = new \stdClass;

            if(Auth::user()->can('permission-create')) {

                $data->headerLink = 'permissions.index';
                $data->groups     = (new PermissionGroupService)->listItems($request)->data;
                return view('permission.create')->with(['dataPack' => $data])->withTitle('Systems Permission');

            }
            return $this->noPermissionResponse();

        }

        return redirect("login")->withSuccess('Opps! You need to log in first!!');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePermissionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if(Auth::user()->can('permission-create')) {

            $result = $this->permissionService->createItem($request);

            if($result->status == 201){
                session()->flash('success', $result->message);
            }else{
                session()->flash('error', 'Cannot Create !');
            }

            return redirect()->route('permissions.index');

        }

        return $this->noPermissionResponse();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePermissionRequest  $request
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePermissionRequest $request, Permission $permission)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy(Permission $permission)
    {
        //
    }


    public function Permission()
    {
    	$user_permission = Permission::where('slug','create-tasks')->first();
		$admin_permission = Permission::where('slug', 'edit-users')->first();

		//RoleTableSeeder.php
		$user_role = new Role();
		$user_role->slug = 'user';
		$user_role->name = 'User_Name';
		$user_role->save();
		$user_role->permissions()->attach($user_permission);

		$admin_role = new Role();
		$admin_role->slug = 'admin';
		$admin_role->name = 'Admin_Name';
		$admin_role->save();
		$admin_role->permissions()->attach($admin_permission);

		$user_role = Role::where('slug','user')->first();
		$admin_role = Role::where('slug', 'admin')->first();

		$createTasks = new Permission();
		$createTasks->slug = 'create-tasks';
		$createTasks->name = 'Create Tasks';
		$createTasks->save();
		$createTasks->roles()->attach($user_role);

		$editUsers = new Permission();
		$editUsers->slug = 'edit-users';
		$editUsers->name = 'Edit Users';
		$editUsers->save();
		$editUsers->roles()->attach($admin_role);

		$user_role = Role::where('slug','user')->first();
		$admin_role = Role::where('slug', 'admin')->first();
		$user_perm = Permission::where('slug','create-tasks')->first();
		$admin_perm = Permission::where('slug','edit-users')->first();

		$user = new User();
		$user->name = 'user1';
		$user->email = 'user1@test.com';
		$user->password = bcrypt('1234567');
		$user->save();
		$user->roles()->attach($user_role);
		$user->permissions()->attach($user_perm);

		$admin = new User();
		$admin->name = 'admin';
		$admin->email = 'admin@test.com';
		$admin->password = bcrypt('admin1234');
		$admin->save();
		$admin->roles()->attach($admin_role);
		$admin->permissions()->attach($admin_perm);


		return redirect()->back();
    }

}
