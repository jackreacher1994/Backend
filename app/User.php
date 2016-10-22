<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;

class User extends Authenticatable
{
    protected $fillable = [
        'fullname', 'email', 'password', 'phone', 'address', 'bio', 'avatar', 'last_login'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = ['created_at', 'updated_at', 'last_login'];

    //protected $dateFormat = 'Y-m-d H:i:s';

    public function roles(){
        return $this->belongsToMany('App\Role', 'role_user', 'user_id', 'role_id');
    }

    public function hasRole($role){
        if(is_string($role)){
            return $this->roles->contains('name', $role);
        }
        return !! $role->intersect($this->roles)->count();
    }

    public function assignRole(Role $role){
        return $this->roles()->attach($role->id);
    }

    public function removeRole(Role $role){
        return $this->roles()->detach($role->id);
    }

    public function removeAllRoles(){
        return $this->roles()->detach();
    }

    public function socials(){
        return $this->hasMany('App\Social');
    }
}
