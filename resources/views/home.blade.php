@extends('layouts.head')
@extends('layouts.header')
@extends('layouts.sidebar')
@extends('layouts.footer')

@section('content')
<!-- main-panel -->
<div class="main-panel">
      <div class="content-wrapper">
      <div class="row">
            <div class="col-md-8">
                  <div class="card">
                        <div class="card-header">
                              @if (session('status'))
                              <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                              </div>
                              @endif

                              <h4> {{ __('You are logged in!') }}</h4>
                        </div>

                        <div class="card-body">
                              @auth
                              <!-- Admin menu-->
                              @if(Auth::user()->role_id == '2')
                              <a class="text-danger" href="{{ route('admin') }}">Click {{ __('Dashboard') }}</a>
                              @endif

                              <!-- vendor manager sidebar menu-->
                              @if(Auth::user()->role_id == '6')
                              <a class="text-danger" href="{{ route('vendor_manager') }}">Click {{ __('Dashboard') }}</a>

                              @endif

                               <!-- casheir sidebar menu-->
                              @if(Auth::user()->role_id == '7')
                              <a class="text-danger" href="{{ route('cashier') }}">Click {{ __('Dashboard') }}</a>
                              @endif

                               <!-- account manager sidebar menu-->
                              @if(Auth::user()->role_id == '8')
                              <a class="text-danger" href="{{ route('account_manager') }}">Click {{ __('Dashboard') }}</a>
                              @endif

                              <!-- parent vendor sidebar menu-->
                              @if(Auth::user()->role_id == '9')
                              <a class="text-danger" href="{{ url('/', [auth()->user()->username]) }}">Click {{ __('Dashboard') }}</a>
                              @endif

                                <!-- child vendor sidebar menu-->
                                @if(Auth::user()->role_id == '10')
                              <a class="text-danger" href="{{ url('/', [auth()->user()->username]) }}">Click {{ __('Dashboard') }}</a>
                              @endif

                              @endauth
                        </div>
                  </div>
            </div>
      </div>
</div>
<footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
                  <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright ©
                        LocalEats Africa {{ date('Y')}} </a>. All rights
                        reserved.</span>
                  <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"><i
                              class="mdi mdi-heart text-danger"></i></span>
            </div>
      </footer>
      </div>
@endsection