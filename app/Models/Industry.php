<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;
use Route;
use Session;

class Industry extends Model
{
    use HasFactory;
    protected $table = 'industry';

    public function getdatatable()
    {

        $requestData = $_REQUEST;
        $columns = array(
            0 => 'industry.id',
            1 => 'industry.industry_name',
            2 => DB::raw('(CASE WHEN industry.status = "0" THEN "Active" ELSE "Inactive" END)'),

        );
        $query = Industry ::from('industry')
                            ->where('industry.is_deleted','N');


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
                    ->select('industry.id','industry.industry_name','industry.status',DB::raw('(CASE WHEN industry.status = "0" THEN "Active" ELSE "Inactive" END) as statuss '))
                    ->get();

        $data = array();
        $i = 0;

        foreach ($resultArr as $row) {

            $actionhtml  = '';


              $actionhtml =  $actionhtml. '<a href="'. route('edit-industry', $row['id']) .'" class="btn btn-icon"><i class="fa fa-pencil-square-o text-warning" title="Edit Industry"> </i></a>';

            // $actionhtml = '<a href="javscript:;" data-toggle="modal" data-target="#viewAuditTrails" data-id="'.$row['id'].'" class="btn btn-icon viewdata"><i class="fa fa-eye text-info"> </i></a>';
            if($row['status'] == '0'){
                $status = '<span class="badge badge-md badge-success">'.$row['statuss'].'</span>';

                  $actionhtml =  $actionhtml. '<a href="#" data-toggle="modal" data-target="#deactiveModel" class="btn btn-icon  deactive-industry" data-id="' . $row["id"] . '" title="Inactive Industry" ><i class="fa fa-times text-danger" ></i></a>';

            }else{
                $status = '<span class="badge badge-md badge-danger">'.$row['statuss'].'</span>';

                  $actionhtml =  $actionhtml. '<a href="#" data-toggle="modal" data-target="#activeModel" class="btn btn-icon  active-industry" data-id="' . $row["id"] . '" title="Active Industry" ><i class="fa fa-check text-success" ></i></a>';

            }

              $actionhtml =  $actionhtml. '<a href="#" data-toggle="modal" data-target="#deleteModel" class="btn btn-icon  delete-industry" data-id="' . $row["id"] . '"  title="Delete Industry"><i class="fa fa-trash text-danger" ></i></a>';


            $i++;
            $nestedData = array();
            $nestedData[] = $i;
            $nestedData[] = $row['industry_name'];
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

    public function add_industry($request){

         $checkCategory = Industry::from('industry')
                       ->where('industry.industry_name', $request->input('industry_name'))
                       ->where('industry.is_deleted', 'N')
                       ->count();

             if($checkCategory == 0){
                $loginDetails = Session::all();
                $objIndustry = new Industry();
                $objIndustry->industry_name = $request->input('industry_name');
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
                    $res = $objAudittrails->add_audit('Insert','admin/'. $currentRoute , json_encode($inputData) ,'Industry' );
                    return 'true';
                }else{
                    return 'false';
                }
             }
             return 'industry_exits';
    }

    public function get_industry_detail($id){
        return Industry::from('industry')
                       ->where('industry.id', $id)
                       ->select('industry.id', 'industry.industry_name', 'industry.status')
                       ->get()
                       ->toArray();
    }

    public function edit_industry($request){

        $checkCategory = Industry::from('industry')
                      ->where('industry.industry_name', $request->input('industry_name'))
                      ->where('industry.industry_name', '!=', $request->input('editId'))
                      ->where('industry.is_deleted', 'N')
                      ->count();

            if($checkCategory == 0){
               $loginDetails = Session::all();
               $objIndustry = Industry::find($request->input('editId'));
               $objIndustry->industry_name = $request->input('industry_name');
               $objIndustry->status = $request->input('status');
               $objIndustry->updated_by = $loginDetails['logindata'][0]['id'];
               $objIndustry->updated_at = date('Y-m-d H:i:s');
               if($objIndustry->save()){

                   $currentRoute = Route::current()->getName();
                   $inputData = $request->input();
                   unset($inputData['_token']);
                   $objAudittrails = new Audittrails();
                   $res = $objAudittrails->add_audit('Edit','admin/'. $currentRoute , json_encode($inputData) ,'Industry' );
                   return 'true';
               }else{
                   return 'false';
               }
            }
            return 'industry_exits';
   }

   public function common_activity_user($data,$type){
       $loginUser = Session::all();

        $objIndustry = Industry::find($data['id']);
        if($type == 0){
            $objIndustry->is_deleted = "Y";
            $event = 'Delete Industry';
        }
        if($type == 1){
            $objIndustry->status = "0";
            $event = 'Active Industry';
        }
        if($type == 2){
            $objIndustry->status = "1";
            $event = 'Deactive Industry';
        }
        $objIndustry->updated_by = $loginUser['logindata'][0]['id'];
        $objIndustry->updated_at = date("Y-m-d H:i:s");
        if($objIndustry->save()){
            $currentRoute = Route::current()->getName();
            $objAudittrails = new Audittrails();
            $res = $objAudittrails->add_audit($event, 'admin/'.$currentRoute, json_encode($data), 'Industry');
            return true;
        }else{
            return false ;
        }
    }

    public function get_industry_list(){
        return Industry::from('industry')
                       ->where('industry.is_deleted', 'N')
                       ->where('industry.status', '0')
                       ->select('industry.id', 'industry.industry_name')
                       ->get()
                       ->toArray();
    }
}
