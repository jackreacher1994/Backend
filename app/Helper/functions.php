<?php
function role_select($data, $select_name=""){
	foreach ($data as $value) {
		$name = $value->name;
		if(strcmp($name, $select_name) == 0) {
			echo "<option value='$name' selected='selected'>$name</option>";
		} else {
			echo "<option value='$name'>$name</option>";
		}
	}
}

function group_select($data, $select_id=0){
	foreach ($data as $value) {
		$id = $value->id;
		$name = $value->name;
		if($select_id != 0 && $id == $select_id) {
			echo "<option value='$id' selected='selected'>$name</option>";
		} else {
			echo "<option value='$id'>$name</option>";
		}
	}
}

function type_select($data, $parent_id=0, $str="", $select_id=0, $disabled="disabled"){
	foreach ($data as $value) {
		$id = $value->id;
		$name = $value->name;
		if($value->parent_id == $parent_id) {
			if($select_id != 0 && $id == $select_id) {
				echo "<option value='$id' selected='selected' $disabled>$str"."$name</option>";
			} else {
				echo "<option value='$id' $disabled>$str"."$name</option>";
			}
			type_select($data, $id, $str."&nbsp;&nbsp;&nbsp;&nbsp;", $select_id, "");
		}
	}
}

function check_format($type,$value){
	if($value==config('setting.'.$type)){
		return 'checked';
	}
}

function get_timezone_list(){
	$timezone= timezone_list();

	foreach ($timezone as $key => $value) {
		if($key==config('setting.timezone')) {
			echo "<option value='$key' selected='selected'>$value</option>";
		} else {
			echo "<option value='$key'>$value</option>";
		}	
	}
}

// Get list time zone
function timezone_list() {
    static $timezones = null;

    if ($timezones === null) {
        $timezones = [];
        $offsets = [];
        $now = new DateTime();

        foreach (DateTimeZone::listIdentifiers() as $timezone) {
            $now->setTimezone(new DateTimeZone($timezone));
            $offsets[] = $offset = $now->getOffset();
            $timezones[$timezone] = '(' . format_GMT_offset($offset) . ') ' . format_timezone_name($timezone);
        }

        array_multisort($offsets, $timezones);
    }
    return $timezones;
}

function format_GMT_offset($offset) {
    $hours = intval($offset / 3600);
    $minutes = abs(intval($offset % 3600 / 60));
    return 'GMT' . ($offset ? sprintf('%+03d:%02d', $hours, $minutes) : '');
}

function format_timezone_name($name) {
    $name = str_replace('/', ', ', $name);
    $name = str_replace('_', ' ', $name);
    $name = str_replace('St ', 'St. ', $name);
    return $name;
}
// End get list timezone
?>