@extends('layouts.master')
@section('title') {{__('translation.Site Settings')}} @endsection
@section('css')

@endsection

@section('body')
<body>
    @endsection

    @section('content')

    @component('components.breadcrumb')
    @slot('title') {{__('translation.Site Settings')}} @endslot
    @slot('pagetitle') {{__('translation.Site Settings')}} @endslot
    @endcomponent

    <div class="row">
        <div class="col-xl-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">{{__('translation.Site Settings')}}</h4>
                </div>

                <div class="card-body pt-0">
                    <form method="POST" action="{{url('update-site-setting')}}" class="needs-validation" novalidate id="setting_form" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="mb-3">
                                    <label>{{__('translation.App Title')}}</label><span class="text-danger">*</span>
                                    <input type="text" name="app_title" id="app_title" placeholder="Enter app title" class="form-control @error('app_title') is-invalid @enderror" required autocomplete="off" value="{{$siteSetting->app_title}}">

                                    <div class="invalid-feedback">Please enter app title.</div>
                                    @error('app_title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="mb-3">
                                    <label>{{__('translation.Light Logo')}}</label><span class="text-danger">*</span>
                                    <p class="text-muted mt-n2" style="margin-top:-7px">The file size should not be more than 2MB</p>
                                    <input type="file" name="light_logo" id="light_logo" class="form-control">
                                    <div class="invalid-feedback">Please select light logo.</div>

                                    @error('light_logo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="mb-3">
                                    <label>{{__('translation.Dark Logo')}}</label><span class="text-danger">*</span>
                                    <p class="text-muted mt-n2">The file size should not be more than 2MB</p>
                                    <input type="file" name="dark_logo" id="dark_logo" class="form-control">
                                    <div class="invalid-feedback">Please select dark logo.</div>

                                    @error('dark_logo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="mb-3">
                                    <label>{{__('translation.Favicon')}}</label><span class="text-danger">*</span>
                                    <p class="text-muted mt-n2">The file size should not be more than 2MB</p>
                                    <input type="file" name="favicon" id="favicon" class="form-control">
                                    <div class="invalid-feedback">Please select favicon.</div>

                                    @error('favicon')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-xl-4">
                                <div class="mb-3">
                                    <label>{{__('translation.Small Logo')}}</label><span class="text-danger">*</span>
                                    <p class="text-muted mt-n2">The file size should not be more than 2MB</p>
                                    <input type="file" name="logo_sm" id="logo_sm" class="form-control">
                                    <div class="invalid-feedback">Please select small logo.</div>

                                    @error('logo_sm')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="mt-4">
                                <h6 class="card-title mb-0" data-key="t-title-&amp;-logo-settings">{{__('translation.Footer Settings')}}</h6>
                            </div>
                            <hr class="mt-2">

                            <div class="col-xl-6">
                                <div class="mb-3">
                                    <label>{{__('translation.Copyright')}}</label><span class="text-danger">*</span>
                                    <input type="text" name="copyright_first" id="copyright_first" placeholder="Enter copyright" class="form-control @error('copyright_first') is-invalid @enderror" required autocomplete="off" value="{{$siteSetting->copyright_first}}">

                                    <div class="invalid-feedback">Please enter copyright.</div>
                                    @error('copyright_first')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="mb-3">
                                    <label>{{__('translation.Copyright')}}</label><span class="text-danger">*</span>
                                    <input type="text" name="copyright_last" id="copyright_last" placeholder="Enter copyright" class="form-control @error('copyright_last') is-invalid @enderror" required autocomplete="off" value="{{$siteSetting->copyright_last}}">

                                    <div class="invalid-feedback">Please enter copyright.</div>
                                    @error('copyright_last')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="hstack justify-content-end d-print-none mt-2">
                                <button type="submit" class="btn btn-success"><i class="align-bottom me-1"></i>{{__('translation.Save')}}</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </div>

    @endsection
    @section('scripts')
    <!-- jquery -->
    <script src="{{URL::asset('assets/js/jquery-3.6.4.min.js')}}"></script>
    <script>
        //Client form validate 
        (function() {
            'use strict';
            // Fetch all the forms we want to apply custom Bootstrap validation styles to
            var forms = document.querySelectorAll('.needs-validation')
            // Loop over them and prevent submission
            Array.prototype.slice.call(forms)
                .forEach(function(form) {
                    form.addEventListener('submit', function(event) {
                        if (!form.checkValidity()) {
                            event.preventDefault()
                            event.stopPropagation()
                        }

                        form.classList.add('was-validated')
                    }, false)
                })

            // Profile Photo
            function triggerClick() {
                document.querySelector('#profile_image').click();
            }

            function displayProfile(e) {
                if (e.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        document.querySelector('#profile_display').setAttribute('src', e.target.result);
                    }
                    reader.readAsDataURL(e.files[0]);
                }
            }
        })()

    </script>
    @endsection
