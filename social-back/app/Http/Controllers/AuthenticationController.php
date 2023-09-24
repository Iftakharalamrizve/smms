<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\Agent;
use Illuminate\Support\Facades\DB;

class AuthenticationController extends Controller
{
    public function login(Request $request)
    {
        $input = $request->all();
        $validator = Validator::make($input, [
            'username' => 'required',
            'password' => 'required'
        ]);

        if ($validator->fails()) {
            return $this->respondValidationError('Your Data Is Not Valid', $validator->messages()->all());
        } else {
        
            $credentials = [
                'username' => $input['username'],
                'status' => 1
            ];
            
            $user = User::firstWhere($credentials);
            
            if ($user && Hash::check($request->password, $user->password)) {
                $token = $user->createToken('gplex-social-admin', ['role:admin'])->plainTextToken;
                return $this->respondWithToken($token, $user, 'Admin');
            }
            
            $username = $input['username'];
            $password = $input['password'];
            
            $concatPass = md5($username . $password);
            $password = DB::raw("SHA2(CONCAT(agent_id, '$concatPass'), 256)");
            
            $agent = Agent::firstWhere([
                ['agent_id', '=', $username],
                ['password', '=', DB::raw("SHA2(CONCAT(agent_id, '$concatPass'), 256)")]
            ]);
            
            if ($agent) {
                $token =  $agent->createToken('gplex-social-agent', ['role:agent'])->plainTextToken;
                return $this->respondWithToken($token, $agent, 'Agent');
            }
            
            return $this->respondWithError('Your Credential Is not Correct.');
        }
    }

}
