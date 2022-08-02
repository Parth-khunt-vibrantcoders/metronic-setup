@extends('backend.layout.layout_business')
@section('section')

@php

    $image = url("public/upload/userprofile/default.jpg");

@endphp

        <form class="form"  id="business-detail" method="POST" enctype="multipart/form-data" action="">
        @csrf

        <!--begin::Wizard Step 1-->
        <div class="pb-5" >
            <h3 class="mb-10 font-weight-bold text-dark">Please Enter Your Business Details</h3>
            <!--begin::Input-->
            <div class="row">
                <div class="col-md-3">

                </div>
                <div class="col-md-6 text-center">
                    <div class="form-group">
                        <label>Business Logo</label>
                        <div class="">
                            <div class="image-input image-input-outline" id="kt_image_1">
                                <div class="image-input-wrapper my-avtar" style="background-image: url({{ $image }})"></div>

                                <label class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="change" data-toggle="tooltip" title="" data-original-title="Change avatar">
                                    <i class="fa fa-pencil  icon-sm text-muted"></i>
                                    <input type="file" name="userimage" accept=".png, .jpg, .jpeg" />
                                    <input type="hidden" name="profile_avatar_remove" />
                                </label>
                                <span class="btn btn-xs btn-icon btn-circle btn-white btn-hover-text-primary btn-shadow" data-action="cancel" data-toggle="tooltip" title="Cancel avatar">
                                    <i class="ki ki-bold-close icon-xs text-muted"></i>
                                </span>
                            </div>
                            <span class="form-text text-muted">Allowed file types: png, jpg, jpeg.</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">

                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="form-group">
                        <label>Business Name</label>
                        <input type="text" class="form-control form-control-solid form-control-lg" name="business_name" placeholder="Please enter business name" />

                    </div>
                </div>
                    <!--end::Input-->
                    <!--begin::Input-->

            </div>

            <div class="row">
                <div class="col-xl-6">
                    <div class="form-group">
                        <label>Business Email</label>
                        <input type="text" class="form-control form-control-solid form-control-lg" name="business_email" placeholder="Please enter business email address" />
                    </div>
                </div>

                <div class="col-xl-6">
                    <div class="form-group">
                        <label>Business Phone Number</label>
                        <input type="text" class="form-control form-control-solid form-control-lg" name="business_number" placeholder="Please enter business phone number" />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xl-12">
                    <div class="form-group">
                        <label>Business Address</label>
                        <textarea name="business_address" class="form-control form-control-solid form-control-lg" id="get_api_details" placeholder="Please enter business address" aria-required="true" aria-describedby="address-error" aria-invalid="false"></textarea>

                    </div>
                </div>
            </div>


            <!--end::Input-->
            <div class="row">
                <div class="col-xl-6">
                    <!--begin::Input-->
                    <div class="form-group">
                        <label>Latitude</label>
                        <input class="form-control latitude form-control-solid form-control-lg" name="latitude" type="text" placeholder="Please enter stockist latitude" readonly="readonly"/>
                    </div>
                    <!--end::Input-->
                </div>
                <div class="col-xl-6">
                    <!--begin::Input-->
                    <div class="form-group">
                        <label>Longitude</label>
                        <input class="form-control longitude form-control-solid form-control-lg" name="longitude" type="text" placeholder="Please enter stockist longitude" readonly="readonly"/>
                    </div>
                    <!--end::Input-->
                </div>
            </div>

        </div>
        <!--end::Wizard Step 1-->

        <!--begin::Wizard Actions-->
        <div class="d-flex justify-content-between border-top mt-5 pt-10">
            <button type="submit" class="btn btn-success font-weight-bolder text-uppercase px-9 py-4">Submit</button>

        </div>
        <!--end::Wizard Actions-->
        </form>


<!--end::Entry-->
@endsection
