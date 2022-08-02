<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;
use Config;
use Illuminate\Support\Facades\DB;
use Mail;

class SendMail extends Model
{
    use HasFactory;

    public function sendMailltesting(){
        $mailData['data']='';
        $mailData['subject'] = 'Warehouse Management System';
        $mailData['attachment'] = array();
        $mailData['template'] ="emailtemplate.test";
        $mailData['mailto'] = 'test.vibrantcoders@gmail.com';
        $sendMail = new Sendmail();
        return $sendMail->sendSMTPMail($mailData);
    }

    public function send_verification_mail($first_name,$last_name, $email, $verifaction_code){

        $mailData['data']['first_name']= $first_name;
        $mailData['data']['last_name']= $last_name;
        $mailData['data']['verifaction_code']= $verifaction_code;
        $mailData['data']['email']= $email;
        $mailData['subject'] = 'Verify your email address';
        $mailData['attachment'] = array();
        $mailData['template'] = "emailtemplate.send_verification_mail";
        $mailData['mailto'] = $email;

        $sendMail = new SendMail();
        return $sendMail->sendSMTPMail($mailData);
    }

    public function sendSMTPMail($mailData)
    {
        $pathToFile = $mailData['attachment'];
        $mailsend = Mail::send($mailData['template'], ['data' => $mailData['data']], function ($m) use ($mailData,$pathToFile) {
            $m->from('no-replay@warehouse.vibrantcoders.in', 'Feedback Management System');
            $m->to($mailData['mailto'], "Feedback Management System")->subject($mailData['subject']);
            if($pathToFile != ""){
            }
        });

        if($mailsend){
            // return true;
        }else{
            // return false;
        }
    }
}
