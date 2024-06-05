<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
class UserJobDetail extends Model
{
	protected $guarded = ['id', 'user_id', 'updated_at', 'created_at'];
	//protected $fillable = array('*');
	/*protected $fillable = [
        "user_id", "job_type", "license_name", "license_number", "company_name", "experience_years", 
        "employee_name", "emp_contact_number", "availability", "work_shift_prepared", "explain_availability"
    ];*/
    public function user(){
        return $this->belongsTo('App\User', 'user_id')->withTimestamps();
    }
    
}
