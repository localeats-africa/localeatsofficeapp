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
                        <span class="text-info">{{$vendorName}}</span> >>>> Bookkeeping
                  </h3>
            </div>

            <div class="row ">
                  <div class="col-12">
                        <div class="row row-cards">

                        <div class="col-md-3 stretch-card grid-margin">
                                          <div class="card bg-gradient-info card-img-holder text-white">
                                                <div class="card-body">
                                                      <img src="{{ asset('assets/images/dashboard/circle.svg')}}"
                                                            class="card-img-absolute" alt="circle-image">
                                                      <h4 class="font-weight-normal">Today's Sales <i
                                                                  class="mdi mdi-24px float-end">
                                                                  <svg xmlns="http://www.w3.org/2000/svg" class="icon"
                                                                        width="24" height="24" viewBox="0 0 24 24"
                                                                        stroke-width="2" stroke="currentColor"
                                                                        fill="none" stroke-linecap="round"
                                                                        stroke-linejoin="round">
                                                                        <path stroke="none" d="M0 0h24v24H0z"
                                                                              fill="none"></path>
                                                                        <path
                                                                              d="M9 14c0 1.657 2.686 3 6 3s6 -1.343 6 -3s-2.686 -3 -6 -3s-6 1.343 -6 3z">
                                                                        </path>
                                                                        <path
                                                                              d="M9 14v4c0 1.656 2.686 3 6 3s6 -1.344 6 -3v-4">
                                                                        </path>
                                                                        <path
                                                                              d="M3 6c0 1.072 1.144 2.062 3 2.598s4.144 .536 6 0c1.856 -.536 3 -1.526 3 -2.598c0 -1.072 -1.144 -2.062 -3 -2.598s-4.144 -.536 -6 0c-1.856 .536 -3 1.526 -3 2.598z">
                                                                        </path>
                                                                        <path d="M3 6v10c0 .888 .772 1.45 2 2"></path>
                                                                        <path d="M3 11c0 .888 .772 1.45 2 2"></path>
                                                                  </svg>
                                                            </i>
                                                      </h4>
                                                      <h2 class="mb-5">₦0</h2>
                                                      <hr class="w-100">
                                                      <h6 class="card-text">weekly average <span style="float:right;">₦0
                                                            </span></h6>
                                                </div>
                                          </div>
                                    </div>
                              <div class="col-md-3 stretch-card grid-margin">
                                    <div class="card bg-gradient-danger card-img-holder text-white">
                                          <div class="card-body">
                                                <img src="{{ asset('assets/images/dashboard/circle.svg') }}"
                                                      class="card-img-absolute" alt="circle-image">
                                                <h4 class="font-weight-normal">Number Of Sales Today <i
                                                            class="fa fa-cutlery  mdi-24px float-end"></i>
                                                </h4>
                                                <h2 class="mb-5">0</h2>
                                                <hr class="w-100">
                                                <h6 class="card-text">weekly average<span class="text-dark"></span>
                                                      <span style="float:right;">0</span>

                                                </h6>
                                          </div>

                                    </div>
                              </div>





                        </div><!---row--->
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
                        @if(session('new-password'))
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
                                    <div> {!! session('new-password') !!}</div>
                              </div>
                              <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                        </div>
                        @endif

                  </div>
            </div>

            <!---end Alert --->
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