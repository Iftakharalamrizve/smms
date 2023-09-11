<?php


namespace App\Repositories;

use App\Models\PermissionGroup as ModelsPermissionGroup;
use App\Traits\QueryTrait;
use App\Models\Role;
use Carbon\Carbon;

class RoleRepository
{
    use QueryTrait;
    // protected $userRepository;

    public function __construct()
    {

        // $this->userRepository = new UserRepository;

    }

    public function listing($request)
    {
        return Role::with('permissions')->orderBy('created_at','DESC')->paginate( $request->perPage );

    }

    public function getAllPermissionGroup()
    {

        return ModelsPermissionGroup::with('permissions')->orderBy('created_at','DESC')->get();

    }

    public function getAllRoles(){
        
        return Role::with('permissions')->get();

    }

    public function show($id)
    {

        return Role::with('permissions','users')->findOrFail($id);

    }

    // public function showMultiple($ids)
    // {

    //     return Role::with('permissions','users')->whereIn('id', $ids)->get();

    // }

    public function create(array  $data)
    {

        $id                 = time();
        $role               = new Role;
        $role->id           = $id;
        $role->name         = $data['name'];
        $role->slug         = isset($data['slug']) ? $data['slug'] : $role->slug;
        $role->created_at   = Carbon::now()->timestamp;
        $role->updated_at   = Carbon::now()->timestamp;
        $role->save();
        return $id;

    }

    public function update(array $data, $id)
    {

        $role               = Role::findorfail($id);
        $role->name         = $data['name'];
        $role->slug         = isset($data['slug']) ? $data['slug'] : $role->slug;
        $role->updated_at   = Carbon::now()->timestamp;
        $role->save();
        return $id;

    }

    public function delete($id)
    {

        $role = Role::with('permissions','users')->findorfail($id);
        return $role->delete();
        
    }

    // public function changeItemStatus(array $data, $id)
    // {

    //     $role                       = Role::with('permissions','users')->findorfail($id);
    //     $role->status               = $data['status'];
    //     //as well as all users status will be changed
    //     if (count($role->users) > 0){
    //         foreach ($role->users as $aUser){
    //             $this->userRepository->changeItemStatus($data, $aUser->id);
    //         }
    //     }
    //     $role->save();
    //     return $role;
    // }

    // public function checkRoleName(array $data)
    // {

    //     $role                       = Role::where('name',$data['name'])->get();
    //     return $role;
    // }

    // public static function filterTask($request, $query, array $whereFilterList, array $likeFilterList)
    // {
    //     $query = self::likeQueryFilter($request, $query, $likeFilterList);
    //     $query = self::whereQueryFilter($request, $query, $whereFilterList);

    //     return $query;

    // }
}
