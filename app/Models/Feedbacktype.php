<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Session;
use Route;

class Feedbacktype extends Model
{
    use HasFactory;
    protected $table = 'feedback_type';

    public function getdatatable()
    {

        $requestData = $_REQUEST;
        $columns = array(
            0 => 'feedback_type.id',
            1 => 'industry.industry_name',
            2 => 'feedback_type.feedback_type',
            3 => DB::raw('(CASE WHEN feedback_type.status = "0" THEN "Active" ELSE "Inactive" END)'),

        );
        $query = Feedbacktype ::from('feedback_type')
                            ->join('industry', 'industry.id', '=', 'feedback_type.industry_id')
                            ->where('feedback_type.is_deleted','N');


        if (!empty($requestData['search']['value'])) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
            $searchVal = $requestData['search']['value'];
            $query->where(function($query) use ($columns, $searchVal, $requestData) {
                $flag = 0;
                foreach ($columns as $key => $value) {
                    $searchVal = $requestData['search']['value'];
                    if ($requestData['columns'][$key]['searchable'] == 'true') {
                        if ($flag == 0) {
                            $query->where($value, 'like', '%' . $searchVal . '%');
                            $flag = $flag + 1;
                        } else {
                            $query->orWhere($value, 'like', '%' . $searchVal . '%');
                        }
                    }
                }
            });
        }

        $temp = $query->orderBy($columns[$requestData['order'][0]['column']], $requestData['order'][0]['dir']);

        $totalData = count($temp->get());
        $totalFiltered = count($temp->get());

        $resultArr = $query->skip($requestData['start'])
                    ->take($requestData['length'])
                    ->select('feedback_type.id', 'industry.industry_name','feedback_type.feedback_type','feedback_type.status',DB::raw('(CASE WHEN feedback_type.status = "0" THEN "Active" ELSE "Inactive" END) as statuss '))
                    ->get();

        $data = array();
        $i = 0;

        foreach ($resultArr as $row) {

            $actionhtml  = '';


              $actionhtml =  $actionhtml. '<a href="'. route('edit-feedback-type', $row['id']) .'" class="btn btn-icon"><i class="fa fa-pencil-square-o text-warning" title="Edit Feedback Type"> </i></a>';

            // $actionhtml = '<a href="javscript:;" data-toggle="modal" data-target="#viewAuditTrails" data-id="'.$row['id'].'" class="btn btn-icon viewdata"><i class="fa fa-eye text-info"> </i></a>';
            if($row['status'] == '0'){
                $status = '<span class="badge badge-md badge-success">'.$row['statuss'].'</span>';

                  $actionhtml =  $actionhtml. '<a href="#" data-toggle="modal" data-target="#deactiveModel" class="btn btn-icon  deactive-feedback-type" data-id="' . $row["id"] . '" title="Inactive Feedback Type" ><i class="fa fa-times text-danger" ></i></a>';

            }else{
                $status = '<span class="badge badge-md badge-danger">'.$row['statuss'].'</span>';

                  $actionhtml =  $actionhtml. '<a href="#" data-toggle="modal" data-target="#activeModel" class="btn btn-icon  active-feedback-type" data-id="' . $row["id"] . '" title="Active Feedback Type" ><i class="fa fa-check text-success" ></i></a>';

            }

              $actionhtml =  $actionhtml. '<a href="#" data-toggle="modal" data-target="#deleteModel" class="btn btn-icon  delete-feedback-type" data-id="' . $row["id"] . '"  title="Delete Feedback Type"><i class="fa fa-trash text-danger" ></i></a>';


            $i++;
            $nestedData = array();
            $nestedData[] = $i;
            $nestedData[] = $row['industry_name'];
            $nestedData[] = $row['feedback_type'];
            $nestedData[] = $status;
            $nestedData[] = $actionhtml;
            $data[] = $nestedData;
        }
        $json_data = array(
            "draw" => intval($requestData['draw']), // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
            "recordsTotal" => intval($totalData), // total number of records
            "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
            "data" => $data   // total data array
        );
        return $json_data;
    }

    public function add_feedback_type($request){
         $checkCategory = Feedbacktype::from('feedback_type')
                       ->where('feedback_type.feedback_type', $request->input('feedback_type'))
                       ->where('feedback_type.industry_id', $request->input('industry_id'))
                       ->where('feedback_type.is_deleted', 'N')
                       ->count();

             if($checkCategory == 0){
                $loginDetails = Session::all();
                $objIndustry = new Feedbacktype();
                $objIndustry->industry_id = $request->input('industry_id');
                $objIndustry->feedback_type = $request->input('feedback_type');
                $objIndustry->status = $request->input('status');
                $objIndustry->add_by = $loginDetails['logindata'][0]['id'];
                $objIndustry->updated_by = $loginDetails['logindata'][0]['id'];
                $objIndustry->created_at = date('Y-m-d H:i:s');
                $objIndustry->updated_at = date('Y-m-d H:i:s');
                if($objIndustry->save()){

                    $currentRoute = Route::current()->getName();
                    $inputData = $request->input();
                    unset($inputData['_token']);
                    $objAudittrails = new Audittrails();
                    $res = $objAudittrails->add_audit('Insert','admin/'. $currentRoute , json_encode($inputData) ,'Feedback Type' );
                    return 'true';
                }else{
                    return 'false';
                }
             }
             return 'feedback_type_exits';
    }

    public function get_feedback_type_detail($id){
        return Feedbacktype::from('feedback_type')
                           ->where('feedback_type.id', $id)
                           ->select('feedback_type.id', 'feedback_type.industry_id', 'feedback_type.feedback_type', 'feedback_type.status')
                           ->get()
                           ->toArray();
    }

    public function edit_feedback_type($request){
         $checkCategory = Feedbacktype::from('feedback_type')
                       ->where('feedback_type.feedback_type', $request->input('feedback_type'))
                       ->where('feedback_type.industry_id', $request->input('industry_id'))
                       ->where('feedback_type.id', '!=', $request->input('editId'))
                       ->where('feedback_type.is_deleted', 'N')
                       ->count();

             if($checkCategory == 0){
                $loginDetails = Session::all();
                $objIndustry = Feedbacktype::find($request->input('editId'));
                $objIndustry->industry_id = $request->input('industry_id');
                $objIndustry->feedback_type = $request->input('feedback_type');
                $objIndustry->status = $request->input('status');
                $objIndustry->updated_by = $loginDetails['logindata'][0]['id'];
                $objIndustry->updated_at = date('Y-m-d H:i:s');
                if($objIndustry->save()){

                    $currentRoute = Route::current()->getName();
                    $inputData = $request->input();
                    unset($inputData['_token']);
                    $objAudittrails = new Audittrails();
                    $res = $objAudittrails->add_audit('Insert','admin/'. $currentRoute , json_encode($inputData) ,'Feedback Type' );
                    return 'true';
                }else{
                    return 'false';
                }
             }
             return 'feedback_type_exits';
    }

    public function common_activity_user($data,$type){
        $loginUser = Session::all();

         $objFeedbacktype = Feedbacktype::find($data['id']);
         if($type == 0){
             $objFeedbacktype->is_deleted = "Y";
             $event = 'Delete Feedback Type';
         }
         if($type == 1){
             $objFeedbacktype->status = "0";
             $event = 'Active Feedback Type';
         }
         if($type == 2){
             $objFeedbacktype->status = "1";
             $event = 'Deactive Feedback Type';
         }
         $objFeedbacktype->updated_by = $loginUser['logindata'][0]['id'];
         $objFeedbacktype->updated_at = date("Y-m-d H:i:s");
         if($objFeedbacktype->save()){
             $currentRoute = Route::current()->getName();
             $objAudittrails = new Audittrails();
             $res = $objAudittrails->add_audit($event, 'admin/'.$currentRoute, json_encode($data), 'Feedback Type');
             return true;
         }else{
             return false ;
         }
     }
}
