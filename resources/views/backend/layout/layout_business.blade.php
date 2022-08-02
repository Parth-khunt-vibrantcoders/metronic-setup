<!DOCTYPE html>
<html lang="en">
	@include('backend.includes.header')
	<!--begin::Body-->
	<body id="kt_body" >
		<!--begin::Main-->
		<!--begin::Header Mobile-->

		<!--end::Header Mobile-->
		<div class="d-flex flex-column flex-root">
            <!--begin::Page-->
            <div class="d-flex flex-row flex-column-fluid page">


                <!--begin::Wrapper-->
                <div class="d-flex flex-column flex-row-fluid wrapper" id="kt_wrapper">
                    <!--begin::Header-->

                    <!--end::Header-->
                    <!--begin::Content-->
                    <div class="content d-flex flex-column flex-column-fluid" id="kt_content">
                        <!--begin::Subheader-->

                        <!--end::Subheader-->
                        <!--begin::Entry-->
                        <div class="d-flex flex-column-fluid">
                            <!--begin::Container-->
                            <div class="container">
                                <div class="card card-custom">
                                    <div class="card-body p-0">
                                        <!--begin::Wizard-->
                                        <div class="wizard wizard-1" id="kt_wizard" data-wizard-state="step-first" data-wizard-clickable="false">
                                            <!--begin::Wizard Nav-->

                                            <!--end::Wizard Nav-->
                                            <!--begin::Wizard Body-->
                                            <div class="row justify-content-center my-10 px-8 my-lg-15 px-lg-10">
                                                <div class="col-xl-12 col-xxl-7">

                                                    @yield('section')
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

		<!--end::Main-->


        @include('backend.includes.footer')

	</body>
	<!--end::Body-->
</html>
