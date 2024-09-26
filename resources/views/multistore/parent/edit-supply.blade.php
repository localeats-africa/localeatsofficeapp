@extends('layouts.head')
@extends('layouts.header')
@extends('layouts.multistore-sidebar')
@extends('layouts.footer')
@section('content')

<!-- main-panel -->
<div class="main-panel">
      <div class="content-wrapper">
            <div class="page-header">
                  <h3 class="page-title">
                        Edit Supply for <span class="text-info">{{$outletStoreName}}</span>
                  </h3>
                  <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                              <li class="breadcrumb-item active" aria-current="page">
                                    <span></span>
                                    Receipt <sup>No:</sup>
                                    <a class="text-info" href="/{{$username}}/supplies-receipt/{{$supply_ref}}">  {{$supply_ref}}</a>      

                              </li>
                        </ul>
                  </nav>
            </div>

            <p></p>
            <!--Alert here--->
            <div class="row ">
                  <div class="col-12">
                        @if(session('update-status'))
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
                                    <div> {!! session('update-status') !!}</div>
                              </div>
                              <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                        </div>
                        @endif


                        @if(session('update-error'))
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
                                    <div> {!! session('update-error') !!}</div>
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

            <div class="row ">
                  <div class="col-12">
                        <form action="{{ route('update-supplies', [$id]) }}" method="post" name="submit">
                              @csrf
                              {{csrf_field()}}
                              <div class="card">
                                    <div class="card-header">
                                          <h3 class="card-title"> </h3>
                                          <h5>All field with <i class="text-danger">*</i> are required</h5>
                                    </div>
                                    <div class="card-body py-3">

                                          <div class="row">
                                                <h5>item: </h5>
                                                <div class="table-responsive">
                                                      <table class="table table-bordered">
                                                            <thead>
                                                                  <tr>
                                                                        <th>SN</th>
                                                                        <th>Item</th>
                                                                        <th class="table-info">Size</th>
                                                                        <th class="table-danger">Weight</th>
                                                                        <th>Quantity</th>
                                                                  </tr>
                                                            </thead>
                                                            <tbody>
                                                                  @foreach($supply as $data)
                                                                  <tr>
                                                                        <td>{{$loop->iteration}}</td>
                                                                        <td>
                                                                        <!-- <input type="text" class="form-control" name="item" value="{{$data->supply}}"> -->
                                                                        <select class="js-example-basic-single text-secondary"
                                                                                    style="width:100%" name="item">
                                                                                    <option value="{{$data->supply}}">{{$data->supply}}</option>
                                                                                    @foreach($item as $items)
                                                                                    <option value="{{$items->item}}">
                                                                                          {{$items->item}}
                                                                                    </option>
                                                                                    @endforeach

                                                                        </td>
                                                                        <td>
                                                                              <input type="text" value="{{$data->size}}"
                                                                                    name="size"
                                                                                    class="form-control">
                                                                        </td>

                                                                        <td>
                                                                        <select class="js-example-basic-single2 text-secondary"
                                                                                    style="width:100%" name="weight">
                                                                                    <option value="{{$data->weight}}">{{$data->weight}}</option>
                                                                                    @foreach($sizes as $size)
                                                                                    <option value="{{$size->size}}">
                                                                                          {{$size->size}}
                                                                                    </option>
                                                                                    @endforeach
                                                                              </select>
                                                                            
                                                                        </td>
                                                                        <td width="">
                                                                        <div class="input-group">
                                                                        <div class="btn btn-sm"
                                                                              id="decreaseOthers-{{ $data->id }}"
                                                                                    onclick="decreaseOthers({{$data->id}})"
                                                                                    value="Decrease Value">-
                                                                              </div>

                                                                              <input type="text" name="quantity" class="form-control"
                                                                                    value="{{$data->supply_qty}}"
                                                                                    style="width:100px; "
                                                                                  id="others-{{ $data->id }}">
                                                                              <div class="btn btn-sm"
                                                                                  id="increaseOthers-{{ $data->id }}"
                                                                                    onclick="increaseOthers({{$data->id}})"
                                                                                    value="Increase Value">+
                                                                              </div>
                                                                        </div>
                                                                        </td>
                                                                  </tr>


                                                                  @endforeach
                                                            </tbody>
                                                      </table>
                                                </div>
                                                <div class="col-md-12">

                                                </div>




                                          </div>
                                          <!--- row-->


                                    </div>
                                    <!--- row-->

                                    <div class="row">
                                          <p></p>
                                          <div class="col-md-6">
                                          </div>
                                          <div class="col-md-6 col-12 grid-margin stretch-card justify-content-end">

                                                <!-- send button here -->
                                                <div class="card-footer bg-transparent mt-auto">
                                                      <div class="btn-list ">
                                                            <button type="submit" name="submit"
                                                                  class="btn bg-gradient-primary  text-white">
                                                                  <svg xmlns="http://www.w3.org/2000/svg"
                                                                        class="icon icon-tabler icon-tabler-device-floppy"
                                                                        width="24" height="24" viewBox="0 0 24 24"
                                                                        stroke-width="1.5" stroke="currentColor"
                                                                        fill="none" stroke-linecap="round"
                                                                        stroke-linejoin="round">
                                                                        <path stroke="none" d="M0 0h24v24H0z"
                                                                              fill="none" />
                                                                        <path
                                                                              d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" />
                                                                        <path
                                                                              d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                                                        <path d="M14 4l0 4l-6 0l0 -4" />
                                                                  </svg>
                                                                  Save Changes
                                                            </button>
                                                      </div>
                                                </div>

                                          </div>
                                    </div>
                                    <!--- row-->

                              </div>
                              <!--- card-->
                        </form>
                  </div>

            </div>
      </div>


      <!--- content-wrapper-->
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
<!--- main-panel-->
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
var path = "{{ route('autocomplete') }}";

$("#search").autocomplete({
      source: function(request, response) {
            $.ajax({
                  url: path,
                  type: 'GET',
                  dataType: "json",
                  data: {
                        search: request.term
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