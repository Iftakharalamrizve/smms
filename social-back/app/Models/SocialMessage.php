<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialMessage extends Model
{
    use HasFactory;

    protected $table = 'social_messages';

    protected $fillable = [
        'channel_id',
        'page_id',
        'customer_id',
        'message_id',
        'message_text',
        'reply_to',
        'reaction_to',
        'assign_agent',
        'direction',
        'attachments',
        'session_id',
        'queue_session_id',
        'read_status',
        'created_time',
        'start_time',
        'end_time',
        'disposition_id',
        'disposition_by',
        'sms_state',
        'created_at',
        'updated_at'
    ];



    public static function boot() 
    {

        parent::boot();

        static::creating(function($model) {
            if($model->direction == 'IN'){
                $model->read_status = 1;

            }
        });
    }

}
