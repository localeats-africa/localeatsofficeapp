@extends('layouts.head')
@extends('layouts.header')
@extends('layouts.sidebar')
@extends('layouts.footer')
@section('content')
<!-- main-panel -->
<style>
.hidetext {
      /* height: 50px; */
      max-width: 130px;
      overflow: hidden;
      text-overflow: ellipsis;
      cursor: pointer;
      word-break: break-all;
      white-space: nowrap;
      border: 1px solid #C8C8C8;
      text-align: left;
      padding: 10px;
}



.hidetext:hover {
      overflow: visible;
      white-space: normal;
      line-height: 1.5em;
}
</style>
<div class="main-panel">
      <div class="content-wrapper">

            <div class="page-header">
                  <h3 class="page-title">Invoice</h3>

                  <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                              <li class="breadcrumb-item active" aria-current="page">
                              <span></span>       
                              <form action="{{ route('export-invoice', [$invoice_ref]) }}" method="post"
                                          name="submit" enctype="multipart/form-data">
                                          @csrf
                                          <input type="hidden" value="{{$invoice_ref}}" name="invoice_ref">
                                          <button type="submit" name="submit" class="btn btn-info">Export To
                                          Excel</button>
                                    </form>

                                
                              </li>
                        </ul>
                  </nav>
            </div>
            <!---Alert --->

            <div class="row">
                  <div class="col-lg-12">
                  </div>
            </div>
            <!---end---alert--->


            <div class="row">
                  <div class="col-md-12">
                        <div class="card">
                              <div class="card-body">
                                    <div class="row">
                                          <div class="col-md-6 col-6">

                                                <div class="d-flex flex-column">
                                                      <img src="{{ asset('assets/images/logo.png') }}" alt="Admin"
                                                            class="rounded-circle " width="110">
                                                      <h4>LocalEats Africa</h4>
                                                      <div class="mt-1 text-secondary">
                                                            <small>2nd floor,10 Hughes Avenue, <br>
                                                                  Alagomeji, Yaba Lagos</small>
                                                            <p>
                                                                  <small> <i class="mdi mdi-email"></i>
                                                                        hi@localeats.africa
                                                                        <br>
                                                                        <i class="mdi mdi-web-check"></i>
                                                                        www.localeats.africa</small>
                                                            </p>

                                                      </div>
                                                </div>
                                          </div>

                                          <div class="col-md-6 col-6">
                                                <div class="row mb-3">
                                                      <p></p>
                                                      <div class="col-sm-12" style="text-align:right;">
                                                            <h6 class="mb-0">{{$vendorBusinessName}}</h6>
                                                            <div class="mt-1 text-secondary ">
                                                                  <small> {{$vendorAddress}} <br>
                                                                        {{$vendorState}} -
                                                                        {{$vendorCountry}}</small>

                                                                  <p class="text-secondary mb-1">
                                                                  <h6></h6>
                                                                  <h6>Contact:&nbsp;&nbsp;
                                                                        {{$vendorFname}}&nbsp;{{$vendorLname}}</h6>

                                                                  <i class="fa fa-phone"></i>
                                                                  {{$vendorPhone}}</small>
                                                                  </p>
                                                            </div>
                                                            <p></p>
                                                            <div class="mt-1">
                                                                  <h4 id="invoice_ref">Invoice ID: {{$invoice_ref}}</h4>
                                                                  <h3 class="text-info text-uppercase">
                                                                        {{$payment_status}}</h3>
                                                            </div>
                                                      </div>
                                                </div>
                                          </div>

                                    </div>
                                    <!---row--->
                                    <div class="row">
                                          <div class="col-sm-12">
                                                <div class="page-header">
                                                      <h6></h6>
                                                      <nav style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
                                                            <ol class="breadcrumb">
                                                                  <li class="breadcrumb-item">
                                                                        <button
                                                                              class="btn btn-outline-dark bg-gradient text-dark"
                                                                              onclick="javascript:window.print();">
                                                                              <i class="fa fa-print"></i></button>
                                                                  </li>
                                                                  <li class="breadcrumb-item">
                                                                        <button
                                                                              class="btn btn-outline-dark bg-gradient text-dark">
                                                                              <i class="fa fa-download"></i></button>
                                                                  </li>
                                                                  <li class="breadcrumb-item">
                                                                        <button
                                                                              class="btn btn-outline-dark bg-gradient text-dark">
                                                                              <i class="fa fa-envelope"></i></button>
                                                                  </li>
                                                                  <li class="breadcrumb-item">
                                                                        <button
                                                                              class="btn btn-outline-dark bg-gradient text-dark">
                                                                              <i class="fa fa-whatsapp"></i></button>
                                                                  </li>
                                                            </ol>
                                                      </nav>
                                                </div>
                                          </div>
                                    </div>


                                    <div class="row mb-3">
                                          <div class="col-sm-12">

                                                <div class="table-responsive">
                                                      <table class="table table-striped">
                                                            <thead>
                                                                  <tr>
                                                                        <th>Item (s)</th>
                                                                        <th>Order Ref</th>
                                                                        <th>Delivery Date</th>
                                                                        <th>Food Price</th>
                                                                        <th>Extra</th>
                                                                  </tr>
                                                            </thead>
                                                            <tbody>
                                                                  @foreach($orders as $data)

                                                                  <tr>
                                                                        <td width="50%" style="white-space:wrap"><small>
                                                                                    {!! nl2br($data->description) !!}
                                                                              </small></td>
                                                                        <td><small>{{$data->order_ref}}</small></td>
                                                                        <td><small>{{ date('m/d/Y', strtotime($data->delivery_date))}}</small>
                                                                        </td>
                                                                        <td><small>{{number_format(floatval($data->food_price))}}</small>
                                                                        </td>
                                                                        <td><small>{{number_format(floatval($data->extra))}}</small>
                                                                        </td>

                                                                  </tr>

                                                                  @endforeach
                                                                  <tr>

                                                                        <th colspan="3" class="text-end">
                                                                        </th>
                                                                        <th>{{number_format($sumFoodPrice, 2)}}
                                                                        </th>
                                                                        <th>{{number_format($sumExtra, 2)}}
                                                                        </th>

                                                                  </tr>
                                                                  <tr>

                                                                        <th colspan="4" class="text-end">
                                                                              <h6>Total Amount (₦)</h6>
                                                                        </th>
                                                                        <th>{{number_format($payout, 2)}}
                                                                        </th>

                                                                  </tr>


                                                                  <tr>
                                                                        <th colspan="4" class="text-end">
                                                                              <h6>Total Order (s)</h6>
                                                                        </th>
                                                                        <th>{{$orders->count() }}</th>
                                                                        <th></th>

                                                                  </tr>
                                                            </tbody>
                                                      </table>
                                                </div>

                                          </div>


                                    </div>

                              </div>
                              <!---card body --->
                        </div>
                        <!---card --->

                  </div>
            </div>
            <!---row --->
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

<script src="{{ asset('assets/vendors/select2/select2.min.js')}}"></script>
<script src="{{ asset('assets/vendors/typeahead.js/typeahead.bundle.min.js')}}"></script>

<!-- endinject -->
<!-- Custom js for this page -->
<script src="{{ asset('assets/js/file-upload.js')}}"></script>
<script src="{{ asset('assets/js/typeahead.js')}}"></script>
<script src="{{ asset('assets/js/select2.js')}}"></script>

<script>
function exportInvoice() {
      var id = document.getElementById('invoice_ref').value;
      var showRoute = "{{ route('export-invoice', ':id') }}";
      url = showRoute.replace(':id', id);

      window.location = url;

}
</script>
@endsection