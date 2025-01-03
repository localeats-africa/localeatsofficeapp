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
                        <span class="text-info"> {{ $username }}</span> >>> Sales Insight </span>
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
                  <form method="GET" action="{{ route('store') }}" name="submit" enctype="multipart/form-data">
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

            <!--row-->
            <div class="row row-cards">
                  <div class="col-md-4 stretch-card grid-margin">
                        <div class="card bg-secondary card-img-holder text-dark">
                              <div class="card-body">
                                    <img src="{{ asset('assets/images/dashboard/circle.svg') }}"
                                          class="card-img-absolute" alt="circle-image">
                                    <h4 class="font-weight-normal">Total In-Store Sales<i
                                                class="fa fa-cutlery  mdi-24px float-end"></i>
                                    </h4>
                                    <h2 class="mb-5">₦{{number_format($offlineSales)}}</h2>
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
                                    <h2 class="mb-5">₦{{number_format($payouts)}}</h2>
                                    <hr class="w-100">
                              </div>
                        </div>
                  </div>

                  <div class="col-md-4 stretch-card grid-margin">
                        <div class="card bg-secondary card-img-holder text-dark">
                              <div class="card-body">
                                    <img src="{{ asset('assets/images/dashboard/circle.svg') }}"
                                          class="card-img-absolute" alt="circle-image">
                                    <h4 class="font-weight-normal">Expenses
                                          <i class="mdi mdi-cash mdi-24px float-end"></i>
                                    </h4>
                                    <h2 class="mb-5">₦{{number_format($expenses)}}</h2>
                                    <hr class="w-100">

                              </div>

                        </div>
                  </div>

            </div>
            <!--row--->

            <div class="row ">
                  <div class="col-12">
                        <div class="row row-cards">

                              <div class="col-md-4 stretch-card grid-margin">
                                    <div class="card bg-secondary card-img-holder text-dark">
                                          <div class="card-body">
                                                <img src="{{ asset('assets/images/dashboard/circle.svg') }}"
                                                      class="card-img-absolute" alt="circle-image">
                                                <h4 class="font-weight-normal">Profit/Loss
                                                      <i class="mdi mdi-24px float-end">
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
                                                <h2 class="mb-5">₦{{number_format($profitLoss)}}</h2>
                                                <hr class="w-100">

                                          </div>

                                    </div>
                              </div>

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

<!-- End custom js for this page -->

<script>
$(function() {
      $("#from").datepicker();
});

$(function() {
      $("#to").datepicker();
});
</script>


@endsection