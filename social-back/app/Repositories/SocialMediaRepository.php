<?php

namespace App\Repositories;

use App\Models\SocialMedia;
use App\Traits\QueryTrait;
use DB;

class SocialMediaRepository
{
    use QueryTrait;

    public function listing($request = null)
    {
        $result = '';

        if($request != null) {

            $result = SocialMedia::with(['client:id,name'])
                            ->paginate( $request->perPage );
        } else {

            $result = SocialMedia::select('*')->get();

        }

        return $result;

    }

    public function getMaxId()
    {

        return SocialMedia::max('id');

    }

    public function show($id)
    {

        return SocialMedia::findorfail($id);

    }

    public function getPageInfo($id)
    {

        return SocialMedia::where('page_id', $id)->first();

    }

    public function create(array $data)
    {

        $socialMedia                    = new SocialMedia();
        $socialMedia->client_id         = $data['client_id'];
        $socialMedia->domain            = $data['domain'] ?? " ";
        $socialMedia->ip                = $data['ip'] ?? " ";
        $socialMedia->page_id           = $data['page_id'] ?? " ";
        $socialMedia->page_name         = $data['page_name'] ?? " ";
        $socialMedia->site_key          = $data['site_key'] ?? " ";
        $socialMedia->page_access_token = $data['page_access_token'] ?? " ";
        $socialMedia->msg_server_ip     = $data['msg_server_ip'] ?? " ";
        $socialMedia->msg_server_port   = $data['msg_server_port'] ?? " ";
        $socialMedia->socket_ip         = $data['socket_ip'] ?? " ";
        $socialMedia->socket_port       = $data['socket_port'] ?? " ";
        $socialMedia->api_url           = $data['api_url'] ?? " ";
        $socialMedia->api_token         = $data['api_token'] ?? " ";
        $socialMedia->media_type        = $data['media_type'] ?? " ";
        $socialMedia->status            = $data['status'] ?? 0;
        $socialMedia->save();

        return $socialMedia;
    }


    public function update(array $data, $id)
    {

        // Update user detail
        $socialMedia                    = SocialMedia::findorfail($id);
        $socialMedia->client_id         = $data['client_id'];
        $socialMedia->domain            = $data['domain'] ?? " ";
        $socialMedia->ip                = $data['ip'] ?? " ";
        $socialMedia->page_id           = $data['page_id'] ?? " ";
        $socialMedia->page_name         = $data['page_name'] ?? " ";
        $socialMedia->site_key          = $data['site_key'] ?? " ";
        $socialMedia->page_access_token = $data['page_access_token'] ?? " ";
        $socialMedia->msg_server_ip     = $data['msg_server_ip'] ?? " ";
        $socialMedia->msg_server_port   = $data['msg_server_port'] ?? " ";
        $socialMedia->socket_ip         = $data['socket_ip'] ?? " ";
        $socialMedia->socket_port       = $data['socket_port'] ?? " ";
        $socialMedia->api_url           = $data['api_url'] ?? " ";
        $socialMedia->api_token         = $data['api_token'] ?? " ";
        $socialMedia->media_type        = $data['media_type'] ?? " ";
        $socialMedia->status            = $data['status'] ?? 0;
        $socialMedia->save();

        return $socialMedia;

    }

    public function deleteItem($id){
        if( SocialMedia::where('id', $id)->first() ){
            return SocialMedia::where('id', $id)->delete();
        }
        return false;
    }

}


