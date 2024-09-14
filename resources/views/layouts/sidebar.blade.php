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
                        <a class="nav-link" data-bs-toggle="collapse" href="#setup" aria-expanded="false"
                              aria-controls="setup">
                              <span class="menu-title">Setup </span>
                              <i class="menu-arrow"></i>
                              <i class="mdi mdi-cog-outline fs-24 menu-icon"></i>

                        </a>
                        <div class="collapse" id="setup">
                              <ul class="nav flex-column sub-menu">
                                    <li class="nav-item">
                                          <a class="nav-link" href="{{ url('setup-chowdeck-vendor') }}"> Chowdeck </a>
                                    </li>

                                    <li class="nav-item">
                                          <a class="nav-link" href="{{ url('setup-vendor') }}">Other Platforms
                                          </a>
                                    </li>

                              </ul>
                        </div>
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
                                          <a class="nav-link" href="{{ url('vendor-merged-invoices') }}">Merged
                                                Invoices</a>
                                    </li>

                                    <li class="nav-item">
                                          <a class="nav-link" href="{{ url('all-invoices') }}">Final Invoices</a>
                                    </li>

                                    <li class="nav-item">
                                          <a class="nav-link" href="{{ url('show-deleted-invoice') }}">Deleted
                                                Invoices</a>
                                    </li>

                                    <li class="nav-item">
                                          <a class="nav-link" href="{{ url('show-deleted-rows') }}">Deleted Rows</a>
                                    </li>

                              </ul>
                        </div>
                  </li>

                  <li class="nav-item">
                        <a class="nav-link" href="{{ url('all-orders') }}" target="">
                              <span class="menu-title">Sales (s)</span>
                              <i class="mdi  mdi-24px  menu-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
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
                        <a class="nav-link" href="{{ url('all-food-menu') }}">
                              <span class="menu-title">Food Menu</span>
                              <i class="mdi mdi-menu   menu-icon fs-24"></i>

                        </a>
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
                        <a class="nav-link" href="{{ url('location')}}" target="">
                              <span class="menu-title">Store Locations</span>
                              <i class="mdi mdi-location-enter fs-24 menu-icon"></i>

                        </a>
                  </li>

                  <li class="nav-item">
                        <a class="nav-link" href="{{ url('all-staff')}}" target="">
                              <span class="menu-title">Staff (s)</span>
                              <i class="mdi mdi-account-multiple fs-24 menu-icon"></i>

                        </a>
                  </li>

                  <li class="nav-item">
                        <a class="nav-link" href="{{ url('roles')}}" target="">
                              <span class="menu-title">LocalEats Roles</span>
                              <i class="mdi mdi-account-tag fs-24 menu-icon"></i>

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
                                          <a class="nav-link" href="{{ url('new-vendor')}}">Add New </a>
                                    </li>

                                    <li class="nav-item">
                                          <a class="nav-link" href="{{ url('all-vendor')}}">All Vendors</a>
                                    </li>

                              </ul>
                        </div>
                  </li>

                  <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#food-menu" aria-expanded="false"
                              aria-controls="food-menu">
                              <span class="menu-title">Bookkeeping</span>
                              <i class="menu-arrow"></i>
                              <i class="mdi mdi-menu   menu-icon fs-24"></i>

                        </a>
                        <div class="collapse" id="food-menu">
                              <ul class="nav flex-column sub-menu">

                                    <li class="nav-item">
                                          <a class="nav-link" href="{{ url('expenses-list') }}">
                                                Expenses</a>
                                    </li>

                                    <li class="nav-item">
                                          <a class="nav-link" href="{{ url('vendor-sales-list') }}">Sales</a>
                                    </li>

                                    <li class="nav-item">
                                          <a class="nav-link" href="{{ url('profit-and-loss') }}">Profit & Loss</a>
                                    </li>

                              </ul>
                        </div>
                  </li>

                  <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#role" aria-expanded="false"
                              aria-controls="role">
                              <span class="menu-title">Multi-Vendor </span>
                              <i class="menu-arrow"></i>
                              <i class="mdi mdi-store-cog fs-24 menu-icon"></i>

                        </a>
                        <div class="collapse" id="role">
                              <ul class="nav flex-column sub-menu">
                              <li class="nav-item">
                                          <a class="nav-link" href="{{ url('parent-vendor') }}">Parent Vendors
                                          </a>
                                    </li>

                                    <li class="nav-item">
                                          <a class="nav-link" href="{{ url('multi-vendor-roles') }}">Roles
                                          </a>
                                    </li>

                              </ul>
                        </div>
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
                        <a class="nav-link" data-bs-toggle="collapse" href="#setup" aria-expanded="false"
                              aria-controls="setup">
                              <span class="menu-title">Setup </span>
                              <i class="menu-arrow"></i>
                              <i class="mdi mdi-cog-outline fs-24 menu-icon"></i>

                        </a>
                        <div class="collapse" id="setup">
                              <ul class="nav flex-column sub-menu">
                                    <li class="nav-item">
                                          <a class="nav-link" href="{{ url('setup-chowdeck-vendor') }}"> Chowdeck </a>
                                    </li>

                                    <li class="nav-item">
                                          <a class="nav-link" href="{{ url('setup-vendor') }}">Other Platforms
                                          </a>
                                    </li>

                              </ul>
                        </div>
                  </li>

                  <li class="nav-item">
                        <a class="nav-link" href="{{ url('all-food-menu') }}">
                              <span class="menu-title">Food Menu</span>
                              <i class="mdi mdi-menu   menu-icon fs-24"></i>

                        </a>
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
                                          <a class="nav-link" href="{{ url('vendor-merged-invoices') }}">Merged
                                                Invoices</a>
                                    </li>

                                    <li class="nav-item">
                                          <a class="nav-link" href="{{ url('all-invoices') }}">Final Invoices</a>
                                    </li>

                              </ul>
                        </div>
                  </li>
                  @endif

                  <!--- Cashier sidebar ---->
                  @if(Auth::user()->role_id == '7')
                  <li class="nav-item">
                        <a class="nav-link" href="{{ url('cashier')}}">
                              <span class="menu-title">Dashboard</span>
                              <i class="mdi mdi-home menu-icon"></i>
                        </a>
                  </li>

                  <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#food-menu" aria-expanded="false"
                              aria-controls="food-menu">
                              <span class="menu-title">Bookkeeping</span>
                              <i class="menu-arrow"></i>
                              <i class="mdi mdi-menu   menu-icon fs-24"></i>

                        </a>
                        <div class="collapse" id="food-menu">
                              <ul class="nav flex-column sub-menu">

                                    <li class="nav-item">
                                          <a class="nav-link" href="{{ url('add-expenses') }}">Expenses</a>
                                    </li>

                                    <li class="nav-item">
                                          <a class="nav-link" href="{{ url('offline-sales') }}">Sales</a>
                                    </li>

                              </ul>
                        </div>
                  </li>
                  @endif

                  <!-- -Account Manager -->
                  @if(Auth::user()->role_id == '8')
                  <li class="nav-item">
                        <a class="nav-link" href="{{ url('accountmanager')}}">
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
                        <a class="nav-link" data-bs-toggle="collapse" href="#setup" aria-expanded="false"
                              aria-controls="setup">
                              <span class="menu-title">Setup </span>
                              <i class="menu-arrow"></i>
                              <i class="mdi mdi-cog-outline fs-24 menu-icon"></i>

                        </a>
                        <div class="collapse" id="setup">
                              <ul class="nav flex-column sub-menu">
                                    <li class="nav-item">
                                          <a class="nav-link" href="{{ url('setup-chowdeck-vendor') }}"> Chowdeck </a>
                                    </li>

                                    <li class="nav-item">
                                          <a class="nav-link" href="{{ url('setup-vendor') }}">Other Platforms
                                          </a>
                                    </li>

                              </ul>
                        </div>
                  </li>

                  <li class="nav-item">
                        <a class="nav-link" href="{{ url('all-food-menu') }}">
                              <span class="menu-title">Food Menu</span>
                              <i class="mdi mdi-menu   menu-icon fs-24"></i>
                        </a>
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
                                          <a class="nav-link" href="{{ url('vendor-merged-invoices') }}">Merged
                                                Invoices</a>
                                    </li>

                                    <li class="nav-item">
                                          <a class="nav-link" href="{{ url('all-invoices') }}">Final Invoices</a>
                                    </li>

                              </ul>
                        </div>
                  </li>
                  <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="collapse" href="#food-menu" aria-expanded="false"
                              aria-controls="food-menu">
                              <span class="menu-title">Bookkeeping</span>
                              <i class="menu-arrow"></i>
                              <i class="mdi mdi-menu   menu-icon fs-24"></i>
                        </a>
                        <div class="collapse" id="food-menu">
                              <ul class="nav flex-column sub-menu">

                                    <li class="nav-item">
                                          <a class="nav-link" href="{{ url('add-expenses') }}">Expenses</a>
                                    </li>

                                    <li class="nav-item">
                                          <a class="nav-link" href="{{ url('offline-sales') }}">Sales</a>
                                    </li>

                              </ul>
                        </div>
                  </li>
                  @endif
                  <!---end account manager --->
                  @endauth
            </ul>

      </nav>