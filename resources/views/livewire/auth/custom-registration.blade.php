<form method="POST" class="login p-5" wire:submit.prevent="registerCustom" >
    @csrf
    <div class="mb-3">
        <h2 class="fw-bold">Register</h2>
    </div>
    <p id="error_status"></p>
    <div class="row">
        <div class="col">
            <div class="mb-3">
                <label for="firstname" class="col-md-12 col-form-label ">{{ __('Firstname') }}</label>
                <input id="firstname" type="text" class="form-control @error('firstname') is-invalid @enderror"
                    wire:model="firstname" value="{{ old('firstname') }}" required autocomplete="firstname" autofocus>

                @error('firstname')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

        </div>
        <div class="col">
            <div class="mb-3">
                <label for="lastname" class="col-md-12 col-form-label ">{{ __('Lastname') }}</label>
                <input id="lastname" type="text" class="form-control @error('lastname') is-invalid @enderror"
                    wire:model="lastname" value="{{ old('lastname') }}" required autocomplete="lastname" autofocus>

                @error('lastname')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div>
    </div>
    <div class="mb-3">
        <label for="username" class="col-md-12 col-form-label ">{{ __('Username') }}</label>
        <input id="username" type="text" class="form-control @error('username') is-invalid @enderror"
            wire:model="username" value="{{ old('username') }}" required autocomplete="username" autofocus>

        @error('username')
            <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
            </span>
        @enderror
    </div>

    <div class="mb-3">
        <label for="email" class="col-md-12 col-form-label ">{{ __('Email Address') }}</label>
        <input id="email" type="text" class="form-control @error('email') is-invalid @enderror"
            wire:model="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

        @error('email')
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
    <div class="mb-3">
        <label for="password-confirm" class="col-md-12 col-form-label ">{{ __('Confirm Password') }}</label>
        <input id="password-confirm" type="password" class="form-control" wire:model="password_confirmation" required
            autocomplete="new-password">

    </div>

    <div class="mb-3">
        <button type="submit" id="loginButton" data-loading-text="Registering..." class="btn bg-custom-0 text-white w-100">
            {{ __('Register') }}
        </button>
    </div>
<br>
</form>
