<form method="POST"  class="login p-4" wire:submit.prevent="loginCustom">
    @csrf
    <div class="mb-3">
        <h2 class="fw-bold">Login</h2>
      </div>
    <div class="mb-3">
        <label for="login" class="col-md-12 col-form-label ">{{ __('Username or Email Address') }}</label>
        <input id="login" type="text" class="form-control @error('login') is-invalid @enderror" wire:model="login"
            value="{{ old('login') }}" required autocomplete="login" autofocus>

        @error('login')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="mb-3">
        <label for="password" class="col-md-4 col-form-label ">{{ __('Password') }}</label>
        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror"
            wire:model="password" required autocomplete="current-password">

        @error('password')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>
    <div class="mb-3 d-flex justify-content-between align-items-center rmb">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="remember" id="remember"
                {{ old('remember') ? 'checked' : '' }}>

            <label class="form-check-label" for="remember">
                <small> {{ __('Remember Me') }}</small>
            </label>
        </div>
        <div class="form-check">
            @if (Route::has('password.request'))
                <a class="btn btn-link" href="{{ route('password.request') }}">
                    <small> {{ __('Forgot Your Password?') }}</small>
                </a>
            @endif
        </div>
    </div>
    <div class="mb-3">
        <button type="submit" id="loginButton" data-loading-text="Logging in..." class="btn btn-re w-100">
            Login
        </button>
    </div>
   
</form>
