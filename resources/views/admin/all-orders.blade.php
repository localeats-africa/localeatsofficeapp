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
                        Sales
                  </h3>
            </div>

            <p></p>
            <p></p>
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


                        @if(session('order-status'))
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
                                    <div> {!! session('order-status') !!}</div>
                              </div>
                              <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                        </div>
                        @endif

                  </div>
            </div>
            <!---end Alert --->
            <p></p>
            <form method="post" action="{{ route('setup') }}" name="submit" enctype="multipart/form-data">
                  @csrf
                  {{csrf_field()}}
                  <div class="row text-end">
                        <h6>Filter sales by vendor name:</h6>
                        <div class="col-md-6  col-12">
                              <div class="input-group ">
                                    <span class="input-group-append">
                                          <span class="input-group-text text-dark d-block">
                                                Vendor <i class="text-danger">*</i>
                                          </span>
                                    </span>
                                    <select class="js-example-basic-single text-secondary" style="width:70%"
                                          name="vendor" id="vendor">
                                          <option> Search
                                          </option>
                                          @foreach($vendor as $data)
                                          <option value="{{$data->id}}">
                                                {{$data->vendor_name}}</option>
                                          @endforeach
                                    </select>
                                    <span class="input-group-append">
                                                <span class="input-group-text bg-light d-block">
                                                   
                                                </span>
                                          </span>
                              </div>


                        </div>

                        <div class="col-md-3 col-12">
                              <div class="form-group">
                                    <div class="input-group ">
                                          <span class="input-group-append">
                                                <span class="input-group-text text-dark d-block">
                                                      Start
                                                </span>
                                          </span>
                                          <input type="text" value="" name="from" class="form-control" placeholder=""
                                                id="from" />
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
                                    <div class="input-group ">
                                          <span class="input-group-append">
                                                <span class="input-group-text text-dark d-block">
                                                      End
                                                </span>
                                          </span>
                                          <input type="text" value="" name="to" class="form-control" placeholder=""
                                                id="to" />
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

                  <!--- row---->

            </form>

            <p></p>
            <div class="row ">
                  <div class="col-12">
                        <div class="card">
                              <div class="card-header">
                                    <h4 class="card-title"> </h4>
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

                                                      <form action="{{ route('all-orders') }}" method="GET"
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
                                                      <th>Import Date</th>
                                                      <th>Order Ref.</th>
                                                      <th>Platform</th>
                                                      <th>Vendors</th>

                                                      <th>Item (s)</th>
                                                      <th>Amount</th>
                                                      <th>Food Price</th>
                                                      <th>Extra</th>
                                                      <th>Delivery Date</th>
                                                      <th>Posted By</th>
                                                </tr>
                                          </thead>
                                          <tbody>
                                                @foreach($orders as $data)
                                                <tr>
                                                      <td>{{ date('Y-m-d', strtotime($data->created_at))}}</td>
                                                      <td>{{$data->order_ref}}</td>
                                                      <td class="text-capitalize">{{$data->name}}</td>
                                                      <td class="text-capitalize">{{$data->vendor_name}}</td>

                                                      <td width="50%" style="white-space:wrap; line-height:1.6"> {!!
                                                            nl2br($data->description) !!}</td>
                                                      <td>{{$data->order_amount}}</td>
                                                      <td>{{$data->food_price}}</td>
                                                      <td>{{$data->extra}}</td>
                                                      <td>{{ date('Y-m-d', strtotime($data->delivery_date))}}
                                                      </td>
                                                      <td class="text-capitalize">{{$data->fullname}}</td>


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
      <!--- content wrapper---->
</div>
<!-- main-panel -->

<script src="{{ asset('assets/vendors/select2/select2.min.js')}}"></script>
<script src="{{ asset('assets/vendors/typeahead.js/typeahead.bundle.min.js')}}"></script>

<!-- endinject -->
<!-- Custom js for this page -->
<script src="{{ asset('assets/js/file-upload.js')}}"></script>
<script src="{{ asset('assets/js/typeahead.js')}}"></script>
<script src="{{ asset('assets/js/select2.js')}}"></script>
<!-- End custom js for this page -->
@endsection