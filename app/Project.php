<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
class Project extends Model
{
    //
    //use SoftDeletes;
    protected $guarded = ['id', 'updated_at', 'created_at'];
    
    public function company(){
        return $this->belongsTo('App\Company')->withTimestamps();
    }
    
    protected static function boot(){
	    parent::boot();
	    // Order by name ASC
	    static::addGlobalScope('order', function (Builder $builder) {
	        $builder->orderBy('name', 'asc');
	    });
	}
}
