<?php

namespace App\Model\Timetable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
class TimetableHour extends Model
{
    //
    //use SoftDeletes;
    protected $tabale = "timetable_hours";
    protected $fillable = [
        "timetable_id", "user_id", "project_id", "location", "check_in_date", "day_name", "check_in_time", "check_out_time", "notes"
    ];
    
    public function projects(){
        return $this->belongsTo('App\Project')->withTimestamps();
    }
    
    public function user(){
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
