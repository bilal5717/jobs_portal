<?php

namespace App\Model\Timetable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
class Timetable extends Model
{
    //
    //use SoftDeletes;
    
    protected $fillable = [
        'title', 'status', 'start_date', 'end_date',
    ];
    
    public function timetable_hours(){
        return $this->hasMany('App\Model\Timetable\TimetableHour');
    }
    
    protected static function boot(){
	    parent::boot();
	    // Order by name ASC
	    static::addGlobalScope('order', function (Builder $builder) {
	        $builder->orderBy('id', 'desc');
	    });
	}
}
