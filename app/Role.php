<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Permission;

class Role extends Model
{
	  protected $fillable = [
        'name'
    ];

    public function permissions(){
    	return $this->belongsToMany('App\Permission');
    }

    public function users()
    {
        return $this->belongsToMany('App\User');
    }

    public function assignPermission(Permission $permission){
        return $this->permissions()->attach($permission->id);
    }

    public function removePermission(Permission $permission){
        return $this->permissions()->detach($permission->id);
    }

    public function removeAllPermissions(){
        return $this->permissions()->detach();
    }
}
