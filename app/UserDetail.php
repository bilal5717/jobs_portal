<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
class UserDetail extends Model
{
	protected $guarded = ['id', 'user_id', 'updated_at', 'created_at'];
	/*protected $fillable = array('*');*/
	/*protected $fillable = [
        "user_id", "birth_date", "contact", "address", "city", "state", "zipcode", "bank_name", "bank_account_name", "bank_account_number", 
        "job_type", "telephone_home", "mobile_number", "gender"
    ];*/
    public function user(){
        return $this->belongsTo('App\User', 'user_id')->withTimestamps();
    }
    
}
