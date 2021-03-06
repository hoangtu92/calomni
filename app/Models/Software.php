<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Software extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'software';
    // protected $primaryKey = 'id';
    // public $timestamps = false;
    protected $guarded = ['id'];
    // protected $fillable = [];
    // protected $hidden = [];
    // protected $dates = [];

    /*
    |--------------------------------------------------------------------------
    | FUNCTIONS
    |--------------------------------------------------------------------------
    */
    protected static function booted()
    {
        parent::booted(); // TODO: Change the autogenerated stub

        static::updated(function ($software){
            foreach($software->hosts as $host_software){
                $host_software->executable = false;
                $host_software->save();
            }

            $notify = new Notification([
                "message" => "{$software->name} has been updated specs requirement. Please verify your machine again now. Dont miss out many jobs a head",
                "receiver" => Notification::SH
            ]);
            $notify->save();
        });

        static::created(function ($software){
            $notify = new Notification([
                "message" => "{$software->name} has been added to our system. Verify your machine now to get even more job requests",
                "receiver" => Notification::SH
            ]);
            $notify->save();
        });
    }





    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function hosts(){
        return $this->hasMany("\App\Models\HostSoftware", "software_id");
    }



    /*
    |--------------------------------------------------------------------------
    | SCOPES
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | ACCESSORS
    |--------------------------------------------------------------------------
    */

    /*
    |--------------------------------------------------------------------------
    | MUTATORS
    |--------------------------------------------------------------------------
    */
}
