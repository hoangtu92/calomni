<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    //
    protected $table = 'messages';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = ["id", "host_id", "notification_id", "message", "unread", "created_at", "updated_at"];
    protected $hidden = ["notification"];
    // protected $dates = [];


    public function notification(){
        return $this->belongsTo("\App\Models\Notification");
    }
    public function getMessageAttribute(){
        return !empty($this->message) ? $this->message : $this->notification->message;
    }

}
