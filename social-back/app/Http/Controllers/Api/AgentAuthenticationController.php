<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agent;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Auth;

class AgentAuthenticationController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $username = $request->input('username');
        $password = $request->input('password');

        $concatPass = md5($username . $password);
        $password = DB::raw("SHA2(CONCAT(agent_id, '$concatPass'), 256)");
        $agent = Agent::firstWhere([
            ['agent_id', '=', $username],
            ['password', '=', DB::raw("SHA2(CONCAT(agent_id, '$concatPass'), 256)")]
        ]);
        if ($agent) {
            $token =  $agent->createToken('gplex-social-agent')->plainTextToken;
            return response()->json(['token' => $token]);
        }
        return response()->json(['message' => 'Unauthorized'], 401);
    }

    public function test()
    {
        
        dd( Auth::guard('agent-api')->user());
    }
}
