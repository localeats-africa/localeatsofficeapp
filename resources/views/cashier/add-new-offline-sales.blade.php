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

.select2-container--default .select2-selection--multiple .select2-selection__rendered {
box-sizing: border-box;
list-style: none;
margin: 7px !important;
padding: 0 5px;
width: 100%;
}

.select2-container--default .select2-selection--multiple .select2-selection__rendered {
box-sizing: border-box;
list-style: none;
/* margin: 0; */
padding: 0 5px;
width: 100%;
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
            <form method="post" action="{{ route('send-offline-sales') }}" name="submit"  enctype="multipart/form-data">
                  @csrf
                  {{csrf_field()}}
                  <div class="row">
                        <div class="col-md-6 col-12">
                              <div class="input-group">
                                    <span class="input-group-append">
                                          <span class="input-group-text text-dark d-block">
                                                Soup &nbsp; &nbsp;
                                          </span>
                                    </span>
                                    <select class="js-example-basic-single2 text-secondary " style="width:40%;"
                                          name="soup">
                                          <option value="">Choose</option>
                                          @foreach($vendorSoup as $data)
                                          <option value="{{$data->soup}}">
                                                {{$data->soup}}
                                          </option>
                                          @endforeach
                                    </select>
                                    <i class="remove"></i>
                                    <span class="input-group-append">
                                          <span class="input-group-text text-dark  d-block">
                                                qty
                                          </span>
                                    </span>
                                    <div class="btn btn-sm" id="decreaseSoup-{{ $data->id }}"
                                          onclick="decreaseSoup({{$data->id}})" value="Decrease Value">-</div>

                                    <input type="text" class="form-control" name="soup_qty" value="0"
                                          style="width:55px;" id="soup-{{ $data->id }}">

                                    <div class="btn btn-sm" id="increaseSoup-{{ $data->id }}"
                                          onclick="increaseSoup({{$data->id}})" value="Increase Value">+</div>
                                    <i class="remove"></i>

                              </div>
                        </div>


                        <div class="col-md-6 col-12">
                              <div class="input-group">
                                    <span class="input-group-append">
                                          <span class="input-group-text text-dark d-block">
                                                Swallow
                                          </span>
                                    </span>
                                    <select class="js-example-basic-single text-secondary " style="width:40%;"
                                          name="swallow">
                                          <option value="">Choose</option>
                                          @foreach($vendorSwallow as $data)
                                          <option value="{{$data->swallow}}">
                                                {{$data->swallow}}
                                          </option>
                                          @endforeach
                                    </select>
                                    <i class="remove"></i>
                                    <span class="input-group-append">
                                          <span class="input-group-text text-dark  d-block">
                                                qty
                                          </span>
                                    </span>
                                    <div class="btn btn-sm" id="decreaseSwallow-{{ $data->id }}"
                                          onclick="decreaseSwallow({{$data->id}})" value="Decrease Value">-</div>

                                    <input type="text" class="form-control" name="swallow_qty" value="0"
                                          style="width:55px;" id="swallow-{{ $data->id }}">

                                    <div class="btn btn-sm" id="increaseSwallow-{{ $data->id }}"
                                          onclick="increaseSwallow({{$data->id}})" value="Increase Value">+</div>
                                    <i class="remove"></i>

                              </div>
                        </div>

                  </div>

                  <p></p>
                  <p></p>


                  <div class="row">
                        <div class="col-md-6 col-12">
                              <div class="input-group">
                                    <span class="input-group-append">
                                          <span class="input-group-text text-dark d-block">
                                                Protein
                                          </span>
                                    </span>
                                    <select class="js-example-basic-single text-secondary " style="width:40%;"
                                          name="protein">
                                          <option value="">Choose</option>
                                          @foreach($vendorProtein as $data)
                                          <option value="{{$data->protein}}">
                                                {{$data->protein}}
                                          </option>
                                          @endforeach
                                    </select>
                                    <i class="remove"></i>
                                    <span class="input-group-append">
                                          <span class="input-group-text text-dark  d-block">
                                                qty
                                          </span>
                                    </span>
                                    <div class="btn btn-sm" id="decreaseProtein-{{ $data->id }}"
                                          onclick="decreaseProtein({{$data->id}})" value="Decrease Value">-</div>

                                    <input type="text" class="form-control" name="protein_qty" value="0"
                                          style="width:55px;" id="protein-{{ $data->id }}">

                                    <div class="btn btn-sm" id="increaseProtein-{{ $data->id }}"
                                          onclick="increaseProtein({{$data->id}})" value="Increase Value">+</div>

                                    <i class="remove"></i>

                              </div>
                        </div>


                        <div class="col-md-6 col-12">
                              <div class="input-group">
                                    <span class="input-group-append">
                                          <span class="input-group-text text-dark d-block">
                                                Others
                                          </span>
                                    </span>
                                    <select class="js-example-basic-multiple" multiple="multiple" style="width:40%; "
                                          name="others[]">
                                          <option value="">Choose</option>
                                          @foreach($vendorOthersFoodItem as $data)
                                          <option value="{{$data->others}}">
                                                {{$data->others}}
                                          </option>
                                          @endforeach
                                    </select>
                                    <i class="remove"></i>
                                    <span class="input-group-append">
                                          <span class="input-group-text text-dark  d-block">
                                                qty
                                          </span>
                                    </span>

                                    <div class="btn btn-sm" id="decreaseOthers-{{ $data->id }}"
                                          onclick="decreaseOthers({{$data->id}})" value="Decrease Value">-</div>

                                    <input type="text" class="form-control" name="others_qty" value="0"
                                          style="width:55px;" id="others-{{ $data->id }}">

                                    <div class="btn btn-sm" id="increaseOthers-{{ $data->id }}"
                                          onclick="increaseOthers({{$data->id}})" value="Increase Value">+</div>

                              </div>
                        </div>
                        <p></p>
                        <div class="col-md-12 col-12">
                              <div class="input-group">
                                    <span class="input-group-append">
                                          <span class="input-group-text text-dark d-block">
                                                Date <i class="text-danger">*</i>
                                          </span>
                                    </span>
                                    <input type="text" class="form-control" value="{{ date('Y-m-d')}}" id="date1"
                                          name="date" placeholder="Enter expenses" />
                                    <input id="vendor" name="vendor" type="hidden" value="{{ $vendor_id }}" />

                                    <i class="remove"></i>
                                    <span class="input-group-append">
                                          <span class="input-group-text text-dark  d-block">
                                                Price <i class="text-danger">*</i>
                                          </span>
                                    </span>
                                    <input type="text" class="form-control" name="price">
                                    <button type="submit" name="submit"
                                          class="btn bg-gradient-primary  btn-block  text-white">Save</button>

                              </div>




                        </div>
                  </div>
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

<script>
$(function() {
      $("#date1").datepicker();
});
</script>

@endsection