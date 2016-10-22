<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use FileSetting;

class HomeController extends Controller
{
    public function index(){
		return view('admin.pages.dashboard');
    }
}
