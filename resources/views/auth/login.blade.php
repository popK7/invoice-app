@extends('layouts.master-without-nav')
@section('title') Sign In @endsection
@section('body') <body class="auth-bg 100-vh"> @endsection
    @section('content')

    <div class="bg-overlay bg-light"></div>
    <div class="account-pages">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-11">
                    <div class="auth-full-page-content d-flex min-vh-100 py-sm-5 py-4">
                        <div class="w-100">
                            <div class="d-flex flex-column h-100 py-0 py-xl-4">

                                <div class="text-center mb-5">
                                    <a href="{{url('/')}}">
                                        <span class="logo-lg">
                                            <img src="{{URL::asset('assets/images/logo-dark.png')}}" alt="" height="21">
                                        </span>
                                    </a>
                                </div>

                                <div class="card my-auto overflow-hidden">
                                    <div class="row g-0">
                                        <div class="col-lg-6">
                                            <div class="p-lg-5 p-4">
                                                <div class="text-center">
                                                    <h5 class="mb-0">Welcome Back !</h5>
                                                    <p class="text-muted mt-2">Sign in to continue to Invoika.</p>
                                                </div>

                                                <div class="mt-4">
                                                    <form action="{{url('login')}}" method="POST" name="loginForm" class="auth-input" onsubmit="return validateform()">
                                                        @csrf
                                                        <div class="mb-3">
                                                            <label for="email" class="form-label">Email</label>
                                                            <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" id="email" placeholder="Enter email" value="<?php if(isset($_COOKIE['rememberEmail']) && $_COOKIE['rememberEmail'] != "") { echo $_COOKIE['rememberEmail'] ; } ?>" autocomplete="off">

                                                            @error('email')
                                                            <span class="invalid-feedback" role="alert" id="emailError">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>

                                                        <div class="mb-2">
                                                            <label for="userpassword" class="form-label">Password</label>
                                                            <div class="position-relative auth-pass-inputgroup mb-3">
                                                                <input type="password" class="form-control pe-5 password-input @error('password') is-invalid @enderror" placeholder="Enter password" name="password" id="password-input" value="<?php if(isset($_COOKIE['rememberPassword']) && $_COOKIE['rememberPassword'] != "") { echo $_COOKIE['rememberPassword'] ; } ?>" autocomplete="off">
                                                                <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="las la-eye align-middle fs-18"></i></button>
                                                            </div>

                                                            @error('password')
                                                            <span class="invalid-feedback" role="alert" id="passwordError">
                                                                <strong>{{ $message }}</strong>
                                                            </span>
                                                            @enderror
                                                        </div>

                                                        <div class="form-check form-check-primary fs-16 py-2">
                                                            <input type="hidden" id="remember" value="<?php echo @$_COOKIE['remember'];?>">
                                                            <input class="form-check-input" type="checkbox" id="remember-check" name="remember">
                                                            <div class="float-end">
                                                                <a href="{{url('reset-password')}}" class="text-muted text-decoration-underline fs-14">Forgot your password?</a>
                                                            </div>
                                                            <label class="form-check-label fs-14" for="remember-check">
                                                                Remember me
                                                            </label>
                                                        </div>

                                                        <div class="mt-2">
                                                            <button class="btn btn-primary w-100" type="submit">Log In</button>
                                                        </div>
                                                    </form>
                                                </div>

                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="d-flex h-100 bg-auth align-items-end">
                                                <div class="p-lg-5 p-4">
                                                    <div class="bg-overlay bg-primary"></div>
                                                    <div class="p-0 p-sm-4 px-xl-0 py-5">
                                                        <div id="reviewcarouselIndicators" class="carousel slide auth-carousel" data-bs-ride="carousel">
                                                            <div class="carousel-indicators carousel-indicators-rounded">
                                                                <button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
                                                                <button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
                                                                <button type="button" data-bs-target="#reviewcarouselIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
                                                            </div>

                                                            <!-- end carouselIndicators -->
                                                            <div class="carousel-inner mx-auto">
                                                                <div class="carousel-item active">
                                                                    <div class="testi-contain text-center">
                                                                        <h5 class="fs-20 text-white mb-0">“I feel confident
                                                                            imposing
                                                                            on myself”
                                                                        </h5>
                                                                        <p class="fs-15 text-white-50 mt-2 mb-0">Vestibulum auctor orci in risus iaculis consequat suscipit felis rutrum aliquet iaculis
                                                                            augue sed tempus In elementum ullamcorper lectus vitae pretium Nullam ultricies diam
                                                                            eu ultrices sagittis.</p>
                                                                    </div>
                                                                </div>

                                                                <div class="carousel-item">
                                                                    <div class="testi-contain text-center">
                                                                        <h5 class="fs-20 text-white mb-0">“Our task must be to
                                                                            free widening circle”</h5>
                                                                        <p class="fs-15 text-white-50 mt-2 mb-0">
                                                                            Curabitur eget nulla eget augue dignissim condintum Nunc imperdiet ligula porttitor commodo elementum
                                                                            Vivamus justo risus fringilla suscipit faucibus orci luctus
                                                                            ultrices posuere cubilia curae ultricies cursus.
                                                                        </p>
                                                                    </div>
                                                                </div>

                                                                <div class="carousel-item">
                                                                    <div class="testi-contain text-center">
                                                                        <h5 class="fs-20 text-white mb-0">“I've learned that
                                                                            people forget what you”</h5>
                                                                        <p class="fs-15 text-white-50 mt-2 mb-0">
                                                                            Pellentesque lacinia scelerisque arcu in aliquam augue molestie rutrum Fusce dignissim dolor id auctor accumsan
                                                                            vehicula dolor
                                                                            vivamus feugiat odio erat sed quis Donec nec scelerisque magna
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- end carousel-inner -->
                                                        </div>
                                                        <!-- end review carousel -->
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <!-- end card -->

                                <div class="mt-5 text-center">
                                    <p class="mb-0 text-muted">©
                                        <script>
                                            document.write(new Date().getFullYear())

                                        </script> Invoika. Crafted with <i class="mdi mdi-heart text-danger"></i> by Themesbrand
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>

    @endsection
    @section('scripts')
    <!-- password-addon init -->
    <script src="{{URL::asset('assets/js/pages/password-addon.init.js')}}"></script>

    <script>
        (function() {
            'use strict';
            var remember = document.getElementById("remember").value;
            if (remember == '1') {
                document.getElementById("remember-check").checked = true;
            } else {
                document.getElementById("remember-check").checked = false;
            }

            function validateform() {
                var email = document.loginForm.email.value;
                var password = document.loginForm.password.value;
                if (email == null || email == "") {
                    document.getElementById("emailError").innerHTML = "Email cant be blank.";
                    return false;
                }
                if (password == null || password == "") {
                    document.getElementById("passwordError").innerHTML = "Password cant be blank.";
                    return false;
                }
                if (password.length < 6) {
                    document.getElementById("passwordError").innerHTML = "Password must be at least 6 characters long.";
                    return false;
                }
            }
        })();

    </script>
    @endsection
