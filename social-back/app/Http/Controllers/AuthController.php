<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Agent;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Auth;
class AuthController extends Controller
{
    //



    /**
     * AuthController constructor.
     * @param UserRepository $userRepository
     */
    public function __construct()
    {
        $this->middleware('guest:agent')->except('logout');
        $this->userRepository   = new UserRepository;
        if(Auth::check()) {

            return redirect()->intended('dashboard');
        }

    }

    public function __invoke(Request $request)
    {

        $input     = $request->all();
        $validator = Validator::make($request->all(), [

            'username'          => 'required',
            'password'          => 'required'

        ]);

        if ($validator->fails()) {

            return response()->json([
                'status_code'   => 400,
                'messages'      => config('status.status_code.400'),
                'errors'        => $validator->messages()->all()
            ]);

        } else {

            $credentials = [
                'username' => $input['username'],
                'password' => $input['password'],
                'status'   => 1
            ];

            if (Auth::attempt($credentials))  {

                return redirect()->intended('agent');

            } else {

                $concatPass = md5($request->username . $request->password);
                $agent      = Agent::firstWhere([['agent_id','=',$input['username']],['password','=',DB::raw("SHA2(CONCAT(agent_id, '$concatPass'), 256)")]]);

                if($agent)
                {
                    Auth::guard('agent')->login($agent);
                    return redirect()->intended('agent');
                }

            }

            return redirect("login")->withSuccess('Oppes! You have entered invalid credentials');

        }

    }
}