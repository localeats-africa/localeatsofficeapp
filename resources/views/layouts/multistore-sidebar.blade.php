<!-- partial -->
<div class="container-fluid page-body-wrapper">
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <ul class="nav">
                  @auth
                  <!-- parent vendor sidebar-->
                  @if(Auth::user()->role_id == '9')

                  <li class="nav-item">
                        <a class="nav-link" href="{{ url('/', [auth()->user()->username]) }}">
                              <span class="menu-title">Dashboard</span>
                              <i class="mdi mdi-home menu-icon"></i>
                        </a>
                  </li>

                  <li class="nav-item">
                        <a class="nav-link" href="{{ url('') }}" target="">
                              <span class="menu-title">Outlet (s)</span>
                              <i class="mdi mdi-account-multiple  menu-icon fs-24"></i>

                        </a>
                  </li>

                  <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#food-menu" aria-expanded="false"
                              aria-controls="food-menu">
                              <span class="menu-title">Bookkeeping</span>
                              <i class="menu-arrow"></i>
                              <i class="mdi mdi-menu menu-icon fs-24"></i>

                        </a>
                        <div  id="food-menu">
                              <ul class="nav flex-column sub-menu">

                                    <li class="nav-item">
                                          <a class="nav-link" href="{{ url('') }}">
                                                Expenses</a>
                                    </li>

                                    <li class="nav-item">
                                          <a class="nav-link" href="{{ url('') }}">Sales</a>
                                    </li>

                                    <li class="nav-item">
                                          <a class="nav-link" href="{{ url('') }}">Profit & Loss</a>
                                    </li>

                              </ul>
                        </div>
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