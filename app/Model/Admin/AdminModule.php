<?php

namespace App\Model\Admin;

use Illuminate\Database\Eloquent\Model;

class AdminModule extends Model
{
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'route_name', 'parent_id', 'type'
    ];


    public function adminRoles(){
        return $this->belongsToMany('App\Model\Admin\AdminRole', 'admin_permissions', 'admin_role_id', 'admin_module_id');
    }
}
