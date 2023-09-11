<?php


namespace App\Services;


use App\Helpers\Helper;
use App\Models\Media;
use App\Models\User;
use App\Models\UserDetail;
use App\Repositories\RoleRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserService
{

    protected $userRepository;
    protected $roleRepository;

    public function __construct()
    {

        $this->userRepository       = new UserRepository();
        $this->roleRepository       = new RoleRepository($this->userRepository);

    }

    public function listItems($request)
    {

        DB::beginTransaction();

        try {

            $listing = $this->userRepository->listing($request);

        } catch (Exception $e) {

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
            'status'    => 200,
            'messages'  => config('status.status_code.200'),
            'data'      => $listing
        ];
    }


    public function showItem($id)
    {

        DB::beginTransaction();

        try{

            $user = $this->userRepository->show($id);

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
            'status'  => 200,
            'message' => config('status.status_code.200'),
            'data'    => $user
        ];
    }

    public function createItem($request)
    {
        $rules = [
            'first_name'    => 'required|string|max:50|min:2',
            'last_name'     => 'required|string|max:50|min:2',
            'role'          => 'required',
            'username'      => 'required|string|max:50|min:4|unique:users',
            'password'      => 'required|same:confirm_password',
        ];

        Validator::make($request->all(), $rules)->validate();
        
        $data           = $request->all();
        $data['id']     = Helper::idGenarator();

        DB::beginTransaction();

        $this->userRepository->create($data);

        $user = $this->userRepository->getUser($data['id']);

        $user->roles()->attach($request->role);
        $user_info = $this->userRepository->show($data['id']);
        try{


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
            'user_created'          => $user_info
        ];
    }

    public function updateItem($request,$id)
    {
        $rules = [
            'first_name'    => 'required|string|max:50|min:2',
            'last_name'     => 'required|string|max:50|min:2',
            'role'          => 'required',
            'username'      => 'required|string|max:50|min:4|unique:users',
            'username'      => [
                'required',
                'string',
                'max:50',
                'min:4',
                Rule::unique('users')->ignore($id),
            ]
        ];

        Validator::make($request->all(), $rules)->validate();

        $data   = $request->all();

        DB::beginTransaction();

        try{
            $this->userRepository->update($data,$id);
            
            $user = $this->userRepository->getUser($id);

            if($request->input('role')){

                DB::table('users_roles')->where('user_id', $id)->delete();
                $user->roles()->attach($request->role);

            }

        }catch (Exception $e) {

            DB::rollBack();
            Log::error('Found Exception: ' . $e->getMessage() . ' [Script: ' . __CLASS__ . '@' . __FUNCTION__ . '] [Origin: ' . $e->getFile() . '-' . $e->getLine() . ']');

            return (object)[
                'status'    => 424,
                'messages'  =>config('status.status_code.424'),
                'errors'    => [$e->getMessage()]
            ];
        }

        DB::commit();

        return (object)[
            'status'    => 208,
            'message'   => config('status.status_code.208'),
            'data'      => $user
        ];
    }


    // public function updatePassword($request,$id)
    // {
    //     $user =Auth::user();
    //     $validator = Validator::make($request->all(),[
    //         'current_password' => [
    //             'required',

    //             function ($attribute, $value, $fail) use ($user) {
    //                 if (!Hash::check($value, $user->password)) {
    //                     $fail('Your password was not updated, since the provided current password does not match.');
    //                 }
    //             }
    //         ],
    //         'password' => 'required|between:6,32|same:confirm_password',

    //     ]);

    //     if($validator->fails()) {

    //         return response()->json([
    //             'status_code' => 400,
    //             'messages'    => config('status.status_code.400'),
    //             'errors'      => $validator->errors()->all()
    //         ]);

    //     }

    //     $input['password'] = Hash::make($request->password);

    //     DB::beginTransaction();

    //     try {

    //         $this->userRepository->updatePassword($input,$id);

    //     } catch (Exception $e) {

    //         DB::rollBack();

    //         Log::error('Found Exception: ' . $e->getMessage() . ' [Script: ' . __CLASS__ . '@' . __FUNCTION__ . '] [Origin: ' . $e->getFile() . '-' . $e->getLine() . ']');

    //         return response()->json([
    //             'status_code'   => 424,
    //             'messages'      => config('status.status_code.424'),
    //             'error'         => $e->getMessage()
    //         ]);
    //     }

    //     DB::commit();

    //     return response()->json(['status_code' => 200, 'messages'=>config('status.status_code.200')]);
    // }

    public function deleteItem($id)
    {

        DB::beginTransaction();

        try{
            DB::table('users_roles')->where('user_id', $id)->delete();
            DB::table('users_permissions')->where('user_id', $id)->delete();
            $this->userRepository->delete($id);

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
            'status'    => 209,
            'message'   => config('status.status_code.209'),
        ];

    }



    // public function changeItemStatus($request, $id)
    // {
    //     $data                       = $request->all();

    //     DB::beginTransaction();

    //     try{

    //         if (isset($data['status'])){
    //             $this->userRepository->changeItemStatus($data, $id);
    //         }
    //         $user_info              = $this->userRepository->show($id);

    //     }catch (Exception $e) {

    //         DB::rollBack();

    //         Log::error('Found Exception: ' . $e->getMessage() . ' [Script: ' . __CLASS__ . '@' . __FUNCTION__ . '] [Origin: ' . $e->getFile() . '-' . $e->getLine() . ']');

    //         return response()->json([
    //             'status'            => 424,
    //             'messages'          => config('status.status_code.424'),
    //             'error'             => $e->getMessage()
    //         ]);
    //     }

    //     DB::commit();

    //     return response()->json([
    //         'status'                => 200,
    //         'message'               => config('status.status_code.200'),
    //         'user_info'             => $user_info
    //     ]);

    // }

    // public function checkUniqueIdentity($request)
    // {
    //     $data                       = $request->all();

    //     DB::beginTransaction();

    //     try{

    //         if (isset($data['username'])){
    //             $user_info          = $this->userRepository->checkUserName($data);
    //         }
    //         if (isset($data['email'])){
    //             $user_info          = $this->userRepository->checkUserEmail($data);
    //         }
    //         if (isset($data['mobile'])){
    //             $user_info          = $this->userRepository->checkUserMobile($data);
    //         }

    //     }catch (Exception $e) {

    //         DB::rollBack();

    //         Log::error('Found Exception: ' . $e->getMessage() . ' [Script: ' . __CLASS__ . '@' . __FUNCTION__ . '] [Origin: ' . $e->getFile() . '-' . $e->getLine() . ']');

    //         return response()->json([
    //             'status'            => 424,
    //             'messages'          => config('status.status_code.424'),
    //             'error'             => $e->getMessage()
    //         ]);
    //     }

    //     DB::commit();

    //     if (count($user_info) == 0){
    //         return response()->json([
    //             'status'                => 200,
    //             'message'               => config('status.status_code.200'),
    //             'availability'          => 'Available'
    //         ]);
    //     }else{
    //         return response()->json([
    //             'status'                => 200,
    //             'message'               => config('status.status_code.200'),
    //             'availability'          => 'Taken'
    //         ]);
    //     }
    // }

    // public function storeSpecialPermissions($request, $id){

    //     $allPermissions =  $request->all();

    //     DB::beginTransaction();

    //     try{
    //         DB::table('users_permissions')->where('user_id', $id)->delete();

    //         foreach($allPermissions as $permissions){
    //             foreach($permissions['permissions'] as  $permission){
    //                 if(!$permission['isRoleBasePermission'] && $permission['isPermissionGiven']){
    //                     $this->userRepository->storeUserPermissions($id, $permission['id']);
    //                 }
    //             }
    //         }

    //     }catch (Exception $e) {

    //         DB::rollBack();

    //         Log::error('Found Exception: ' . $e->getMessage() . ' [Script: ' . __CLASS__ . '@' . __FUNCTION__ . '] [Origin: ' . $e->getFile() . '-' . $e->getLine() . ']');

    //         return response()->json([
    //             'status'            => 424,
    //             'messages'          => config('status.status_code.424'),
    //             'error'             => $e->getMessage()
    //         ]);
    //     }

    //     DB::commit();

    //     return response()->json([
    //         'status'                => 200,
    //         'message'               => config('status.status_code.200')
    //     ]);


    // }

    // public function getSpecialPermissions($id){

    //     DB::beginTransaction();

    //     try{

    //         $userPermissions                = $this->userRepository->getSpecialPermissions($id);

    //     }catch (Exception $e) {

    //         DB::rollBack();
    //         Log::error('Found Exception: ' . $e->getMessage() . ' [Script: ' . __CLASS__ . '@' . __FUNCTION__ . '] [Origin: ' . $e->getFile() . '-' . $e->getLine() . ']');

    //         return response()->json([
    //             'status'            => 424,
    //             'messages'          => config('status.status_code.424'),
    //             'error'             => $e->getMessage()
    //         ]);
    //     }

    //     DB::commit();

    //     return response()->json([
    //         'status'                => 200,
    //         'messages'              => config('status.status_code.200'),
    //         'userPermissions'       => $userPermissions
    //     ]);
    // }

    // public function getUsersByRoleName($roleName){

    //     try{

    //         $users                  = $this->userRepository->getUsersByRoleName($roleName);

    //     }catch (Exception $e) {

    //         Log::error('Found Exception: ' . $e->getMessage() . ' [Script: ' . __CLASS__ . '@' . __FUNCTION__ . '] [Origin: ' . $e->getFile() . '-' . $e->getLine() . ']');

    //         return response()->json([
    //             'status'            => 424,
    //             'messages'          => config('status.status_code.424'),
    //             'error'             => $e->getMessage()
    //         ]);
    //     }

    //     return response()->json([
    //         'status'                => 200,
    //         'messages'              => config('status.status_code.200'),
    //         'users'                 => $users
    //     ]);
    // }

    // public function searchUserList($request){
    //     try{

    //         $users                  = $this->userRepository->searchUserList($request);

    //     }catch (Exception $e) {

    //         Log::error('Found Exception: ' . $e->getMessage() . ' [Script: ' . __CLASS__ . '@' . __FUNCTION__ . '] [Origin: ' . $e->getFile() . '-' . $e->getLine() . ']');

    //         return response()->json([
    //             'status'            => 424,
    //             'messages'          => config('status.status_code.424'),
    //             'error'             => $e->getMessage()
    //         ]);
    //     }

    //     return response()->json([
    //         'status'                => 200,
    //         'messages'              => config('status.status_code.200'),
    //         'listing'               => $users
    //     ]);
    // }
}
