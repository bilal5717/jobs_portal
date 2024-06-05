<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Filters\UserFilter;
use Illuminate\Database\Eloquent\Builder;

use App\Notifications\PasswordReset;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'email_verified_at', 'password','company_id', "step", "user_status", "image"
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function folders(){
        return $this->belongsToMany("App\Folder");
    }

    public function company(){
        return $this->belongsTo('App\Company');
    }

    public function files(){
        return $this->belongsToMany("App\File");
    }
    
    public function UserDetail(){
        return $this->hasOne("App\UserDetail");
    }
    
    public function UserJobDetail(){
        return $this->hasOne("App\UserJobDetail");
    }
    
    public function UserDocument(){
        return $this->hasOne("App\UserDocument");
    }
    
    public function TimesheetDailyHours(){
        return $this->hasMany("App\Model\Timesheet\TimesheetDailyHour");
    }
    
    public function timesheets(){
        return $this->hasMany("App\Model\Timesheet\Timesheet");
    }
    
    public function scopeFilter(Builder $builder, $request)
    {
        return (new UserFilter($request))->filter($builder);
    }
    
    /**
	 * Send the password reset notification.
	 *
	 * @param  string  $token
	 * @return void
	*/
    public function sendPasswordResetNotification($token){
	    $this->notify(new PasswordReset($token));
	}

}
