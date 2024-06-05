<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
class Company extends Model
{
    //
    use SoftDeletes;
    protected $fillable = ['company_name','description','slug'];

    public function users(){
        return $this->hasMany('App\User');
    }
    
    public function folders(){
        return $this->belongsToMany('App\Folder')->withTimestamps();
    }
    
    public function projects(){
        return $this->hasMany('App\Project');
    }
    
    protected static function boot(){
	    parent::boot();
	    // Order by name ASC
	    static::addGlobalScope('order', function (Builder $builder) {
	        $builder->orderBy('company_name', 'asc');
	    });
	}
}
