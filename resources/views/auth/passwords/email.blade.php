@extends('layouts.index')

@section('content')
    <div class="wrapper auth-section" style="margin-top: 5rem;">


        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-5">
                    <div class="card">
                        <div class="card-header bg-custom-0 text-white">{{ __('Reset Password') }}</div>

                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('password.email') }}">
                                @csrf

                                <div class=" mb-3">
                                    <label for="email" class="text-md-start">{{ __('Email Address') }}</label>

                                </div>
                                <div class="mb-3">

                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="email" autofocus>

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                        </div>

                        <div class="mb-3 d-flex">
                            <button type="submit" class="btn bg-custom-0 text-white mx-auto">
                                {{ __('Send Password Reset Link') }}
                            </button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    </div>
@endsection
