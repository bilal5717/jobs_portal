<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
class UserDocument extends Model
{
	protected $guarded = ['id', 'user_id', 'updated_at', 'created_at'];
	
    public function user(){
        return $this->belongsTo('App\User', 'user_id')->withTimestamps();
    }
    
}
