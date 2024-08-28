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
                        Final Invoices
                  </h3>
            </div>

            <!--row-deck-->
            <p></p>
            <!--Alert here--->
            <div class="row ">
                  <div class="col-12">

                        @if(session('invoice-status'))
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
                                    <div> {!! session('invoice-status') !!}</div>
                              </div>
                              <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                        </div>
                        @endif
                  </div>
            </div>
            <!---end Alert --->

            <!-- filter dashboard  -->
            <div class="row ">
                  <form method="GET" action="{{ route('filter-all-invoices') }}" name="submit"
                        enctype="multipart/form-data">
                        @csrf
                        {{csrf_field()}}
                        <div class="row text-end">
                        <h6></h6>
                              <div class="col-md-3">
                              </div>
                              <div class="col-md-3">
                              </div>
                              
                              <div class="col-md-2 col-12">    
                              </div>

                              <div class="col-md-4 col-12">
                                    <div class="form-group">
                                          <div class="input-group">
                                                <span class="input-group-append">
                                                      <span class="input-group-text text-dark d-block">
                                                      Filter record:
                                                      </span>
                                                </span>
                                              
                                                <select class="js-example-basic-single text-secondary"
                                                      name="status" style="width:50%">
                                                      <option>Invoice Status</option>
                                                      <option value="paid">Paid</option>
                                                      <option value="pending ">UnPaid</option>
                                                </select>

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
                        <div class="row row-cards">

                              <div class="col-md-3 stretch-card grid-margin">
                                    <div class="card bg-gradient-success card-img-holder text-white">
                                          <div class="card-body">
                                                <img src="{{ asset('assets/images/dashboard/circle.svg')}}"
                                                      class="card-img-absolute" alt="circle-image">
                                                <h4 class="font-weight-normal">Paid Invoices <i
                                                            class="mdi mdi-cash mdi-24px float-end"></i>
                                                </h4>
                                                <h2 class="mb-5">{{$paidInvoice}}</h2>
                                                <hr class="w-100">
                                          </div>
                                    </div>
                              </div>
                              <div class="col-md-3 stretch-card grid-margin">
                                    <div class="card bg-gradient-secondary card-img-holder text-dark">
                                          <div class="card-body">
                                                <img src="{{ asset('assets/images/dashboard/circle.svg') }}"
                                                      class="card-img-absolute" alt="circle-image">
                                                <h4 class="font-weight-normal">Total Payout <i
                                                            class="mdi mdi-cash mdi-24px float-end"></i>
                                                </h4>
                                                <h2 class="mb-5">{{number_format($payout, 2)}}</h2>
                                                <hr class="w-100">
                                          </div>

                                    </div>
                              </div>
                              <div class="col-md-3 stretch-card grid-margin">
                                    <div class="card bg-gradient-warning card-img-holder text-dark">
                                          <div class="card-body">
                                                <img src="{{ asset('assets/images/dashboard/circle.svg') }}"
                                                      class="card-img-absolute" alt="circle-image">
                                                <h4 class="font-weight-normal">Unpaid Invoices <i
                                                            class="mdi mdi-cash mdi-24px float-end"></i>
                                                </h4>
                                                <h2 class="mb-5">{{$unPaidInvoice}}</h2>
                                                <hr class="w-100">
                                          </div>

                                    </div>
                              </div>

                              <div class="col-md-3 stretch-card grid-margin">
                                    <div class="card bg-gradient-secondary card-img-holder text-dark">
                                          <div class="card-body">
                                                <img src="{{ asset('assets/images/dashboard/circle.svg') }}"
                                                      class="card-img-absolute" alt="circle-image">
                                                <h4 class="font-weight-normal">Unpaid EVS <i
                                                            class="mdi mdi-cash mdi-24px float-end"></i>
                                                </h4>
                                                <h2 class="mb-5">{{number_format($unpaidEVS, 2)}}</h2>
                                                <hr class="w-100">
                                          </div>

                                    </div>
                              </div>

                        </div>
                  </div>
            </div>
            <p></p>
            <div class="row ">
                  <div class="col-12">
                        <div class="card">
                              <div class="card-header">
                                    <h3 class="card-title"> </h3>
                              </div>
                              <div class="card-body border-bottom py-3">
                                    <div class="d-flex">
                                          <div class="text-secondary">
                                                Show
                                                <div class="mx-2 d-inline-block">
                                                      <select id="pagination" class="form-control form-control-sm"
                                                            name="perPage">
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

                                                      <form action="{{ route('all-invoices') }}" method="GET"
                                                            role="search">
                                                            {{ csrf_field() }}
                                                            <div class="input-group mb-2">
                                                                  <input type="text" class="form-control"
                                                                        placeholder="Search for…" name="search">
                                                                  <button type="submit" class="btn"
                                                                        type="button">Go!</button>
                                                            </div>
                                                      </form>
                                                </div>
                                          </div>
                                    </div>
                              </div>

                              <div class="table-responsive " id="card">
                                    <table class="table table-striped card-table table-vcenter text-nowrap datatable"
                                          id="orders">
                                          <thead>
                                                <tr>
                                                      <th> Import Date </th>
                                                      <th>Vendor</th>
                                                      <th>Invoice Ref.</th>
                                                      <th>Payment Status</th>
                                                      <th></th>
                                                </tr>
                                          </thead>
                                          <tbody>
                                                @foreach($orders as $data)
                                                <tr>

                                                      <td>{{ date('d/m/Y', strtotime($data->created_at))}}</td>

                                                      <td class="text-sm">{{$data->vendor_name}}
                                                             </td>
                                                      <td>{{ $data->invoice_ref}}</td>
                                                      <td>
                                                            @if( $data->payment_status =='pending ')
                                                            <span
                                                                  class="badge badge-round bg-warning  text-dark text-capitalize">
                                                                  Unpaid</span>
                                                            @endif

                                                            @if( $data->payment_status =='paid')
                                                            <span
                                                                  class="badge badge-round bg-success  text-dark text-capitalize">
                                                                  {{ $data->payment_status}}</span>
                                                            @endif

                                                      </td>

                                                      <td class="">
                                                            <a href="invoice/{{$data->invoice_ref}}/{{$data->id}}"
                                                                  class="text-danger"><i class="fa fa-eye"></i></a>
                                                            @auth
                                                            @if(Auth::user()->role_id =='2')
                                                            <span class="text-end">
                                                                  &nbsp; &nbsp;
                                                                  <a href="computed-invoice/{{$data->id}}/{{$data->number_of_order_merge}}/{{$data->invoice_ref}}"
                                                                        class="text-danger"><i
                                                                              class="fa fa-edit"></i></a></span>
                                                            @endif
                                                            @endauth
                                                      </td>

                                                </tr>
                                                @endforeach

                                          </tbody>

                                    </table>
                              </div>
                              <div class="card-footer d-flex align-items-center">
                                    <p class="m-0 text-secondary">

                                          Showing
                                          {{ ($orders->currentPage() - 1) * $orders->perPage() + 1; }} to
                                          {{ min($orders->currentPage()* $orders->perPage(), $orders->total()) }}
                                          of
                                          {{$orders->total()}} entries
                                    </p>

                                    <ul class="pagination m-0 ms-auto">
                                          @if(isset($orders))
                                          @if($orders->currentPage() > 1)
                                          <li class="page-item ">
                                                <a class="page-link text-danger" href="{{ $orders->previousPageUrl() }}"
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
                                                {{ $orders->appends(compact('perPage'))->links()  }}
                                          </li>
                                          @if($orders->hasMorePages())
                                          <li class="page-item">
                                                <a class="page-link text-danger" href="{{ $orders->nextPageUrl() }}">
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
                        <!--- card-->
                  </div>
            </div>

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
<script src="{{ asset('assets/vendors/select2/select2.min.js')}}"></script>
<script src="{{ asset('assets/vendors/typeahead.js/typeahead.bundle.min.js')}}"></script>

<!-- endinject -->
<!-- Custom js for this page -->
<script src="{{ asset('assets/js/file-upload.js')}}"></script>
<script src="{{ asset('assets/js/typeahead.js')}}"></script>
<script src="{{ asset('assets/js/select2.js')}}"></script>
@endsection