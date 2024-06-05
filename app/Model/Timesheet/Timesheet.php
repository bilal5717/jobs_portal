<?php

namespace App\Model\Timesheet;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
class Timesheet extends Model
{
    //
    //use SoftDeletes;
    
    protected $fillable = [
        'user_id', 'title', 'status', 'start_date', 'end_date', 'submit_count', 'submit_date'
    ];
    
    public function timesheet_daily_hours(){
        return $this->hasMany('App\Model\Timesheet\TimesheetDailyHour');
    }
    
    public function timesheet_comments(){
        return $this->hasMany('App\Model\Timesheet\TimesheetComment');
    }
    
    public function user(){
        return $this->belongsTo('App\User');
    }
    
    protected static function boot(){
	    parent::boot();
	    // Order by name ASC
	    static::addGlobalScope('order', function (Builder $builder) {
	        $builder->orderBy('id', 'desc');
	    });
	}
}
