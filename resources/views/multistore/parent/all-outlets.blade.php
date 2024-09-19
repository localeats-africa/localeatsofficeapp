@extends('layouts.head')
@extends('layouts.header')
@extends('layouts.multistore-sidebar')
@extends('layouts.footer')
@section('content')
<!-- main-panel -->
<div class="main-panel">
      <div class="content-wrapper">
            <div class="page-header">
                  <h3 class="page-title">
                <span class="text-info"> Outlet (s)
                  </h3>
                
            </div>
            <div class="row ">
                  <div class="col-12">
                        <div class="row row-cards">
                              <div class="col-sm-4  col-12 stretch-card grid-margin">
                                    <div class="card bg-gradient-dark card-img-holder text-white">
                                          <div class="card-body">
                                                <img src="/assets/images/dashboard/circle.svg" class="card-img-absolute"
                                                      alt="circle-image">
                                                <h4 class="font-weight-normal mb-3">Total Outlets
                                                      <i class="mdi mdi-pot-steam  mdi-24px float-end"></i>
                                                </h4>
                                                <h2 class="">{{$countChildVendor->count()}}</h2>
                                          </div>
                                          <hr class="w-100">
                                          <div class="card-body">
                                                <h6 class="card-text">{{$countActiveChildVendor->count()}} active </h6>
                                          </div>
                                    </div>
                              </div>

                        </div>
                  </div>
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

                                    <form action="/outlets" method="GET" role="search">
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

                  @foreach($childVendor as $data)
                  @php
                  $words = explode(" ", $data->store_name, 2 );
                  $initials = null;
                  foreach ($words as $w) {
                  $initials .= $w[0];
                  }
                  @endphp
                  <div class="col-md-6 col-12">
                        <div class="card" style=" border:2px;">
                              <div class="card-body p-4 text-center">
                                    <div class="dropdown  text-muted text-end">
                                          <span class="text-danger" data-bs-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false">
                                                Actions
                                                <i class="fa fa-caret-down"></i>
                                          </span>

                                          <div class="dropdown-menu dropdown-menu-end text-end ">
                                             
                                                <a class="dropdown-item text-capitalize text-dark"
                                                      href="vendor-profile/{{$data->id}}">
                                                      <small>Profile</small>
                                                </a>
                                                <!-- <a class="dropdown-item text-capitalize text-dark"
                                                      href="edit-vendor/{{$data->id}}">
                                                      <small>Edit</small>
                                                </a> -->

                                          </div>
                                    </div>
                                    <span class="avatar avatar-xl mb-3 rounded">{{$initials}}</span>
                                    <h6 class="m-0 mb-1">
                                          {!! Str::limit("$data->store_name", 25, '...') !!}
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
                                   
                                    <a href="vendor-dashboard/{{$data->id}}" class="card-btn "
                                          style="text-decoration:none;" title="Profile">
                                          <small>Dashboard </small> <small class="text-success"> &nbsp;<i
                                                      class="fa fa-dashboard"></i></small>
                                    </a>

                                    <a href="vendor-dashboard/{{$data->id}}" class="card-btn "
                                          style="text-decoration:none;" title="Profile">
                                          <small>Supplies </small> <small class="text-info"> &nbsp;<i
                                                      class="fa fa-list"></i></small>
                                    </a>
                                  
                                    <a href="vendor-profile/{{$data->id}}" class="card-btn "
                                          style="text-decoration:none;" title="Outlets">
                                          <small> Expenses </small> <small class="text-danger"> &nbsp;<i
                                                      class="fa fa-eye" aria-hidden="true"></i></small>
                                    </a>


                                    
                    
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
                                    {{ ($childVendor->currentPage() - 1) * $childVendor->perPage() + 1; }} to
                                    {{ min($childVendor->currentPage()* $childVendor->perPage(), $childVendor->total()) }}
                                    of
                                    {{$childVendor->total()}} entries
                              </p>

                              <ul class="pagination m-0 ms-auto">
                                    @if(isset($childVendor))
                                    @if($childVendor->currentPage() > 1)
                                    <li class="page-item ">
                                          <a class="page-link text-danger" href="{{ $childVendor->previousPageUrl() }}"
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
                                          {{ $childVendor->appends(compact('perPage'))->links()  }}
                                    </li>
                                    @if($childVendor->hasMorePages())
                                    <li class="page-item">
                                          <a class="page-link text-danger" href="{{ $childVendor->nextPageUrl() }}">
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