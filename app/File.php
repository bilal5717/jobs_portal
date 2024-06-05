<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class File extends Model
{
    //
    protected $fillable = ['file','folder_id', 'orignal_name', 'mime_type'];
    
    protected static function boot(){
	    parent::boot();
	    // Order by name ASC
	    static::addGlobalScope('order', function (Builder $builder) {
	        $builder->orderBy('created_at', 'DESC');
	    });
	}
	
	public function scopeFilter(Builder $builder, $request)
    {
    	//dd($request);
        return (new FolderFilter($request))->filter($builder);
    }
}
