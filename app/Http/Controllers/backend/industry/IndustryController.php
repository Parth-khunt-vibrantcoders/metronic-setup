<?php

namespace App\Http\Controllers\backend\industry;

use App\Http\Controllers\Controller;
use App\Models\Industry;
use Illuminate\Http\Request;
use Config;

class IndustryController extends Controller
{
    function __construct()
    {
            $this->middleware('admin');
    }

    public function list(Request $request){

        $data['title'] = Config::get('constants.SYSTEM_NAME') . ' || Industry List';
        $data['description'] = Config::get('constants.SYSTEM_NAME') . ' || Industry List';
        $data['keywords'] = Config::get('constants.SYSTEM_NAME') . ' || Industry List';
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
            'industry.js',
        );
        $data['funinit'] = array(
            'Industry.init()'
        );
        $data['header'] = array(
            'title' => 'Industry List',
            'breadcrumb' => array(
                'Dashboard' => route('dashboard'),
                'Industry List' => 'Industry List',
            )
        );
        return view('backend.pages.industry.list', $data);
    }

    public function add(){

        $data['title'] = Config::get('constants.SYSTEM_NAME') . ' || Add Industry ';
        $data['description'] = Config::get('constants.SYSTEM_NAME') . ' || Add Industry ';
        $data['keywords'] = Config::get('constants.SYSTEM_NAME') . ' || Add Industry ';
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
            'industry.js',
        );
        $data['funinit'] = array(
            'Industry.add()'
        );
        $data['header'] = array(
            'title' => 'Add Industry',
            'breadcrumb' => array(
                'Dashboard' => route('dashboard'),
                'Industry List' => route('industry'),
                'Add Industry' => 'Add Industry',
            )
        );
        return view('backend.pages.industry.add', $data);
    }

    public function save_add_industry(Request $request){
        $objIndustry = new Industry();
        $result = $objIndustry->add_industry($request);

        if ($result == "true") {
            $return['status'] = 'success';
            $return['message'] = 'Industry successfully added.';
            $return['jscode'] = '$("#loader").hide();';
            $return['redirect'] = route('industry');
        }else{
            if ($result == "industry_exits") {
                $return['status'] = 'warning';
                $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
                $return['message'] = 'Industry name already exits.';
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
        $data['industry_detail'] = $objIndustry->get_industry_detail($editId);
        // ccd($data['industry_detail']);

        $data['title'] = Config::get('constants.SYSTEM_NAME') . ' || Edit Industry ';
        $data['description'] = Config::get('constants.SYSTEM_NAME') . ' || Edit Industry ';
        $data['keywords'] = Config::get('constants.SYSTEM_NAME') . ' || Edit Industry ';
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
            'industry.js',
        );
        $data['funinit'] = array(
            'Industry.edit()'
        );
        $data['header'] = array(
            'title' => 'Edit Industry',
            'breadcrumb' => array(
                'Dashboard' => route('dashboard'),
                'Industry List' => route('industry'),
                'Edit Industry' => 'Edit Industry',
            )
        );
        return view('backend.pages.industry.edit', $data);
    }

    public function save_edit_industry(Request $request){
        $objIndustry = new Industry();
        $result = $objIndustry->edit_industry($request);

        if ($result == "true") {
            $return['status'] = 'success';
            $return['message'] = 'Industry successfully updated.';
            $return['jscode'] = '$("#loader").hide();';
            $return['redirect'] = route('industry');
        }else{
            if ($result == "industry_exits") {
                $return['status'] = 'warning';
                $return['jscode'] = '$(".submitbtn:visible").removeAttr("disabled");$("#loader").hide();';
                $return['message'] = 'Industry name already exits.';
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
                $objIndustry = new Industry();
                $list = $objIndustry->getdatatable();

                echo json_encode($list);
                break;

            case 'delete-industry':


                $objIndustry = new Industry();
                $result = $objIndustry->common_activity_user($request->input('data'),0);

                if ($result) {
                    $return['status'] = 'success';
                    $return['message'] = 'Industry successfully deleted.';
                    $return['redirect'] = route('industry');
                } else {
                    $return['status'] = 'error';
                    $return['jscode'] = '$("#loader").hide();';
                    $return['message'] = 'Something goes to wrong.';
                }
                echo json_encode($return);
                exit;



            case 'active-industry':

                $objIndustry = new Industry();
                $result = $objIndustry->common_activity_user($request->input('data'),1);

                if ($result) {
                    $return['status'] = 'success';
                    $return['message'] = 'Industry successfully actived.';
                    $return['redirect'] = route('industry');
                } else {
                    $return['status'] = 'error';
                    $return['jscode'] = '$("#loader").hide();';
                    $return['message'] = 'Something goes to wrong.';
                }
                echo json_encode($return);
                exit;


            case 'deactive-industry':

                $objIndustry = new Industry();
                $result = $objIndustry->common_activity_user($request->input('data'),2);

                if ($result) {
                    $return['status'] = 'success';
                    $return['message'] = 'Industry successfully deactived.';
                    $return['redirect'] = route('industry');
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
