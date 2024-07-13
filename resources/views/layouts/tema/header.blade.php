<header class="main-header">
      <div class="d-flex align-items-center logo-box justify-content-start bg-brown">
            <!-- Logo -->
            <a href="index" class="logo">
                  <!-- logo-->
                  <div class="logo-mini w-70">
                        <span class="light-logo"><img src="images/logo.png" alt="logo"></span>
                  </div>
                  <div class="logo-lg">
                        <span class="light-logo text-white fw-bold">LocalEats Africa</span>
                  </div>
            </a>
      </div>
      <!-- Header Navbar -->
      <nav class="navbar navbar-static-to glass1 d-noe">
            <!-- Sidebar toggle button-->
            <div class="app-menu">
                  <ul class="header-megamenu nav">
                        <li class="btn-group nav-item">
                              <a href="#" class="waves-effect waves-light nav-link push-btn btn-primary-light text-red"
                                    data-toggle="push-menu" role="button">
                                    <i class="mdi mdi-menu"></i>
                              </a>
                        </li>
                  </ul>
            </div>
            <div class="navbar-custom-menu r-side">
                  <ul class="nav navbar-nav">
                        <li class="btn-group nav-item d-lg-inline-flex d-none">
                              <a href="#" data-provide="fullscreen"
                                    class="waves-effect waves-light nav-link full-screen" title="Full Screen">
                                    <i class="mdi mdi-fullscreen text-red"></i>
                              </a>
                        </li>
                        <li class="btn-group nav-item">

                              <a href="{{ route('logout') }}" class="waves-effect full-screen waves-light logout"
                                    onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    <i class="mdi mdi-power text-red"></i>
                              </a>
                              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                              </form>
                        </li>
                  </ul>
            </div>
      </nav>
</header>