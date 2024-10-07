@extends('layouts.master')
@section('title') {{__('translation.Profile')}} @endsection
@section('css')

@endsection

@section('body')
<body>
    @endsection

    @section('content')

    @component('components.breadcrumb')
    @slot('title') {{__('translation.Profile')}} @endslot
    @slot('pagetitle') {{__('translation.Profile')}} @endslot
    @endcomponent

    <div class="row">
        <div class="col-xl-8">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">{{__('translation.Profile')}}</h4>
                </div>

                <div class="card-body pt-0">
                    <form method="POST" action="{{url('update-profile')}}" class="needs-validation" novalidate id="profile_form" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="mb-3">
                                    <label>{{__('translation.First Name')}}</label><span class="text-danger">*</span>
                                    <input type="text" name="first_name" id="first_name" placeholder="Enter first name" class="form-control @error('first_name') is-invalid @enderror" required autocomplete="off" value="{{$user->first_name}}">

                                    @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="mb-3">
                                    <label>{{__('translation.Last Name')}}</label><span class="text-danger">*</span>
                                    <input type="text" name="last_name" id="last_name" placeholder="Enter last name" class="form-control @error('last_name') is-invalid @enderror" required autocomplete="off" value="{{$user->last_name}}">

                                    @error('first_name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="mb-3">
                                    <label>{{__('translation.Username')}}</label><span class="text-danger">*</span>
                                    <input type="text" name="username" id="username" placeholder="Enter username" class="form-control @error('username') is-invalid @enderror" required autocomplete="off" value="{{$user->username}}" readonly style="background: #e9e9e9">

                                    @error('username')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="mb-3">
                                    <label>{{__('translation.Email')}}</label><span class="text-danger">*</span>
                                    <input type="email" name="email" id="email" placeholder="Enter email" class="form-control @error('email') is-invalid @enderror" required autocomplete="off" readonly value="{{$user->email}}" readonly style="background: #e9e9e9">

                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="mb-3">
                                    <label>{{__('translation.Mobile Number')}}</label><span class="text-danger">*</span>
                                    <input type="text" name="mobile_number" id="mobile_number" placeholder="Enter mobile number" class="form-control @error('mobile_number') is-invalid @enderror" required autocomplete="off" value="{{$user->mobile_number}}">

                                    @error('mobile_number')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-xl-6">
                                <div class="mb-3">
                                    <label>{{__('translation.Profile Image')}}</label><span class="text-danger">*</span>
                                    <input type="file" name="profile_image" id="profile_image" class="form-control" onchange="displayProfile(this)">
                                    <div class="text-center mt-4">
                                        @if($user->profile_image !== NULL || $user->profile_image !== '')
                                        <img src="{{ URL::asset('assets/images/users/'.$user->profile_image) }}" alt="" class="img-fluid" height="100px" width="100px" id="profile_display" style="border-radius:50%!important">
                                        @else
                                        <img src="{{ URL::asset('assets/images/users/user-dummy-img.jpg') }}" alt="" class="img-fluid" height="100px" width="100px" id="profile_display" style="border-radius:50%!important">
                                        @endif
                                    </div>
                                    <div class="invalid-feedback">Please select profile image.</div>
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

        <div class="col-xl-4">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">{{__('translation.Update Password')}}</h4>
                </div>

                <div class="card-body pt-0">
                    <form method="POST" action="{{url('update-password')}}" class="needs-validation" novalidate id="password_form" enctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="col-xl-12">
                                <div class="mb-3">
                                    <label>{{__('translation.Old Password')}}</label><span class="text-danger">*</span>
                                    <input type="password" name="old_password" id="old_password" placeholder="Enter old password" class="form-control @error('old_password') is-invalid @enderror" required autocomplete="off">

                                    @error('old_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-xl-12">
                                <div class="mb-3">
                                    <label>{{__('translation.New Password')}}</label><span class="text-danger">*</span>
                                    <input type="password" name="password" id="password" placeholder="Enter new password" class="form-control @error('password') is-invalid @enderror" required autocomplete="off">

                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-xl-12">
                                <div class="mb-3">
                                    <label>{{__('translation.Re-enter Password')}}</label><span class="text-danger">*</span>
                                    <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Re-Enter password" class="form-control @error('password_confirmation') is-invalid @enderror" required autocomplete="off">

                                    @error('password_confirmation')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="hstack justify-content-end d-print-none mt-2">
                                <button type="submit" class="btn btn-success"><i class="align-bottom me-1"></i>{{__('translation.Update')}}</button>
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
