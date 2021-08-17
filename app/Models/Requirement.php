<?php

namespace App\Models;

use App\Http\Enum\EnumProjects;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'requirements';
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

    /* Total cost of requirement */
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

    /* 	Relation sub_functions Table */
    public function subFunctions()
    {
        return $this->hasMany(SubFunction::class, 'requirement_id', 'id');
    }

    /* 	Relation systems Table */
    public function system()
    {
        return $this->belongsTo(System::class, 'system_id', 'id');
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

    /* Total Ios cost of requirement */
    public function getTotalIosAttribute()
    {
        $subFunctions = $this->subFunctions()->get();
        if (count($subFunctions) < 1) {
            return $this->ios_cost;
        }
        $total = 0;
        foreach ($subFunctions as $subFunction) {
            $total += $subFunction->ios_cost;
        }

        return $total;
    }

    /* Total Android cost of requirement */
    public function getTotalAndroidAttribute()
    {
        $subFunctions = $this->subFunctions()->get();
        if (count($subFunctions) < 1) {
            return $this->android_cost;
        }
        $total = 0;
        foreach ($subFunctions as $subFunction) {
            $total += $subFunction->android_cost;
        }

        return $total;
    }

    /* Total Web cost of requirement */
    public function getTotalWebAttribute()
    {
        $subFunctions = $this->subFunctions()->get();
        if (count($subFunctions) < 1) {
            return $this->web_cost;
        }
        $total = 0;
        foreach ($subFunctions as $subFunction) {
            $total += $subFunction->web_cost;
        }

        return $total;
    }

    /* Total records of requirement */
    public function getTotalRecordsAttribute()
    {
        $subFunctions = $this->subFunctions()->get();
        $total = count($subFunctions) + 1;
        if ($total < 2) {
            return $total;
        }

        return $total;
    }

    /* get Model name */
    public function getModelAttribute()
    {
        return EnumProjects::REQUIREMENTS;
    }

    /* Get child relationship */
    public function getChildsAttribute()
    {
        return $this->subFunctions()->get();
    }
}
