<?php

namespace App\Model\Timesheet;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
class TimesheetDailyHour extends Model
{
    //
    //use SoftDeletes;
    protected $tabale = "timesheet_daily_hours";
    protected $fillable = [
        "timesheet_id", "user_id", "project_id", "location", "check_in_date", "check_in_time", "check_out_time", "notes"
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
