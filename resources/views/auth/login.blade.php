@extends('layouts.app')

@section('content')
<div class="page-login page-center">
      <div class="container container-tight py-4">
            <div class="text-center mb-4">
                  <a href="." class="navbar-brand navbar-brand-autodark">
                        <img src="{{ asset('dist/images/logo.png')}}" width="110" width="100px" >
                  </a>
            </div>
            <div class="card card-md">
                  <div class="card-body">
                        <h2 class="h2 text-center mb-4">Login to your account</h2>
                        <form action="{{ route('login') }}" method="POST" autocomplete="off" novalidate>
                  
                        @csrf
                              <div class="mb-3">
                                    <label class="form-label">Email address</label>
                                    <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"
                                     placeholder="your@email.com" value="{{ old('email') }}" required
                                     autocomplete="email" autofocus>
                                    @error('email')
                                    <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                              </div>
                              <div class="mb-2">
                                    <label class="form-label">
                                          Password
                                          <span class="form-label-description">
                                                @if (Route::has('password.request'))
                                                <a href="{{ route('password.request') }}">I forgot password</a>
                                                @endif
                                          </span>
                                    </label>
                                    <div class="input-group input-group-flat" id="show_hide_password">
                                          <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror"
                                                placeholder="Your password" autocomplete="current-password" required >
                                          @error('password')
                                          <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                          </span>
                                          @enderror
                                          <span class="input-group-text">
                                                <a href="#" class="link-secondary" title="Show password"
                                                      data-bs-toggle="tooltip">
                                                      <i  class="fa fa-eye-slash"></i>
                                                </a>
                                          </span>
                                    </div>
                              </div>
                              <div class="mb-2">
                                    <label class="form-check">
                                          <input type="checkbox" class="form-check-input" 
                                                                        name="remember" id="remember"
                                                                        {{ old('remember') ? 'checked' : '' }}/>
                                          <span class="form-check-label">Remember me on this device</span>
                                    </label>
                              </div>
                              <div class="form-footer">
                                    <button type="submit" class="btn btn-primary w-100">Sign in</button>
                              </div>
                        </form>
                  </div>
                  <div class="hr-text">or</div>
                  <div class="card-body">
                        <div class="row">
                             
                              
                        </div>
                  </div>
            </div>
            <!-- <div class="text-center text-secondary mt-3">
                  Don't have account yet? <a  href="{{ route('register') }}"tabindex="-1">Sign up</a>
            </div> -->
      </div>
</div>


@endsection