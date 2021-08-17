<?php

namespace App\Models;

use App\Http\Enum\EnumProjects;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class System extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'systems';
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

    /* Total cost of system */
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($query) {
            $query->total_cost = $query->ios_cost + $query->android_cost + $query->web_cost;
        });
    }

    /* Query clause */
    public function scopeHigh($query)
    {
        return $query->where('priority', 'high');
    }

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */
    /* 	Relation requirements Table */
    public function requirements()
    {
        return $this->hasMany(Requirement::class, 'system_id', 'id');
    }

    /* 	Relation projects Table */
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
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

    /* Total Ios cost of system */
    public function getTotalIosAttribute()
    {
        $requirements = $this->requirements()->get();
        if (count($requirements) < 1) {
            return $this->ios_cost;
        }
        $total = 0;
        foreach ($requirements as $requirement) {
            $total += $requirement->TotalIos;
        }

        return $total;
    }

    /* Total Android cost of system */
    public function getTotalAndroidAttribute()
    {
        $requirements = $this->requirements()->get();
        if (count($requirements) < 1) {
            return $this->android_cost;
        }
        $total = 0;
        foreach ($requirements as $requirement) {
            $total += $requirement->TotalAndroid;
        }

        return $total;
    }

    /* Total Web cost of system */
    public function getTotalWebAttribute()
    {
        $requirements = $this->requirements()->get();
        if (count($requirements) < 1) {
            return $this->web_cost;
        }
        $total = 0;
        foreach ($requirements as $requirement) {
            $total += $requirement->TotalWeb;
        }

        return $total;
    }

    /* Total records of system */
    public function getTotalRecordsAttribute()
    {
        $requirements = $this->requirements()->get();
        if (count($requirements) < 1) {
            return 1;
        }
        $total = 0;
        foreach ($requirements as $requirement) {
            $total += $requirement->totalRecords;
        }

        return $total;
    }

    /* get Model name */
    public function getModelAttribute(){
        return EnumProjects::SYSTEMS;
    }

    /* Get child relationship */
    public function getChildsAttribute()
    {
        return $this->requirements()->get();
    }
}
