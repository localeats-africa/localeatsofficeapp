@extends('layouts.head')
@extends('layouts.header')
@extends('layouts.multistore-sidebar')
@extends('layouts.footer')
@section('content')
</style>
<!-- main-panel -->
<div class="main-panel">
      <div class="content-wrapper">
            <div class="page-header">
                  <h3 class="page-title">
                        <span class="text-info">{{$vendorName}}</span> >>>> Add New Expenses
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

                  <form method="post" action="{{ route('add-outlet-expenses') }}" name="submit"
                        enctype="multipart/form-data">
                        @csrf
                        {{csrf_field()}}
                        <div class="row">
                              <div class="col-md-4 col-12">
                                    <div class="form-group">
                                          <label for="">Expenses</label>
                                          <br>
                                          <input type="hidden" id="vendor_id" value="{{$vendor_id}}" name="vendor">
                                          <input class="typeahead form-control" id="search" type="text" name="item"
                                          placeholder="search here">
                                    </div>
                              </div>
                              <div class="col-md-4 col-12">
                                    <div class="form-group">
                                          <label for="">Category</label>
                                          <br>
                                          <select class="js-example-basic-single text-secondary" style="width:100%" name="area" >
                                                <option value="">Choose</option>
                                                @foreach($expensesCategory as $data)
                                                <option value="{{$data->category}}">
                                                      {{$data->category}}
                                                </option>
                                                @endforeach
                                          </select>
                                    </div>
                              </div>
                              
                              <div class="col-md-4 col-12">
                                    <div class="form-group">
                                          <label for="">Price</label>
                                          <br>
                                          <div class="input-group ">
                                                <input type="text" class="form-control" id="price" name="price"
                                                      placeholder="Enter expenses" />
                                                <button type="submit" name="submit"
                                                      class="btn bg-gradient-primary btn-sm  text-white"
                                                   >Submit</button>
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

                                                      <form action="{{ url(auth()->user()->username,'vendor-add-expenses'  ) }}" method="GET"
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
                                                      <th class="w-1">SN</th>
                                                      <th>Date</th>
                                                      <th>Item</th>
                                                      <th>Cost (₦)</th>
                                                </tr>
                                          </thead>
                                          <tbody>
                                                @foreach($expenses as $data)
                                                <tr>
                                                      <td>{{$loop->iteration}}</td>
                                                      <td>{{ date('d/m/Y', strtotime($data->expense_date))}}</td>
                                                      <td class="text-capitalize">{{$data->description}}</td>
                                                      <td>{{number_format($data->cost)}}</td>


                                                </tr>
                                                @endforeach

                                          </tbody>

                                    </table>
                              </div>
                              <div class="card-footer d-flex align-items-center">
                                    <p class="m-0 text-secondary">

                                          Showing
                                          {{ ($expenses->currentPage() - 1) * $expenses->perPage() + 1; }} to
                                          {{ min($expenses->currentPage()* $expenses->perPage(), $expenses->total()) }}
                                          of
                                          {{$expenses->total()}} entries
                                    </p>

                                    <ul class="pagination m-0 ms-auto">
                                          @if(isset($expenses))
                                          @if($expenses->currentPage() > 1)
                                          <li class="page-item ">
                                                <a class="page-link text-danger"
                                                      href="{{ $expenses->previousPageUrl() }}" tabindex="-1"
                                                      aria-disabled="true">
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
                                                {{ $expenses->appends(compact('perPage'))->links()  }}
                                          </li>
                                          @if($expenses->hasMorePages())
                                          <li class="page-item">
                                                <a class="page-link text-danger" href="{{ $expenses->nextPageUrl() }}">
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
<script src="{{ asset('assets/vendors/select2/select2.min.js')}}"></script>
<script src="{{ asset('assets/vendors/typeahead.js/typeahead.bundle.min.js')}}"></script>

<!-- endinject -->
<!-- Custom js for this page -->
<script src="{{ asset('assets/js/file-upload.js')}}"></script>
<script src="{{ asset('assets/js/typeahead.js')}}"></script>
<script src="{{ asset('assets/js/select2.js')}}"></script>

<script type="text/javascript">
var id = document.getElementById('vendor_id').value;
var showRoute = "{{ route('autocomplete-expenses', ':id') }}";
path = showRoute.replace(':id', id);  

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
            var item = document.getElementById('item').value;
            var vendor = document.getElementById('vendor').value;

            var url = "{{ route('add-expenses-list') }}";
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
      $("#date").datepicker();
});
</script>

@endsection