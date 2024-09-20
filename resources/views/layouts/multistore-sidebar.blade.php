<!-- partial -->
<div class="container-fluid page-body-wrapper">
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <ul class="nav">
                  @auth
                  <!-- parent vendor sidebar-->
                  @if(Auth::user()->role_id == '9')

                  <li class="nav-item">
                        <a class="nav-link" href="{{ url('/', [auth()->user()->username, 'dashboard'] ) }}">
                              <span class="menu-title">Dashboard</span>
                              <i class="mdi mdi-home menu-icon"></i>
                        </a>
                  </li>

                  <li class="nav-item">
                        <a class="nav-link" href="{{ url(auth()->user()->username, 'outlets') }}" target="">
                              <span class="menu-title">Outlet (s)</span>
                              <i class="mdi mdi-account-multiple  menu-icon fs-24"></i>

                        </a>
                  </li>

                

                  <li class="nav-item">
                        <a class="nav-link" href="{{ url('') }}" target="">
                              <span class="menu-title">Supplies</span>
                              <i class="fa fa-chain  menu-icon fs-24"></i>

                        </a>
                  </li>

                  @endif
                  <!---end parent manager --->
                  @endauth
            </ul>

      </nav>