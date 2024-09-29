@extends('layouts.head')
@extends('layouts.header')
@extends('layouts.multistore-sidebar')
@extends('layouts.footer')
@section('content')
</style>
<!-- main-panel -->
<div class="main-panel">
      <div class="content-wrapper">
            <div class="page-header">
                  <h3 class="page-title">
                      <span class="text-info"> {{$vendorName}}</span> >>> Expenses
                  </h3>
            </div>

  <!--Alert here--->
  <div class="row ">
                  <div class="col-12">
                        @if(session('add-platform'))
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
                                    <div> {!! session('add-platform') !!}</div>
                              </div>
                              <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                        </div>
                        @endif


                        @if(session('platform-status'))
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
                                    <div> {!! session('platform-status') !!}</div>
                              </div>
                              <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                        </div>
                        @endif


                  </div>
            </div>
            <!---end Alert --->

            <div class="row ">

                  <form method="GET" action="/{{$username}}/outlet-expenses/{{$vendor_id}}" name="submit"
                        enctype="multipart/form-data">
                        @csrf
                        {{csrf_field()}}
                        <div class="row">
                              <div class="col-md-6 col-12">
                                    <div class="form-group">
                                          <label for="">From</label>
                                          <div class="input-group date">
                                                <input type="text" value="{{ date('Y-m-d')}}" name="from" class="form-control" placeholder=""
                                                      id="from" />
                                                <span class="input-group-append">
                                                      <span class="input-group-text bg-light d-block">
                                                            <i class="fa fa-calendar"></i>
                                                      </span>
                                                </span>
                                          </div>
                                    </div>
                              </div>

                              <div class="col-md-6 col-12">
                                    <div class="form-group">

                                          <label for="">To</label>
                                          <div class="input-group date">
                                                <input type="text" value="{{ date('Y-m-d')}}" name="to" class="form-control" placeholder=""
                                                      id="to" />
                                                <span class="input-group-append">
                                                      <span class="input-group-text bg-light d-block">
                                                            <i class="fa fa-calendar"></i>
                                                      </span>
                                                </span>
                                                <input type="hidden"   name="vendor_id"  value="{{$vendor_id}}">
                                                <button type="submit" name="submit"
                                                      class="btn bg-gradient-dark btn-sm  text-white">Filter!</button>
                                          </div>
                                    </div>
                              </div>
                        </div>
                        <!---end row--->
                  </form>
            </div>
            <!---end row --->

            

            <div class="row ">
                  <div class="col-12">
                        <h4><span class="text-info">{{$vendorName}}</span> Expenses for <span class="text-info">{{$startDate}} - {{$endDate}}</span></h4>
                        <p></p>
                        <div class="row row-cards">
                              <div class="col-md-4 stretch-card grid-margin">
                                    <div class="card bg-gradient-danger card-img-holder text-white">
                                          <div class="card-body">
                                                <img src="{{ asset('assets/images/dashboard/circle.svg')}}"
                                                      class="card-img-absolute" alt="circle-image">
                                                <h4 class="font-weight-normal">Total Expenses <i
                                                            class="fa fa-money mdi-24px float-end"></i>
                                                </h4>
                                                <h2 class="mb-5"> ₦{{number_format($vendorTotalExpense)}}</h2>
                                                <hr class="w-100">
                                                <h6 class="card-text"> </h6>
                                          </div>
                                    </div>
                              </div>
                        </div>
                  </div>
            </div>
            <p></p>
          

            <p></p>
            <div class="row ">
               <div class="table-responsive">
               <table class="table table-striped">
                        <thead>
                              <th>SN</th>
                              <th>Date</th>
                              <th>Expenses</th>
                              <th>Cost (₦)</th>
                        </thead>
                        <tbody>
                              @foreach($vendorExpense as $data)
                              <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{ date('Y-m-d', strtotime($data->expense_date)) }} Time: <span class="text-info"> {{\Carbon\Carbon::parse($data->created_at)->format('H:i:s')}}</span></td>
                                    <td>{{$data->description}}</td>
                                    <td>{{number_format($data->cost)}}</td>
                              </tr>
                              @endforeach
                        </tbody>
                  </table>
               </div>
            </div><!---row--->

      </div>
      <!--- content wrapper---->
      <!-- partial -->
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
<!-- main-panel -->
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.3/themes/base/jquery-ui.css">

<script src="https://code.jquery.com/jquery-3.7.1.js"></script>
<script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
<script>
$(function() {
      $("#from").datepicker();
});

$(function() {
      $("#to").datepicker();
});
</script>
<script src="{{ asset('assets/vendors/select2/select2.min.js')}}"></script>
<script src="{{ asset('assets/vendors/typeahead.js/typeahead.bundle.min.js')}}"></script>

<!-- endinject -->
<!-- Custom js for this page -->
<script src="{{ asset('assets/js/file-upload.js')}}"></script>
<script src="{{ asset('assets/js/typeahead.js')}}"></script>
<script src="{{ asset('assets/js/select2.js')}}"></script>
<!-- End custom js for this page -->


@endsection