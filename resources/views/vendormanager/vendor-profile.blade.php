@extends('layouts.head')
@extends('layouts.header')
@extends('layouts.sidebar')
@extends('layouts.footer')
@section('content')
<!-- main-panel -->
<div class="main-panel">
      <div class="content-wrapper">

            <div class="page-header">
                  <h3 class="page-title">Vendor Profile</h3>
                  @auth
                  @if(Auth::user()->role_id =='2')

                  @if($status == 'pending')
                  <!---only  admin view this-->
                  <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                              <li class="breadcrumb-item active" aria-current="page">
                              
                                    <form action="{{ route('approve-vendor', [$vendorID] )}}" method="post">
                                          @csrf
                                          <div class="alert  alert-danger alert-dismissible" role="alert">
                                                <div class="d-flex">
                                                      <div>
                                                            <!-- Download SVG icon from http://tabler-icons.io/i/alert-triangle -->
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                  class="icon alert-icon" width="24" height="24"
                                                                  viewBox="0 0 24 24" stroke-width="2"
                                                                  stroke="currentColor" fill="none"
                                                                  stroke-linecap="round" stroke-linejoin="round">
                                                                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                  <path
                                                                        d="M10.24 3.957l-8.422 14.06a1.989 1.989 0 0 0 1.7 2.983h16.845a1.989 1.989 0 0 0 1.7 -2.983l-8.423 -14.06a1.989 1.989 0 0 0 -3.4 0z" />
                                                                  <path d="M12 9v4" />
                                                                  <path d="M12 17h.01" />
                                                            </svg>
                                                      </div>
                                                      <div> Sure you want to approve {{$vendorName}} &nbsp;

                                                            <input type="submit" class=" btn btn-sm bg-success "
                                                                  value="Approve Now">
                                                      </div>

                                                </div>
                                                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                                          </div>


                                    </form>
                              </li>
                        </ul>
                  </nav>
                  @elseif($status == 'approve')
                  @elseif($status == 'suspended')
                  @else
                  @endif

                  @endif
                  @endauth
            </div>
            <!---Alert --->

            <div class="row">
                  <div class="col-lg-12">

                        @if(session('update-error'))
                        <div class="alert  alert-danger alert-dismissible" role="alert">
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
            <!---end---alert--->

            <div class="row">
                  <div class="container">
                        <div class="main-body">
                              <div class="row">
                                    <div class="col-lg-5">
                                          <div class="card">
                                                <div class="card-body">
                                                      <div class="d-flex flex-column align-items-center text-center">
                                                            <img src="{{ asset('assets/images/faces/user.png')}}" alt="Admin"
                                                                  class="rounded-circle p-1 bg-dark" width="110">
                                                            <div class="mt-3">
                                                                  <h4>{{$vendorName}}</h4>
                                                                  <p class="text-secondary mb-1"> </p>
                                                                  <p class="text-muted font-size-sm">
                                                                        @php
                                                                        $a = str_replace( array('[',']') , '' ,
                                                                        $vendorFoodType );
                                                                        $b = preg_replace('/"/i', ' ', $a);
                                                                        @endphp </p>
                                                                  <button
                                                                        class="btn bg-gradient-primary text-white">{{$vendorStoreType}}</button>
                                                                  <p></p>
                                                                  <small class="text-danger mb-1">{{$b}}</small>
                                                            </div>
                                                      </div>
                                                      <hr class="my-4">

                                                      <ul class="list-group list-group-flush">
                                                            <li
                                                                  class="list-group-item d-flex justify-content-between align-items-center flex-wrap">
                                                                  <h6 class="mb-0"> <i class="fa fa-globe"></i>
                                                                        Reference</h6>
                                                                  <span class="text-secondary">{{$vendorRef}}</span>
                                                            </li>
                                                      </ul>
                                                      <div class="table-responsive">
                                                            <table class="table">
                                                                  <thead>
                                                                        <tr>
                                                                              <th></th>
                                                                              <th></th>
                                                                              <th></th>
                                                                              <th></th>
                                                                        </tr>
                                                                  </thead>
                                                                  <tbody>
                                                                        @foreach($vendorPlatforms as $platform)
                                                                        <tr>
                                                                              <td style="">
                                                                                    <!--- platform logo/icon --->
                                                                                    @if(empty($platform->img_url) )
                                                                                    <h6 class="mb-0 col-"
                                                                                          style="color:#0C513F;">
                                                                                          <i class="mdi mdi-alpha-c-circle text-chow fs-1"
                                                                                                width="24"
                                                                                                height="24"></i>
                                                                                    </h6>
                                                                                    @else
                                                                                    <span class="py-1">
                                                                                          <img src="{{ asset($platform->img_url) }}"
                                                                                                class="rounded-circle"
                                                                                                alt="" width="24"
                                                                                                height="24">
                                                                                    </span>

                                                                                    @endif
                                                                              </td>
                                                                              <td>
                                                                                    <!--- platform --name --->
                                                                                    <small>{{$platform->platform_name}}</small>
                                                                              </td>
                                                                              <td>

                                                                                    <!--- platform status --->
                                                                                    @if($platform->vendor_status ==
                                                                                    'inactive')
                                                                                    <span
                                                                                          class="badge badge-pill badge-warning text-dark">{{$platform->vendor_status}}</span>
                                                                                    @elseif($platform->vendor_status ==
                                                                                    'active')
                                                                                    <span
                                                                                          class="badge badge-pill badge-success text-dark">{{$platform->vendor_status}}</span>
                                                                                    @else
                                                                                    <span
                                                                                          class="text-secondary">{{$platform->vendor_status}}</span>
                                                                                    @endif
                                                                              </td>
                                                                              <td>
                                                                                    <!--- platform ref --->
                                                                                    @if(empty($platform->platform_ref))
                                                                                    nill
                                                                                    @else

                                                                                    <input type="hidden" class="text-secondary form-control" value="{{$platform->id}}">
                                                                                  
                                                                                  <div class="input-group">
                                                                                  <input type="text" class="text-secondary form-control" value="{{$platform->platform_ref}}">
                                                                                    <button class="text-success"><i class="fa fa-check"></i></button>
                                                                                  </div>
                                                                                    @endif
                                                                              </td>

                                                                        </tr>
                                                                        @endforeach
                                                                  </tbody>
                                                            </table>

                                                      </div>

                                                      
                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-lg-7">
                                          <div class="card">
                                                <div class="card-body">
                                                      <div class="row mb-3">
                                                            <p></p>
                                                            <div class="col-sm-4">
                                                                  <h6 class="mb-0">Contact Person</h6>
                                                            </div>
                                                            <div class="col-sm-8 text-secondary">

                                                                  <span class="form-control text-capitalize">{{$vendorFname}}
                                                                        {{$vendorLname}}</span>
                                                            </div>
                                                      </div>
                                                      <div class="row mb-3">
                                                            <div class="col-sm-4">
                                                                  <h6 class="mb-0">Email</h6>
                                                            </div>
                                                            <div class="col-sm-8 text-secondary">
                                                                  <span class="form-control text-lowwercase">
                                                                        @if(empty($vendorEmail))
                                                                        Nill
                                                                        @else
                                                                        {{$vendorEmail}}
                                                                        @endif
                                                                  </span>
                                                            </div>
                                                      </div>

                                                      <div class="row mb-3">
                                                            <div class="col-sm-4">
                                                                  <h6 class="mb-0">Mobile</h6>
                                                            </div>
                                                            <div class="col-sm-8 text-secondary">
                                                                  <span class="form-control">{{$vendorPhone}}</span>
                                                            </div>
                                                      </div>
                                                      <div class="row mb-3">
                                                            <div class="col-sm-4">
                                                                  <h6 class="mb-0">Store Address</h6>
                                                            </div>
                                                            <div class="col-sm-8 text-secondary">
                                                                  <span
                                                                        class="form-control text-capitalize">{{$vendorAddress}}</span>
                                                            </div>
                                                      </div>

                                                      <div class="row mb-3">
                                                            <div class="col-sm-4">
                                                                  <h6 class="mb-0">State</h6>
                                                            </div>
                                                            <div class="col-sm-8 text-secondary">
                                                                  <span
                                                                        class="form-control text-capitalize">{{$vendorState}}</span>
                                                            </div>
                                                      </div>


                                                      <div class="row mb-3">
                                                            <div class="col-sm-4">
                                                                  <h6 class="mb-0">Country</h6>
                                                            </div>
                                                            <div class="col-sm-8 text-secondary">
                                                                  <span
                                                                        class="form-control text-capitalize">{{$vendorCountry}}</span>
                                                            </div>
                                                      </div>


                                                      <div class="row mb-3">
                                                            <div class="col-sm-4">
                                                                  <h6 class="mb-0">Store location (s)</h6>
                                                            </div>
                                                            <div class="col-sm-8 text-secondary">
                                                                  <span
                                                                        class="form-control text-capitalize">{{$vendorNumberOfLocation}}</span>
                                                            </div>
                                                      </div>


                                                      <div class="row mb-3">
                                                            <div class="col-sm-4">
                                                                  <h6 class="mb-0">Delivery Time</h6>
                                                            </div>
                                                            <div class="col-sm-8 text-secondary">
                                                                  <span class="form-control text-capitalize">{{$vendorDeliveryTime}}
                                                                        min.</span>
                                                            </div>
                                                      </div>




                                                </div>
                                          </div>
                                          <div class="row">
                                                <div class="col-sm-12">
                                                      <div class="card">
                                                            <div class="card-body">
                                                                  <h5 class="d-flex align-items-center mb-3"></h5>
                                                                  <div class="row mb-3">
                                                                        <div class="col-sm-4">
                                                                              <h6 class="mb-0">Bank Name</h6>
                                                                        </div>
                                                                        <div class="col-sm-8 text-secondary">
                                                                              <span
                                                                                    class="form-control text-capitalize">{{$vendorBank}}</span>
                                                                        </div>
                                                                  </div>

                                                                  <div class="row mb-3">
                                                                        <div class="col-sm-4">
                                                                              <h6 class="mb-0">Account Name</h6>
                                                                        </div>
                                                                        <div class="col-sm-8 text-secondary">
                                                                              <span
                                                                                    class="form-control text-capitalize">{{$vendorAccountName}}</span>
                                                                        </div>
                                                                  </div>

                                                                  <div class="row mb-3">
                                                                        <div class="col-sm-4">
                                                                              <h6 class="mb-0">Account Number</h6>
                                                                        </div>
                                                                        <div class="col-sm-8 text-secondary">
                                                                              <span
                                                                                    class="form-control text-capitalize">{{$vendorAccountNumber}}</span>
                                                                        </div>
                                                                  </div>




                                                            </div>
                                                      </div>
                                                </div>
                                          </div>
                                    </div>
                              </div>
                        </div>
                  </div>
            </div>
      </div><!-- content-panel -->
      <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
                  <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright ©
                        LocalEats Africa {{ date('Y')}} </a>. All rights
                        reserved.</span>
                  <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"><i
                              class="mdi mdi-heart text-danger"></i></span>
            </div>
      </footer>
</div><!-- main-panel -->
<script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jquery-editable/js/jquery-editable-poshytip.min.js"></script>
<script type="text/javascript">
    $.fn.editable.defaults.mode = 'inline';
  
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{csrf_token()}}'
        }
    }); 
  
    $('.update').editable({
           url: "{{ route('vendor-platform-ref') }}",
           type: 'text',
           pk: 1,
           name: 'name'
    });
</script>
@endsection