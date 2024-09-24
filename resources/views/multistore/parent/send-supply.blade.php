@extends('layouts.head')
@extends('layouts.header')
@extends('layouts.multistore-sidebar')
@extends('layouts.footer')
@section('content')
<style>
.select2-results__option[aria-selected] {
cursor: pointer;
text-transform: lowercase;
}
</style>
<!-- main-panel -->
<div class="main-panel">
      <div class="content-wrapper">
            <div class="page-header">
                  <h3 class="page-title">
                        Send Supplies to >>>> <a href="/{{$username}}/outlet-supplies/{{$vendor_id}}"
                              class="text-info">{{$outletStoreName}}</a>
                  </h3>
            </div>

            <p></p>
            <!--Alert here--->
            <div class="row ">
                  <div class="col-12">
                        @if(session('supply-status'))
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
                                    <div> {!! session('supply-status') !!}</div>
                              </div>
                              <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                        </div>
                        @endif


                        @if(session('supply-error'))
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
                                    <div> {!! session('supply-error') !!}</div>
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
            <form method="post" action="{{ route('send-supplies') }}" name="submit" enctype="multipart/form-data">
                  @csrf
                  {{csrf_field()}}
                  <div class="row">
                        <div class="col-md-12 ">
                              <input id="vendor" name="vendor_id" type="hidden" value="{{ $vendor_id }}" />
                              <input id="vendor" name="parent_id" type="hidden" value="{{ $parentStoreID }}" />
                              <div class="input-group">
                                    <span class="input-group-append">
                                          <span class="input-group-text text-dark d-block">
                                                item <i class="text-danger">*</i>
                                          </span>
                                    </span>
                                    <input class="typeahead form-control" id="search" type="text" name="item"
                                          placeholder="search here">
                                        
                                    <span class="input-group-append">
                                          <span class="input-group-text text-dark d-block">
                                                size
                                          </span>
                                    </span>
                                    <input type="text" name="size" value="0"
                                          style="width:85px;  padding-left:20px;  padding-right:5px;" id="size">
                                   

                                    <span class="input-group-append">
                                          <span class="input-group-text text-dark d-block">
                                                weight
                                          </span>
                                    </span>
                                    <select class="js-example-basic-single2 text-secondary" style="width:20%"
                                          name="weight" >
                                          <option value="">Choose</option>
                                          @foreach($sizes as $data)
                                          <option value="{{$data->size}}">
                                                {{$data->size}}
                                          </option>
                                          @endforeach
                                    </select>

                                    <div class="btn btn-sm" id="decreaseSupply" onclick="decreaseSupply()"
                                          value="Decrease Value">-
                                    </div>
                                    <span class="input-group-append">
                                          <span class="input-group-text text-dark d-block">
                                                qty <i class="text-danger">*</i>
                                          </span>
                                    </span>
                                    <input type="text" name="quantity" value="0"
                                          style="width:85px;  padding-left:20px;  padding-right:5px;" id="supply"
                                          multiple="multiple">
                                    <div class="btn btn-sm" id="increaseSupply" onclick="increaseSupply()"
                                          value="Increase Value">+
                                    </div>
                                    <button type="submit" name="submit"
                                          class="btn bg-gradient-primary btn-sm  text-white">Enter</button>
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
                                                      <th>Item</th>
                                                      <th>Weight/Size</th>
                                                      <th>Quantity</th>
                                                </tr>
                                          </thead>
                                          <tbody>
                                                @foreach($supply as $data)
                                                <tr>
                                                      <td>{{$loop->iteration}}</td>
                                                      <td class="text-capitalize">{{$data->supply}}</td>
                                                      <td>
                                                            @if($data->size == 0)
                                                            {{$data->weight}}
                                                            @else
                                                            {{$data->size}} {{$data->weight}}
                                                            @endif 
                                                      </td>
                                                      <td>
                                                      @if($data->supply_qty == 0)
                                                            @else
                                                            {{$data->supply_qty}}
                                                            @endif       
                                                    </td>
                                                    <td >
                                                      <form action="{{ route('remove-supply-item') }}" method="post">
                                                      @csrf
                                                      {{csrf_field()}}
                                                            <input type="text" value="{{$data->id}}">
                                                            <button type="submit"  name="submit" class=" btn btn-xs text-danger"><i class="fa fa-trash"></i></button>
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
                      
                        <form method="post" action="{{ route('push-supplies') }}" name="submit"
                              enctype="multipart/form-data">
                              @csrf
                              {{csrf_field()}}
                              <input type="hidden" name="parent_id" value="{{$parentStoreID}}">
                              <input type="hidden" name="vendor_id" value="{{$vendor_id}}">
                              
                              <button type="submit" name="submit"
                                    class="btn bg-gradient-primary btn-md  text-white">Push Supplies To
                                    {{$outletStoreName}}</button>
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