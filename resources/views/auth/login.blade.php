<x-guest-layout>
    
    <!-- Hero Start -->
    <section class="bg-home d-flex align-items-center" style="background: url('{{ asset('images/hero/bg.jpg') }}') center;">
        <div class="bg-overlay bg-gradient-overlay"></div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-4 col-md-8">
                    <div class="card login-page bg-white shadow rounded border-0">
                        <div class="card-body">
                            <a href="{{ url('/') }}">
                                <!-- <img src="{{ asset('images/logo-dark.png') }}" class="mb-4 d-block mx-auto" alt="Logo"> -->
                            </a>
                            <h4 class="card-title text-center">Sign In</h4>  

                            <!-- Session Status -->
                            @session('status')
                                <div class="alert alert-success" role="alert">
                                    {{ $value }}
                                </div>
                            @endsession

                            <!-- Validation Errors -->
                            <x-custom-validation-errors />

                            <form class="login-form mt-4" method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">{{ __('Alamat Email') }} <span class="text-danger">*</span></label>
                                            <input id="email" type="email" class="form-control" name="email" placeholder="example@website.com" value="{{ old('email') }}" required autofocus autocomplete="username">
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="mb-3">
                                            <label class="form-label fw-semibold">{{ __('Password') }} <span class="text-danger">*</span></label>
                                            <input id="password" type="password" class="form-control" name="password" placeholder="Password" required autocomplete="current-password">
                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="d-flex justify-content-between">
                                            <div class="mb-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" id="remember_me" name="remember">
                                                    <label class="form-label form-check-label text-muted" for="remember_me">{{ __('Ingat saya') }}</label>
                                                </div>
                                            </div>
                                            @if (Route::has('password.request'))
                                                <span class="forgot-pass text-muted small mb-0">
                                                    <a href="{{ route('password.request') }}" class="text-muted">{{ __('Lupa password?') }}</a>
                                                </span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-lg-12 mb-0">
                                        <div class="d-grid">
                                            <button class="btn btn-primary">{{ __('Sign in') }}</button>
                                        </div>
                                    </div>

                                    @if (Route::has('register'))
                                        <div class="col-12 text-center mt-3">
                                            <span>
                                                <span class="text-muted me-2 small">{{ __("Belum punya akun?") }}</span>
                                                <a href="{{ route('register') }}" class="text-dark fw-semibold small">{{ __('Daftar Sekarang') }}</a>
                                            </span>
                                        </div>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </div> <!--end col-->
            </div><!--end row-->
        </div> <!--end container-->
    </section><!--end section-->
    <!-- Hero End -->
</x-guest-layout>