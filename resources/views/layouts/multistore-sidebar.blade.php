<!-- partial -->
<div class="container-fluid page-body-wrapper">
      <nav class="sidebar sidebar-offcanvas" id="sidebar">
            <ul class="nav">
                  @auth
                  <!-- admin sidebar-->
                  @if(Auth::user()->role_id == '9')

                  <li class="nav-item">
                        <a class="nav-link" href="{{ url('parent_vendor') }}">
                              <span class="menu-title">Dashboard</span>
                              <i class="mdi mdi-home menu-icon"></i>
                        </a>
                  </li>

                  @endif
                  <!---end account manager --->
                  @endauth
            </ul>

      </nav>