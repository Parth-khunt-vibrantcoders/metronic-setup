<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Users;
use App\Models\SendMail;
use Config;
use Auth;
use Session;
use Hash;

class LoginController extends Controller
{
    public function login(){

        $data['title'] = Config::get('constants.SYSTEM_NAME') . ' || Login';
        $data['description'] = Config::get('constants.SYSTEM_NAME') . ' || Login';
        $data['keywords'] = Config::get('constants.SYSTEM_NAME') . ' || Login';
        $data['css'] = array(
            'toastr/toastr.min.css'
        );
        $data['plugincss'] = array(
        );
        $data['pluginjs'] = array(
            'toastr/toastr.min.js',
            'plugins/validate/jquery.validate.min.js',
            'pages\custom\login\login-general.js',
        );
        $data['js'] = array(
            'comman_function.js',
            'ajaxfileupload.js',
            'jquery.form.min.js',
            'login.js',
        );
        $data['funinit'] = array(
            'Login.init()'
        );
        return view('backend.pages.login.login', $data);
    }

    public function check_login(Request $request){

        if (Auth::guard('admin')->attempt(['email' => $request->input('email'), 'password' => $request->input('password'), 'is_deleted'=>'N'])) {
            $loginData = '';
            $request->session()->forget('logindata');
            $loginData = array(
                'first_name' => Auth::guard('admin')->user()->first_name,
                'last_name' => Auth::guard('admin')->user()->last_name,
                'email' => Auth::guard('admin')->user()->email,
                'userimage' => Auth::guard('admin')->user()->userimage,
                'usertype' => Auth::guard('admin')->user()->user_type,
                'complete_bussiness_details' => Auth::guard('admin')->user()->complete_bussiness_details,
                'id' => Auth::guard('admin')->user()->id
            );
            Session::push('logindata', $loginData);
            $return['status'] = 'success';
            $return['message'] = 'You have successfully logged in.';
            $return['redirect'] = route('dashboard');
        } else {
                $return['status'] = 'error';
                $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
                $return['message'] = 'Invalid Login Id/Password';
        }
        return json_encode($return);
        exit();
    }

    public function testingmail(){
        $objSendmail = new SendMail();
        $Sendmail = $objSendmail->sendMailltesting();
    }

    public function new_user_sign_up(Request $request){
        $objUsers = new Users();
        $result = $objUsers->add_sign_up($request);

        if ($result == "true") {
            $return['status'] = 'success';
            $return['message'] = 'User successfully added.';
            $return['jscode'] = '$("#loader").hide();';
            $return['redirect'] = route('login');
        }else{
            if ($result == "email_exits") {
                $return['status'] = 'warning';
                $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
                $return['message'] = 'Email already exits.';
                }else{
                $return['status'] = 'error';
                $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
                $return['message'] = 'Something goes to wrong.';

                }
        }
        echo json_encode($return);
        exit;
    }


    public function logout(Request $request) {
        $this->resetGuard();
        $request->session()->forget('logindata');
        return redirect()->route('login');
    }

    public function resetGuard() {
        Auth::logout();
        Auth::guard('admin')->logout();
    }

}
