@extends('backend.layout.layout')
@section('section')

<!--begin::Entry-->
<div class="d-flex flex-column-fluid">
   <!--begin::Container-->
   <!--begin::Container-->
   <div class="container-fluid">
      <div class="row">
         <div class="col-md-12">
            <!--begin::Card-->
            <div class="card card-custom gutter-b example example-compact">
               <div class="card-header">
                  <h3 class="card-title">{{ $header['title'] }}</h3>
               </div>
               <!--begin::Form-->
               <form class="form" id="edit-feedback-type" method="POST" action="{{ route('edit-save-feedback-type') }}" >
                  @csrf
                  <div class="card-body">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Industry
                                <span class="text-danger">*</span></label>
                                <select class="form-control select2" id="industry_id"  name="industry_id">
                                    <option value="">Select Industry</option>
                                    @foreach ($industry_list as $key => $value)
                                        <option value="{{ $value['id'] }}" {{ $value['id'] == $feedback_type_detail[0]['industry_id'] ? 'selected="selected"' : '' }}>{{ $value['industry_name'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Feedback Type
                                <span class="text-danger">*</span></label>
                                <input type="text" name="feedback_type" class="form-control" placeholder="Please enter feedback type" value="{{ $feedback_type_detail[0]['feedback_type'] }}" >
                                <input type="hidden" name="editId" value="{{ $feedback_type_detail[0]['id'] }}">
                            </div>
                        </div>


                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Status <span class="text-danger">*</span></label>
                                <div class="radio-inline" style="margin-top:10px">
                                    <label class="radio radio-lg radio-success" >
                                    <input type="radio" name="status" class="radio-btn" value="0" {{ $feedback_type_detail[0]['status'] == '0' ? 'checked="checked"' : '' }} checked="checked"/>
                                    <span></span>Active</label>
                                    <label class="radio radio-lg radio-danger" >
                                    <input type="radio" name="status" class="radio-btn" value="1" {{ $feedback_type_detail[0]['status'] == '1' ? 'checked="checked"' : '' }} />
                                    <span></span>Inactive</label>
                                </div>
                            </div>
                        </div>
                    </div>


                  </div>
                  <div class="card-footer">
                     <button type="submit" class="btn btn-primary mr-2 green-btn submitbtn">Submit</button>
                     <a href="{{ route('feedback-type') }}" class="btn btn-secondary">Cancel</a>

                  </div>
               </form>
               <!--end::Form-->
            </div>
            <!--end::Card-->
         </div>
      </div>
   </div>
   <!--end::Container-->
   <!--end::Container-->
</div>
<!--end::Entry-->
@endsection
