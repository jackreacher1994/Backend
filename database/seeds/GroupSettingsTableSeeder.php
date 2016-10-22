<?php

use Illuminate\Database\Seeder;
use App\GroupSetting;
use Thetispro\Setting\Facades\Setting;

class GroupSettingsTableSeeder extends Seeder
{
    public function run()
    {
        $groupSystem = new GroupSetting();
        $groupSystem->key = 'system';
        $groupSystem->name = 'System';
        $groupSystem->order = 1;
        $groupSystem->save();

        Setting::clear();
        Setting::set('system', '');
    }
}
