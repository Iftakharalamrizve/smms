<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasPermissionsTrait;

class UserDetail extends Model
{
    use HasFactory, HasPermissionsTrait;
    
}
