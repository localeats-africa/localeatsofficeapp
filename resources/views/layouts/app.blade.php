<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <meta http-equiv=“refresh” content="{{config('session.lifetime') * 60}}">
      <!-- CSRF Token -->
      <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>LocalEats :: Login</title>
       <!-- favicon -->
       <link rel="shortcut icon" href="{{ asset('dist/images/favicon.png') }}" />
    <!-- CSS files -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link href="{{ asset('dist/css/tabler.css') }}" rel="stylesheet"/>
    <link href="{{ asset('dist/css/tabler-flags.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('dist/css/tabler-payments.css') }}" rel="stylesheet"/>
    <link href="{{ asset('dist/css/tabler-vendors.css') }}" rel="stylesheet"/>
    <link href="{{ asset('dist/css/demo.css') }}" rel="stylesheet"/>
    <style>
      @import url('https://rsms.me/inter/inter.css');
      :root {
      	--tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
      }
      body {
      	font-feature-settings: "cv03", "cv04", "cv11";
      }
    </style>
  </head>
  <body  class=" d-flex flex-column">
    <script src="/dist/js/demo-theme.min.js"></script>
      @yield('content')
      <!-- Vendor JS -->
      <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
      <script src="{{ asset('dist/js/tabler.min.js') }}" defer></script>
    <script src="{{ asset('dist/js/demo.min.js') }}" defer></script>



    <script>
      $(document).ready(function() {
    $("#show_hide_password a").on('click', function(event) {
        event.preventDefault();
        if($('#show_hide_password input').attr("type") == "text"){
            $('#show_hide_password input').attr('type', 'password');
            $('#show_hide_password i').addClass( "fa-eye-slash" );
            $('#show_hide_password i').removeClass( "fa-eye" );
        }else if($('#show_hide_password input').attr("type") == "password"){
            $('#show_hide_password input').attr('type', 'text');
            $('#show_hide_password i').removeClass( "fa-eye-slash" );
            $('#show_hide_password i').addClass( "fa-eye" );
        }
    });
});
</script>
  </body>
</html>