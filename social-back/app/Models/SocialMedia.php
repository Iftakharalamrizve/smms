<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Client;

class SocialMedia extends Model
{
    use HasFactory;

    protected $table        = 'social_media';

    protected $fillable     = [
                    'client_id',
                    'domain',
                    'ip',
                    'page_id',
                    'page_name',
                    'site_key',
                    'page_access_token',
                    'msg_server_ip',
                    'msg_server_port',
                    'listening_ip',
                    'listening_port',
                    'api_url',
                    'api_token',
                    'media_type',
                    'status'
                ];


    public function client()
    {

        return $this->hasOne(Client::class, 'id', 'client_id');

    }



}
