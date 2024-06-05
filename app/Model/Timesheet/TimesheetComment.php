<?php

namespace App\Model\Timesheet;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
class TimesheetComment extends Model
{
    //
    //use SoftDeletes;
    
    protected $fillable = [
        'timesheet_id', 'comment', 'admin_id'
    ];
    
    public function timesheet(){
        return $this->belongsTo('App\Model\Timesheet\Timesheet')->withTimestamps();
    }
    
    protected static function boot(){
	    parent::boot();
	    // Order by name ASC
	    static::addGlobalScope('order', function (Builder $builder) {
	        $builder->orderBy('updated_at', 'desc');
	    });
	}
}
