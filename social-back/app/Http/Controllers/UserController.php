<?php

namespace App\Http\Controllers;

use App\Repositories\RoleRepository;
use Illuminate\Http\Request;
use App\Services\UserService;
use Session;
use Auth;
use stdClass;

class UserController extends Controller
{

    protected $userService, $response;

    public function __construct(UserService $userService)
    {

        $this->userService = $userService;

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if(Auth::check()) {

            $data = new stdClass;

            if(Auth::user()->can('user-list')) {

                if(isset($request->perPage) && $request->perPage <= 150){
                    session(['perPage' => $request->perPage]);
                }
                $request->perPage   = session()->has('perPage') ? session('perPage') : config('others.ROW_PER_PAGE');

                $data->perPage      = $request->perPage;
                $data->data         = $this->userService->listItems($request)->data;
                $data->headerLink   = 'users.index';
                $data->routeLink    = 'users.create';

                return view('webUser.list')->with('dataPack', $data)->withTitle('Systems Users');
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

            if(Auth::user()->can('user-create')) {

                $data->headerLink = 'users.index';
                $data->roles      = (new RoleRepository)->getAllRoles();
                return view('webUser.create')->with(['dataPack' => $data])->withTitle('Systems Users');

            }
            return $this->noPermissionResponse();

        }

        return redirect("login")->withSuccess('Opps! You need to log in first!!');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if(Auth::user()->can('user-create')) {

            $result = $this->userService->createItem($request);

            if($result->status == 201){
                session()->flash('success', $result->message);
            }else{
                session()->flash('error', 'Cannot Create !');
            }

            return redirect()->route('users.index');

        }

        return $this->noPermissionResponse();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::check()) {

            $data = new \stdClass;

            if(Auth::user()->can('user-edit')) {

                $data->user         = $this->userService->showItem($id)->data;
                $data->roles        = (new RoleRepository)->getAllRoles();
                $data->headerLink   = 'users.index';


                return view('webUser.edit')->with(['dataPack' => $data])->withTitle('System User');
            }
            return $this->noPermissionResponse();
        }

        return redirect("login")->withSuccess('Opps! You need to log in first!!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if(Auth::user()->can('user-edit')) {

            $result = $this->userService->updateItem($request, $id);

            if($result->status == 208){
                session()->flash('success', $result->message);
            }else{
                session()->flash('error', 'Cannot Edit !');
            }

            return redirect()->route('users.index');

        }

        return $this->noPermissionResponse();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if(Auth::user()->can('user-delete')) {

            $result = $this->userService->deleteItem($id);

            if($result->status == 209){
                session()->flash('success', $result->message);
            }else{
                session()->flash('error', 'Cannot Delete !');
            }

            return redirect()->route('users.index');

        }

        return $this->noPermissionResponse();
    }


    public function logout(Request $request) {

        Session::flush();
        Auth::logout();

        return Redirect('login');

    }
}
