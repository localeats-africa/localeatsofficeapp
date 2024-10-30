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
                  <span class="text-info"> {{ $username }}</span> >>> Sales Insight  </span>
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

          <!-- filter dashboard  -->
          <div class="row ">
                  <form method="GET" action="{{ route('store') }}" name="submit"
                        enctype="multipart/form-data">
                        @csrf
                        {{csrf_field()}}
                        <div class="row text-end">
                        <h6>Filter record:</h6>
                              <div class="col-md-3">
                              </div>
                              <div class="col-md-3">
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

                              <div class="col-md-4 stretch-card grid-margin">
                                    <div class="card bg-gradient-secondary card-img-holder text-dark">
                                          <div class="card-body">
                                                <img src="{{ asset('assets/images/dashboard/circle.svg') }}"
                                                      class="card-img-absolute" alt="circle-image">
                                                <h4 class="font-weight-normal">Number Of Orders <i
                                                            class="mdi mdi-shopping  mdi-24px float-end"></i>
                                                </h4>
                                                <h2 class="mb-5">{{$countAllOrder}}</h2>
                                                <hr class="w-100">
                               
                                          </div>

                                    </div>
                              </div>

                              <div class="col-md-4 stretch-card grid-margin">
                                    <div class="card bg-secondary card-img-holder text-dark">
                                          <div class="card-body">
                                                <img src="{{ asset('assets/images/dashboard/circle.svg') }}"
                                                      class="card-img-absolute" alt="circle-image">
                                                <h4 class="font-weight-normal">Number Of Plates <i
                                                            class="fa fa-cutlery  mdi-24px float-end"></i>
                                                </h4>
                                                <h2 class="mb-5">{{$countAllPlate}}</h2>
                                                <hr class="w-100">
                                                
                                          </div>

                                    </div>
                              </div>


                        </div>
                        <!--row--->
                  </div>
            </div>
            <!--row-deck-->
                        <!--row-->
                        <div class="row row-cards">
                        <div class="col-md-4 stretch-card grid-margin">
                                    <div class="card bg-secondary card-img-holder text-dark">
                                          <div class="card-body">
                                                <img src="{{ asset('assets/images/dashboard/circle.svg') }}"
                                                      class="card-img-absolute" alt="circle-image">
                                                <h4 class="font-weight-normal">In-Store Sales<i
                                                            class="fa fa-cutlery  mdi-24px float-end"></i>
                                                </h4>
                                                <h2 class="mb-5">{{number_format($offlineSales)}}</h2>
                                                <hr class="w-100">
                                                
                                          </div>
                                    </div>
                              </div>

                              <div class="col-sm-4 col-12 stretch-card grid-margin">
                                    <div class="card bg-gradient-secondary card-img-holder text-dark">
                                          <div class="card-body">
                                                <img src="{{ asset('assets/images/dashboard/circle.svg')}}"
                                                      class="card-img-absolute" alt="circle-image">
                                                <h4 class="font-weight-normal">Total Onilne Sales
                                                      <i class="mdi mdi-cash mdi-24px float-end"></i>
                                                </h4>
                                                <h2 class="mb-5">₦{{number_format($payouts, 2)}}</h2>
                                                <hr class="w-100">
                                          </div>
                                    </div>
                              </div>

                              <div class="col-md-4 stretch-card grid-margin">
                                    <div class="card bg-secondary card-img-holder text-dark">
                                          <div class="card-body">
                                                <img src="{{ asset('assets/images/dashboard/circle.svg') }}"
                                                      class="card-img-absolute" alt="circle-image">
                                                <h4 class="font-weight-normal">Expenses<i
                                                            class="fa fa-cutlery  mdi-24px float-end"></i>
                                                </h4>
                                                <h2 class="mb-5">{{number_format($expenses)}}</h2>
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


                  </div>
            </div>

            <!---end Alert --->
        
            <!--- row--->
            <p></p>
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
            const bgColor1 = ["rgba(12, 81, 63, 1)"];
            const bgColor2 = ["rgba(255, 194, 68, 1"];
            const bgColor3 = ["rgba(162, 153, 149, 1)"];

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
                              }
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
                                    gradientStrokeGreen
                              ],
                              hoverBackgroundColor: [
                                    gradientStrokeBlue,
                                    gradientStrokeRed,
                                    gradientStrokeGreen

                              ],
                              borderColor: [
                                    gradientStrokeBlue,
                                    gradientStrokeRed,
                                    gradientStrokeGreen

                              ],
                              legendColor: [
                                    gradientLegendBlue,
                                    gradientLegendRed,
                                    gradientLegendGreen

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