<?php

namespace App\Models;

use App\Http\Enum\EnumProjects;
use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use CrudTrait;

    /*
    |--------------------------------------------------------------------------
    | GLOBAL VARIABLES
    |--------------------------------------------------------------------------
    */

    protected $table = 'projects';
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

    /* Relation systems table */

    public function systems()
    {
        return $this->hasMany(System::class, 'project_id', 'id');
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

    /* Total Ios cost of project */
    public function getTotalIosAttribute()
    {
        $systems = $this->systems()->get();
        if (count($systems) < 1) {
            return EnumProjects::NULLCOST;
        }
        $total = 0;
        foreach ($systems as $system) {
            $total += $system->TotalIos;
        }

        return $total;
    }

    /* Total Android cost of project */
    public function getTotalAndroidAttribute()
    {
        $systems = $this->systems()->get();
        if (count($systems) < 1) {
            return EnumProjects::NULLCOST;
        }
        $total = 0;
        foreach ($systems as $system) {
            $total += $system->TotalAndroid;
        }

        return $total;
    }

    /* Total Web cost of project */
    public function getTotalWebAttribute()
    {
        $systems = $this->systems()->get();
        if (count($systems) < 1) {
            return EnumProjects::NULLCOST;
        }
        $total = 0;
        foreach ($systems as $system) {
            $total += $system->TotalWeb;
        }

        return $total;
    }

    /* Total Cost of project */
    public function getTotalCostAttribute(){
        return $this->totalIos + $this->totalAndroid + $this->totalWeb;
    }
}
