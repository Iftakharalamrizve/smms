<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class Agent extends Model
{
    use  HasFactory, Notifiable, HasApiTokens;
    protected $guard = "agentapi";

    protected $primaryKey = 'agent_id';
    protected $hidden = [
        'password',
        'remember_token',
    ];
}
