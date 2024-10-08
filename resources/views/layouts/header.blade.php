 <!-- Navbar -->
 <nav class="navbar default-layout-navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
       <div class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
             <a class="" href=""><img src="{{ asset('assets/images/logo.png') }}" alt="logo" width="70px" /></a>
             <h4 class="brand-logo d-none d-sm-none d-lg-block text-white">LocalEats Africa</h4>

       </div>
       <div class="navbar-menu-wrapper d-flex align-items-stretch">
             <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                   <span class="mdi mdi-menu"></span>
             </button>
             <div class="search-field d-none d-md-block">
                   <form class="d-flex align-items-center h-100" action="#">
                         <div class="input-group">
                               <div class="input-group-prepend bg-transparent">
                                     <i class="input-group-text border-0 mdi mdi-magnify"></i>
                               </div>
                               <input type="text" class="form-control bg-transparent border-0"
                                     placeholder="Search projects">
                         </div>
                   </form>
             </div>
             <ul class="navbar-nav navbar-nav-right">
                   <li class="nav-item nav-profile dropdown d-none d-lg-block">
                         <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown"
                               aria-expanded="false">
                               <div class="nav-profile-img">
                                     <img src="{{ asset('assets/images/faces/user.png') }}" alt="image">
                                     <span class="availability-status online"></span>
                               </div>
                               <div class="nav-profile-text">
                                     <p class="mb-1 text-black text-capitalize">
                                          @if(auth()->user()->username)
                                          {{Auth::user()->username}} 
                                          @else
                                          {{Auth::user()->fullname}} 
                                          @endif 
                                    </p>
                                     <span class="text-secondary text-small"></span>
                               </div>
                         </a>
                         <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                               <a class="dropdown-item" href="#">
                                     <i class="mdi mdi-cached me-2 text-success"></i> Profile </a>
                               <div class="dropdown-divider"></div>
                               <a class="dropdown-item" href="/show-change-password">
                               <i class="mdi mdi-circle-edit-outline me-2 text-danger"></i> Change Password </a>

                         </div>
                   </li>
                   <!---mobile--->

                   <li class="nav-item nav-profile dropdown d-sm-block d-lg-none">
                         <a class="nav-link dropdown-toggle" id="profileDropdown" href="#" data-bs-toggle="dropdown"
                               aria-expanded="false">
                         <span class="text-capitalize text-dark">  
                         @if(auth()->user()->username)
                        {{Auth::user()->username}} 
                        @else
                        {{Auth::user()->fullname}} 
                        @endif 
                        </span>

                         </a>
                         <div class="dropdown-menu navbar-dropdown" aria-labelledby="profileDropdown">
                               <a class="dropdown-item" href="#">
                                     <i class="mdi mdi-cached me-2 text-success"></i> Profile </a>
                                     <a class="dropdown-item" href="/show-change-password">
                               <i class="mdi mdi-circle-edit-outline me-2 text-danger"></i> Change Password </a>

                               <div class="dropdown-divider"></div>
               
                                     <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                <i class="mdi mdi-logout me-2 text-primary"></i> Signout
                              </a>
                              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                              </form>

                         </div>
                   </li>
                   <!---mobile--->

                   <li class="nav-item d-none d-lg-block full-screen-link">
                         <a class="nav-link">
                               <i class="mdi mdi-fullscreen" id="fullscreen-button"></i>
                         </a>
                   </li>
                
                   <li class="nav-item dropdown">
                         <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#"
                               data-bs-toggle="dropdown">
                               <i class="mdi mdi-bell-outline"></i>
                               <span class="count-symbol bg-danger"></span>
                         </a>
                         <div class="dropdown-menu dropdown-menu-end navbar-dropdown preview-list"
                               aria-labelledby="notificationDropdown">
                               <h6 class="p-3 mb-0">Notifications</h6>
                               <div class="dropdown-divider"></div>
                               <a class="dropdown-item preview-item">
                                     <div class="preview-thumbnail">
                                           <div class="preview-icon bg-success">
                                                 <i class="mdi mdi-calendar"></i>
                                           </div>
                                     </div>
                                     <div
                                           class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                                           <h6 class="preview-subject font-weight-normal mb-1">Event today</h6>
                                           <p class="text-gray ellipsis mb-0"> Just a reminder that you have an event
                                                 today </p>
                                     </div>
                               </a>
                               <div class="dropdown-divider"></div>
                               <a class="dropdown-item preview-item">
                                     <div class="preview-thumbnail">
                                           <div class="preview-icon bg-warning">
                                                 <i class="mdi mdi-cog"></i>
                                           </div>
                                     </div>
                                     <div
                                           class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                                           <h6 class="preview-subject font-weight-normal mb-1">Settings</h6>
                                           <p class="text-gray ellipsis mb-0"> Update dashboard </p>
                                     </div>
                               </a>
                               <div class="dropdown-divider"></div>
                               <a class="dropdown-item preview-item">
                                     <div class="preview-thumbnail">
                                           <div class="preview-icon bg-info">
                                                 <i class="mdi mdi-link-variant"></i>
                                           </div>
                                     </div>
                                     <div
                                           class="preview-item-content d-flex align-items-start flex-column justify-content-center">
                                           <h6 class="preview-subject font-weight-normal mb-1">Launch Admin</h6>
                                           <p class="text-gray ellipsis mb-0"> New admin wow! </p>
                                     </div>
                               </a>
                               <div class="dropdown-divider"></div>
                               <h6 class="p-3 mb-0 text-center">See all notifications</h6>
                         </div>
                   </li>
                   <li class="nav-item nav-logout d-none d-lg-block">
                         <a href="{{ route('logout') }}" class="nav-link" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                              <i class="mdi mdi-power"></i>
                              </a>
                              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                              </form>
                   </li>

             </ul>
             <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
                   data-toggle="offcanvas">
                   <span class="mdi mdi-menu"></span>
             </button>
       </div>
 </nav>