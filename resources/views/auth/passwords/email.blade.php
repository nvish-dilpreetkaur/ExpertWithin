
@extends('layouts.login')

@section('content')
<div class="auth-section-wrap">
        <div class="auth-bg-container">
            <div class="expert-within-logo">
                    <a href="/"><img src="{{ URL::asset('images/Logo.svg') }}"></a>
            </div>
        <div class="auth-bg-picture" id="auth-page-frgt">
        
<div class="container">
<div class="row justify-content-center">  
        <div class="col-md-8 auth-page-frgt">
            <div class="card">
                <div class="card-header">{{ __('Enter recovery Email address') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}" class="auth-frgt-form">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary auth-btn">
                                    {{ __('Send Recovery Link') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
        <!-- <div class="footer my-opportunities-page inner-profile-page">
            <div class="container">
                <div class="footer-text">© 2020 ExpertWithin™ All rights reserved.</div>
            </div>
        </div> -->
 </div>
 </div>
@endsection
