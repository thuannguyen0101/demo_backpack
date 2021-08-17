<?php

namespace App\Models;

use App\Http\Enum\EnumProjects;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class SubFunction extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'sub_functions';
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

    /* Total cost */
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
    public function requirement()
    {
        return $this->belongsTo(Requirement::class, 'requirement_id', 'id');
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

    /* get Model name */
    public function getModelAttribute()
    {
        return EnumProjects::SUBFUNCTIONS;
    }
}
