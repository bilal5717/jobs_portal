<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class AdminRole extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'description'
    ];

    public function admins(){
        return $this->hasMany('App\Model\Admin\Admin');
    }
    public function adminModules(){
        return $this->belongsToMany('App\Model\Admin\AdminModule', 'admin_permissions', 'admin_role_id', 'admin_module_id');
    }
}
