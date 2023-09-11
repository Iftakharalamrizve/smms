<?php
namespace App\Services;

use App\Helpers\Helper;
use App\Repositories\RoleRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\Role;
use Illuminate\Validation\Rule;

class RoleService
{
    protected $roleRepository;

    public function __construct()
    {

        $this->roleRepository = new RoleRepository;

    }

    public function listItems($request)
    {
        DB::beginTransaction();

        try{

            $listing = $this->roleRepository->listing($request);

        }catch (Exception $e) {

            DB::rollBack();
            Log::error('Found Exception: ' . $e->getMessage() . ' [Script: ' . __CLASS__ . '@' . __FUNCTION__ . '] [Origin: ' . $e->getFile() . '-' . $e->getLine() . ']');

            return (object)[
                'status'            => 424,
                'messages'          => config('status.status_code.424'),
                'error'             => $e->getMessage()
            ];
        }

        DB::commit();

        return (object)[
            'status'                => 200,
            'messages'              => config('status.status_code.200'),
            'data'                  => $listing
        ];
    }

    public function getAllPermissionGroup(){

        DB::beginTransaction();

        try{

            $listing = $this->roleRepository->getAllPermissionGroup();

        }catch (Exception $e) {

            DB::rollBack();
            Log::error('Found Exception: ' . $e->getMessage() . ' [Script: ' . __CLASS__ . '@' . __FUNCTION__ . '] [Origin: ' . $e->getFile() . '-' . $e->getLine() . ']');

            return (object)[
                'status'            => 424,
                'messages'          => config('status.status_code.424'),
                'error'             => $e->getMessage()
            ];
        }

        DB::commit();

        return (object)[
            'status'                => 200,
            'messages'              => config('status.status_code.200'),
            'data'                  => $listing
        ];

    }

    public function showItem($id)
    {

        DB::beginTransaction();

        try{

            $role = $this->roleRepository->show($id);

        }catch (Exception $e) {

            DB::rollBack();
            Log::error('Found Exception: ' . $e->getMessage() . ' [Script: ' . __CLASS__ . '@' . __FUNCTION__ . '] [Origin: ' . $e->getFile() . '-' . $e->getLine() . ']');

            return (object)[
                'status'            => 424,
                'messages'          => config('status.status_code.424'),
                'error'             => $e->getMessage()
            ];
        }

        DB::commit();

        return (object)[
            'status'                => 200,
            'message'               => config('status.status_code.200'),
            'data'                  => $role
        ];
    }


    public function createItem($request)
    {
        Validator::make($request->all(), [

            'name'                  => 'required|string|max:50|min:3|unique:roles',
            'permissions'           => 'required',

        ])->validate();
        
        $data                       = $request->all();
        $data['slug']               = Helper::slugify($request->name);

        DB::beginTransaction();
        
        try{

            $id                     = $this->roleRepository->create($data);
            $role_info              = $this->roleRepository->show($id);
            foreach($request->permissions as $permission){
                $role_info->permissions()->attach( $permission );
            }
            // $role_info              = $this->roleRepository->show($role_info->id);

        }catch (Exception $e) {

            DB::rollBack();
            Log::error('Found Exception: ' . $e->getMessage() . ' [Script: ' . __CLASS__ . '@' . __FUNCTION__ . '] [Origin: ' . $e->getFile() . '-' . $e->getLine() . ']');

            return (object)[
                'status'            => 424,
                'messages'          => config('status.status_code.424'),
                'error'             => $e->getMessage()
            ];
        }

        DB::commit();

        return (object)[
            'status'                => 201,
            'message'               => config('status.status_code.201'),
            'data'                  => $role_info
        ];
    }

    public function updateItem($request, $id)
    {
        Validator::make($request->all(), [

            'username'      => [
                'name',
                'string',
                'max:50',
                'min:3',
                Rule::unique('roles')->ignore($id),
            ],
            'permissions'           => 'required',

        ])->validate();
        
        $data                       = $request->all();
        $data['slug']               = Helper::slugify($request->name);

        DB::beginTransaction();
        
        try{

            $id                     = $this->roleRepository->update($data, $id);
            $role_info              = $this->roleRepository->show($id);
            DB::table('roles_permissions')->where('role_id', $id)->delete();
            foreach($request->permissions as $permission){
                $role_info->permissions()->attach( $permission );
            }
            
        }catch (Exception $e) {

            DB::rollBack();
            Log::error('Found Exception: ' . $e->getMessage() . ' [Script: ' . __CLASS__ . '@' . __FUNCTION__ . '] [Origin: ' . $e->getFile() . '-' . $e->getLine() . ']');

            return (object)[
                'status'    => 424,
                'messages'  => config('status.status_code.424'),
                'error'     => $e->getMessage()
            ];
        }

        DB::commit();

        return (object)[
            'status'    => 208,
            'message'   => config('status.status_code.208'),
            'data'      => $role_info
        ];
    }


    public function deleteItem($id)
    {

        DB::beginTransaction();

        try{
            
            $previousRole  = Role::with('users')->findOrFail($id);
            $roleUserCount = $previousRole->users->count();

            if($roleUserCount){
                return (object)[
                    'status'        => 620,
                    'message'      => config('status.status_code.620'),
                    'error'         => "Cannot delete this! {$roleUserCount} users belongs this role."
                ];
            }

            DB::table('roles_permissions')->where('role_id', $id)->delete();
            $this->roleRepository->delete($id);

        }catch (Exception $e) {

            DB::rollBack();

            Log::error('Found Exception: ' . $e->getMessage() . ' [Script: ' . __CLASS__ . '@' . __FUNCTION__ . '] [Origin: ' . $e->getFile() . '-' . $e->getLine() . ']');

            return (object)[
                'status'    => 424,
                'message'  => config('status.status_code.424'),
                'error'     => $e->getMessage()
            ];
        }

        DB::commit();

        return (object)[
            'status'    => 209,
            'message'   => config('status.status_code.209'),
        ];

    }


    public function changeItemStatus($request, $id)
    {
        /* $data                       = $request->all();

        DB::beginTransaction();

        try{

            if (isset($data['status'])){
                $this->roleRepository->changeItemStatus($data, $id);
            }
            $role_info              = $this->roleRepository->show($id);

        }catch (Exception $e) {

            DB::rollBack();

            Log::error('Found Exception: ' . $e->getMessage() . ' [Script: ' . __CLASS__ . '@' . __FUNCTION__ . '] [Origin: ' . $e->getFile() . '-' . $e->getLine() . ']');

            return response()->json([
                'status'            => 424,
                'messages'          => config('status.status_code.424'),
                'error'             => $e->getMessage()
            ]);
        }

        DB::commit();

        return response()->json([
            'status'                => 200,
            'message'               => config('status.status_code.200'),
            'role_info'             => $role_info
        ]); */

    }

    public function checkUniqueIdentity($request)
    {
        /* $data                       = $request->all();

        DB::beginTransaction();

        try{

            if (isset($data['name'])){
                $role_info          = $this->roleRepository->checkRoleName($data);
            }

        }catch (Exception $e) {

            DB::rollBack();

            Log::error('Found Exception: ' . $e->getMessage() . ' [Script: ' . __CLASS__ . '@' . __FUNCTION__ . '] [Origin: ' . $e->getFile() . '-' . $e->getLine() . ']');

            return response()->json([
                'status'            => 424,
                'messages'          => config('status.status_code.424'),
                'error'             => $e->getMessage()
            ]);
        }

        DB::commit();

        if (count($role_info) == 0){
            return response()->json([
                'status'                => 200,
                'message'               => config('status.status_code.200'),
                'availability'          => 'Available'
            ]);
        }else{
            return response()->json([
                'status'                => 200,
                'message'               => config('status.status_code.200'),
                'availability'          => 'Taken'
            ]);
        } */
    }
}
