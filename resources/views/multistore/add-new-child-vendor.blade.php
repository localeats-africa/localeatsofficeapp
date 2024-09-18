@extends('layouts.head')
@extends('layouts.header')
@extends('layouts.sidebar')
@extends('layouts.footer')
@section('content')
<!-- partial -->
<div class="main-panel">
      <div class="content-wrapper">
            <div class="page-header">
                  <h3 class="page-title"> Add New Outlet >>> to >>> <span class="text-info">{{$vendorName}}</span></h3>
            </div>
            <!--Alert here--->
            <div class="row">
                  <div class="col-12">

                        @if(session('add-vendor'))
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
                                    <div> {!! session('add-vendor') !!}</div>
                              </div>
                              <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                        </div>
                        @endif

                        @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible" role="alert">
                              <div class="d-flex">
                                    <div>
                                          <!-- Download SVG icon from http://tabler-icons.io/i/alert-circle -->
                                          <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon" width="24"
                                                height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                fill="none" stroke-linecap="round" stroke-linejoin="round">
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

                  </div>
            </div>
            <!---end Alert --->

            <div class="row">
            </div>
            <!---end row --->
         
            <form method="post" action="{{ route('add-child-vendor') }}" name="submit" enctype="multipart/form-data">
                  @csrf
                  {{csrf_field()}}
                  <div class="row">
                        <div class="col-md-4 grid-margin stretch-card">
                              <div class="card">
                                    <div class="card-body">
                                          <div class="form-label required">Business Name <i class="text-danger">*</i>
                                          </div>
                                          <input type="text" class="form-control" name="store_name" placeholder=""
                                                value="">
                                          @error('vendor_name')
                                          <div class="alert alert-danger alert-dismissible" role="alert">
                                                <div class="d-flex">
                                                      <div>
                                                            <!-- Download SVG icon from http://tabler-icons.io/i/alert-circle -->
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                  class="icon alert-icon" width="24" height="24"
                                                                  viewBox="0 0 24 24" stroke-width="2"
                                                                  stroke="currentColor" fill="none"
                                                                  stroke-linecap="round" stroke-linejoin="round">
                                                                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                  <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                                                  <path d="M12 8v4" />
                                                                  <path d="M12 16h.01" />
                                                            </svg>
                                                      </div>
                                                      <div>
                                                            {{ $message }}
                                                      </div>
                                                </div>
                                                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                                          </div>
                                          @enderror
                                    </div>
                              </div>
                        </div>

                        <div class="col-md-4 grid-margin stretch-card">
                              <div class="card">
                                    <div class="card-body">
                                          <div class="form-label required">Restaurant Type <i class="text-danger">*</i>
                                          </div>
                                          <select class="js-example-basic-single" style="width:100%"
                                                name="restaurant_type">
                                                <option>Search</option>
                                                @foreach($selectRestaurantType as $store)
                                                <option value="{{$store->id}}">
                                                      {{$store->restaurant_type}}</option>
                                                @endforeach
                                          </select>
                                          @error('restaurant_type')
                                          <div class="alert alert-danger alert-dismissible" role="alert">
                                                <div class="d-flex">
                                                      <div>
                                                            <!-- Download SVG icon from http://tabler-icons.io/i/alert-circle -->
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                  class="icon alert-icon" width="24" height="24"
                                                                  viewBox="0 0 24 24" stroke-width="2"
                                                                  stroke="currentColor" fill="none"
                                                                  stroke-linecap="round" stroke-linejoin="round">
                                                                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                  <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                                                  <path d="M12 8v4" />
                                                                  <path d="M12 16h.01" />
                                                            </svg>
                                                      </div>
                                                      <div>
                                                            {{ $message }}
                                                      </div>
                                                </div>
                                                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                                          </div>
                                          @enderror
                                    </div>
                              </div>
                        </div>

                        <div class="col-md-4 grid-margin stretch-card">
                              <div class="card">
                                    <div class="card-body">
                                          <div class="form-label required">Select Food Type (s) <i class="text-danger">*</i>
                                          </div>
                                          <option>Search</option>
                                          <select class="js-example-basic-single"
                                                style="width:100%" name="food_type">

                                                @foreach($selectFoodType as $food)
                                                <option value="{{$food->food_type}}">
                                                      {{$food->food_type}}</option>
                                                @endforeach
                                          </select>
                                          @error('food_type')
                                          <div class="alert alert-danger alert-dismissible" role="alert">
                                                <div class="d-flex">
                                                      <div>
                                                            <!-- Download SVG icon from http://tabler-icons.io/i/alert-circle -->
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                  class="icon alert-icon" width="24" height="24"
                                                                  viewBox="0 0 24 24" stroke-width="2"
                                                                  stroke="currentColor" fill="none"
                                                                  stroke-linecap="round" stroke-linejoin="round">
                                                                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                  <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                                                  <path d="M12 8v4" />
                                                                  <path d="M12 16h.01" />
                                                            </svg>
                                                      </div>
                                                      <div>
                                                            {{ $message }}
                                                      </div>
                                                </div>
                                                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                                          </div>
                                          @enderror
                                    </div>
                              </div>
                        </div>


                        <div class="col-md-6 col-12 grid-margin stretch-card">
                              <div class="card">
                                    <div class="card-body">
                                          <div class="form-label required">Number of store location <i class="text-danger">*</i>
                                          </div>
                                          <div class="value-button" id="decrease" onclick="decreaseStore()"
                                                value="decrease Value">-</div>
                                          <input type="number" name="number_of_store_location" value="1" id="min">

                                          <div class="value-button" id="increase" onclick="increaseStore()"
                                                value="Increase Value">+</div>
                                          @error('number_of_store_location')
                                          <div class="alert alert-danger alert-dismissible" role="alert">
                                                <div class="d-flex">
                                                      <div>
                                                            <!-- Download SVG icon from http://tabler-icons.io/i/alert-circle -->
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                  class="icon alert-icon" width="24" height="24"
                                                                  viewBox="0 0 24 24" stroke-width="2"
                                                                  stroke="currentColor" fill="none"
                                                                  stroke-linecap="round" stroke-linejoin="round">
                                                                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                  <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                                                  <path d="M12 8v4" />
                                                                  <path d="M12 16h.01" />
                                                            </svg>
                                                      </div>
                                                      <div>
                                                            {{ $message }}
                                                      </div>
                                                </div>
                                                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                                          </div>
                                          @enderror
                                    </div>
                              </div>
                        </div>


                        <div class="col-md-6 col-12 grid-margin stretch-card">
                              <div class="card">
                                    <div class="card-body">
                                          <div class="form-label required">Delivery Time <i class="text-danger">*</i>
                                          </div>
                                          <input type="hidden" name="delivery_time" id="gtime" value="">

                                          <div class="value"></div>
                                          <input type='range' min='3' max='90' value='30' step='1' class='val'
                                                id='r1' />

                                          @error('delivery_time')
                                          <div class="alert alert-danger alert-dismissible" role="alert">
                                                <div class="d-flex">
                                                      <div>
                                                            <!-- Download SVG icon from http://tabler-icons.io/i/alert-circle -->
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                  class="icon alert-icon" width="24" height="24"
                                                                  viewBox="0 0 24 24" stroke-width="2"
                                                                  stroke="currentColor" fill="none"
                                                                  stroke-linecap="round" stroke-linejoin="round">
                                                                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                  <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                                                  <path d="M12 8v4" />
                                                                  <path d="M12 16h.01" />
                                                            </svg>
                                                      </div>
                                                      <div>
                                                            {{ $message }}
                                                      </div>
                                                </div>
                                                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                                          </div>
                                          @enderror
                                    </div>
                              </div>
                        </div>

                        <div class="col-md-12 col-12 grid-margin stretch-card">
                              <div class="card">
                                    <div class="card-body">
                                          <div class="form-label required">Store Address <i class="text-danger">*</i>
                                          </div>
                                          <input type="text" class="form-control" name="address" placeholder=""
                                                value="">
                                          @error('address')
                                          <div class="alert alert-danger alert-dismissible" role="alert">
                                                <div class="d-flex">
                                                      <div>
                                                            <!-- Download SVG icon from http://tabler-icons.io/i/alert-circle -->
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                  class="icon alert-icon" width="24" height="24"
                                                                  viewBox="0 0 24 24" stroke-width="2"
                                                                  stroke="currentColor" fill="none"
                                                                  stroke-linecap="round" stroke-linejoin="round">
                                                                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                  <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                                                  <path d="M12 8v4" />
                                                                  <path d="M12 16h.01" />
                                                            </svg>
                                                      </div>
                                                      <div>
                                                            {{ $message }}
                                                      </div>
                                                </div>
                                                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                                          </div>
                                          @enderror
                                    </div>
                              </div>
                        </div>
                        <div class="col-md-4 col-12 grid-margin stretch-card">
                              <div class="card">
                                    <div class="card-body">
                                          <div class="form-label required">Store Area / Location <i class="text-danger">*</i>
                                          </div>
                                                <select class="js-example-basic-single2 text-secondary" style="width:100%" name="area" >
                                                <option value="">Choose</option>
                                                @foreach($location as $data)
                                                <option value="{{$data->id}}">
                                                      {{$data->area}}
                                                </option>
                                                @endforeach
                                          </select>
                                          @error('area')
                                          <div class="alert alert-danger alert-dismissible" role="alert">
                                                <div class="d-flex">
                                                      <div>
                                                            <!-- Download SVG icon from http://tabler-icons.io/i/alert-circle -->
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                  class="icon alert-icon" width="24" height="24"
                                                                  viewBox="0 0 24 24" stroke-width="2"
                                                                  stroke="currentColor" fill="none"
                                                                  stroke-linecap="round" stroke-linejoin="round">
                                                                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                  <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                                                  <path d="M12 8v4" />
                                                                  <path d="M12 16h.01" />
                                                            </svg>
                                                      </div>
                                                      <div>
                                                            {{ $message }}
                                                      </div>
                                                </div>
                                                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                                          </div>
                                          @enderror
                                    </div>
                              </div>
                        </div>

                        <div class="col-md-4 col-12 grid-margin stretch-card">
                              <div class="card">
                                    <div class="card-body">
                                          <div class="form-label required">State <i class="text-danger">*</i>
                                          </div>
                                          <select  class="js-example-basic-single" style="width:100%" name="state" id="">
                                          <option value="">Choose</option>     
                                          @foreach($state as $data)
                                                <option value="{{$data->id}}">{{$data->state}}</option>
                                                @endforeach
                                          </select>
                                          @error('state')
                                          <div class="alert alert-danger alert-dismissible" role="alert">
                                                <div class="d-flex">
                                                      <div>
                                                            <!-- Download SVG icon from http://tabler-icons.io/i/alert-circle -->
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                  class="icon alert-icon" width="24" height="24"
                                                                  viewBox="0 0 24 24" stroke-width="2"
                                                                  stroke="currentColor" fill="none"
                                                                  stroke-linecap="round" stroke-linejoin="round">
                                                                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                  <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                                                  <path d="M12 8v4" />
                                                                  <path d="M12 16h.01" />
                                                            </svg>
                                                      </div>
                                                      <div>
                                                            {{ $message }}
                                                      </div>
                                                </div>
                                                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                                          </div>
                                          @enderror
                                    </div>
                              </div>
                        </div>

                        <div class="col-md-4 col-12 grid-margin stretch-card">
                              <div class="card">
                                    <div class="card-body">
                                          <div class="form-label required">Country
                                          </div>
                                          <select class="form-control" name="country" id="">
                                                <option value="{{$countryID}}">{{$country}}</option>
                                          </select>
                                          @error('country')
                                          <div class="alert alert-danger alert-dismissible" role="alert">
                                                <div class="d-flex">
                                                      <div>
                                                            <!-- Download SVG icon from http://tabler-icons.io/i/alert-circle -->
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                  class="icon alert-icon" width="24" height="24"
                                                                  viewBox="0 0 24 24" stroke-width="2"
                                                                  stroke="currentColor" fill="none"
                                                                  stroke-linecap="round" stroke-linejoin="round">
                                                                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                  <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                                                  <path d="M12 8v4" />
                                                                  <path d="M12 16h.01" />
                                                            </svg>
                                                      </div>
                                                      <div>
                                                            {{ $message }}
                                                      </div>
                                                </div>
                                                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                                          </div>
                                          @enderror
                                    </div>
                              </div>
                        </div>

                        <div class="col-md-12 col-12 grid-margin stretch-card">
                              <div class="card">
                                    <div class="card-body">
                                          <div class="form-label required">Store Description
                                          </div>
                                          <input type="text" class="form-control" name="description" placeholder=""
                                                value="">
                                          @error('description')
                                          <div class="alert alert-danger alert-dismissible" role="alert">
                                                <div class="d-flex">
                                                      <div>
                                                            <!-- Download SVG icon from http://tabler-icons.io/i/alert-circle -->
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                  class="icon alert-icon" width="24" height="24"
                                                                  viewBox="0 0 24 24" stroke-width="2"
                                                                  stroke="currentColor" fill="none"
                                                                  stroke-linecap="round" stroke-linejoin="round">
                                                                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                  <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                                                  <path d="M12 8v4" />
                                                                  <path d="M12 16h.01" />
                                                            </svg>
                                                      </div>
                                                      <div>
                                                            {{ $message }}
                                                      </div>
                                                </div>
                                                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                                          </div>
                                          @enderror
                                    </div>
                              </div>
                        </div>

                       
                  </div>
                  <!-- row -->

                  <div class="row">
                        <h4>Contact Person:</h4>

                        <div class="col-md-6 col-12 grid-margin stretch-card">
                              <div class="card">
                                    <div class="card-body">
                                          <div class="form-label required">First Name <i class="text-danger">*</i>
                                          </div>
                                          <input type="text" class="form-control" name="first_name" placeholder=""
                                                value="">
                                          @error('first_name')
                                          <div class="alert alert-danger alert-dismissible" role="alert">
                                                <div class="d-flex">
                                                      <div>
                                                            <!-- Download SVG icon from http://tabler-icons.io/i/alert-circle -->
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                  class="icon alert-icon" width="24" height="24"
                                                                  viewBox="0 0 24 24" stroke-width="2"
                                                                  stroke="currentColor" fill="none"
                                                                  stroke-linecap="round" stroke-linejoin="round">
                                                                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                  <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                                                  <path d="M12 8v4" />
                                                                  <path d="M12 16h.01" />
                                                            </svg>
                                                      </div>
                                                      <div>
                                                            {{ $message }}
                                                      </div>
                                                </div>
                                                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                                          </div>
                                          @enderror
                                    </div>
                              </div>
                        </div>

                        <div class="col-md-6 col-12 grid-margin stretch-card">
                              <div class="card">
                                    <div class="card-body">
                                          <div class="form-label required">Last Name <i class="text-danger">*</i>
                                          </div>
                                          <input type="text" class="form-control" name="last_name" placeholder=""
                                                value="">
                                          @error('last_name')
                                          <div class="alert alert-danger alert-dismissible" role="alert">
                                                <div class="d-flex">
                                                      <div>
                                                            <!-- Download SVG icon from http://tabler-icons.io/i/alert-circle -->
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                  class="icon alert-icon" width="24" height="24"
                                                                  viewBox="0 0 24 24" stroke-width="2"
                                                                  stroke="currentColor" fill="none"
                                                                  stroke-linecap="round" stroke-linejoin="round">
                                                                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                  <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                                                  <path d="M12 8v4" />
                                                                  <path d="M12 16h.01" />
                                                            </svg>
                                                      </div>
                                                      <div>
                                                            {{ $message }}
                                                      </div>
                                                </div>
                                                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                                          </div>
                                          @enderror
                                    </div>
                              </div>
                        </div>


                        <div class="col-md-6 col-12 grid-margin stretch-card">
                              <div class="card">
                                    <div class="card-body">
                                          <div class="form-label required">Mobile <i class="text-danger">*</i>
                                          </div>
                                          <input type="text" class="form-control" name="phone" placeholder="" value="">
                                          @error('phone')
                                          <div class="alert alert-danger alert-dismissible" role="alert">
                                                <div class="d-flex">
                                                      <div>
                                                            <!-- Download SVG icon from http://tabler-icons.io/i/alert-circle -->
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                  class="icon alert-icon" width="24" height="24"
                                                                  viewBox="0 0 24 24" stroke-width="2"
                                                                  stroke="currentColor" fill="none"
                                                                  stroke-linecap="round" stroke-linejoin="round">
                                                                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                  <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                                                  <path d="M12 8v4" />
                                                                  <path d="M12 16h.01" />
                                                            </svg>
                                                      </div>
                                                      <div>
                                                            {{ $message }}
                                                      </div>
                                                </div>
                                                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                                          </div>
                                          @enderror
                                    </div>
                              </div>
                        </div>

                        <div class="col-md-6 col-12 grid-margin stretch-card">
                              <div class="card">
                                    <div class="card-body">
                                          <div class="form-label required">Email
                                          </div>
                                          <input type="email" class="form-control" name="email" placeholder="" value="">
                                          @error('email')
                                          <div class="alert alert-danger alert-dismissible" role="alert">
                                                <div class="d-flex">
                                                      <div>
                                                            <!-- Download SVG icon from http://tabler-icons.io/i/alert-circle -->
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                  class="icon alert-icon" width="24" height="24"
                                                                  viewBox="0 0 24 24" stroke-width="2"
                                                                  stroke="currentColor" fill="none"
                                                                  stroke-linecap="round" stroke-linejoin="round">
                                                                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                  <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                                                  <path d="M12 8v4" />
                                                                  <path d="M12 16h.01" />
                                                            </svg>
                                                      </div>
                                                      <div>
                                                            {{ $message }}
                                                      </div>
                                                </div>
                                                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                                          </div>
                                          @enderror
                                    </div>
                              </div>
                        </div>



                  </div>
                  <!-- row -->

                  <div class="row">
                        <div class="col-md-4 col-12 grid-margin stretch-card">
                              <div class="card">
                                    <div class="card-body">
                                          <div class="form-label required">Bank Name 
                                          </div>

                                          <select class="js-example-basic-single" style="width:100%" name="bankName"
                                                id="bank">
                                                <option>Search for bank
                                                </option>
                                                @foreach($selectBankName as $bank)
                                                <option value="{{$bank->code}}">
                                                      {{$bank->name}}</option>
                                                @endforeach
                                          </select>
                                          

                                          @error('bankName')
                                          <div class="alert alert-danger alert-dismissible" role="alert">
                                                <div class="d-flex">
                                                      <div>
                                                            <!-- Download SVG icon from http://tabler-icons.io/i/alert-circle -->
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                  class="icon alert-icon" width="24" height="24"
                                                                  viewBox="0 0 24 24" stroke-width="2"
                                                                  stroke="currentColor" fill="none"
                                                                  stroke-linecap="round" stroke-linejoin="round">
                                                                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                  <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                                                  <path d="M12 8v4" />
                                                                  <path d="M12 16h.01" />
                                                            </svg>
                                                      </div>
                                                      <div>
                                                            {{ $message }}
                                                      </div>
                                                </div>
                                                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                                          </div>
                                          @enderror
                                    </div>
                              </div>
                        </div>


                        <div class="col-md-4 col-12 grid-margin stretch-card">
                              <div class="card">
                                    <div class="card-body">
                                          <div class="form-label required">Account Number</div>
                                          <input type="text" class="form-control" name="accountNumber"
                                                placeholder="Valid account number only " value="" id="accountNumber"
                                                maxlength="10" onkeyup="check_account_number()">
                                          <!---account number validation error --->
                                          <span class="" id="check_account"></span>
                                          <span class="text-danger" id="accountError"></span>
                                         
                                          <div class="progress" id="show-progress" style="display:none;">
                                                <div class="progress-bar progress-bar-striped  progress-bar-animated"
                                                      role="progressbar" aria-valuenow="75" aria-valuemin="0"
                                                      aria-valuemax="100" style="width: 75%"></div>
                                          </div>

                                          <!--- end validation error --->
                                          @error('accountNumber')
                                          <div class="alert alert-danger alert-dismissible" role="alert">
                                                <div class="d-flex">
                                                      <div>
                                                            <!-- Download SVG icon from http://tabler-icons.io/i/alert-circle -->
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                  class="icon alert-icon" width="24" height="24"
                                                                  viewBox="0 0 24 24" stroke-width="2"
                                                                  stroke="currentColor" fill="none"
                                                                  stroke-linecap="round" stroke-linejoin="round">
                                                                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                  <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                                                  <path d="M12 8v4" />
                                                                  <path d="M12 16h.01" />
                                                            </svg>
                                                      </div>
                                                      <div>
                                                            {{ $message }}
                                                      </div>
                                                </div>
                                                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                                          </div>
                                          @enderror
                                    </div>
                              </div>
                        </div>


                        <div class="col-md-4 col-12 grid-margin stretch-card">
                              <div class="card">
                                    <div class="card-body">
                                          <div class="form-label">Account Name </div>
                                          <input type="hidden" class="form-control text-muted-fg bg-muted"
                                                name="accountName" id="showName" value="">
                                          <input class="form-control " id="showName2" disabled="" value="">

                                          @error('accountName')
                                          <div class="alert alert-danger alert-dismissible" role="alert">
                                                <div class="d-flex">
                                                      <div>
                                                            <!-- Download SVG icon from http://tabler-icons.io/i/alert-circle -->
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                  class="icon alert-icon" width="24" height="24"
                                                                  viewBox="0 0 24 24" stroke-width="2"
                                                                  stroke="currentColor" fill="none"
                                                                  stroke-linecap="round" stroke-linejoin="round">
                                                                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                  <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                                                  <path d="M12 8v4" />
                                                                  <path d="M12 16h.01" />
                                                            </svg>
                                                      </div>
                                                      <div>
                                                            {{ $message }}
                                                      </div>
                                                </div>
                                                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                                          </div>
                                          @enderror
                                    </div>
                              </div>
                        </div>

                  </div>
                  <!-- row -->
                  <div class="row">
                        <p></p>
                        <div class="col-md-6">
                              <input type="hidden" value="{{$parent_id}}">
                        </div>
                        <div class="col-md-6 col-12 grid-margin stretch-card justify-content-end">

                              <!-- send button here -->
                              <div class="card-footer bg-transparent mt-auto">
                                    <div class="btn-list ">
                                          <button type="submit" name="submit"
                                                class="btn bg-gradient-primary  text-white">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                      class="icon icon-tabler icon-tabler-device-floppy" width="24"
                                                      height="24" viewBox="0 0 24 24" stroke-width="1.5"
                                                      stroke="currentColor" fill="none" stroke-linecap="round"
                                                      stroke-linejoin="round">
                                                      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                      <path
                                                            d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" />
                                                      <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                                      <path d="M14 4l0 4l-6 0l0 -4" />
                                                </svg>
                                                Submit
                                          </button>
                                    </div>
                              </div>

                        </div>
                  </div>
                  <!-- row -->


            </form>
      </div>

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
<!-- main-panel ends -->



<script>
// number of store locations
function increaseStore() {
      var value = parseInt(document.getElementById('min').value, 10);
      value = isNaN(value) ? 0 : value;
      value++;
      document.getElementById('min').value = value;
}

function decreaseStore() {
      var value = parseInt(document.getElementById('min').value, 10);
      value = isNaN(value) ? 0 : value;
      value < 1 ? value = 1 : '';
      value--;
      document.getElementById('min').value = value;
}


function increaseTime() {
      var value = parseInt(document.getElementById('time').value, 10);
      value = isNaN(value) ? 0 : value;
      value++;
      document.getElementById('time').value = value;
}

function decreaseTime() {
      var value = parseInt(document.getElementById('time').value, 10);
      value = isNaN(value) ? 0 : value;
      value < 1 ? value = 1 : '';
      value--;
      document.getElementById('time').value = value;
}
</script>


<script>
var elem = document.querySelector('input[type="range"]');

var rangeValue = function() {
      var newValue = elem.value;
      var target = document.querySelector('.value');
      var gtime = document.getElementById('gtime');
      target.innerHTML = newValue;
      gtime.value = newValue;
}

elem.addEventListener("input", rangeValue);
</script>


<script>
function check_account_number() {
      let account = document.getElementById('accountNumber').value;
      let bankCode = document.getElementById('bank').value;
      let accountNumber = document.getElementById('accountNumber').value;
      document.getElementById('show-progress').style.display = 'none';



      if (account.length < 10) {

            document.getElementById('show-progress').style.display = 'none';
            document.getElementById('check_account').style.color = 'red';
            document.getElementById('check_account').innerHTML = '☒ account number must be 10 digits ';


      } else {

            document.getElementById('check_account').innerHTML = ' ';
            document.getElementById('show-progress').style.display = '';


            // Make the fetch request with the variables
            //Test secret key: sk_test_b665e0b51fe5f6df4ea0f29a56d8d84b74eca251
            //live secret key : sk_live_883a3c48aa5da65d6793526046220d82ea0f1c16
            const fetchPromise =
                  fetch("https://api.paystack.co/bank/resolve?account_number=" + accountNumber + "&bank_code=" +
                        bankCode, {
                              headers: {
                                    Authorization: 'Bearer sk_live_883a3c48aa5da65d6793526046220d82ea0f1c16'
                              }
                        });
            // Timeout after 120 seconds//  2 min
            const timeoutId = setTimeout(() => {
                  controller.abort(); // Abort the fetch request
                  console.log('Timed out');
            }, 120000);

            // Handle the fetch request
            fetchPromise
                  .then(response => {
                        // Check if the request was successful
                        if (!response.ok) {
                              throw new Error('Slow network!');
                        }
                        // Parse the response as JSON
                        return response.json();
                  })
                  .then(data => {
                        // Handle the JSON data
                        console.log(data.data.account_name);

                        document.getElementById('show-progress').style.display = 'none';
                        document.getElementById('check_account').style.color = 'green';
                        document.getElementById('check_account').innerHTML = '☒ validated ';

                        document.getElementById('showName').value = data.data.account_name;
                        document.getElementById('showName2').value = data.data.account_name;


                  })
                  .catch(error => {
                        // Handle any errors that occurred during the fetch
                        console.error('Fetch error:', error);
                        document.getElementById('accountError').innerHTML = error;
                  })
                  .finally(() => {
                        clearTimeout(timeoutId); // Clear the timeout
                  });
      }
}
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
<!-- container-scroller -->