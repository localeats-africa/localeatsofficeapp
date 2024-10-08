@extends('layouts.head')
@extends('layouts.header')
@extends('layouts.sidebar')
@extends('layouts.footer')
@section('content')
<!-- main-panel -->
<div class="main-panel">
      <div class="content-wrapper">
            <div class="page-header">
                  <h3 class="page-title">
                        Change Password
                  </h3>
            </div>
            <!--Alert here--->
            <div class="row">
                  <div class="col-12">

                        @if(session('new-password'))
                        <div class="alert  alert-danger alert-dismissible" role="alert">
                              <div class="d-flex">
                                    <div>
                                          <!-- Download SVG icon from http://tabler-icons.io/i/alert-triangle -->
                                          <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                      d="M10.24 3.957l-8.422 14.06a1.989 1.989 0 0 0 1.7 2.983h16.845a1.989 1.989 0 0 0 1.7 -2.983l-8.423 -14.06a1.989 1.989 0 0 0 -3.4 0z" />
                                                <path d="M12 9v4" />
                                                <path d="M12 17h.01" />
                                          </svg>
                                    </div>
                                    <div> {!! session('new-password') !!}</div>
                              </div>
                              <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                        </div>
                        @endif

                        @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible" role="alert">
                              <div class="d-flex">
                                    <div>
                                          <!-- Download SVG icon from http://tabler-icons.io/i/alert-circle -->
                                          <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                                <path d="M12 8v4" />
                                                <path d="M12 16h.01" />
                                          </svg>
                                    </div>
                                    <div>
                                          <ul>
                                                @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                                @endforeach
                                          </ul>
                                    </div>
                              </div>
                              <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                        </div>
                        @endif

                  </div>
            </div>
            <!---end Alert --->
            <form method="post" action="/change-password" name="submit" enctype="multipart/form-data">
                  @csrf
                  <div class="row">
                        <div class="col-md-6 grid-margin stretch-card">
                              <div class="card">
                                    <div class="card-body">
                                          <div class="form-label required">New Password <i class="text-danger">*</i>
                                          </div>
                                          <div class="input-group input-group-flat" id="show_hide_password">
                                                <input type="password" class="form-control" name="password"
                                                      placeholder="" id="password" onkeyup="check_password()">

                                                <span class="input-group-text">
                                                      <a href="" class="text-secondary">
                                                            <i class="fa fa-eye-slash"></i>
                                                      </a>
                                                </span>
                                          </div>
                                          <span class="" id="check_password">

                                                @if ($errors->has('password'))
                                                <div class="alert alert-danger alert-dismissible" role="alert">
                                                      <div class="d-flex">
                                                            <div>
                                                                  <!-- Download SVG icon from http://tabler-icons.io/i/alert-circle -->
                                                                  <svg xmlns="http://www.w3.org/2000/svg"
                                                                        class="icon alert-icon" width="24" height="24"
                                                                        viewBox="0 0 24 24" stroke-width="2"
                                                                        stroke="currentColor" fill="none"
                                                                        stroke-linecap="round" stroke-linejoin="round">
                                                                        <path stroke="none" d="M0 0h24v24H0z"
                                                                              fill="none" />
                                                                        <path
                                                                              d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                                                        <path d="M12 8v4" />
                                                                        <path d="M12 16h.01" />
                                                                  </svg>
                                                            </div>
                                                            <div>
                                                                  {{ $errors->first('password') }}
                                                            </div>
                                                      </div>
                                                      <a class="btn-close" data-bs-dismiss="alert"
                                                            aria-label="close"></a>
                                                </div>
                                                @endif
                                    </div>
                              </div>
                        </div>


                        <div class="col-md-6 grid-margin stretch-card">
                              <div class="card">
                                    <div class="card-body">
                                          <div class="form-group">

                                                <label>Confirm Password </label>
                                                <div class="input-group input-group-flat" id="show_hide_password">
                                                      <input type="password" class="form-control" 
                                                            autocomplete="off" name="password_confirmation"
                                                            id="confirm_pass" onkeyup="validate_password()">
                                                      <span class="input-group-text" id="wrong_pass_alert">
                                                            <a href="" class="text-secondary">
                                                                  <i class="fa fa-eye-slash"></i>
                                                            </a>
                                                      </span>
                                                   

                                                </div>
                                                <span id="password_not_match" >
                                                </span>
                                          </div>
                                          @error('password_confirmation')
                                          <div class="alert alert-danger alert-dismissible" role="alert">
                                                <div class="d-flex">
                                                      <div>
                                                            <!-- Download SVG icon from http://tabler-icons.io/i/alert-circle -->
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                  class="icon alert-icon" width="24" height="24"
                                                                  viewBox="0 0 24 24" stroke-width="2"
                                                                  stroke="currentColor" fill="none"
                                                                  stroke-linecap="round" stroke-linejoin="round">
                                                                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                  <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                                                  <path d="M12 8v4" />
                                                                  <path d="M12 16h.01" />
                                                            </svg>
                                                      </div>
                                                      <div>
                                                            {{ $message }}
                                                      </div>
                                                </div>
                                                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                                          </div>
                                          @enderror
                                    </div>
                              </div>
                        </div>




                  </div>
                  <!--- row---->

                  <!-- row -->
                  <div class="row">
                        <div class="col-md-6">
                        </div>
                        <div class="col-md-6 col-12 grid-margin stretch-card justify-content-end">

                              <!-- send button here -->
                              <div class="card-footer bg-transparent mt-auto">
                                    <div class="btn-list ">
                                          <button type="submit" name="submit"
                                                class="btn bg-gradient-primary  text-white">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                      class="icon icon-tabler icon-tabler-device-floppy" width="24"
                                                      height="24" viewBox="0 0 24 24" stroke-width="1.5"
                                                      stroke="currentColor" fill="none" stroke-linecap="round"
                                                      stroke-linejoin="round">
                                                      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                      <path
                                                            d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" />
                                                      <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                                      <path d="M14 4l0 4l-6 0l0 -4" />
                                                </svg>
                                                Submit
                                          </button>
                                    </div>
                              </div>

                        </div>
                  </div>
                  <!-- row -->
            </form>
      </div>
      <!--- content wrapper---->
</div>
<!-- main-panel -->


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script>
$(document).ready(function() {
      $("#show_hide_password a").on('click', function(event) {
            event.preventDefault();
            if ($('#show_hide_password input').attr("type") == "text") {
                  $('#show_hide_password input').attr('type', 'password');
                  $('#show_hide_password i').addClass("fa-eye-slash");
                  $('#show_hide_password i').removeClass("fa-eye");
            } else if ($('#show_hide_password input').attr("type") == "password") {
                  $('#show_hide_password input').attr('type', 'text');
                  $('#show_hide_password i').removeClass("fa-eye-slash");
                  $('#show_hide_password i').addClass("fa-eye");
            }
      });
});
</script>
<script type="text/javascript">
function validate_password() {

      let pass = document.getElementById('password').value;
      let confirm_pass = document.getElementById('confirm_pass').value;
      if (confirm_pass != pass) {
            document.getElementById('wrong_pass_alert').style.color = 'red';
            document.getElementById('password_not_match').style.color = 'red';
            document.getElementById('confirm_pass').style.border = '1px solid red';
            document.getElementById('wrong_pass_alert').innerHTML =
                  '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-x" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 6l-12 12" /><path d="M6 6l12 12" /></svg>';

            document.getElementById('password_not_match').innerHTML = 'password do not match';
      } else if (confirm_pass = pass) {
            document.getElementById('wrong_pass_alert').style.color = 'green';
            document.getElementById('confirm_pass').style.border = '1px solid green';
            document.getElementById('wrong_pass_alert').innerHTML =
                  '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>';
                  document.getElementById('password_not_match').innerHTML = '';
      } else {
            document.getElementById('wrong_pass_alert').innerHTML = ' ';
      }
}

function check_password() {
      let pass = document.getElementById('password').value;
      let confirm_pass = document.getElementById('confirm_pass').value;

      if (pass.length < 8) {
            document.getElementById('check_password').style.color = 'red';
            document.getElementById('check_password').innerHTML = '☒ password  must be atleast 8 ';

      } else {
            document.getElementById('check_password').innerHTML = ' ';
      }
}
</script>
@endsection