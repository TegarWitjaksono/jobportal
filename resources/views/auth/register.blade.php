<x-guest-layout>
    <x-guest-card>
        {{-- TODO: CREATE CRUD OFFICER --}}

        <x-custom-validation-errors/>

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <a href="home"><img src="images/logo-dark.png" class="mb-4 d-block mx-auto" alt=""></a>
            <h6 class="mb-3 text-uppercase fw-semibold">{{ __('Register your account') }}</h6>

            <div class="mb-3">
                <x-label for="name" value="{{ __('Your Name') }}" />
                <x-input name="name" id="name" type="text" class="form-control" placeholder="Calvin Carlo" :value="old('name')" required autofocus autocomplete="name" />
                <x-custom-input-error for="name" />
            </div>

            <div class="mb-3">
                <x-label for="email" value="{{ __('Your Email') }}" />
                <x-input name="email" id="email" type="email" class="form-control" placeholder="example@website.com" :value="old('email')" required autofocus autocomplete="email" />
                <x-custom-input-error for="email" />
            </div>

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

            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                <div class="form-check mb-3">
                    <input class="form-check-input" type="checkbox" name="terms" id="terms" required>
                    <label class="form-label form-check-label text-muted" for="terms">
                        {!! __('I agree to the :terms_of_service and :privacy_policy', [
                            'terms_of_service' => '<a target="_blank" href="'.route('terms.show').'" class="text-primary">'.__('Terms of Service').'</a>',
                            'privacy_policy' => '<a target="_blank" href="'.route('policy.show').'" class="text-primary">'.__('Privacy Policy').'</a>',
                        ]) !!}
                    </label>
                    <x-custom-input-error for="terms" />
                </div>
            @endif

            <button class="btn btn-primary w-100" type="submit">{{ __('Register') }}</button>

            <div class="col-12 text-center mt-3">
                <span><span class="text-muted small me-2">Already have an account ? </span> <a href="{{ route('login') }}" class="text-dark fw-semibold small">Sign in</a></span>
            </div><!--end col-12-->
        </form>
    </x-guest-card>
</x-guest-layout>
