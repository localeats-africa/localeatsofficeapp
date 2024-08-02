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
                       Create Offline FoodMenu
                  </h3>
            </div>

            <p></p>
            <!--Alert here--->
            <div class="row ">
                  <div class="col-12">
                        @if(session('expense-status'))
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
                                    <div> {!! session('expense-status') !!}</div>
                              </div>
                              <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                        </div>
                        @endif


                        @if(session('expense-error'))
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
                                    <div> {!! session('expense-error') !!}</div>
                              </div>
                              <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                        </div>
                        @endif


                  </div>
            </div>
            <!---end Alert --->

            <div class="row ">

            <form method="post" action="{{ route('add-offline-foodmenu') }}" name="submit" enctype="multipart/form-data">
                  @csrf
                  {{csrf_field()}}
                        <div class="row">
                              <div class="col-md-4 col-12">
                                    <div class="form-group">
                                    <label for="">Vendor</label>
                                    <br>
                                    <select class="js-example-basic-single text-secondary" style="width:100%"
                                          name="vendor" id="vendor">
                                          <option>Choose</option>
                                          @foreach($vendor as $data)
                                          <option value="{{$data->id}}">
                                                {{$data->vendor_name}}
                                          </option>
                                          @endforeach
                                    </select>
                                    </div>
                              </div>

                              <div class="col-md-8 col-12">
                                    <div class="form-group">
                                    <label for="">FoodMenu / Item</label>
                                    <br>
                                    <div class="input-group date">
                                          <input type="text" class="form-control" name="item" placeholder="Enter expenses" />
                                          <button type="submit" name="submit"
                                          class="btn bg-gradient-primary btn-sm  text-white">Submit</button>
                                    </div>
                                    </div>
                              </div>

                              

                        </div>
                        <!---end row--->
                  </form>
            </div>
            <!---end row --->

<!---bulk Upload--->
<p>
            <h4>Bulk Upload:</h4>
            </p>
            <div class="row">
                  <div class="col-md-12  text-danger ">
                        <small><b>How to upload bulk foodmenu list; A single spreedsheet save with vendor/store name</b></small>
                        <!-- <p> <img src="/assets/images/bulk-upload-food-menu.png" alt="" style="width:100%;"></p> -->

                  </div>
                  <p></p>
            </div>
            <form method="post" action="{{ route('import-offline-foodmenu') }}" name="submit" enctype="multipart/form-data">
                  @csrf
                  <div class="row ">
                        <div class="col-md-6 grid-margin stretch-card">
                              <div class="card">
                                    <div class="card-body ">
                                          <div class="form-label ">Choose a vendor <i class="text-danger">*</i>
                                          </div>
                                          <select class="js-example-basic-single2" style="width:100%" name="vendor_name"
                                                id="vendor2">
                                                <option> search </option>
                                                @foreach($vendor as $data)
                                                <option value="{{$data->id}}">
                                                      {{$data->vendor_name}}</option>
                                                @endforeach
                                          </select>

                                    </div>
                                    @error('vendor_name')
                                    <div class="alert alert-danger alert-dismissible" role="alert">
                                          <div class="d-flex">
                                                <div>
                                                      <!-- Download SVG icon from http://tabler-icons.io/i/alert-circle -->
                                                      <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon"
                                                            width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                            stroke="currentColor" fill="none" stroke-linecap="round"
                                                            stroke-linejoin="round">
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
                        <div class="col-md-6 grid-margin stretch-card">

                              <div class="card">
                                    <div class="card-body">
                                          <div class="form-group">

                                                <label>Import Excel File <i class="text-danger">*</i></label>
                                                <input type="file" name="file" accept=".xlsx,.xls"
                                                      class="file-upload-default" id="file">
                                                <div class="input-group col-xs-12">
                                                      <input type="text" class="form-control file-upload-info"
                                                            disabled="" placeholder=". xlsx, .xls">
                                                      <span class="input-group-append">
                                                            <button
                                                                  class="file-upload-browse btn btn-sm  bg-gradient-dark  text-white py-3"
                                                                  type="button"> <i
                                                                        class="mdi mdi-cloud-braces fs-24 menu-icon"></i></button>
                                                      </span>
                                                </div>


                                          </div>
                                          @error('file')
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

                  <!-- row -->
                  <div class="row">
                        <div class="col-md-6">
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
                                                Add Expenses List
                                          </button>
                                    </div>
                              </div>

                        </div>
                  </div>
                  <!-- row -->
            </form>
            <p></p>
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

<script src="{{ asset('assets/js/select2.js')}}"></script>
<!-- End custom js for this page -->
@endsection