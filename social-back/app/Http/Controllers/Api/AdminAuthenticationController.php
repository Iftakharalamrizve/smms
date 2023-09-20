<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agent;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Auth;

class AdminAuthenticationController extends Controller
{
    public function login(Request $request)
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
                'status'   => 1
            ];
            $user = User::firstWhere($credentials);
            if (! $user || ! Hash::check($request->password, $user->password)) {
                throw ValidationException::withMessages([
                    'email' => ['Your Credential Is not Correct.'],
                ]);
            }
            $token = $user->createToken('gplex-social-agent')->plainTextToken;
            return response()->json(['token' => $token]);
            // dd(Auth::guard('api')->check($credentials));
            // if (Auth::guard('api')->attempt($credentials)) {

            //     $token = Auth::guard('api')->user()->createToken('gplex-social-agent')->plainTextToken;
            //     return response()->json(['token' => $token]);

            // }
    
            return response()->json(['message' => 'Unauthorized'], 401);

        }

    }

    public function test()
    {
        dd( Auth::guard('api')->user()->username);
    }
}
