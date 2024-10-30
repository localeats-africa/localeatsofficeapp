<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <meta http-equiv=“refresh” content="{{config('session.lifetime') * 60}}">
      <!-- CSRF Token -->
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <title>LocalEats</title>
      <!-- favicon -->
      <link rel="shortcut icon" href="{{ asset('assets/images/favicon.png')}}" />
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
      <!----tinymyn ---
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>

      <!-- plugins:css -->
      <link rel="stylesheet" href="{{ asset('assets/vendors/mdi/css/materialdesignicons.min.css?v=echo filemtime();') }}">
      <link rel="stylesheet" href="{{ asset('assets/vendors/ti-icons/css/themify-icons.css?v=echo filemtime();') }}">
      <link rel="stylesheet" href="{{ asset('assets/vendors/css/vendor.bundle.base.css?v=echo filemtime();') }}">
      <link rel="stylesheet" href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css?v=echo filemtime();') }}">
      <!-- endinject -->
      <!-- Plugin css for this page -->
      <link rel="stylesheet" href="{{ asset('assets/vendors/font-awesome/css/font-awesome.min.css?v=echo filemtime();') }}" />
      <link rel="stylesheet" href="{{ asset('assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.css?v=echo filemtime();') }}">

      <!-- Plugin css for this page -->
      <link rel="stylesheet" href="{{ asset('assets/vendors/select2/select2.css?v=echo filemtime();') }}">
      <link rel="stylesheet" href="{{ asset('assets/vendors/select2-bootstrap-theme/select2-bootstrap.min.css?v=echo filemtime();') }}">
      <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}">
      <link rel="stylesheet" href="{{ asset('assets/css/style.css?v=echo filemtime();') }}">

</head>

<body>
      
      @yield('content')
 
</body>

</html>