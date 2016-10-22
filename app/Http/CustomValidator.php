<?php

namespace App\Http;

use Auth;
use Hash;
use App\GroupSetting;

class CustomValidator {
    public function validateOldPassword($attribute, $value, $parameters, $validator)
    {
    	return Hash::check($value, Auth::user()->password);
    }

    public function validateTypeKey($attribute, $value, $parameters, $validator)
    {
    	if(array_has($validator->getData(), 'parent_id'))
    		$parent_id = $validator->getData()['parent_id'];
    	else
    		$parent_id = 0;
    	
    	$type = GroupSetting::where('parent_id', $parent_id)->where('key', $value)->first();
    	if($type)
    		return false;

    	return true;
    }
}