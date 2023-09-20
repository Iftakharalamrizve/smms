<?php

namespace App\Models;


use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\HasPermissionsTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;



class Agent extends Authenticatable
{
    use HasPermissionsTrait, HasFactory, Notifiable, HasApiTokens;
    protected $primaryKey = 'agent_id';
    protected $hidden = [
        'password',
        'remember_token',
    ];
}
