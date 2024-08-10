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
                        <span class="text-info">{{$vendorName}}</span> >>>> Add New Sales
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



            <div class="row">
                  <h6 class="text-danger">Check multiple one or more food item, enter each quantity, enter
                        total price and date</h6>
                  <p></p>
                  <div class="col-md-6 col-12 list-wrapper">
                        <form method="post" action="{{ route('add-vendor-offline-soup') }}" name="submit"
                              enctype="multipart/form-data">
                              @csrf
                              {{csrf_field()}}
                              <h6>Soup</h6>

                              <ul class="d-flex flex-column-reverse ">
                                    @foreach($vendorSoup as $data)
                                    <li>
                                          <div class="form-check">
                                                <label class="form-check-label">
                                                      <input class="checkbox" type="checkbox" name="soup[]"
                                                            value="{{$data->soup}}" multiple="multiple">{{$data->soup}}
                                                      <i class="input-helper"></i>
                                                </label>
                                          </div>

                                          <i class="remove"></i>
                                          <input type="hidden" value="{{ $data->id }}" name="soup_id[]">

                                          <input class="form-control" type="text" name="soup_price[]"
                                                value="{{$data->soup_price}}" style="width:85px;" disabled>

                                          <div class="btn btn-sm" id="decreaseSoup-{{ $data->id }}"
                                                onclick="decreaseSoup({{$data->id}})" value="Decrease Value">-</div>

                                          <input type="text" class="form-control" name="soup_qty[]" value="1"
                                                style="width:85px;" id="soup-{{ $data->id }}">

                                          <div class="btn btn-sm" id="increaseSoup-{{ $data->id }}"
                                                onclick="increaseSoup({{$data->id}})" value="Increase Value">+</div>

                                    </li>

                                    @endforeach
                              </ul>

                              <div class="form-group">
                                    <h6 for="">Date</h6>
                                    <br>
                                    <div class="input-group date">

                                          <input type="text" class="form-control" value="{{ date('Y-m-d')}}" id="date1"
                                                name="date" placeholder="Enter expenses" />
                                          <input id="vendor" name="vendor" type="hidden" value="{{ $vendor_id }}" />
                                          <button type="submit" name="submit"
                                                class="btn bg-gradient-primary btn-sm  text-white">Save Soup</button>
                                    </div>
                              </div>

                        </form>

                  </div>
                  <div class="col-md-6 col-12 list-wrapper">
                        <form method="post" action="{{ route('add-vendor-offline-swallow') }}" name="submit"
                              enctype="multipart/form-data">
                              @csrf
                              {{csrf_field()}}
                              <h6>Swallow</h6>
                              <ul class="d-flex flex-column-reverse ">
                                    @foreach($vendorSwallow as $data)
                                    <li>
                                          <div class="form-check">
                                                <label class="form-check-label">
                                                      <input class="checkbox" type="checkbox" name="swallow[]"
                                                            value="{{$data->swallow}}">{{$data->swallow}}
                                                </label>
                                          </div>

                                          <i class="remove"></i>
                                          <input class="form-control" type="text" name="swallow_price[]"
                                                value="{{$data->swallow_price}}" style="width:85px;" disabled>

                                          <div class="btn btn-sm" id="decreaseSwallow-{{ $data->id }}"
                                                onclick="decreaseSwallow({{$data->id}})" value="Decrease Value">-</div>

                                          <input type="text" class="form-control" name="swallow_qty[]" value="1"
                                                style="width:85px;" id="swallow-{{ $data->id }}">

                                          <div class="btn btn-sm" id="increaseSwallow-{{ $data->id }}"
                                                onclick="increaseSwallow({{$data->id}})" value="Increase Value">+</div>

                                    </li>
                                    @endforeach
                              </ul>

                              <div class="form-group">
                                    <h6 for="">Date</h6>
                                    <br>
                                    <div class="input-group date">

                                          <input type="text" class="form-control" value="{{ date('Y-m-d')}}" id="date2"
                                                name="date" placeholder="Enter expenses" />
                                          <input id="vendor" name="vendor" type="hidden" value="{{ $vendor_id }}" />
                                          <button type="submit" name="submit"
                                                class="btn bg-gradient-primary btn-sm  text-white">Save Swallow</button>
                                    </div>
                              </div>
                        </form>

                  </div>
            </div>


            <div class="row">
                  <div class="col-md-6 col-12 list-wrapper">
                        <form method="post" action="{{ route('add-vendor-offline-protein') }}" name="submit"
                              enctype="multipart/form-data">
                              @csrf
                              {{csrf_field()}}
                              <h6>Protein</h6>
                              <ul class="d-flex flex-column-reverse ">
                                    @foreach($vendorProtein as $data)
                                    <li>
                                          <div class="form-check">
                                                <label class="form-check-label">
                                                      <input class="checkbox" type="checkbox" name="protein[]"
                                                            value="{{$data->protein}}">{{$data->protein}}
                                                </label>
                                          </div>

                                          <i class="remove"></i>
                                          <input class="form-control" type="text" name="protein_price[]"
                                                value="{{$data->protein_price}}" style="width:85px;" disabled>

                                          <div class="btn btn-sm" id="decreaseProtein-{{ $data->id }}"
                                                onclick="decreaseProtein({{$data->id}})" value="Decrease Value">-</div>

                                          <input type="text" class="form-control" name="protein_qty[]" value="1"
                                                style="width:85px;" id="protein-{{ $data->id }}">

                                          <div class="btn btn-sm" id="increaseProtein-{{ $data->id }}"
                                                onclick="increaseProtein({{$data->id}})" value="Increase Value">+</div>


                                    </li>
                                    @endforeach
                              </ul>

                              <div class="form-group">
                                    <h6 for="">Date</h6>
                                    <br>
                                    <div class="input-group date">

                                          <input type="text" class="form-control" value="{{ date('Y-m-d')}}" id="date3"
                                                name="date" placeholder="Enter expenses" />
                                          <input id="vendor" name="vendor" type="hidden" value="{{ $vendor_id }}" />
                                          <button type="submit" name="submit"
                                                class="btn bg-gradient-primary btn-sm  text-white">Save Protein</button>
                                    </div>
                              </div>
                        </form>

                  </div>


                  <div class="col-md-6 col-12 list-wrapper">
                        <form method="post" action="{{ route('add-vendor-offline-others') }}" name="submit"
                              enctype="multipart/form-data">
                              @csrf
                              {{csrf_field()}}
                              <h6>Others</h6>
                              <ul class="d-flex flex-column-reverse ">
                                    @foreach($vendorOthersFoodItem as $data)
                                    <li>
                                          <div class="form-check">
                                                <label class="form-check-label">
                                                      <input class="checkbox" type="checkbox" name="others[]"
                                                            value="{{$data->others}}">{{$data->others}}
                                                </label>
                                          </div>

                                          <i class="remove"></i>
                                          <input class="form-control" type="text" name="others_price[]"
                                                value="{{$data->others_price}}" style="width:85px;" disabled>

                                          <div class="btn btn-sm" id="decreaseOthers-{{ $data->id }}"
                                                onclick="decreaseOthers({{$data->id}})" value="Decrease Value">-</div>

                                          <input type="text" class="form-control" name="others_qty[]" value="1"
                                                style="width:85px;" id="others-{{ $data->id }}">

                                          <div class="btn btn-sm" id="increaseOthers-{{ $data->id }}"
                                                onclick="increaseOthers({{$data->id}})" value="Increase Value">+</div>



                                    </li>
                                    @endforeach
                              </ul>
                              <div class="form-group">
                                    <h6 for="">Date</h6>
                                    <br>
                                    <div class="input-group date">

                                          <input type="text" class="form-control" value="{{ date('Y-m-d')}}" id="date4"
                                                name="date" placeholder="Enter expenses" />
                                          <input id="vendor" name="vendor" type="hidden" value="{{ $vendor_id }}" />
                                          <button type="submit" name="submit"
                                                class="btn bg-gradient-primary btn-sm  text-white">Save Others</button>
                                    </div>
                              </div>
                        </form>

                  </div>

            </div>
            <!---row--->
            <p></p>


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

                                                      <form action="{{ route('offline-sales') }}" method="GET"
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
                                    <table class="table table-striped card-table table-vcenter text-nowrap datatable "
                                          id="orders">
                                          <thead>
                                                <tr>
                                                      <th>Date</th>
                                                      <th>Sales Item</th>
                                                      <th>Price</th>
                                                      <th>Total</th>
                                                </tr>
                                          </thead>
                                          <tbody>
                                                @foreach($sales as $data)
                                                <tr>
                                               
                                                      <td>{{ date('Y-m-d', strtotime($data->sales_date))}} Time: <span class="text-info"> {{\Carbon\Carbon::parse($data->created_at)->format('H:i:s')}}</span></td>
                                                      <td class="text-capitalize">
                                                            {{ $data->sales_item }}
                                                            @if($data->soup ==' ')
                                                            @else

                                                            {{ $data->soup_qty }}
                                                            {{$data->soup}}
                                                            @endif

                                                            @if($data->swallow ==' ')
                                                            @else
                                                            {{$data->swallow_qty }} {{$data->swallow}}
                                                            @endif

                                                            @if($data->protein ==' ')
                                                            @else
                                                            {{$data->protein_qty }} {{$data->protein}}
                                                            @endif

                                                            @if($data->others ==' ')
                                                            @else
                                                            {{$data->others_qty }} {{$data->others}}
                                                            @endif
                                                            <a class=" btn btn-sm text-capitalize text-danger"
                                                                  href="edit-offline-sales/{{$data->id}}">
                                                                  <i class=" fa fa-pencil"></i>
                                                            </a>
                                                      </td>
                                                      <td>
                                                            @if($data->soup ==' ')
                                                            @else
                                                            {{$data->soup_price}}
                                                            @endif

                                                            @if($data->swallow ==' ')
                                                            @else
                                                            {{$data->swallow_price}}
                                                            @endif

                                                            @if($data->protein ==' ')
                                                            @else
                                                            {{$data->protein_price}}
                                                            @endif

                                                            @if($data->others ==' ')
                                                            @else
                                                            {{$data->others_price}}
                                                            @endif
                                                            {{$data->price}}

                                                      </td>

                                                      <td>
                                                          

                                                            @if($data->soup ==' ')
                                                            @else
                                                          
                                                            {{ $data->soup_total }} 
                                                            @endif

                                                            @if($data->swallow ==' ')
                                                            @else
                                                        
                                                            {{$data->swallow_total }}
                                                            @endif

                                                            @if($data->protein ==' ')
                                                            @else
                                                      
                                                            {{$data->protein_total }}
                                                            @endif

                                                            @if($data->others ==' ')
                                                            @else
                                                         
                                                            {{$data->others_total  }}
                                                            @endif
                                                            {{$data->price}}
                                                      </td>
                                                </tr>
                                                @endforeach

                                          </tbody>

                                    </table>
                              </div>
                              <div class="card-footer d-flex align-items-center">
                                    <p class="m-0 text-secondary">

                                          Showing
                                          {{ ($sales->currentPage() - 1) * $sales->perPage() + 1; }} to
                                          {{ min($sales->currentPage()* $sales->perPage(), $sales->total()) }}
                                          of
                                          {{$sales->total()}} entries
                                    </p>

                                    <ul class="pagination m-0 ms-auto">
                                          @if(isset($sales))
                                          @if($sales->currentPage() > 1)
                                          <li class="page-item ">
                                                <a class="page-link text-danger" href="{{ $sales->previousPageUrl() }}"
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
                                                {{ $sales->appends(compact('perPage'))->links()  }}
                                          </li>
                                          @if($sales->hasMorePages())
                                          <li class="page-item">
                                                <a class="page-link text-danger" href="{{ $sales->nextPageUrl() }}">
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.3/jquery-ui.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.1/js/select2.min.js"></script>

<!-- End custom js for this page -->
<script type="text/javascript">
$(document).ready(function() {
      $("#item").select2({
            placeholder: "Search ",
            closeOnSelect: true,
            language: {
                  noResults: function(term) {
                        return $(
                              "<div>Result not found!. <a href='#' onclick='return myClick()'>click here add new</a></div>"
                        );
                  }
            },
      });

      $('#btn-add-state').on("click", function() {
            var newStateVal = $('#new-item').val();
            // Set the value, creating a new option if necessary
            // if ($('#item').find("option[value=" + newStateVal + "]").length) {
            //       $('#item').val(newStateVal).trigger("change");
            // } else {
            // Create the DOM option that is pre-selected by default
            var newState = new Option(newStateVal, newStateVal, true, true);
            // Append it to the select
            $('#item').append(newState).trigger('change').select2();
            // }
            var item = document.getElementById('new-item').value;
            var vendor = document.getElementById('vendor').value;

            var url = "{{ route('offline-sales-list') }}";
            // url = showRoute;

            //window.location = url;
            $.ajaxSetup({
                  headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  }
            });
            $.ajax({
                  method: 'POST',
                  enctype: 'multipart/form-data',
                  url: url,
                  data: {
                        //you can more data here
                        'item': item,
                        'vendor': vendor
                  },
                  success: function(data) {
                        console.log(data.message);
                        document.getElementById('response').style.display =
                              '';
                        document.getElementById('response').style.color =
                              'green';
                        document.getElementById('response').innerHTML = data
                              .message;
                        document.getElementById("show").style.display =
                              'none';
                  },
                  error: function(data) {
                        console.log(data);
                  }
            });
      });
});

function myClick() {
      var x = document.getElementById("show");
      if (x.style.display === "none") {
            x.style.display = "block";
      } else {
            x.style.display = "none";
      }
}
</script>



<script>
$(function() {
      $("#date1").datepicker();
});
</script>

<script>
$(function() {
      $("#date2").datepicker();
});
</script>
<script>
$(function() {
      $("#date3").datepicker();
});
</script>

<script>
$(function() {
      $("#date4").datepicker();
});
</script>


@endsection