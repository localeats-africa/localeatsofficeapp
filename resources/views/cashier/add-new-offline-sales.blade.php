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

            <form method="post" action="" name="submit"
                  enctype="multipart/form-data">
                  @csrf
                  {{csrf_field()}}

                  <div class="row">
                        <h6 class="text-danger">Check multiple one or more food item, enter each quantity, enter
                              total price and date</h6>
                        <p></p>
                        <div class="col-md-6 col-12 list-wrapper">

                              <h6>Soup</h6>

                              <ul class="d-flex flex-column-reverse ">
                                    @foreach($vendorSoup as $data)
                                    <li>
                                          <div class="form-check">
                                                <label class="form-check-label">
                                                      <input class="checkbox" type="checkbox" name="soup[]"
                                                            value="{{$data->soup}}" multiple="multiple" id="soup_item-{{ $data->soup }}">{{$data->soup}}
                                                      <i class="input-helper"></i>
                                                </label>
                                          </div>

                                          <i class="remove"></i>
           
                                          <div class="btn btn-sm" id="decreaseSoup-{{ $data->id }}"
                                                onclick="decreaseSoup({{$data->id}})" value="Decrease Value">-</div>

                                          <input type="text" class="form-control" name="soup_qty[]" value="1"
                                                style="width:85px;" id="soup-{{ $data->id }}">

                                          <div class="btn btn-sm" id="increaseSoup-{{ $data->id }}"
                                                onclick="increaseSoup({{$data->id}})" value="Increase Value">+</div>

                                    </li>

                                    @endforeach
                              </ul>

                        </div>
                        <div class="col-md-6 col-12 list-wrapper">
                              <h6>Swallow</h6>
                              <ul class="d-flex flex-column-reverse ">
                                    @foreach($vendorSwallow as $data)
                                    <li>
                                          <div class="form-check">
                                                <label class="form-check-label">
                                                      <input class="checkbox" type="checkbox" name="swallow[]"
                                                            value="{{$data->swallow}}"  id="swallow_item-{{ $data->swallow }}">{{$data->swallow}}
                                                </label>
                                          </div>

                                          <i class="remove"></i>
                                          <div class="btn btn-sm" id="decreaseSwallow-{{ $data->id }}"
                                                onclick="decreaseSwallow({{$data->id}})" value="Decrease Value">-</div>

                                          <input type="text" class="form-control" name="swallow_qty[]" value="1"
                                                style="width:85px;" id="swallow-{{ $data->id }}">

                                          <div class="btn btn-sm" id="increaseSwallow-{{ $data->id }}"
                                                onclick="increaseSwallow({{$data->id}})" value="Increase Value">+</div>

                                    </li>
                                    @endforeach
                              </ul>

                        </div>
                  </div>

                  <p></p>
                  <p></p>
                  <div class="row">
                        <div class="col-md-6 col-12 list-wrapper">
                              <h6>Protein</h6>
                              <ul class="d-flex flex-column-reverse ">
                                    @foreach($vendorProtein as $data)
                                    <li>
                                          <div class="form-check">
                                                <label class="form-check-label">
                                                      <input class="checkbox" type="checkbox" name="protein[]"
                                                            value="{{$data->protein}}"  id="protein_item-{{ $data->protein }}">{{$data->protein}}
                                                </label>
                                          </div>

                                          <i class="remove"></i>
                                          <div class="btn btn-sm" id="decreaseProtein-{{ $data->id }}"
                                                onclick="decreaseProtein({{$data->id}})" value="Decrease Value">-</div>

                                          <input type="text" class="form-control" name="protein_qty[]" value="1"
                                                style="width:85px;" id="protein-{{ $data->id }}">

                                          <div class="btn btn-sm" id="increaseProtein-{{ $data->id }}"
                                                onclick="increaseProtein({{$data->id}})" value="Increase Value">+</div>


                                    </li>
                                    @endforeach
                              </ul>
                        </div>


                        <div class="col-md-6 col-12 list-wrapper">

                              <h6>Others</h6>
                              <ul class="d-flex flex-column-reverse ">
                                    @foreach($vendorOthersFoodItem as $data)
                                    <li>
                                          <div class="form-check">
                                                <label class="form-check-label">
                                                      <input class="checkbox" type="checkbox" name="others[]"
                                                            value="{{$data->others}}" id="others_item-{{ $data->others }}" >{{$data->others}}
                                                </label>
                                          </div>

                                          <i class="remove"></i>
                                          <div class="btn btn-sm" id="decreaseOthers-{{ $data->id }}"
                                                onclick="decreaseOthers({{$data->id}})" value="Decrease Value">-</div>

                                          <input type="text" class="form-control" name="others_qty[]" value="1"
                                                style="width:85px;" id="others-{{ $data->id }}">

                                          <div class="btn btn-sm" id="increaseOthers-{{ $data->id }}"
                                                onclick="increaseOthers({{$data->id}})" value="Increase Value">+</div>
                                    </li>
                                    @endforeach
                              </ul>


                        </div>

                  </div>
                  <!---row--->
                  <div class="row ">
                  <div class="col-md-6 col-12 list-wrapper">
                              <div class="form-group">
                                    <h6 for="">Price</h6>
                                    <br>
                                    <input type="text" class="form-control" value="" id="price" name="price"
                                          placeholder="Enter expenses" />

                              </div>

                        </div>

                        <div class="col-md-6 col-12 list-wrapper">
                              <div class="form-group">
                                    <h6 for="">Date</h6>
                                    <br>
                                    <div class="input-group date">

                                          <input type="text" class="form-control" value="{{ date('Y-m-d')}}" id="date4"
                                                name="date" placeholder="Enter expenses" />
                                          <input id="vendor" name="vendor" type="hidden" value="{{ $vendor_id }}" />
                                          <button type="submit" name="submit"
                                                class="btn bg-gradient-primary btn-sm  text-white">Save</button>
                                    </div>
                              </div>

                        </div>
                  </div>
                  <p></p>


                  <p></p>
                  <div class="row ">
                        <div class="col-12">
                              <div class="card">
                                    <div class="card-header">
                                          <h4 class="card-title"> </h4>
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

                                                            <td>{{ date('Y-m-d', strtotime($data->sales_date))}} Time:
                                                                  <span class="text-info">
                                                                        {{\Carbon\Carbon::parse($data->created_at)->format('H:i:s')}}</span>
                                                            </td>
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



<script>
function sendSales(data) {
      var soup_item = document.querySelector('#soup_item-' + data).value;
      var soup_qty = document.querySelector('#soup-' + data).value;
      var swallow_item = document.querySelector('#swallow_item-' + data).value;
      var swallow_qty = document.querySelector('#swallow-' + data).value;
      var protein_item = document.querySelector('#protein_item-' + data).value;
      var protein_qty = document.querySelector('#protein-' + data).value;
      var others_item = document.querySelector('#others_item-' + data).value;
      var others_qty = document.querySelector('#others-' + data).value;
      var price = document.getElementById('price').value;
      var orderdate = document.getElementById('date4').value;


      var url = "{{ route('reject-supplies') }}";
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
                  'soup_item': soup_item,
                  'soup_qty': soup_qty,
                  'swallow_item': swallow_item,
                  'swallow_qty': swallow_qty,
                  'protein_item': protein_item,
                  'protein_qty': protein_qty,
                  'others_item': others_item,
                  'others_qty': others_qty,
                  'price': price,
                  'orderdate':orderdate
            },
            success: function(data) {
                  console.log(data.message);
                    alert("Update Successful");
                     location.reload();
                  
            },
            error: function(data) {
                  console.log(data);
            }
      });

}

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