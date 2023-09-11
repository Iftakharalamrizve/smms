<?php

namespace App\Repositories;

use App\Traits\QueryTrait;
use Carbon\Carbon;
use Exception;
use DB;
use Illuminate\Contracts\Session\Session;
use App\Models\Agent;

class AgentRepository
{
    use QueryTrait;

    public function listing($request)
    {

        $result = '';

        if($request != null) {

            $result = Agent::select('*')->orderBy('agent_id','ASC')->paginate( $request->perPage );

        } else {

            $result = Agent::select('*')->orderBy('agent_id','ASC')->get();

        }

        return $result;

    }

    public function show($id)
    {
        if (!empty($id)){

            return Agent::findorfail($id);

        } else {

            return Agent::orderBy('agent_id','ASC')->take(1)->get();

        }

    }


    public function create(array $data)
    {
//        dd($data);

        $client                     = new Agent();
        $client->agent_id           = $data['agent_id'];
        $client->name               = $data['business_name'];
        $client->contact_name       = $data['contact_name'] ?? " ";
        $client->mobile             = $data['contact_phone'] ?? " ";
        $client->email              = $data['email'] ?? " ";
        $client->active             = $data['active'];
        $client->seat               = $data['seat'];
        $client->expire_date        = $data['expire_date'] ?? date('Y-m-d');
        $client->save();

        return $data['agent_id'];
    }

    public function getMaxId()
    {

        return Agent::where([['agent_id','!=','root']])->max('agent_id');

    }

    public function update(array $data, $id)
    {

        // Update user detail
        $client                     = Agent::findorfail($id);
        $client->name               = $data['business_name'];
        $client->contact_name       = $data['contact_name'] ?? " ";
        $client->mobile             = $data['contact_phone'] ?? " ";
        $client->email              = $data['email'] ?? " ";
        $client->status             = $data['active'];
        $client->seat               = $data['seat'];
        $client->expire_date        = $data['expire_date'] ?? date('Y-m-d');
        $client->save();

        return $client;

    }

    public function deleteItem($id){

        if( Agent::where('id', $id)->first() ){

            return Agent::where('id', $id)->delete();

        }

        return false;
    }

    public static function filterTask($request, $query, array $whereFilterList, array $likeFilterList)
    {
        /* $query = self::likeQueryFilter($request, $query, $likeFilterList);
        $query = self::whereQueryFilter($request, $query, $whereFilterList);

        return $query; */

    }
}
