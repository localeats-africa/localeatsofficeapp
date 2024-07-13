
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
            <nav class="sidebar sidebar-offcanvas" id="sidebar">
                  <ul class="nav">
                        @auth 
                        <!-- admin sidebar-->
                        @if(Auth::user()->role_id == '2')
                    
                        <li class="nav-item">
                              <a class="nav-link" href="{{ url('admin') }}">
                                    <span class="menu-title">Dashboard</span>
                                    <i class="mdi mdi-home menu-icon"></i>
                              </a>
                        </li>
                    
                        <li class="nav-item">
                              <a class="nav-link" data-bs-toggle="collapse" href="#platform" aria-expanded="false"
                                    aria-controls="platform">
                                    <span class="menu-title">Platforms</span>
                                    <i class="menu-arrow"></i>
                                    <i class="mdi mdi-cloud-braces fs-24 menu-icon"></i>
                                   
                              </a>
                              <div class="collapse" id="platform">
                                    <ul class="nav flex-column sub-menu">
                                          <li class="nav-item">
                                                <a class="nav-link" href="{{ url('new-platform')}}">Add New </a>
                                          </li>
                                     
                                          <li class="nav-item">
                                                <a class="nav-link" href="{{ url('all-platform') }}">All Platforms</a>
                                          </li>
                                        
                                    </ul>
                              </div>
                        </li>
                        <li class="nav-item">
                              <a class="nav-link" href="{{ url('setup-vendor') }}" target="">
                                    <span class="menu-title">Setup</span>
                                    <i class="mdi mdi-cog-outline fs-24 menu-icon"></i>
                                 
                              </a>
                        </li>
                        <!-- <li class="nav-item">
                              <a class="nav-link" href="" target="">
                                    <span class="menu-title"></span>
                                    <i class="mdi mdi-invoice-text-multiple fs-24 menu-icon"></i>
                              
                              </a>
                        </li> -->
                        <li class="nav-item">
                              <a class="nav-link" data-bs-toggle="collapse" href="#invoice" aria-expanded="false"
                                    aria-controls="invoice">
                                    <span class="menu-title">Invoice (s)</span>
                                    <i class="menu-arrow"></i>
                                    <i class="mdi mdi-invoice-text-multiple   menu-icon fs-24"></i>
                                   
                              </a>
                              <div class="collapse" id="invoice">
                                    <ul class="nav flex-column sub-menu">
                                          <li class="nav-item">
                                                <a class="nav-link" href="{{ url('create-invoice') }}"> New Invoice </a>
                                          </li>
                                     
                                          <li class="nav-item">
                                                <a class="nav-link" href="{{ url('vendor-merged-invoices') }}">Merged Invoices</a>
                                          </li>

                                          <li class="nav-item">
                                                <a class="nav-link" href="{{ url('all-invoices') }}">Final Invoices</a>
                                          </li>
                                        
                                    </ul>
                              </div>
                        </li>

                        <li class="nav-item">
                              <a class="nav-link" href="" target="">
                                    <span class="menu-title">Order (s)</span>
                                    <i class="mdi mdi-shopping fs-24 menu-icon"></i>
                                 
                              </a>
                        </li>

                        <li class="nav-item">
                              <a class="nav-link" href="" target="">
                                    <span class="menu-title">Reports</span>
                                    <i class="mdi mdi-chart-timeline-variant-shimmer fs-24 menu-icon"></i>
                              </a>
                        </li>
                      


            
                        <li class="nav-item">
                              <a class="nav-link" data-bs-toggle="collapse" href="#food-menu" aria-expanded="false"
                                    aria-controls="food-menu">
                                    <span class="menu-title">Food Menu</span>
                                    <i class="menu-arrow"></i>
                                    <i class="mdi mdi-menu   menu-icon fs-24"></i>
                                   
                              </a>
                              <div class="collapse" id="food-menu">
                                    <ul class="nav flex-column sub-menu">
                                          <li class="nav-item">
                                                <a class="nav-link" href="{{ url('food-menu') }}">Add New </a>
                                          </li>
                                     
                                          <li class="nav-item">
                                                <a class="nav-link" href="{{ url('all-food-menu') }}">All Food Menu</a>
                                          </li>
                                        
                                    </ul>
                              </div>
                        </li>
                  


                        <li class="nav-item">
                              <a class="nav-link" data-bs-toggle="collapse" href="#vendor" aria-expanded="false"
                                    aria-controls="vendor">
                                    <span class="menu-title">Vendor</span>
                                    <i class="menu-arrow"></i>
                                    <i class="mdi mdi-pot-steam   menu-icon fs-24"></i>
                                   
                              </a>
                              <div class="collapse" id="vendor">
                                    <ul class="nav flex-column sub-menu">
                                          <li class="nav-item">
                                                <a class="nav-link" href="{{ url('new-vendor')}}">Add New </a>
                                          </li>
                                     
                                          <li class="nav-item">
                                                <a class="nav-link" href="{{ url('all-vendor')}}">All Vendors</a>
                                          </li>
                                        
                                    </ul>
                              </div>
                        </li>
                  

                        <li class="nav-item">
                              <a class="nav-link" href="{{ url('restaurant')}}" target="">
                                    <span class="menu-title">Restaurant Type</span>
                                    <i class="mdi mdi-store fs-24 menu-icon"></i>
                                 
                              </a>
                        </li>

                        <li class="nav-item">
                              <a class="nav-link" href="{{ url('food-type')}}" target="">
                                    <span class="menu-title">Food Type</span>
                                    <i class="mdi mdi-food fs-24 menu-icon"></i>
                                 
                              </a>
                        </li>

                        

                        <li class="nav-item">
                              <a class="nav-link" href="" target="">
                                    <span class="menu-title">PayOut</span>
                                    <i class="mdi mdi-cash fs-24 menu-icon"></i>
                                 
                              </a>
                        </li>

                        <li class="nav-item">
                              <a class="nav-link" href="" target="">
                                    <span class="menu-title">Commission (s)</span>
                                    <i class="mdi mdi-hand-coin fs-24 menu-icon"></i>
                                 
                              </a>
                        </li>
                        <li class="nav-item">
                              <a class="nav-link" data-bs-toggle="collapse" href="#user" aria-expanded="false"
                                    aria-controls="user">
                                    <span class="menu-title">Staff (s)</span>
                                    <i class="menu-arrow"></i>
                                    <i class="mdi mdi-account-multiple menu-icon fs-24"></i>
                              </a>
                              <div class="collapse" id="user">
                                    <ul class="nav flex-column sub-menu">
                                          <li class="nav-item">
                                                <a class="nav-link" href="{{ url('new-staff')}}">Add New</a>
                                          </li>
                                          <li class="nav-item">
                                                <a class="nav-link" href="{{ url('all-staff')}}">All Staff (s)</a>
                                          </li>
                                     
                                    </ul>
                              </div>
                        </li>


                        <li class="nav-item">
                              <a class="nav-link" href="" target="">
                                    <!-- <span class="menu-title">Role / Level</span>
                                    <i class="mdi mdi-account-key fs-24 menu-icon"></i> -->
                                 
                              </a>
                        </li>

                       
                        @endif
                        <!--- vendor manager sidebar ---->
                        @if(Auth::user()->role_id == '6')
                     
                        <li class="nav-item">
                              <a class="nav-link" href="{{ url('vendormanager')}}">
                                    <span class="menu-title">Dashboard</span>
                                    <i class="mdi mdi-home menu-icon"></i>
                              </a>
                        </li>
                   
                        <li class="nav-item">
                              <a class="nav-link" data-bs-toggle="collapse" href="#vendor" aria-expanded="false"
                                    aria-controls="vendor">
                                    <span class="menu-title">Vendor</span>
                                    <i class="menu-arrow"></i>
                                    <i class="mdi mdi-pot-steam   menu-icon fs-24"></i>
                              </a>
                              <div class="collapse" id="vendor">
                                    <ul class="nav flex-column sub-menu">
                                          <li class="nav-item">
                                                <a class="nav-link" href="{{ url('new-vendor')}}">Add New Vendor</a>
                                          </li>
                                          <li class="nav-item">
                                                <a class="nav-link" href="{{ url('all-vendor')}}">All Vendors</a>
                                          </li>
                                     
                                    </ul>
                              </div>
                        </li>

                    
                        <li class="nav-item">
                              <a class="nav-link" href="{{ url('setup-vendor') }}" target="">
                                    <span class="menu-title">Setup</span>
                                    <i class="mdi mdi-cog-outline fs-24 menu-icon"></i>
                                 
                              </a>
                        </li>

                        <li class="nav-item">
                              <a class="nav-link" data-bs-toggle="collapse" href="#food-menu" aria-expanded="false"
                                    aria-controls="food-menu">
                                    <span class="menu-title">Food Menu</span>
                                    <i class="menu-arrow"></i>
                                    <i class="mdi mdi-menu   menu-icon fs-24"></i>
                                   
                              </a>
                              <div class="collapse" id="food-menu">
                                    <ul class="nav flex-column sub-menu">
                                          <li class="nav-item">
                                                <a class="nav-link" href="{{ url('food-menu')}}">Add New </a>
                                          </li>
                                     
                                          <li class="nav-item">
                                                <a class="nav-link" href="{{ url('all-food-menu')}}">All Food Menu</a>
                                          </li>
                                        
                                    </ul>
                              </div>
                        </li>

                        <li class="nav-item">
                              <a class="nav-link" data-bs-toggle="collapse" href="#invoice" aria-expanded="false"
                                    aria-controls="invoice">
                                    <span class="menu-title">Invoice (s)</span>
                                    <i class="menu-arrow"></i>
                                    <i class="mdi mdi-invoice-text-multiple   menu-icon fs-24"></i>
                                   
                              </a>
                              <div class="collapse" id="invoice">
                                    <ul class="nav flex-column sub-menu">
                                          <li class="nav-item">
                                                <a class="nav-link" href="{{ url('create-invoice') }}"> New Invoice </a>
                                          </li>
                                     
                                          <li class="nav-item">
                                                <a class="nav-link" href="{{ url('vendor-merged-invoices') }}">Merged Invoices</a>
                                          </li>

                                          <li class="nav-item">
                                                <a class="nav-link" href="{{ url('all-invoices') }}">Final Invoices</a>
                                          </li>
                                        
                                    </ul>
                              </div>
                        </li>

                       
                     
                        @endif 
                        @endauth 
                  </ul>
              
            </nav>