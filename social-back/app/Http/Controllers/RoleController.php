<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRoleRequest;
use App\Http\Requests\UpdateRoleRequest;
use App\Models\Role;
use App\Services\RoleService;
use Illuminate\Http\Request;
use Auth;

class RoleController extends Controller
{
    protected $roleService;

    public function __construct()
    {

        $this->roleService = new RoleService;

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

            if(Auth::user()->can('role-list')) {

                if(isset($request->perPage) && $request->perPage <= 150){
                    session(['perPage' => $request->perPage]);
                }
                $request->perPage   = session()->has('perPage') ? session('perPage') : config('others.ROW_PER_PAGE');
                $data->perPage      = $request->perPage;
                $data->data         = $this->roleService->listItems($request)->data;
                $data->headerLink   = 'roles.index';
                $data->routeLink    = 'roles.create';

                return view('role.list')->with('dataPack', $data)->withTitle('Systems Role');
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
    public function create()
    {
        if(Auth::check()) {

            $data = new \stdClass;

            if(Auth::user()->can('role-create')) {

                $data->headerLink = 'roles.index';
                $data->groups     = $this->roleService->getAllPermissionGroup()->data;
                return view('role.create')->with(['dataPack' => $data])->withTitle('Systems Role');

            }
            return $this->noPermissionResponse();

        }

        return redirect("login")->withSuccess('Opps! You need to log in first!!');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRoleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if(Auth::user()->can('role-create')) {

            $result = $this->roleService->createItem($request);

            if($result->status == 201){
                session()->flash('success', $result->message);
            }else{
                session()->flash('error', 'Cannot Create !');
            }

            return redirect()->route('roles.index');

        }

        return $this->noPermissionResponse();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::check()) {

            $data = new \stdClass;

            if(Auth::user()->can('role-edit')) {

                $data->headerLink       = 'roles.index';
                $data->role             = $this->roleService->showItem($id)->data;
                $data->permissionIds    = $data->role->permissions->pluck('id')->toArray();
                $data->groups           = $this->roleService->getAllPermissionGroup()->data;

                return view('role.edit')->with(['dataPack' => $data])->withTitle('Systems Role');
            }
            return $this->noPermissionResponse();
        }

        return redirect("login")->withSuccess('Opps! You need to log in first!!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRoleRequest  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(Auth::user()->can('role-edit')) {

            $result = $this->roleService->updateItem($request, $id);

            if($result->status == 208){
                session()->flash('success', $result->message);
            }else{
                session()->flash('error', 'Cannot Edit !');
            }

            return redirect()->route('roles.index');

        }

        return $this->noPermissionResponse();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->can('role-delete')) {

            $result = $this->roleService->deleteItem($id);

            if($result->status == 209){
                session()->flash('success', $result->message);
            }else{
                session()->flash('error', isset($result->error) ? $result->error : 'Cannot Delete !');
            }

            return redirect()->route('roles.index');

        }

        return $this->noPermissionResponse();
    }
}
