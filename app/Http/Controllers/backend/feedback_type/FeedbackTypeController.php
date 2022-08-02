<?php

namespace App\Http\Controllers\backend\feedback_type;

use App\Http\Controllers\Controller;
use App\Models\Feedbacktype;
use App\Models\Industry;
use Illuminate\Http\Request;
use Config;

class FeedbackTypeController extends Controller
{
    function __construct()
    {
            $this->middleware('admin');
    }

    public function list(Request $request){

        $data['title'] = Config::get('constants.SYSTEM_NAME') . ' || Feedback Type List';
        $data['description'] = Config::get('constants.SYSTEM_NAME') . ' || Feedback Type List';
        $data['keywords'] = Config::get('constants.SYSTEM_NAME') . ' || Feedback Type List';
        $data['css'] = array(
            'toastr/toastr.min.css'
        );
        $data['plugincss'] = array(
            'plugins/custom/datatables/datatables.bundle.css'
        );
        $data['pluginjs'] = array(
            'toastr/toastr.min.js',
            'plugins/custom/datatables/datatables.bundle.js',
            'pages/crud/datatables/data-sources/html.js'
        );
        $data['js'] = array(
            'comman_function.js',
            'feedback_type.js',
        );
        $data['funinit'] = array(
            'Feedback_type.init()'
        );
        $data['header'] = array(
            'title' => 'Feedback Type List',
            'breadcrumb' => array(
                'Dashboard' => route('dashboard'),
                'Feedback Type List' => 'Feedback Type List',
            )
        );
        return view('backend.pages.feedback_type.list', $data);
    }

    public function add(){

        $objIndustry = new Industry();
        $data['industry_list'] = $objIndustry->get_industry_list();

        $data['title'] = Config::get('constants.SYSTEM_NAME') . ' || Add Feedback Type ';
        $data['description'] = Config::get('constants.SYSTEM_NAME') . ' || Add Feedback Type ';
        $data['keywords'] = Config::get('constants.SYSTEM_NAME') . ' || Add Feedback Type ';
        $data['css'] = array(
            'toastr/toastr.min.css'
        );
        $data['plugincss'] = array(
        );
        $data['pluginjs'] = array(
            'toastr/toastr.min.js',
            'plugins/validate/jquery.validate.min.js',
        );
        $data['js'] = array(
            'comman_function.js',
            'ajaxfileupload.js',
            'jquery.form.min.js',
            'feedback_type.js',
        );
        $data['funinit'] = array(
            'Feedback_type.add()'
        );
        $data['header'] = array(
            'title' => 'Add Feedback Type',
            'breadcrumb' => array(
                'Dashboard' => route('dashboard'),
                'Feedback Type List' => route('feedback-type'),
                'Add Feedback Type' => 'Add Feedback Type',
            )
        );
        return view('backend.pages.feedback_type.add', $data);
    }

    public function save_add_feedback_type(Request $request){
        $objFeedbacktype = new Feedbacktype();
        $result = $objFeedbacktype->add_feedback_type($request);

        if ($result == "true") {
            $return['status'] = 'success';
            $return['message'] = 'Feedback Type successfully added.';
            $return['jscode'] = '$("#loader").hide();';
            $return['redirect'] = route('feedback-type');
        }else{
            if ($result == "feedback_type_exits") {
                $return['status'] = 'warning';
                $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
                $return['message'] = 'Feedback Type already exits.';
                }else{
                    $return['status'] = 'error';
                    $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
                    $return['message'] = 'Something goes to wrong.';
                }
        }
        echo json_encode($return);
        exit;
    }

    public function edit($editId){

        $objIndustry = new Industry();
        $data['industry_list'] = $objIndustry->get_industry_list();

        $objFeedbacktype = new Feedbacktype();
        $data['feedback_type_detail'] = $objFeedbacktype->get_feedback_type_detail($editId);
        // ccd($data['feedback_type_detail']);

        $data['title'] = Config::get('constants.SYSTEM_NAME') . ' || Edit Feedback Type ';
        $data['description'] = Config::get('constants.SYSTEM_NAME') . ' || Edit Feedback Type ';
        $data['keywords'] = Config::get('constants.SYSTEM_NAME') . ' || Edit Feedback Type ';
        $data['css'] = array(
            'toastr/toastr.min.css'
        );
        $data['plugincss'] = array(
        );
        $data['pluginjs'] = array(
            'toastr/toastr.min.js',
            'plugins/validate/jquery.validate.min.js',
        );
        $data['js'] = array(
            'comman_function.js',
            'ajaxfileupload.js',
            'jquery.form.min.js',
            'feedback_type.js',
        );
        $data['funinit'] = array(
            'Feedback_type.edit()'
        );
        $data['header'] = array(
            'title' => 'Edit Feedback Type',
            'breadcrumb' => array(
                'Dashboard' => route('dashboard'),
                'Feedback Type List' => route('feedback-type'),
                'Edit Feedback Type' => 'Edit Feedback Type',
            )
        );
        return view('backend.pages.feedback_type.edit', $data);
    }

    public function save_edit_feedback_type(Request $request){
        $objFeedbacktype = new Feedbacktype();
        $result = $objFeedbacktype->edit_feedback_type($request);

        if ($result == "true") {
            $return['status'] = 'success';
            $return['message'] = 'Feedback type successfully updated.';
            $return['jscode'] = '$("#loader").hide();';
            $return['redirect'] = route('feedback-type');
        }else{
            if ($result == "feedback_type_exits") {
                $return['status'] = 'warning';
                $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
                $return['message'] = 'Feedback type already exits.';
                }else{
                    $return['status'] = 'error';
                    $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
                    $return['message'] = 'Something goes to wrong.';
                }
        }
        echo json_encode($return);
        exit;
    }


    public function ajaxcall(Request $request){

        $action = $request->input('action');
        switch ($action) {
            case 'getdatatable':
                $objFeedbacktype = new Feedbacktype();
                $list = $objFeedbacktype->getdatatable();

                echo json_encode($list);
                break;

            case 'delete-feedback-type':


                $objFeedbacktype = new Feedbacktype();
                $result = $objFeedbacktype->common_activity_user($request->input('data'),0);

                if ($result) {
                    $return['status'] = 'success';
                    $return['message'] = 'Feedback Type successfully deleted.';
                    $return['redirect'] = route('feedback-type');
                } else {
                    $return['status'] = 'error';
                    $return['jscode'] = '$("#loader").hide();';
                    $return['message'] = 'Something goes to wrong.';
                }
                echo json_encode($return);
                exit;



            case 'active-feedback-type':

                $objFeedbacktype = new Feedbacktype();
                $result = $objFeedbacktype->common_activity_user($request->input('data'),1);

                if ($result) {
                    $return['status'] = 'success';
                    $return['message'] = 'Feedback Type successfully actived.';
                    $return['redirect'] = route('feedback-type');
                } else {
                    $return['status'] = 'error';
                    $return['jscode'] = '$("#loader").hide();';
                    $return['message'] = 'Something goes to wrong.';
                }
                echo json_encode($return);
                exit;


            case 'deactive-feedback-type':

                $objFeedbacktype = new Feedbacktype();
                $result = $objFeedbacktype->common_activity_user($request->input('data'),2);

                if ($result) {
                    $return['status'] = 'success';
                    $return['message'] = 'Feedback Type successfully deactived.';
                    $return['redirect'] = route('feedback-type');
                } else {
                    $return['status'] = 'error';
                    $return['jscode'] = '$("#loader").hide();';
                    $return['message'] = 'Something goes to wrong.';
                }
                echo json_encode($return);
                exit;
        }
    }
}
