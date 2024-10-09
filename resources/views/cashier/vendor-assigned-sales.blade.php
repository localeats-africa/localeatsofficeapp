@extends('layouts.head')
@extends('layouts.header')
@extends('layouts.sidebar')
@extends('layouts.footer')
@section('content')
<!-- main-panel -->
<div class="main-panel">
      <div class="content-wrapper">
            <div class="page-header">
                  <h3 class="page-title">
                        Vendors Assigned
                  </h3>
            </div>
         
            <!--row-deck-->
            <p></p>
            <!--Alert here--->
            <div class="row ">
                  <div class="col-12">
                        @if(session('add-vendor'))
                        <div class="alert alert-important alert-success alert-dismissible" role="alert">
                              <div class="d-flex">
                                    <div>
                                          <!-- Download SVG icon from http://tabler-icons.io/i/alert-triangle -->
                                          <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                      d="M10.24 3.957l-8.422 14.06a1.989 1.989 0 0 0 1.7 2.983h16.845a1.989 1.989 0 0 0 1.7 -2.983l-8.423 -14.06a1.989 1.989 0 0 0 -3.4 0z" />
                                                <path d="M12 9v4" />
                                                <path d="M12 17h.01" />
                                          </svg>
                                    </div>
                                    <div> {!! session('add-vendor') !!}</div>
                              </div>
                              <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                        </div>
                        @endif

                        @if(session('update-vendor'))
                        <div class="alert alert-important alert-success alert-dismissible" role="alert">
                              <div class="d-flex">
                                    <div>
                                          <!-- Download SVG icon from http://tabler-icons.io/i/alert-triangle -->
                                          <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                      d="M10.24 3.957l-8.422 14.06a1.989 1.989 0 0 0 1.7 2.983h16.845a1.989 1.989 0 0 0 1.7 -2.983l-8.423 -14.06a1.989 1.989 0 0 0 -3.4 0z" />
                                                <path d="M12 9v4" />
                                                <path d="M12 17h.01" />
                                          </svg>
                                    </div>
                                    <div> {!! session('update-vendor') !!}</div>
                              </div>
                              <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                        </div>
                        @endif


                        @if(session('update-error'))
                        <div class="alert alert-danger alert-dismissible" role="alert">
                              <div class="d-flex">
                                    <div>
                                          <!-- Download SVG icon from http://tabler-icons.io/i/alert-triangle -->
                                          <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                      d="M10.24 3.957l-8.422 14.06a1.989 1.989 0 0 0 1.7 2.983h16.845a1.989 1.989 0 0 0 1.7 -2.983l-8.423 -14.06a1.989 1.989 0 0 0 -3.4 0z" />
                                                <path d="M12 9v4" />
                                                <path d="M12 17h.01" />
                                          </svg>
                                    </div>
                                    <div> {!! session('update-error') !!}</div>
                              </div>
                              <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                        </div>
                        @endif


                        @if(session('setup-vendor'))
                        <div class="alert  alert-success alert-dismissible" role="alert">
                              <div class="d-flex">
                                    <div>
                                          <!-- Download SVG icon from http://tabler-icons.io/i/alert-triangle -->
                                          <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                      d="M10.24 3.957l-8.422 14.06a1.989 1.989 0 0 0 1.7 2.983h16.845a1.989 1.989 0 0 0 1.7 -2.983l-8.423 -14.06a1.989 1.989 0 0 0 -3.4 0z" />
                                                <path d="M12 9v4" />
                                                <path d="M12 17h.01" />
                                          </svg>
                                    </div>
                                    <div> {!! session('setup-vendor') !!}</div>
                              </div>
                              <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                        </div>
                        @endif
                  </div>
            </div>
            <!---end Alert --->

            <p></p>
            <div class="row">
                  <div class="d-flex">
                        <div class="text-secondary">
                              Show
                              <div class="mx-2 d-inline-block">
                                    <select id="pagination" class="form-control form-control-sm" name="perPage">
                                          <option value="5" @if($perPage==5) selected @endif>5
                                          </option>
                                          <option value="10" @if($perPage==10) selected @endif>
                                                10
                                          </option>
                                          <option value="25" @if($perPage==25) selected @endif>
                                                25
                                          </option>
                                          <option value="50" @if($perPage==50) selected @endif>
                                                50
                                          </option>
                                    </select>
                              </div>
                              records
                        </div>
                        <div class="ms-auto text-secondary">
                              Search:
                              <div class="ms-2 d-inline-block">

                                    <form action="/all-vendor" method="GET" role="search">
                                          {{ csrf_field() }}
                                          <div class="input-group mb-2">
                                                <input type="text" class="form-control" placeholder="Search for…"
                                                      name="search">
                                                <button type="submit" class="btn" type="button">Go!</button>
                                          </div>
                                    </form>
                              </div>
                        </div>
                  </div>

                  @foreach($vendor as $data)
                  @php
                  $words = explode(" ", $data->vendor_name, 2 );
                  $initials = null;
                  foreach ($words as $w) {
                  $initials .= $w[0];
                  }
                  @endphp
                  <div class="col-md-6 col-12">
                        <div class="card" style=" border:2px;">
                              <div class="card-body p-4 text-center">
                                 <!--action  button--> 
                                    <span class="avatar avatar-xl mb-3 rounded">{{$initials}}</span>
                                    <h6 class="m-0 mb-1">
                                          {!! Str::limit("$data->vendor_name", 25, '...') !!}
                                    </h6>
                                    <div class="text-dark"> <small>{{$data->store_area}}, {{$data->state}}</small></div>

                                    <p></p>
                                    @if($data->vendor_status =='pending')
                                    <span class="badge badge-pill badge-warning text-dark">
                                          {{$data->vendor_status}} </span>
                                    @elseif($data->vendor_status == 'approved')
                                    <span class="badge badge-pill badge-success text-dark">
                                          {{$data->vendor_status}} </span>
                                    @else
                                    <span class="badge badge-pill badge-secondary text-white">
                                          {{$data->vendor_status}} </span>
                                    @endif


                                    <div class="mt-3">
                                    </div>
                              </div>
                              <div class="d-flex">
                                   
                                    @if($data->vendor_status == 'suspended')
                                    @auth
                                    @if(Auth::user()->role_id =='2')
                                    <a href="vendor-dashboard/{{$data->id}}" class="card-btn "
                                          style="text-decoration:none;" title="Profile">
                                          <small>Dashboard </small> <small class="text-info"> &nbsp;<i
                                                      class="fa fa-dashboard"></i></small>
                                    </a>
                                    @endif
                                    @endauth

                                    @auth
                                    @if(Auth::user()->role_id =='8')
                                    <a href="vendor-dashboard/{{$data->id}}" class="card-btn "
                                          style="text-decoration:none;" title="Profile">
                                          <small>Dashboard </small> <small class="text-info"> &nbsp;<i
                                                      class="fa fa-dashboard"></i></small>
                                    </a>
                                    @endif
                                    @endauth

                                    <a href="upload-past-invoice/{{$data->id}}" class="card-btn "
                                          style="text-decoration:none;" title="Invoice">
                                          <!-- Download SVG icon from http://tabler-icons.io/i/phone -->
                                          <small>Past Invoices </small>
                                    </a>

                                    @else 
                                    @auth
                                    @if(Auth::user()->role_id =='2')
                                    <a href="vendor-dashboard/{{$data->id}}" class="card-btn "
                                          style="text-decoration:none;" title="Profile">
                                          <small>Dashboard </small> <small class="text-info"> &nbsp;<i
                                                      class="fa fa-dashboard"></i></small>
                                    </a>
                                    @endif
                                    @endauth

                                    @auth
                                    @if(Auth::user()->role_id =='8')
                                    <a href="vendor-dashboard/{{$data->id}}" class="card-btn "
                                          style="text-decoration:none;" title="Profile">
                                          <small>Dashboard </small> <small class="text-info"> &nbsp;<i
                                                      class="fa fa-dashboard"></i></small>
                                    </a>
                                    @endif
                                    @endauth

                                    <a href="vendor-food-menu/{{$data->id}}" class="card-btn "
                                          style="text-decoration:none;" title="Profile">
                                          <small>FoodMenu </small> <small class="text-info"> &nbsp;<i
                                                      class="fa fa-cutlery" aria-hidden="true"></i></small>
                                    </a>

                                    <a href="upload-invoice/{{$data->id}}" class="card-btn "
                                          style="text-decoration:none;" title="Invoice">
                                          <!-- Download SVG icon from http://tabler-icons.io/i/phone -->
                                          <small>Create Invoice </small> <small class="text-info"> &nbsp;<i
                                                      class="fa fa-plus"></i></small>
                                    </a>

                                    <a href="upload-past-invoice/{{$data->id}}" class="card-btn "
                                          style="text-decoration:none;" title="Invoice">
                                          <!-- Download SVG icon from http://tabler-icons.io/i/phone -->
                                          <small>Past Invoices </small>
                                    </a>
                                    @endif
                    
                              </div>


                        </div>
                        <!--card  --->
                        <p></p>
                  </div>

                  @endforeach

                  <div class="d-flex">
                        <p></p>
                        <div class="card-footer d-flex align-items-center">

                              <span></span>
                              <p class="m-0 text-secondary">

                                    Showing
                                    {{ ($vendor->currentPage() - 1) * $vendor->perPage() + 1; }} to
                                    {{ min($vendor->currentPage()* $vendor->perPage(), $vendor->total()) }}
                                    of
                                    {{$vendor->total()}} entries
                              </p>

                              <ul class="pagination m-0 ms-auto">
                                    @if(isset($vendor))
                                    @if($vendor->currentPage() > 1)
                                    <li class="page-item ">
                                          <a class="page-link text-danger" href="{{ $vendor->previousPageUrl() }}"
                                                tabindex="-1" aria-disabled="true">
                                                <!-- Download SVG icon from http://tabler-icons.io/i/chevron-left -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                      height="24" viewBox="0 0 24 24" stroke-width="2"
                                                      stroke="currentColor" fill="none" stroke-linecap="round"
                                                      stroke-linejoin="round">
                                                      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                      <path d="M15 6l-6 6l6 6" />
                                                </svg>
                                                prev
                                          </a>
                                    </li>
                                    @endif


                                    <li class="page-item">
                                          {{ $vendor->appends(compact('perPage'))->links()  }}
                                    </li>
                                    @if($vendor->hasMorePages())
                                    <li class="page-item">
                                          <a class="page-link text-danger" href="{{ $vendor->nextPageUrl() }}">
                                                next
                                                <!-- Download SVG icon from http://tabler-icons.io/i/chevron-right -->
                                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24"
                                                      height="24" viewBox="0 0 24 24" stroke-width="2"
                                                      stroke="currentColor" fill="none" stroke-linecap="round"
                                                      stroke-linejoin="round">
                                                      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                      <path d="M9 6l6 6l-6 6" />
                                                </svg>
                                          </a>
                                    </li>
                                    @endif
                                    @endif
                              </ul>
                        </div>
                  </div>

            </div>
            <!--row  --->

            <p></p>


      </div>
      <!--- content-wrapper-->
      <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
                  <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright ©
                        LocalEats Africa {{ date('Y')}} </a>. All rights
                        reserved.</span>
                  <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"><i
                              class="mdi mdi-heart text-danger"></i></span>
            </div>
      </footer>
</div>
@endsection