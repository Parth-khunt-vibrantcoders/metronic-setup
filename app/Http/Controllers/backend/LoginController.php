<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Users;
use Config;
use Auth;
use Session;
use Hash;

class LoginController extends Controller
{
    public function login(){

        $data['title'] = Config::get('constants.SYSTEM_NAME').' || Login';
        $data['description'] = Config::get('constants.SYSTEM_NAME').' || Login';
        $data['keywords'] = Config::get('constants.SYSTEM_NAME').' || Login';
        $data['css'] = array(
        );
        $data['plugincss'] = array(
        );
        $data['pluginjs'] = array(
        );
        $data['js'] = array(
        );
        $data['funinit'] = array(
        );
        return view('backend.pages.login.login', $data);
    }
}
