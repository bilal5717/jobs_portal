<?php

namespace App;

use App\Filters\FolderFilter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Folder extends Model
{
    //
    protected $fillable = [
        'name', 'slug', 'parent_id'
    ];

        
   public function companies(){
        return $this->belongsToMany('App\Company')->withTimestamps();
    }

	protected static function boot(){
	    parent::boot();
	    # Order by name ASC
	    static::addGlobalScope('order', function (Builder $builder) {
	        $builder->orderBy('created_at', 'DESC');
	    });
	}
	
	/*public function scopeFilter($query, $filters){
	    if( isset($filters['folder_name']) ){
	      $query->where('name', 'LIKE', '%' . $filters['folder_name'] . '%');
	    }
	}*/
	
	public function scopeFilter(Builder $builder, $request)
    {
        return (new FolderFilter($request))->filter($builder);
    }
    
    public function files() {
	    return $this->hasMany('App\File', 'folder_id');
	}
	
    public function parent() {
	    return $this->belongsToOne(static::class, 'parent_id');
	}

  	//each category might have multiple children
  	public function children() {
	    return $this->hasMany(static::class, 'parent_id')->with('children');
	}
	
}
