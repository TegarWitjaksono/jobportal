<x-guest-layout>
    <!-- Register Start -->
    <section class="bg-home d-flex align-items-center" style="background: url('{{ asset('images/hero/bg3.jpg') }}') center;">
        <div class="bg-overlay bg-linear-gradient-2"></div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10"> <!-- Updated width -->
                    <div class="card login-page bg-white shadow rounded border-0">
                        <div class="card-body">
                            <x-custom-validation-errors />

                            <form class="login-form mt-4" method="POST" action="{{ route('register') }}">
                                @csrf

                                <a href="home"><img src="images/logo-dark.png" class="mb-4 d-block mx-auto" alt=""></a>
                                <h6 class="mb-3 text-uppercase fw-semibold text-center">{{ __('Register your account') }}</h6>

                                <div class="row">
                                    <!-- Left Column -->
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <x-label for="nama_depan" value="{{ __('Nama Depan') }}" />
                                            <x-input name="nama_depan" id="nama_depan" type="text" class="form-control" placeholder="Budi" :value="old('nama_depan')" required autofocus autocomplete="given-name" />
                                            <x-custom-input-error for="nama_depan" />
                                        </div>
                                        <div class="mb-3">
                                            <x-label for="nama_belakang" value="{{ __('Nama Belakang') }}" />
                                            <x-input name="nama_belakang" id="nama_belakang" type="text" class="form-control" placeholder="Santoso" :value="old('nama_belakang')" autocomplete="family-name" />
                                            <x-custom-input-error for="nama_belakang" />
                                        </div>
                                        <div class="mb-3">
                                            <x-label for="email" value="{{ __('Your Email') }}" />
                                            <x-input name="email" id="email" type="email" class="form-control" placeholder="example@website.com" :value="old('email')" required autocomplete="email" />
                                            <x-custom-input-error for="email" />
                                        </div>

                                    </div>

                                    <!-- Right Column -->
                                    <div class="col-md-6">
                                        
                                        <div class="mb-3">
                                            <x-label for="loginpass" value="{{ __('Password') }}" />
                                            <x-input name="password" id="loginpass" type="password" class="form-control" placeholder="Password" required autocomplete="new-password" />
                                            <x-custom-input-error for="password" />
                                        </div>

                                        <div class="mb-3">
                                            <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                                            <x-input name="password_confirmation" id="password_confirmation" type="password" class="form-control" placeholder="Confirm Password" required autocomplete="new-password" />
                                            <x-custom-input-error for="password_confirmation" />
                                        </div>
                                        @php
                                            $countries = config('countries');
                                        @endphp
                                        <div class="mb-3">
                                            <x-label for="negara" value="{{ __('Negara') }}" />
                                            <select name="negara" id="negara" class="form-select" required>
                                                <option value="">{{ __('Pilih Negara') }}</option>
                                                @foreach($countries as $code => $country)
                                                    @php
                                                        $flag = mb_chr(127397 + ord($code[0])) . mb_chr(127397 + ord($code[1]));
                                                    @endphp
                                                    <option value="{{ $country }}" @selected(old('negara') === $country)>{{ $flag }} {{ $country }}</option>
                                                @endforeach
                                            </select>
                                            <x-custom-input-error for="negara" />
                                        </div>
                                        
                                        
                                    </div>

                                    <!-- Full Width Buttons -->
                                    <div class="col-12">
                                        @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                                            <div class="mb-3">
                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox" name="terms" id="terms" required>
                                                    <label class="form-label form-check-label text-muted" for="terms">
                                                        {!! __('I agree to the :terms_of_service and :privacy_policy', [
                                                            'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="text-primary">'.__('Terms of Service').'</a>',
                                                            'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="text-primary">'.__('Privacy Policy').'</a>',
                                                        ]) !!}
                                                    </label>
                                                    <x-custom-input-error for="terms" />
                                                </div>
                                            </div>
                                        @endif
                                        <button class="btn btn-primary w-100 mb-3" type="submit">{{ __('Register') }}</button>
                                        <div class="text-center">
                                            <span><span class="text-muted small me-2">Already have an account ? </span> <a href="{{ route('login') }}" class="text-dark fw-semibold small">Sign in</a></span>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Register End -->
</x-guest-layout>

