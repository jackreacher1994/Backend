<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GroupSetting extends Model
{
    protected $table = 'group_settings';
    
    protected $fillable = array('parent_id', 'key', 'name', 'description', 'order');

    public function settings(){
    	return $this->hasMany('App\Setting', 'type_id', 'id');
    }
}
