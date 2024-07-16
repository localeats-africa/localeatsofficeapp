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
                  <h3 class="page-title">Computed Invoice</h3>
            </div>
            <!---Alert --->

            <div class="row">
                  <div class="col-lg-12">
                        @if(session('invoice'))
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
                                    <div> {!! session('invoice') !!}</div>
                              </div>
                              <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                        </div>
                        @endif

                        @if(session('merge-error'))
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
                                    <div> {!! session('merge-error') !!}</div>
                              </div>
                              <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                        </div>
                        @endif
                  </div>
            </div>
            <!---end---alert--->

            @if ($errors->any())
            <div class="alert alert-danger alert-dismissible" role="alert">
                  <div class="d-flex">
                        <div>
                              <!-- Download SVG icon from http://tabler-icons.io/i/alert-circle -->
                              <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                    <path d="M12 8v4" />
                                    <path d="M12 16h.01" />
                              </svg>
                        </div>
                        <div>
                              <ul>
                                    @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                    @endforeach
                              </ul>
                        </div>
                  </div>
                  <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
            @endif

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
                                                            <h6 class="mb-0">{{$vendorName}}</h6>
                                                            <div class="mt-1 text-secondary ">
                                                                  <small> {{$vendorAddress}} <br>
                                                                        {{$vendorState}} -
                                                                        {{$vendorCountry}}</small>

                                                                  <p class="text-secondary mb-1">
                                                                        <small> {{$vendorEmail}} <br>
                                                                              <i class="fa fa-phone"></i>
                                                                              {{$vendorPhone}}</small>
                                                                  </p>
                                                            </div>
                                                            <p></p>
                                                      </div>
                                                </div>
                                          </div>

                                    </div>
                                    <!---row--->
                                    <div class="row">
                                          <div class="col-sm-12">
                                                <div class="page-header">
                                                      <h6></h6>
                                                      <nav aria-label="breadcrumb">
                                                            <ol class="breadcrumb">
                                                                  <li class="breadcrumb-item">
                                                                        <form action="{{ route('generate-invoice') }}"
                                                                              method="post" name="submit"
                                                                              enctype="multipart/form-data">
                                                                              @csrf
                                                                              <input type="hidden"
                                                                                    value="{{$invoiceRef}}"
                                                                                    name="invoice">
                                                                              <input type="hidden" value="{{$vendorID}}"
                                                                                    name="vendor">
                                                                              <button type="submit" name="submit"
                                                                                    class="btn bg-gradient-primary text-white">Generate
                                                                                    Invoice</button>
                                                                        </form>

                                                                  </li>
                                                            </ol>
                                                      </nav>
                                                </div>
                                          </div>
                                    </div>


                                    <div class="row mb-3">
                                          <div class="col-sm-12">

                                                <div class="table-responsive">
                                                      <table class="table table-bordered">
                                                            <thead>
                                                                  <tr>
                                                                        <th>SN</th>
                                                                        <th>Order Ref</th>
                                                                        <th class="table-info">Amount (₦)</th>
                                                                        <th class="table-danger">P-Comm.</th>
                                                                        <th>Item (s)</th>
                                                                        <th>F-Price</th>
                                                                        <th>Extra</th>
                                                                        <th class="table-success">Commission</th>
                                                                  </tr>
                                                            </thead>
                                                            <tbody>
                                                                  @foreach($orders as $data)

                                                                  <tr>
                                                                        <td class="align-items-center">
                                                                              <small>{{$loop->iteration}} </small>

                                                                              <form action="{{ route('delete-order', [$data->id]) }}"
                                                                                    method="post" name="submit"
                                                                                    enctype="multipart/form-data">
                                                                                    @csrf

                                                                                    <div class="input-group">
                                                                                          <input type="hidden"
                                                                                                value="{{$data->id}}">
                                                                                          <button type="submit"
                                                                                                class="text-danger"><i
                                                                                                      class="fa fa-trash"></i></button>
                                                                                    </div>
                                                                              </form>

                                                                        </td>

                                                                        <td>
                                                                              <p><small>{{$data->order_ref}}</small></p>
                                                                              <p><small>{{$data->name}}</small></p>
                                                                              <p><small>{{ date('m/d/Y', strtotime($data->delivery_date))}}</small>
                                                                              </p>
                                                                        </td>
                                                                        <td class="table-info">
                                                                              <small>{{number_format(floatval($data->order_amount))}}</small>
                                                                        </td>
                                                                        <td class="table-danger">
                                                                              @if($data->name == 'Chowdeck')
                                                                              {{ number_format(floatval($data->platform_comm))}}
                                                                              @endif

                                                                              @if($data->name == 'Glovo')
                                                                              {{ number_format($data->platform_comm) }}
                                                                              @endif </td>
                                                                        <td width="50%" style="white-space:wrap">
                                                                              <small>{{$data->description}}</small>

                                                                        <td>
                                                                              <p> {{number_format(floatval($data->food_price))}}
                                                                              </p>
                                                                              <form action="{{ route('update-merge-invoice-food') }}"
                                                                                    method="post" name="submit"
                                                                                    enctype="multipart/form-data">
                                                                                    @csrf

                                                                                    <div class="form-group">
                                                                                          <select
                                                                                                class="js-example-basic-multiple1"
                                                                                                multiple="multiple"
                                                                                                style="width:100%"
                                                                                                name="food_price[]">
                                                                                                <option value="">
                                                                                                      Search
                                                                                                </option>
                                                                                                @foreach($vendorFoodPrice
                                                                                                as $food)
                                                                                                <option
                                                                                                      value="{{$food->id}}">
                                                                                                      {{$food->item}}
                                                                                                </option>
                                                                                                @endforeach
                                                                                          </select>
                                                                                    </div>
                                                                                    <input type="hidden" name="order"
                                                                                          value="{{$data->id}}">
                                                                                    <input type="hidden" name="vendor"
                                                                                          value="{{$data->vendor_id}}">
                                                                                    <input type="hidden" name="amount"
                                                                                          value="{{$data->order_amount}}">

                                                                                    <input type="hidden" name="extra"
                                                                                          value="{{$data->extra}}">


                                                                                    <div
                                                                                          class="d-flex flex-column align-items-center text-center">
                                                                                          <button type="submit"
                                                                                                class="btn text-success"><i
                                                                                                      class="fa fa-check"></i></button>
                                                                                    </div>
                                                                              </form>


                                                                              <div
                                                                                    class="d-flex flex-column align-items-center text-center">
                                                                                    <!-- Reset food prie ----->
                                                                                    <form action="{{ route('reset-order-food-price', [$data->id]) }}"
                                                                                          method="post" name="submit"
                                                                                          enctype="multipart/form-data">
                                                                                          @csrf

                                                                                          <button type="submit"
                                                                                                class="text-danger"><i
                                                                                                      class="fa fa-times"></i></button>

                                                                                    </form>
                                                                              </div>

                                                                        </td>

                                                                        <td>
                                                                              <p> {{number_format(floatval($data->extra))}}
                                                                              </p>
                                                                              <form action="{{ route('update-merge-invoice-extra') }}"
                                                                                    method="post" name="submit"
                                                                                    enctype="multipart/form-data">
                                                                                    @csrf
                                                                                    <div class="form-group">
                                                                                          <select
                                                                                                class="js-example-basic-multiple"
                                                                                                multiple="multiple"
                                                                                                style="width:100%"
                                                                                                name="extra[]">
                                                                                                @foreach($vendorFoodPrice
                                                                                                as $food)
                                                                                                <option
                                                                                                      value="{{$food->id}}">
                                                                                                      {{$food->item}}
                                                                                                </option>
                                                                                                @endforeach
                                                                                          </select>
                                                                                    </div>
                                          
                                                                                    <div
                                                                                          class="d-flex flex-column align-items-center text-center">
                                                                                          <input type="hidden"
                                                                                                name="order"
                                                                                                value="{{$data->id}}">
                                                                                          <input type="hidden"
                                                                                                name="vendor"
                                                                                                value="{{$data->vendor_id}}">
                                                                                          <input type="hidden"
                                                                                                name="amount"
                                                                                                value="{{$data->order_amount}}">

                                                                                          <input type="hidden"
                                                                                                name="food_price"
                                                                                                value="{{$data->food_price}}">
                                                                                          <button type="submit"
                                                                                                class="btn text-success"><i
                                                                                                      class="fa fa-check"></i></button>
                                                                                    </div>
                                                                              </form>

                                                                              <div
                                                                                    class="d-flex flex-column align-items-center text-center">
                                                                                    <!-- Reset extra prie ----->
                                                                                    <form action="{{ route('reset-order-extra', [$data->id]) }}"
                                                                                          method="post" name="submit"
                                                                                          enctype="multipart/form-data">
                                                                                          @csrf

                                                                                          <button type="submit"
                                                                                                class="text-danger"><i
                                                                                                      class="fa fa-times"></i></button>

                                                                                    </form>
                                                                              </div>

                                                                        </td>

                                                                        <td class="table-success">
                                                                              @if($data->name == 'Chowdeck')
                                                                              {{ number_format($data->localeats_comm)}}
                                                                              @endif

                                                                              @if($data->name == 'Glovo')
                                                                              {{ number_format($data->localeats_comm )}}
                                                                              @endif
                                                                        </td>
                                                                  </tr>

                                                                  @endforeach
                                                                  <tr>

                                                                        <th colspan="2" class="text-end">
                                                                              <h6>Total (₦)</h6>
                                                                        </th>

                                                                        <th>{{number_format($sumAmount, 2)}}
                                                                        </th>
                                                                        <th>{{number_format($totalPlatformComm, 2)}}
                                                                        </th>
                                                                        <th></th>
                                                                        <th>{{number_format($sumFoodPrice, 2)}}
                                                                        </th>
                                                                        <th>{{number_format($sumExtra, 2)}}
                                                                        </th>
                                                                        <th>{{number_format($totalComm, 2)}}
                                                                        </th>
                                                                  </tr>

                                                                  <tr>
                                                                        <th row colspan="6" class="text-end">
                                                                              <h6>Estimated PayOut (₦)</h6>
                                                                              <p><small class="text-danger fw-light">(food
                                                                                          price +
                                                                                          extra)</small></p>
                                                                        </th>
                                                                        <th>
                                                                              {{number_format($sumFoodPrice + $sumExtra, 2) }}
                                                                        </th>
                                                                        <th></th>
                                                                  </tr>
                                                                  <tr>
                                                                        <th row colspan="6" class="text-end">
                                                                              <h6> Actual PayOut (₦)</h6>
                                                                              <p><small class="text-danger fw-light">(after
                                                                                          reconciliation)</small>
                                                                              </p>
                                                                        </th>
                                                                        <th>
                                                                              <form action="{{ route('update-merge-invoice-payout') }}"
                                                                                    method="post" name="submit"
                                                                                    enctype="multipart/form-data">
                                                                                    @csrf
                                                                                    {{csrf_field()}}
                                                                                    <input type="hidden" name="order"
                                                                                          value="{{$data->id}}">

                                                                                    <input type="hidden" name="vendor"
                                                                                          value="{{$data->vendor_id}}">

                                                                                    <div class="input-group">
                                                                                          <input type="text"
                                                                                                name="amount_payout"
                                                                                                class="form-control bg-secondary fw-bold"
                                                                                                value="{{number_format($payout, 2)}}">
                                                                                          <button type="submit"
                                                                                                class="btn text-success"><i
                                                                                                      class="fa fa-check"></i></button>
                                                                                    </div>
                                                                              </form>
                                                                        </th>
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
function mydelete() {
      alert("Sure you want to delete?");
}
</script>
@endsection