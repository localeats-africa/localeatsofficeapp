<!DOCTYPE html>
<html lang="en">


<head>
  <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/images/favicon.ico">

    <title>LocalEats - Login </title>
  
	<!-- Vendors Style-->
	<link rel="stylesheet" href="/css/vendors_css.css">
	  
	<!-- Style-->    
	<link rel="stylesheet" href="/css/style.css">
	<link rel="stylesheet" href="/css/skin_color.css">	
	<link rel="stylesheet" href="/css/app.css">	

</head>

<body class="hold-transition theme-primary bg-body" rel="login">
	<!-- <div id="particles-js" class="h-p100"></div> -->
	<div class="container h-p100">
		<div class="row d-flex align-items-center justify-content-md-center h-p100">
			<div class="col-12">
				<div class="row justify-content-center g-0">
					<div class="col-lg-4 col-md-4 col-12">
						<div class="rounded10 shadow-lg bg-brown">
							<div class="content-top-agile p-20 pb-0">
								<img src="../images/logo.png" width="100px" alt="logo">
								<h2 class="mb-1 pt-0 fs-20 text-light fw-bold">Staff Login</h2>						
							</div>
							<div class="px-40 py-20">
								<div class="alert text-center py-5 fs-14 text-dark log-err fw-600 d-none"></div> 	
								<form class="log">
									<div class="form-group">
										<div class="input-group mb-3">
											<span class="input-group-text"><i class="ti-user text-danger fs-14"></i></span>
											<input type="email" class="form-control ps-15 fs-14 bg-light" name="email" placeholder="Email">
										</div>
									</div>
									<div class="form-group">
										<div class="input-group mb-3">
											<span class="input-group-text"><i class="ti-lock text-danger fs-14"></i></span>
											<input type="password" class="form-control ps-15 fs-14 bg-light" name="password" placeholder="Password">
										</div>
									</div>
									  <div class="row">
										<div class="col-6">
										  <div class="checkbox">
											<input type="checkbox" name="rem" id="rem">
											<label for="rem" class="text-light">Remember Me</label>
										  </div>
										</div>
										<!-- /.col -->
										<div class="col-6">
										 <div class="fog-pwd text-end">
											<a href="" class="hover-warning text-light"><i class="ti ti-lock text-danger fs-14"></i> Forgot pwd?</a><br>
										  </div>
										</div>
										<!-- /.col -->
										<div class="col-12 text-center">
										  <button type="button" class="btn btn-danger logb text-white mt-10">Login</button>
										</div>
										<!-- /.col -->
									  </div>
								</form>	
								<div class="text-center">
									<p class="mt-15 mb-0 text-light">Don't have an account? <a href="register" class="text-danger fw-700 ms-5">Register</a></p>
									<p class="lt mt-20 mb-0 fs-12 font-ibm text-secondary fw-bold"></p>
								</div>	
							</div>						
						</div>
					</div>
				</div>
			</div>		
		</div>
	</div>

	<!-- Vendor JS -->
	<script src="/js/vendors.min.js"></script>
    <script src="/assets/icons/feather-icons/feather.min.js"></script>	
	<script src="https://kit.fontawesome.com/59f7d59eaa.js" crossorigin="anonymous"></script>
	<script src="/assets/vendor_components/jquery-toast-plugin-master/src/jquery.toast.js"></script>
	<script src="/assets/vendor_components/moment/min/moment.min.js"></script>
	<script src="/js/particles.js"></script>
	<script src="/js/applify.js"></script>
</body>


</html>