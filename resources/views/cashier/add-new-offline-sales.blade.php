@extends('layouts.head')
@extends('layouts.header')
@extends('layouts.sidebar')
@extends('layouts.footer')
@section('content')
<style>
.select2-results__option[aria-selected] {
      cursor: pointer;
      text-transform: capitalize;
}
</style>
<!-- main-panel -->
<div class="main-panel">
      <div class="content-wrapper">
            <div class="page-header">
                  <h3 class="page-title">
                        <span class="text-info"> {{$vendorName}}</span> >> In-Store Sales
                  </h3>
            </div>

            <p></p>
            <!--Alert here--->
            <div class="row ">
                  <div class="col-12">
                        @if(session('sales-status'))
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
                                    <div> {!! session('sales-status') !!}</div>
                              </div>
                              <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                        </div>
                        @endif


                        @if(session('sales-error'))
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
                                    <div> {!! session('sales-error') !!}</div>
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

            <p></p>
            <p></p>
            <form method="post" action="{{ route('save-offline-sales') }}" name="submit" enctype="multipart/form-data">
                  @csrf
                  {{csrf_field()}}
                  <div class="row">
                        <div class="col-md-3">
                              <div class="form-label required"> Food item <i class="text-danger">*</i>
                              </div>

                              <select class="js-example-basic-single2 text-secondary " style="width:100%;" name="item">
                                    <option value="">Choose</option>
                                    @foreach($salesList as $data)
                                    <option  value="{{$data->item}}" >
                                    {{$data->item}}
                                    </option>
                                    @endforeach
                              </select>
                        </div>

                        <div class="col-md-3">
                              <div class="form-label required"> Food Category <i class="text-danger">*</i>
                              </div>

                              <select class="js-example-basic-single2 text-secondary " style="width:100%;" name="item">
                                    <option value="">Choose</option>
                                    @foreach($category as $data)
                                    <option  value="{{$data->category}}" >
                                    {{$data->category}}
                                    </option>
                                    @endforeach
                              </select>
                        </div>

                        <div class="col-md-3">
                              <div class="form-label required">Quantity <i class="text-danger">*</i>
                              </div>
                              <div class="input-group">
                                    <div class="btn btn-sm" id="decreaseSupply" onclick="decreaseSupply()"
                                          value="Decrease Value">-
                                    </div>
                                    <input type="text" class="form-control" name="quantity" value="1" style="width:45px;" id="supply"
                                          multiple="multiple">
                                    <div class="btn btn-sm" id="increaseSupply" onclick="increaseSupply()"
                                          value="Increase Value">+
                                    </div>
                              </div>

                        </div>

                        <div class="col-md-3">
                              <div class="form-label required">Price <i class="text-danger">*</i>
                              </div>
                              <div class="input-group">
                                    <input type="text" class="form-control" name="price">
                                    <button type="submit" name="submit"
                                          class="btn bg-gradient-primary btn-sm  text-white">Save</button>
                              </div>

                        </div>

                  </div>
            </form>

            <p></p>
            <div class="row ">
                  <div class="col-12">
                        <div class="card">
                              <div class="card-header">
                                    <h4 class="card-title"> </h4>
                              </div>


                              <div class="table-responsive " id="card">
                                    <table class="table table-striped card-table table-center text-nowrap datatable"
                                          id="orders">
                                          <thead>
                                                <tr>
                                                      <th>SN</th>
                                                      <th>Food Category</th>
                                                      <th>Item</th>
                                                      <th>Price</th>
                                                      <th>Quantity</th>
                                                      <th>Amount</th>
                                                </tr>
                                          </thead>
                                          <tbody>
                                                @foreach($sales as $data)
                                                <tr>
                                                      <td>{{$loop->iteration}}</td>
                                                      <td class="text-capitalize">{{$data->category}}</td>
                                                      <td class="text-capitalize">{{$data->food_item}}</td>
                                                      <td>{{$data->price}}</td>
                                                      <td>{{$data->quantity}}</td>
                                                      <td>{{$data->amount}}</td>
                                                      <td>
                                                            <form action="{{ route('remove-sales-item', [$data->id]) }}"
                                                                  method="post">
                                                                  @csrf
                                                                  {{csrf_field()}}
                                                                  <input type="hidden" value="" name="id">
                                                                  <button type="submit" name="submit"
                                                                        class=" btn btn-xs text-danger"><i
                                                                              class="fa fa-trash"></i></button>
                                                            </form>
                                                      </td>

                                                </tr>
                                                @endforeach

                                          </tbody>

                                    </table>
                              </div>

                        </div>
                        <!--- card-->
                        <p></p>

                        <form method="post" action="{{ route('send-offline-sales') }}" name="submit"
                              enctype="multipart/form-data">
                              @csrf
                              {{csrf_field()}}

                              <button type="submit" name="submit"
                                    class="btn bg-gradient-primary btn-md  text-white">Submit </button>
                        </form>

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
<script src="{{ asset('assets/vendors/select2/select2.min.js')}}"></script>
<script src="{{ asset('assets/vendors/typeahead.js/typeahead.bundle.min.js')}}"></script>

<!-- endinject -->
<!-- Custom js for this page -->
<script src="{{ asset('assets/js/file-upload.js')}}"></script>
<script src="{{ asset('assets/js/typeahead.js')}}"></script>
<script src="{{ asset('assets/js/select2.js')}}"></script>

<!-- header search bar js -->
<script type="text/javascript">
var path = "{{ route('autocomplete') }}";
$('input.search').typeahead({
      source: function(str, process) {
            return $.get(path, {
                  str: str
            }, function(data) {
                  return process(data);
            });
      }
});
</script>


<script type="text/javascript">
var path = "{{ route('autocomplete-vendor-food-menu') }}";

$("#search").autocomplete({
      source: function(request, response) {
            var parent = document.getElementById('parent').value;
            $.ajax({
                  url: path,
                  type: 'GET',
                  dataType: "json",
                  data: {
                        search: request.term,
                        parent: parent
                  },
                  success: function(data) {
                        response(data);
                  }
            });
      },
      select: function(event, ui) {
            $('#search').val(ui.item.label);
            console.log(ui.item);
            return false;
      }
});
</script>

@endsection