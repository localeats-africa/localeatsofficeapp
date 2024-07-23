@extends('layouts.head')
@extends('layouts.header')
@extends('layouts.sidebar')
@extends('layouts.footer')
@section('content')
</style>
<!-- main-panel -->
<div class="main-panel">
      <div class="content-wrapper">
            <div class="page-header">
                  <h3 class="page-title">
                       Profit & Loss
                  </h3>
            </div>

            <div class="row ">

            <form method="GET" action="{{ route('profit-and-loss') }}" name="submit"
                        enctype="multipart/form-data">
                        @csrf
                        {{csrf_field()}}
                        <div class="row">
                              <div class="col-md-4 col-12">
                                    <div class="form-group">
                                          <label for="">Vendor</label>
                                          <select class="js-example-basic-single text-secondary" style="width:100%"
                                                name="vendor_id" id="vendor">
                                                <option>Choose</option>
                                                @foreach($vendor as $data)
                                                <option value="{{$data->id}}">
                                                      {{$data->vendor_name}}
                                                </option>
                                                @endforeach
                                          </select>
                                    </div>
                              </div>

                              <div class="col-md-4 col-12">
                                    <div class="form-group">
                                          <label for="">From</label>
                                          <div class="input-group date">
                                                <input type="text" value="{{ date('Y-m-d')}}" name="from"
                                                      class="form-control" placeholder="" id="from" />
                                                <span class="input-group-append">
                                                      <span class="input-group-text bg-light d-block">
                                                            <i class="fa fa-calendar"></i>
                                                      </span>
                                                </span>
                                          </div>
                                    </div>
                              </div>

                              <div class="col-md-4 col-12">
                                    <div class="form-group">

                                          <label for="">To</label>
                                          <div class="input-group date">
                                                <input type="text" value="{{ date('Y-m-d')}}" name="to"
                                                      class="form-control" placeholder="" id="to" />
                                                <span class="input-group-append">
                                                      <span class="input-group-text bg-light d-block">
                                                            <i class="fa fa-calendar"></i>
                                                      </span>
                                                </span>
                                                <button type="submit" name="submit"
                                                      class="btn bg-gradient-dark btn-sm  text-white">GO!</button>
                                          </div>
                                    </div>
                              </div>
                        </div>
                        <!---end row--->
                  </form>
            </div>
            <!---end row --->
            <p></p>
            <div class="row ">
                  <div class="col-12">
                  <h4><span class="text-info">{{$vendorName}}</span> Profit & Loss for <span class="text-info">
                  {{$startDate}} - {{$endDate}}</span></h4>
                  <p></p>
                        <div class="row row-cards">
                        <div class="col-md-4 stretch-card grid-margin">
                                    <div class="card bg-gradient-info card-img-holder text-white">
                                          <div class="card-body">
                                                <img src="{{ asset('assets/images/dashboard/circle.svg')}}"
                                                      class="card-img-absolute" alt="circle-image">
                                                <h4 class="font-weight-normal">Total Sales <i
                                                            class="fa fa-money mdi-24px float-end"></i>
                                                </h4>
                                                <h2 class="mb-5"> {{$vendorTotalSales}}</h2>
                                                <hr class="w-100">
                                                <h6 class="card-text"> </h6>
                                          </div>
                                    </div>
                              </div>

                              <div class="col-md-4 stretch-card grid-margin">
                                    <div class="card bg-gradient-danger card-img-holder text-white">
                                          <div class="card-body">
                                                <img src="{{ asset('assets/images/dashboard/circle.svg')}}"
                                                      class="card-img-absolute" alt="circle-image">
                                                <h4 class="font-weight-normal">Total Expenses <i
                                                            class="fa fa-money mdi-24px float-end"></i>
                                                </h4>
                                                <h2 class="mb-5">{{$vendorTotalExpense}}</h2>
                                                <hr class="w-100">
                                                <h6 class="card-text"> </h6>
                                          </div>
                                    </div>
                              </div>

                              <div class="col-md-4 stretch-card grid-margin">
                                    <div class="card bg-gradient-success card-img-holder text-white">
                                          <div class="card-body">
                                                <img src="{{ asset('assets/images/dashboard/circle.svg')}}"
                                                      class="card-img-absolute" alt="circle-image">
                                                <h4 class="font-weight-normal">Profit/Loss <i
                                                            class="fa fa-money mdi-24px float-end"></i>
                                                </h4>
                                                <h2 class="mb-5">{{$profitAndLoss}}</h2>
                                                <hr class="w-100">
                                                <h6 class="card-text"> </h6>
                                          </div>
                                    </div>
                              </div>

                        </div>
                  </div>
            </div>
         

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