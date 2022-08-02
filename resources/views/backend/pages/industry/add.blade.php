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
               <form class="form" id="add-industry" method="POST" action="{{ route('add-save-industry') }}" >
                  @csrf
                  <div class="card-body">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Industry Name
                                <span class="text-danger">*</span></label>
                                <input type="text" name="industry_name" class="form-control" placeholder="Please enter industry name" >
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Status <span class="text-danger">*</span></label>
                                <div class="radio-inline" style="margin-top:10px">
                                    <label class="radio radio-lg radio-success" >
                                    <input type="radio" name="status" class="radio-btn" value="0" checked="checked"/>
                                    <span></span>Active</label>
                                    <label class="radio radio-lg radio-danger" >
                                    <input type="radio" name="status" class="radio-btn" value="1" />
                                    <span></span>Inactive</label>
                                </div>
                            </div>
                        </div>
                    </div>


                  </div>
                  <div class="card-footer">
                     <button type="submit" class="btn btn-primary mr-2 green-btn submitbtn">Submit</button>
                     <a href="{{ route('industry') }}" class="btn btn-secondary">Cancel</a>

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
