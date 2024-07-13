<html lang="en">

<head>
      <meta charset="utf-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <meta name="description" content="">
      <meta name="author" content="">
      <link rel="icon" href="/images/favicon.ico">

      <title>LocalEats - Dashboard</title>
      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Inclusive+Sans:ital@0;1&display=swap" rel="stylesheet">
      <!-- Vendors Style-->
      <link rel="stylesheet" href="/css/vendors_css.css">
      <!-- Node Style --->
      <link rel="stylesheet" href="/node/css/materialdesignicons.css">
      <link rel="stylesheet" href="/node/css/materialdesignicons.css.map">

      <link rel="stylesheet" href="/node/fonts/materialdesignicons.webfont.eot">
      <link rel="stylesheet" href="/node/fonts/materialdesignicons.webfont.ttf">
      <link rel="stylesheet" href="/node/fonts/materialdesignicons.webfont.woff">
      <link rel="stylesheet" href="/node/scripts/verify.js">

      <!-- Style-->
      <link rel="stylesheet" href="/css/style.css">
      <link rel="stylesheet" href="/css/skin_color.css">
      <link rel="stylesheet" href="/css/app.css">
</head>

<body class="hold-transition light-skin sidebar-mini theme-primary fixed" rel='dashboard'>
      <div class="wrapper">
            <!-- <div id="loader"></div> -->
            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper">
                  <div class="container-full">
                        <!-- Main content -->
                        @yield('content')
                  </div>
            </div>
            <!-- /.content-wrapper -->

      </div>
      <!-- ./wrapper -->
      <!-- Page Content overlay -->
      <footer class="main-footer">
            &copy; <script>
            document.write(new Date().getFullYear())
            </script> <a href="">LocalEats Africa</a>. All Rights Reserved.
      </footer>
      <!-- Vendor JS -->
      <script src="/js/vendors.min.js"></script>
      <script src="/assets/icons/feather-icons/feather.min.js"></script>
      <script src="/assets/vendor_components/apexcharts-bundle/dist/apexcharts.js"></script>
      <script src="/assets/vendor_components/progressbar.js-master/dist/progressbar.js"></script>
      <script src="https://kit.fontawesome.com/59f7d59eaa.js" crossorigin="anonymous"></script>
      <script src="/assets/vendor_components/jquery.peity/jquery.peity.js"></script>
      <script src="/assets/vendor_components/jquery-toast-plugin-master/src/jquery.toast.js"></script>
      <script src="/assets/vendor_components/moment/min/moment.min.js"></script>
      <script src="/js/template.js"></script>
      <script src="/js/dashboard.js"></script>
      <!-- <script src="js/pages/app-ticket.js"></script> -->
      <!-- <script src="/js/applify.js"></script> -->
</body>

</html>