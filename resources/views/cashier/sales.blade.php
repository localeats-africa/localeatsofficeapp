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


                  </div>
            </div>
            <!---end Alert --->

            <div class="row ">

                  <form method="post" action="{{ route('add-vendor-offline-sales') }}" name="submit" enctype="multipart/form-data">
                        @csrf
                        {{csrf_field()}}
                        <div class="row">
                              <div class="col-md-6 col-12">
                                    <div class="form-group">
                                          <label for="">Food List</label>

                                          <select id="item" class="" name="item" type="text" style="width:90%">
                                                <option value=""></option>
                                                @foreach($salesList as $data)
                                                <option value="{{$data->id}}">
                                                      {{$data->item}}
                                                </option>
                                                @endforeach
                                          </select>
                                          <span id="response"></span>
                                    </div>

                                    <div class="form-group" id="show" style="display:none;">
                                          <p><br></p>
                                          <div class="input-group">
                                                <input id="new-item" class="form-control" type="text"
                                                      placeholder=" Enter new sales item" />
                                                <input id="vendor" name="vendor" type="hidden" value="{{ $vendor_id }}" />
                                                <button type="button" class="btn btn-dark btn-sm" id="btn-add-state"><i
                                                            class="fa fa-check"></i></button>
                                          </div>
                                    </div>


                              </div>
                              <!-- <div class="col-md-4 col-12" >
                                  
                              </div> -->

                              <div class="col-md-6 col-12">
                                    <div class="form-group">
                                          <label for="">Price</label>
                                          <br>
                                          <div class="input-group date">
                                                <input type="text" class="form-control" id="price" name="price"
                                                      placeholder="Enter food price" />
                                                <button type="submit" name="submit"
                                                      class="btn bg-gradient-primary btn-sm  text-white" onclick="addVendorExpenses()">Submit</button>
                                          </div>
                                    </div>
                              </div>

                        </div>
                        <!---end row--->
                  </form>
            </div>
            <!---end row --->
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
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



@endsection