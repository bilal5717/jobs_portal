<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
class TimesheetWeeklyHour extends Model
{
    //
    use SoftDeletes;
    
    public function projects(){
        return $this->belongsTo('App\Project')->withTimestamps();
    }
    
    public function users(){
        return $this->belongsTo('App\User')->withTimestamps();
    }
    
    /*protected static function boot(){
	    parent::boot();
	    // Order by name ASC
	    static::addGlobalScope('order', function (Builder $builder) {
	        $builder->orderBy('id', 'asc');
	    });
	}*/
}
