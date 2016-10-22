<?php
namespace App\Listeners;

use Carbon\Carbon;
use Illuminate\Auth\Events\Login;
use Request;

class LogSuccessfulLogin
{
    public function handle(Login $event)
    {
        $event->user->last_login = Carbon::now();
        $event->user->last_login_ip = Request::getClientIp();
        $event->user->save();
    }
}