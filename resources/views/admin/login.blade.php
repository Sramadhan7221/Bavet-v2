@extends('layouts.auth')

@section('title', "Login - Bavet Jabar")

@section('content')
<div class="account-pages p-sm-5  position-relative">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xxl-9 col-lg-11">
                <div class="card overflow-hidden" style="background-color: #800080">
                    <div class="row g-0">
                        <div class="col-lg-5">
                            <div class="d-flex flex-column h-100">
                                <div class="my-auto">
                                    <div class="auth-brand p-4 pb-0 text-center my-3">
                                        <a href="{{ route('dashboard') }}" class="logo-light">
                                            <img src="{{ asset('admin/images/logo.png') }}" alt="logo" width="275">
                                        </a>
                                        <a href="{{ route('dashboard') }}" class="logo-dark">
                                            <img src="{{ asset('admin/images/logo.png') }}" alt="dark logo" width="275">
                                        </a>
                                    </div>
                                    <div class="p-4 text-center text-white">
                                        <h4 class="fs-20" style="color:gold;">Login Bavet CMS</h4>
                                        <p class="text-white mb-4">Silahkan masukan Username dan Password untuk melanjutkan
                                        </p>

                                        <!-- form -->
                                        <form action="{{ route('login') }}" method="POST" class="text-start">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="emailaddress" class="form-label">Username</label>
                                                <input class="form-control" type="text" name="username" required=""
                                                    placeholder="Username">
                                            </div>
                                            <div class="mb-3">
                                                <label for="password" class="form-label">Password</label>
                                                <input class="form-control" type="password" required="" id="password" name="password"
                                                    placeholder="Kata sandi">
                                            </div>
                                            {{-- <input type="hidden" name="g-recaptcha-response" id="recaptcha-token"> --}}
                                            <div class="mb-0 text-start">
                                                <button class="btn btn-soft-primary w-100" type="submit"><i
                                                        class="ri-login-circle-fill me-1"></i> <span class="fw-bold">Masuk</span> </button>
                                            </div>

    
                                        </form>
                                        <!-- end form-->
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end col -->
                        <div class="col-lg-7 d-none d-lg-block">
                            <img src="{{ asset('admin/images/bavet.png') }}" alt="" class="img-fluid my-auto">
                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
<!-- end page -->
@endsection