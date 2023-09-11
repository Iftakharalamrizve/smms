<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{

    protected $fillable = ['page_id', 'type', 'content', 'platform_time'];
    protected $table = 'contents';

    public function socialMedia() {
        return $this->hasOne(SocialMedia::class, 'page_id', 'page_id');
    }

}
