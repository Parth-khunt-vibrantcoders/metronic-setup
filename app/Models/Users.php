<?php

namespace App\Models;

use App\Event\UserCreated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Audittrails;
use DB;
use Hash;
use Route;
use Session;
use Str;
class Users extends Model
{
    use HasFactory;
    protected $table= 'users';

    public function update_profile($request){
        $countUser = Users::where("email",$request->input('email'))
                        ->where("id",'!=',$request->input('edit_id'))
                        ->count();

        if($countUser == 0){

            $objUsers = Users::find($request->input('edit_id'));
            $objUsers->first_name = $request->input('first_name');
            $objUsers->last_name = $request->input('last_name');
            $objUsers->full_name = $request->input('first_name'). ' '. $request->input('last_name');
            $objUsers->email = $request->input('email');
            if($request->file('userimage')){
                $image = $request->file('userimage');
                $imagename = 'userimage'.time().'.'.$image->getClientOriginalExtension();
                $destinationPath = public_path('/upload/userprofile/');
                $image->move($destinationPath, $imagename);
                $objUsers->userimage  = $imagename ;
            }
            if($objUsers->save()){
                $currentRoute = Route::current()->getName();
                $inputData = $request->input();
                unset($inputData['_token']);
                unset($inputData['profile_avatar_remove']);
                unset($inputData['userimage']);
                if($request->file('userimage')){
                    $inputData['userimage'] = $imagename;
                }
                $objAudittrails = new Audittrails();
                $res = $objAudittrails->add_audit('Update','admin/'. $currentRoute , json_encode($inputData) ,'Update Profile' );
                return true;
            }else{
                return "false";
            }

        }else{
            return "email_exist";
        }
    }

    public function changepassword($request)
    {

        if (Hash::check($request->input('old_password'), $request->input('user_old_password'))) {
            $countUser = Users::where("id",'=',$request->input('editid'))->count();
            if($countUser == 1){
                $objUsers = Users::find($request->input('editid'));
                $objUsers->password =  Hash::make($request->input('new_password'));
                $objUsers->updated_at = date('Y-m-d H:i:s');
                if($objUsers->save()){
                    $currentRoute = Route::current()->getName();
                    $inputData = $request->input();
                    unset($inputData['_token']);
                    unset($inputData['user_old_password']);
                    unset($inputData['old_password']);
                    unset($inputData['new_password']);
                    unset($inputData['new_confirm_password']);
                    $objAudittrails = new Audittrails();
                    $res = $objAudittrails->add_audit('Update','admin/'. $currentRoute , json_encode($inputData) ,'Change Password' );
                    return true;
                }else{
                    return 'false';
                }
            }else{
                return "false";
            }
        }else{
            return "password_not_match";
        }
    }

    public function add_sign_up($request){

            $checkEmail = Users::from('users')
                          ->where('users.email', $request->input('email'))
                          ->where('users.is_deleted', 'N')
                          ->count();

                if($checkEmail == 0){
                   $objUsers = new Users();
                   $objUsers->email = $request->input('email');
                   $objUsers->first_name = $request->input('first_name');
                   $objUsers->last_name = $request->input('last_name');
                   $objUsers->mobile_no = $request->input('mobile_no');
                   $password = Str::random(8);
                   $objUsers->password = Hash::make($password);
                   $objUsers->user_type = '2';
                   $objUsers->status = '0';
                   $objUsers->created_at = date('Y-m-d H:i:s');
                   $objUsers->updated_at = date('Y-m-d H:i:s');
                   if($objUsers->save()){
                    event(new UserCreated( $request->input('first_name'),  $request->input('last_name'), $request->input('email'), $password));

                       return 'true';
                   }else{
                       return 'false';
                   }
                }
                return 'email_exits';
    }

    public function send_new_user_mail($first_name,$last_name,$email, $password){
        $mailData['data']['first_name']= $first_name;
        $mailData['data']['last_name']= $last_name;
        $mailData['data']['password']= $password;
        $mailData['data']['email']= $email;
        $mailData['subject'] = 'Login Credentials';
        $mailData['attachment'] = array();
        $mailData['template'] = "emailtemplate.send_login_credential_mail";
        $mailData['mailto'] = $email;

        $sendMail = new SendMail();
        $sendMail->sendSMTPMail($mailData);
    }
}
