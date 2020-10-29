<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use CrudTrait;

    const PENDING = "pending";
    const RUNNING = "running";
    const COMPLETED = "completed";
    const FAILED = "failed";
    const STOPPPED = "stopped";

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'jobs';
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

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    public function host(){
        return $this->belongsTo("\App\Models\Host");
    }

    public function user(){
        return $this->belongsTo("\App\Models\User");
    }

    public function software(){
        return $this->belongsTo("\App\Models\Software");
    }

    public function hostSoftware(){
        return $this->belongsTo("\App\Models\HostSoftware");
    }

    public function tasks(){
        return $this->hasMany("\App\Models\Task", "job_id", "id");
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
