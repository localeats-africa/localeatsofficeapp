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
                        <a class="nav-link" data-bs-toggle="collapse" href="#food-menu" aria-expanded="false"
                              aria-controls="food-menu">
                              <span class="menu-title">Bookkeeping</span>
                              <i class="menu-arrow"></i>
                              <i class="mdi mdi-menu menu-icon fs-24"></i>

                        </a>
                        <div class="collapse" id="food-menu">
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
                              <span class="menu-title">Sales (s)</span>
                              <i class="menu-icon fs-24">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="18" height="18"
                                          viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                          stroke-linecap="round" stroke-linejoin="round">
                                          <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                          <path
                                                d="M9 14c0 1.657 2.686 3 6 3s6 -1.343 6 -3s-2.686 -3 -6 -3s-6 1.343 -6 3z">
                                          </path>
                                          <path d="M9 14v4c0 1.656 2.686 3 6 3s6 -1.344 6 -3v-4">
                                          </path>
                                          <path
                                                d="M3 6c0 1.072 1.144 2.062 3 2.598s4.144 .536 6 0c1.856 -.536 3 -1.526 3 -2.598c0 -1.072 -1.144 -2.062 -3 -2.598s-4.144 -.536 -6 0c-1.856 .536 -3 1.526 -3 2.598z">
                                          </path>
                                          <path d="M3 6v10c0 .888 .772 1.45 2 2"></path>
                                          <path d="M3 11c0 .888 .772 1.45 2 2"></path>
                                    </svg>
                              </i>

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