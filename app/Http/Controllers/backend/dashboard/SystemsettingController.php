<?php

namespace App\Http\Controllers\backend\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Systemsetting;
use Config;
class SystemsettingController extends Controller
{
    function __construct()
    {
        $this->middleware('admin');
    }

    public function system_setting(Request $request){

        $data['title'] =  Config::get('constants.SYSTEM_NAME') . ' || System Setting';
        $data['description'] =  Config::get('constants.SYSTEM_NAME') . ' || System Setting';
        $data['keywords'] =  Config::get('constants.SYSTEM_NAME') . ' || System Setting';
        $data['css'] = array(
        );
        $data['plugincss'] = array(
        );
        $data['pluginjs'] = array(
            'plugins/validate/jquery.validate.min.js',
        );
        $data['js'] = array(
            'comman_function.js',
            'ajaxfileupload.js',
            'jquery.form.min.js',
            'systemsetting.js',
        );
        $data['funinit'] = array(
            'Systemsetting.init()'
        );
        $data['header'] = array(
            'title' => 'System Setting',
            'breadcrumb' => array(
                'System Setting' => 'System Setting',
            )
        );
        return view('backend.pages.dashboard.systemsetting', $data);
    }

}
