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
                        Overview >>> <span class="text-info"> {{ $startDate }}</span> - <span class="text-info">
                              {{ $endDate   }}</span>
                  </h3>
                  <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                              <li class="breadcrumb-item active" aria-current="page">

                              </li>

                              <li class="breadcrumb-item active" aria-current="page">

                              </li>
                        </ul>
                  </nav>
            </div>

            <div class="row ">

                  <form method="GET" action="{{ route('admin-filter-dashboard') }}" name="submit"
                        enctype="multipart/form-data">
                        @csrf
                        {{csrf_field()}}
                        <div class="row">
                              <div class="row text-end">
                                    <h6>Filter record: &nbsp; <a href="{{ url('admin') }}"
                                                class="btn bg-info btn-sm  text-white"> View All</a>
                                    </h6>
                                    <div class="col-md-3">
                                    </div>
                                    <div class="col-md-3 col-12">
                                    </div>
                                    <div class="col-md-3 col-12">
                                          <div class="form-group">
                                                <div class="input-group date">
                                                      <span class="input-group-append">
                                                            <span class="input-group-text text-dark d-block">
                                                                  Start
                                                            </span>
                                                      </span>
                                                      <input type="text" value="" name="from" class="form-control"
                                                            placeholder="" id="from" />
                                                      <span class="input-group-append">
                                                            <span class="input-group-text bg-light d-block">
                                                                  <i class="fa fa-calendar"></i>
                                                            </span>
                                                      </span>
                                                </div>
                                          </div>
                                    </div>

                                    <div class="col-md-3 col-12">
                                          <div class="form-group">
                                                <div class="input-group date">
                                                      <span class="input-group-append">
                                                            <span class="input-group-text text-dark d-block">
                                                                  End
                                                            </span>
                                                      </span>
                                                      <input type="text" value="" name="to" class="form-control"
                                                            placeholder="" id="to" />
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
            <!-- <div class="container "> -->
            <div class="row ">
                  <div class="col-12">
                        <div class="row row-cards">

                              <div class="col-md-3 stretch-card grid-margin">
                                    <div class="card bg-gradient-dark card-img-holder text-white">
                                          <div class="card-body">
                                                <img src="{{ asset('assets/images/dashboard/circle.svg')}}"
                                                      class="card-img-absolute" alt="circle-image">
                                                <h4 class="font-weight-normal">Platforms <i
                                                            class="mdi mdi-cloud-braces mdi-24px float-end"></i>
                                                </h4>
                                                <h2 class="mb-5">{{$countPlatforms->count()}}</h2>
                                                <hr class="w-100">
                                                <h6 class="card-text">active <span
                                                            style="float:right;">{{$activePlatform->count()}}
                                                      </span> </h6>
                                          </div>
                                    </div>
                              </div>
                              <div class="col-md-3 stretch-card grid-margin">
                                    <div class="card bg-gradient-warning card-img-holder text-dark">
                                          <div class="card-body">
                                                <img src="{{ asset('assets/images/dashboard/circle.svg') }}"
                                                      class="card-img-absolute" alt="circle-image">
                                                <h4 class="font-weight-normal">Vendors <i
                                                            class="mdi mdi-pot-steam  mdi-24px float-end"></i>
                                                </h4>
                                                <h2 class="mb-5">{{$countVendor->count()}}</h2>
                                                <hr class="w-100">
                                                <h6 class="card-text">active
                                                      <span style="float:right;">{{$countActiveVendor->count()}}</span>

                                                </h6>
                                          </div>

                                    </div>
                              </div>

                              <div class="col-md-3 stretch-card grid-margin">
                                    <div class="card bg-gradient-secondary card-img-holder text-dark">
                                          <div class="card-body">
                                                <img src="{{ asset('assets/images/dashboard/circle.svg') }}"
                                                      class="card-img-absolute" alt="circle-image">
                                                <h4 class="font-weight-normal">Number Of Orders <i
                                                            class="mdi mdi-shopping  mdi-24px float-end"></i>
                                                </h4>
                                                <h2 class="mb-5">{{$countAllOrder}}</h2>
                                                <hr class="w-100">
                                                <h6 class="card-text">From <span class="text-dark">(
                                                            {{$countPlatformWhereOrderCame}} )</span>
                                                      <span style="float:right;">platform (s)</span>

                                                </h6>
                                          </div>

                                    </div>
                              </div>

                              <div class="col-md-3 stretch-card grid-margin">
                                    <div class="card bg-gradient-danger card-img-holder text-white">
                                          <div class="card-body">
                                                <img src="{{ asset('assets/images/dashboard/circle.svg') }}"
                                                      class="card-img-absolute" alt="circle-image">
                                                <h4 class="font-weight-normal">Number Of Plates <i
                                                            class="fa fa-cutlery  mdi-24px float-end"></i>
                                                </h4>
                                                <h2 class="mb-5">{{$countAllPlate}}</h2>
                                                <hr class="w-100">
                                                <h6 class="card-text">From <span class="text-dark">(
                                                            {{$countAllOrder}} )</span>
                                                      <span style="float:right;">order (s)</span>

                                                </h6>
                                          </div>

                                    </div>
                              </div>



                        </div>
                        <!--row--->
                  </div>
            </div>
            <!--row-deck-->

            <div class="row ">
                  <div class="col-12">
                        <div class="row row-cards">
                              <div class="col-md-4 stretch-card grid-margin">
                                    <div class="card bg-gradient-info card-img-holder text-white">
                                          <div class="card-body">
                                                <img src="{{ asset('assets/images/dashboard/circle.svg')}}"
                                                      class="card-img-absolute" alt="circle-image">
                                                <h4 class="font-weight-normal">Total Sales <i
                                                            class="mdi mdi-24px float-end">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="icon"
                                                                  width="24" height="24" viewBox="0 0 24 24"
                                                                  stroke-width="2" stroke="currentColor" fill="none"
                                                                  stroke-linecap="round" stroke-linejoin="round">
                                                                  <path stroke="none" d="M0 0h24v24H0z" fill="none">
                                                                  </path>
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
                                                <h2 class="mb-5">₦{{number_format($sumAllOrders, 2)}}</h2>
                                                <hr class="w-100">
                                          </div>
                                    </div>
                              </div>

                              <div class="col-sm-4 col-12 stretch-card grid-margin">
                                    <div class="card bg-gradient-primary card-img-holder text-white">
                                          <div class="card-body">
                                                <img src="{{ asset('assets/images/dashboard/circle.svg')}}"
                                                      class="card-img-absolute" alt="circle-image">
                                                <h4 class="font-weight-normal">Estimated Vendor Sales
                                                      <i class="mdi mdi-cash mdi-24px float-end"></i>
                                                </h4>
                                                <h2 class="mb-5">₦{{number_format($vendorFoodPrice, 2)}}</h2>
                                                <hr class="w-100">
                                          </div>
                                    </div>
                              </div>

                              <div class="col-sm-4  col-12 stretch-card grid-margin">
                                    <div class="card bg-primary card-img-holder text-white">
                                          <div class="card-body">
                                                <img src="{{ asset('assets/images/dashboard/circle.svg')}}"
                                                      class="card-img-absolute" alt="circle-image">
                                                <h4 class="font-weight-normal"> Platform Commission
                                                      <i class="mdi mdi-hand-coin mdi-24px float-end"></i>
                                                </h4>
                                                <h2 class="mb-5">₦ {{number_format($sumGlovoComm, 2) }}</h2>
                                                <hr class="w-100">
                                          </div>
                                    </div>
                              </div>

                        </div>
                        <!--row--->

                        <!--row-->
                        <div class="row row-cards">

                              <div class="col-sm-4  col-12 stretch-card grid-margin">
                                    <div class="card bg-success card-img-holder text-white">
                                          <div class="card-body">
                                                <img src="{{ asset('assets/images/dashboard/circle.svg')}}"
                                                      class="card-img-absolute" alt="circle-image">
                                                <h4 class="font-weight-normal"> Total Commission
                                                      <i class="mdi mdi-hand-coin mdi-24px float-end"></i>
                                                </h4>
                                                <h2 class="mb-5">₦ {{number_format($commission, 2) }}</h2>
                                                <hr class="w-100">
                                          </div>
                                    </div>
                              </div>

                              <div class="col-sm-4 col-12 stretch-card grid-margin">
                                    <div class="card bg-danger card-img-holder text-white">
                                          <div class="card-body">
                                                <img src="{{ asset('assets/images/dashboard/circle.svg')}}"
                                                      class="card-img-absolute" alt="circle-image">
                                                <h4 class="font-weight-normal">Actual Payouts
                                                      <i class="mdi mdi-cash mdi-24px float-end"></i>
                                                </h4>
                                                <h2 class="mb-5">₦{{number_format($payouts, 2)}}</h2>
                                                <hr class="w-100">
                                          </div>
                                    </div>
                              </div>


                              <div class="col-sm-4  col-12 stretch-card grid-margin">
                                    <div class="card bg-secondary card-img-holder text-white">
                                          <div class="card-body">
                                                <img src="{{ asset('assets/images/dashboard/circle.svg')}}"
                                                      class="card-img-absolute" alt="circle-image">
                                                <h4 class="font-weight-normal"> Commission Paid
                                                      <i class="mdi mdi-hand-coin mdi-24px float-end"></i>
                                                </h4>
                                                <h2 class="mb-5">₦ {{number_format($commissionPaid, 2) }}</h2>
                                                <hr class="w-100">
                                          </div>
                                    </div>
                              </div>

                        </div>
                        <!--row--->
                  </div>
            </div>
            <!--row-deck-->
            <!-- </div> -->
            <p></p>
            <!--Alert here--->
            <!-- <div class="container "> -->
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
            <div class="row">
                  <div class="col-md-7 grid-margin stretch-card">
                        <div class="card">
                              <div class="card-body">
                                    <h4 class="card-title">Sales chart:</h4>
                                    <canvas id="lineChart" style="height: 55px !important; width: 125px;"></canvas>
                              </div>
                        </div>
                  </div>
                  <div class="col-md-5 grid-margin stretch-card">
                        <div class="card">
                              <div class="card-body">
                                    <h4 class="card-title">Sales platform: </h4>
                                    <div class="table-responsive">
                                          <table class="table">
                                                <thead>
                                                      <tr>
                                                            <th> </th>
                                                            <th> Name </th>
                                                            <th> Orders</th>
                                                            <th> Progress </th>
                                                      </tr>
                                                </thead>
                                                <tbody>
                                                      @foreach($platformOrders as $platform)
                                                      <tr>
                                                            <td>
                                                                  @if(empty($platform->img_url))
                                                                  None
                                                                  @else
                                                                  <img src="{{ asset($platform->img_url) }}"
                                                                        class="cursor" style="">
                                                                  @endif
                                                            </td>
                                                            <td>{{$platform->name}} </td>
                                                            <td>
                                                                  @if($platform->name == 'Chowdeck')
                                                                  {{$chowdeckOrderCount}}
                                                                  @endif

                                                                  @if($platform->name == 'Glovo')
                                                                  {{$glovoOrderCount}}
                                                                  @endif

                                                                  @if($platform->name == 'Edenlife')
                                                                  {{$edenOrderCount}}
                                                                  @endif

                                                                  @if($platform->name == 'Mano')
                                                                  {{$manoOrderCount}}
                                                                  @endif
                                                            </td>
                                                            <td>
                                                                  @if($platform->name == 'Chowdeck')

                                                                  <div class="progress" role="progressbar">
                                                                        <div class="progress-bar  progress-bar-striped progress-bar-animated bg-info"
                                                                              role="progressbar"
                                                                              style="width: {{ $chowdeckSalesPercentageChart}}%"
                                                                              aria-valuenow="{{$chowdeckSalesPercentageChart}}"
                                                                              aria-valuemin="0" aria-valuemax="100">
                                                                        </div>
                                                                  </div>
                                                                  @endif

                                                                  @if($platform->name == 'Glovo')

                                                                  <div class="progress" role="progressbar">
                                                                        <div class="progress-bar  progress-bar-striped progress-bar-animated bg-info"
                                                                              role="progressbar"
                                                                              style="width: {{$glovoSalesPercentageChart}}%"
                                                                              aria-valuenow="{{$glovoSalesPercentageChart}}"
                                                                              aria-valuemin="" aria-valuemax="100">
                                                                        </div>
                                                                  </div>
                                                                  @endif

                                                                  @if($platform->name == 'Edenlife')

                                                                  <div class="progress" role="progressbar">
                                                                        <div class="progress-bar  progress-bar-striped progress-bar-animated bg-info"
                                                                              role="progressbar"
                                                                              style="width: {{$edenSalesPercentageChart}}%"
                                                                              aria-valuenow="{{$edenSalesPercentageChart}}"
                                                                              aria-valuemin="" aria-valuemax="100">
                                                                        </div>
                                                                  </div>
                                                                  @endif

                                                                  @if($platform->name == 'Mano')

                                                                  <div class="progress" role="progressbar">
                                                                        <div class="progress-bar  progress-bar-striped progress-bar-animated bg-info"
                                                                              role="progressbar"
                                                                              style="width: {{$manoSalesPercentageChart}}%"
                                                                              aria-valuenow="{{$manoSalesPercentageChart}}"
                                                                              aria-valuemin="" aria-valuemax="100">
                                                                        </div>
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
            </div>
            <!--- row--->
            <p></p>
            <div class="row">
                  <!--chart in dashboard.js--->
                  <div class="col-md-7 grid-margin stretch-card">
                        <div class="card">
                              <div class="card-body">
                                    <div class="clearfix">
                                          <h4 class="card-title float-start">Sales Performance</h4>
                                          <div id="visit-sale-chart-legend"
                                                class="rounded-legend legend-horizontal legend-top-right float-end">
                                          </div>
                                    </div>
                                    <canvas id="visit-sale-chart" class="mt-4"></canvas>
                              </div>
                        </div>
                  </div>
                  <div class="col-md-5 grid-margin stretch-card">
                        <div class="card">
                              <div class="card-body">
                                    <h4 class="card-title">Sales Percentage: </h4>
                                    <p></p>
                                    <div class="doughnutjs-wrapper d-flex justify-content-center">
                                          <canvas id="traffic-chart"></canvas>
                                    </div>
                                    <div id="traffic-chart-legend"
                                          class="rounded-legend legend-vertical legend-bottom-left pt-4">


                                    </div>
                              </div>
                        </div>
                  </div>
            </div>
            <!-- </div> -->
      </div>
      <!--content wrapper-->
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

<!-- <script src="{{ asset('assets/js/dashboard.js') }}"></script> -->
<!-- <script src="{{ asset('assets/js/chart.js') }}"></script> -->
<!-- End custom js for this page -->

<script>
$(function() {
      $("#from").datepicker();
});

$(function() {
      $("#to").datepicker();
});
</script>

<script>
(function($) {
      'use strict';
      if ($("#visit-sale-chart").length) {
            const ctx = document.getElementById('visit-sale-chart');
            //chowdeck
            var graphGradient1 = document.getElementById('visit-sale-chart').getContext("2d");
            //glovo
            var graphGradient2 = document.getElementById('visit-sale-chart').getContext("2d");
            //eden
            var graphGradient3 = document.getElementById('visit-sale-chart').getContext("2d");
            //mano  
            var graphGradient4 = document.getElementById('visit-sale-chart').getContext("2d");

            var gradientStrokeViolet = graphGradient1.createLinearGradient(0, 0, 0, 181);
            gradientStrokeViolet.addColorStop(0, 'rgba(12, 81, 63, 1)');
            gradientStrokeViolet.addColorStop(1, 'rgba(12, 81, 63, 1)');
            var gradientLegendViolet = 'linear-gradient(to right, rgba(12, 81, 63, 1), rgba(12, 81, 63, 1))';

            var gradientStrokeBlue = graphGradient2.createLinearGradient(0, 0, 0, 360);
            gradientStrokeBlue.addColorStop(0, 'rgba(255, 194, 68, 1)');
            gradientStrokeBlue.addColorStop(1, 'rgba(255, 194, 68, 1)');
            var gradientLegendBlue = 'linear-gradient(to right, rgba(255, 194, 68, 1), rgba(255, 194, 68, 1))';

            var gradientStrokeRed = graphGradient3.createLinearGradient(0, 0, 0, 300);
            gradientStrokeRed.addColorStop(0, 'rgba(162, 153, 149, 1)');
            gradientStrokeRed.addColorStop(1, 'rgba(162, 153, 149, 1)');
            var gradientLegendRed = 'linear-gradient(to right, rgba(162, 153, 149, 1), rgba(162, 153, 149, 1))';

            var gradientStrokeMano = graphGradient4.createLinearGradient(0, 0, 0, 170);
            gradientStrokeMano.addColorStop(0, 'rgba(238, 39, 55, 1)');
            gradientStrokeMano.addColorStop(1, 'rgba(238, 39, 55, 1)');
            var gradientLegendMano = 'linear-gradient(to right, rgba(238, 39, 55, 1), rgba(238, 39, 55, 1))';

            const bgColor1 = ["rgba(12, 81, 63, 1)"];
            const bgColor2 = ["rgba(255, 194, 68, 1"];
            const bgColor3 = ["rgba(162, 153, 149, 1)"];
            const bgManoColor = ["rgba(238, 39, 55, 1)"];

            new Chart(ctx, {
                  type: 'bar',
                  data: {
                        labels: @json($barChartData['months']),
                        datasets: [{
                                    label: "Chowdeck",
                                    borderColor: gradientStrokeViolet,
                                    backgroundColor: gradientStrokeViolet,
                                    fillColor: bgColor1,
                                    hoverBackgroundColor: gradientStrokeViolet,
                                    pointRadius: 0,
                                    fill: false,
                                    borderWidth: 1,
                                    fill: 'origin',
                                    data: @json($barChartData['chocdekSales']),
                                    barPercentage: 0.5,
                                    categoryPercentage: 0.5,
                              },
                              {
                                    label: "Glovo",
                                    borderColor: gradientStrokeBlue,
                                    backgroundColor: gradientStrokeBlue,
                                    hoverBackgroundColor: gradientStrokeBlue,
                                    fillColor: bgColor2,
                                    pointRadius: 0,
                                    fill: false,
                                    borderWidth: 1,
                                    fill: 'origin',
                                    data: @json($barChartData['glovoSales']),
                                    barPercentage: 0.5,
                                    categoryPercentage: 0.5,
                              },
                              {
                                    label: "Eden",
                                    borderColor: gradientStrokeRed,
                                    backgroundColor: gradientStrokeRed,
                                    hoverBackgroundColor: gradientStrokeRed,
                                    fillColor: bgColor3,
                                    pointRadius: 0,
                                    fill: false,
                                    borderWidth: 1,
                                    fill: 'origin',
                                    data: @json($barChartData['edenSales']),
                                    barPercentage: 0.5,
                                    categoryPercentage: 0.5,
                              },
                              {
                                    label: "Mano",
                                    borderColor: gradientStrokeMano,
                                    backgroundColor: gradientStrokeMano,
                                    hoverBackgroundColor: gradientStrokeMano,
                                    fillColor: bgManoColor,
                                    pointRadius: 0,
                                    fill: false,
                                    borderWidth: 1,
                                    fill: 'origin',
                                    data: @json($barChartData['manoSales']),
                                    barPercentage: 0.5,
                                    categoryPercentage: 0.5,
                              },
                        ]
                  },
                  options: {
                        responsive: true,
                        maintainAspectRatio: true,
                        elements: {
                              line: {
                                    tension: 0.4,
                              },
                        },
                        scales: {
                              y: {
                                    display: false,
                                    grid: {
                                          display: true,
                                          drawOnChartArea: true,
                                          drawTicks: false,
                                    },
                              },
                              x: {
                                    display: true,
                                    grid: {
                                          display: false,
                                    },
                              }
                        },
                        plugins: {
                              legend: {
                                    display: false,
                              }
                        }
                  },
                  plugins: [{
                        afterDatasetUpdate: function(chart, args, options) {
                              const chartId = chart.canvas.id;
                              var i;
                              const legendId = `${chartId}-legend`;
                              const ul = document.createElement('ul');
                              for (i = 0; i < chart.data.datasets.length; i++) {
                                    ul.innerHTML += `
              <li>
                <span style="background-color: ${chart.data.datasets[i].fillColor}"></span>
                ${chart.data.datasets[i].label}
              </li>
            `;
                              }
                              // alert(chart.data.datasets[0].backgroundColor);
                              return document.getElementById(legendId).appendChild(
                                    ul);
                        }
                  }]
            });
      }
      //Pie Chart
      if ($("#traffic-chart").length) {
            const ctx = document.getElementById('traffic-chart');
            //chowdeck
            var graphGradient1 = document.getElementById("traffic-chart").getContext('2d');
            //glovo
            var graphGradient2 = document.getElementById("traffic-chart").getContext('2d');
            //eden
            var graphGradient3 = document.getElementById("traffic-chart").getContext('2d');
            //mano
            var graphGradient4 = document.getElementById("traffic-chart").getContext('2d');

            //chowdeck
            var gradientStrokeBlue = graphGradient1.createLinearGradient(0, 0, 0, 181);
            gradientStrokeBlue.addColorStop(0, 'rgba(12, 81, 63, 1)');
            gradientStrokeBlue.addColorStop(1, 'rgba(12, 81, 63, 1)');
            var gradientLegendBlue = 'rgba(12, 81, 63, 1)';

            //glovo
            var gradientStrokeRed = graphGradient2.createLinearGradient(0, 0, 0, 50);
            gradientStrokeRed.addColorStop(0, 'rgba(255, 194, 68, 1)');
            gradientStrokeRed.addColorStop(1, 'rgba(255, 194, 68, 1)');
            var gradientLegendRed = 'rgba(255, 194, 68, 1)';
            //eden
            var gradientStrokeGreen = graphGradient3.createLinearGradient(0, 0, 0, 300);
            gradientStrokeGreen.addColorStop(0, 'rgba(162, 153, 149, 1)');
            gradientStrokeGreen.addColorStop(1, 'rgba(162, 153, 149, 1)');
            var gradientLegendGreen = 'rgba(162, 153, 149, 1)';
            //mano
            var gradientStrokeMano = graphGradient4.createLinearGradient(0, 0, 0, 300);
            gradientStrokeMano.addColorStop(0, 'rgba(238, 39, 55, 1)');
            gradientStrokeMano.addColorStop(1, 'rgba(238, 39, 55, 1)');
            var gradientLegendMano = 'rgba(238, 39, 55, 1)';

            // const bgColor1 = ["rgba(54, 215, 232, 1)"];
            // const bgColor2 = ["rgba(255, 191, 150, 1"];
            // const bgColor3 = ["rgba(6, 185, 157, 1)"];

            new Chart(ctx, {
                  type: 'doughnut',
                  data: {
                        labels: @json($piechartData['label']),
                        datasets: [{
                              data: @json($piechartData['data']),
                              backgroundColor: [gradientStrokeBlue, gradientStrokeRed,
                                    gradientStrokeGreen, gradientStrokeMano
                              ],
                              hoverBackgroundColor: [
                                    gradientStrokeBlue,
                                    gradientStrokeRed,
                                    gradientStrokeGreen,
                                    gradientStrokeMano

                              ],
                              borderColor: [
                                    gradientStrokeBlue,
                                    gradientStrokeRed,
                                    gradientStrokeGreen,
                                    gradientStrokeMano

                              ],
                              legendColor: [
                                    gradientLegendBlue,
                                    gradientLegendRed,
                                    gradientLegendGreen,
                                    gradientLegendMano

                              ]
                        }]
                  },
                  options: {
                        cutout: 50,
                        animationEasing: "easeOutBounce",
                        animateRotate: true,
                        animateScale: false,
                        responsive: true,
                        maintainAspectRatio: true,
                        showScale: true,
                        legend: false,
                        plugins: {
                              legend: {
                                    display: false,
                              }
                        }
                  },
                  plugins: [{
                        afterDatasetUpdate: function(chart, args, options) {
                              const chartId = chart.canvas.id;
                              var i;
                              const legendId = `${chartId}-legend`;
                              const ul = document.createElement('ul');
                              for (i = 0; i < chart.data.datasets[0].data
                                    .length; i++) {
                                    ul.innerHTML += `
                <li>
                  <span style="background-color: ${chart.data.datasets[0].legendColor[i]}"></span>
                  ${chart.data.labels[i]}:  ${chart.data.datasets[0].data[i]} %
                </li>
              `;
                              }
                              return document.getElementById(legendId).appendChild(
                                    ul);
                        }
                  }]
            });
      }



      if ($("#inline-datepicker").length) {
            $('#inline-datepicker').datepicker({
                  enableOnReadonly: true,
                  todayHighlight: true,
            });
      }
      if ($.cookie('purple-pro-banner') != "true") {
            document.querySelector('#proBanner').classList.add('d-flex');
            document.querySelector('.navbar').classList.remove('fixed-top');
      } else {
            document.querySelector('#proBanner').classList.add('d-none');
            document.querySelector('.navbar').classList.add('fixed-top');
      }

      if ($(".navbar").hasClass("fixed-top")) {
            document.querySelector('.page-body-wrapper').classList.remove('pt-0');
            document.querySelector('.navbar').classList.remove('pt-5');
      } else {
            document.querySelector('.page-body-wrapper').classList.add('pt-0');
            document.querySelector('.navbar').classList.add('pt-5');
            document.querySelector('.navbar').classList.add('mt-3');

      }
      document.querySelector('#bannerClose').addEventListener('click', function() {
            document.querySelector('#proBanner').classList.add('d-none');
            document.querySelector('#proBanner').classList.remove('d-flex');
            document.querySelector('.navbar').classList.remove('pt-5');
            document.querySelector('.navbar').classList.add('fixed-top');
            document.querySelector('.page-body-wrapper').classList.add('proBanner-padding-top');
            document.querySelector('.navbar').classList.remove('mt-3');
            var date = new Date();
            date.setTime(date.getTime() + 24 * 60 * 60 * 1000);
            $.cookie('purple-pro-banner', "true", {
                  expires: date
            });
      });
})(jQuery);
</script>

<script>
var ctx = document.getElementById('lineChart').getContext('2d');
var myChart = new Chart(ctx, {
      type: 'line',
      data: {
            labels: @json($data['month']),
            datasets: [{
                  label: @json($salesYear),
                  data: @json($data['sales']),
                  backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                  ],
                  borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                  ],
                  borderWidth: 1,
                  fill: false
            }]
      },
      options: {
            scales: {
                  y: {
                        beginAtZero: false
                  }
            }
      }
});
</script>
@endsection