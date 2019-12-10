<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Library\Api;
use Config;
use helpers;
use Session;
use DB;
use \App\Library\Validation_rules as Validation_rules;
class SettingsController extends Controller
{
     public function __construct()
    {
    }
   
	
	public function chksession() {
		
		$data = Session::all();		
		pre($data);
	}
}
