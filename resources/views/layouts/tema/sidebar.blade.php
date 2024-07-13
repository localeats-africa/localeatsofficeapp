<aside class="main-sidebar bg-brown">
      <!-- sidebar-->
      <section class="sidebar position-relative">
            <div class="multinav">
                  <div class="multinav-scroll" style="height: 100%;">
                        <!-- sidebar menu-->
                        <ul class="sidebar-menu" data-widget="tree">
                              @auth
                              <!-- Admin sidebar menu-->
                              @if(Auth::user()->role_id == '2')
                              <li class="active"><a href="{{ route('admin') }}"><i
                                                class="mdi mdi-view-dashboard fs-24"></i><span>Dashboard</span></a>
                              </li>
                              <li class=""><a href="platforms"><i
                                                class="mdi mdi-cloud-braces fs-24"></i><span>Platforms</span></a>
                              </li>
                              <li class="">
                                    <a href="invoice"><i
                                                class="mdi mdi-invoice-text-multiple fs-24"></i><span>Invoice</span></a>
                              </li>
                            
                              <li class="">
                                    
                                    <a class="dropdown-toggle " data-bs-boundary="viewport" data-bs-toggle="dropdown">
                                          <i class="mdi mdi-pot-steam fs-24"></i>
                                          <span>Vendors</span></a>
                                    <div class="dropdown-menu">
                                          <a class="dropdown-item text-capitalize text-dark" href="">
                                                Dasboard
                                          </a>
                                          <a class="dropdown-item text-capitalize text-dark" href="">
                                                Food Menu
                                          </a>
                                          <div class="dropdown-divider"></div>
                                          <a class="dropdown-item text-capitalize text-dark" href="">
                                                Profile
                                          </a>
                                    </div>


                              </li>
                              <li class=""><a href="reports"><i
                                                class="mdi mdi-chart-timeline-variant-shimmer fs-24"></i><span>Reports</span></a>
                              </li>

                              <li class=""><a href="#"><i class="mdi mdi-cog-outline fs-24"></i><span>Setup</span></a>
                              </li>
                              @endif
                              <!-- Vendor sidebar menu-->
                              @if(Auth::user()->role_id == '6')
                              <li class="active"><a href="{{ route('vendor_manager') }}"><i
                                                class="mdi mdi-view-dashboard fs-24"></i><span>Dashboard</span></a>
                              </li>

                              <li class=""><a href="vendors"><i
                                                class="mdi mdi-pot-steam fs-24"></i><span>Vendors</span></a>
                              </li>
                              </li>
                              @endif
                              @endauth


                              <li class="logout">
                                    <a href="{{ route('logout') }}" class="waves-effect full-screen waves-light logout"
                                          onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                          <i class="mdi mdi-power fs-24"></i> <span>Logout</span>
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                          @csrf
                                    </form>
                              </li>
                        </ul>

                        <div class="sidebar-widgets d-flex align-items-start">
                              <div class="copyright text-center m-25 text-white-50">
                                    <p><strong class="d-block">LocalEats Africa</strong> © <script>
                                          document.write(new Date().getFullYear())
                                          </script> All Rights Reserved</p>
                                    <!-- <p><strong class="text-info">Ver. 1.05.23</strong></p> -->
                              </div>
                        </div>
                  </div>
            </div>
      </section>
</aside>