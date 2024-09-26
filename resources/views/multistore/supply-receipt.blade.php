@extends('layouts.head')
@extends('layouts.header')
@extends('layouts.multistore-sidebar')
@extends('layouts.footer')
@section('content')
<!-- main-panel -->
<style>
.hidetext {
      /* height: 50px; */
      max-width: 130px;
      overflow: hidden;
      text-overflow: ellipsis;
      cursor: pointer;
      word-break: break-all;
      white-space: nowrap;
      border: 1px solid #C8C8C8;
      text-align: left;
      padding: 10px;
}

.hidetext:hover {
      overflow: visible;
      white-space: normal;
      line-height: 1.5em;
}
</style>
<div class="main-panel">
      <div class="content-wrapper">

            <div class="page-header">
                  <h3 class="page-title">Supply Receipt</h3>
            </div>
            <!---Alert --->

            <div class="row">
                  <div class="col-lg-12">
                  </div>
            </div>
            <!---end---alert--->
            <div class="row">
                  <div class="col-sm-12">
                        <div class="page-header">
                              <form action=""></form>
                              <nav style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
                                    <p id="response"></p>
                                    <ol class="breadcrumb">
                                          <li class="breadcrumb-item">
                                                <button class="btn btn-outline-dark " onclick="printDiv()">
                                                      <i class="fa fa-print"></i></button>
                                          </li>
                                          <li class="breadcrumb-item">
                                                <button class="btn btn-outline-dark " onclick="getPDF()">
                                                      <i class="fa fa-download"></i></button>
                                          </li>
                                    </ol>
                              </nav>


                        </div>
                  </div>
            </div>

            <!---Alert --->

            <div class="row">
                  <div class="col-lg-12">

                        @if(session('email-sent'))
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
                                    <div> {!! session('save') !!}</div>
                              </div>
                              <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                        </div>
                        @endif
                  </div>
            </div>
            <!---end---alert--->

            <div class="row">
                  <div class="col-md-12">
                        <div class="card print_invoice" id="print_invoice">
                              <div class="card-body">
                                    <div class="row">
                                          <div class="col-md-6 col-6">

                                                <div class="d-flex flex-column">
                                                      <img src="{{ asset('assets/images/logo.png') }}" alt="Admin"
                                                            class="rounded-circle " width="110">
                                                      <h4>{{$parentName}}</h4>
                                                      <h6>Head Office:</h6>
                                                      <div class="mt-1 text-secondary" style="line-height:1.7">
                                                            <small>{{$parentAddress}}</small>
                                                            <br>
                                                            <small> <i class="mdi mdi-email"></i>
                                                                  {{$parentEmail}}
                                                                  <br></small>
                                                      </div>

                                                      <div class="row mb-3">
                                                            <p></p>
                                                            <div class="col-sm-12">
                                                                  <p></p>
                                                                  <br>
                                                                  <div class="mt-1">
                                                                        <small><strong>Suuply Date:</strong>
                                                                              {{$supply_date}}</small>
                                                                  </div>
                                                            </div>
                                                      </div>
                                                      <!---end row --->
                                                </div>
                                          </div>

                                          <div class="col-md-6 col-6">
                                                <div class="row mb-3">
                                                      <p></p>
                                                      <div class="col-sm-12" style="text-align:right;">
                                                            <h6 class="mb-0">{{$storeName}}</h6>
                                                            <div class="mt-1 text-secondary ">
                                                                  <small> {{$storeAddress}} <br>
                                                                        {{$vendorState}} -
                                                                        {{$vendorCountry}}</small>

                                                                  <p class="text-secondary mb-1">

                                                                  </p>

                                                                  <p>

                                                                  </p>
                                                            </div>
                                                            <p></p>
                                                            <br><br>
                                                            <div class="mt-1">
                                                                  <h4 id="invoice_ref">Reference: {{$supply_ref}}</h4>

                                                                  @if($status == 'accepted')
                                                                  <h3 class="text-success text-uppercase">
                                                                        {{$status}}</h3>

                                                                  @esle
                                                                  <h3 class="text-info text-uppercase">
                                                                        {{$status}}</h3>
                                                                  @endif
                                                            </div>
                                                      </div>
                                                </div>
                                          </div>

                                    </div>
                                    <!---row--->

                                    <div class="row mb-3">
                                          <div class="col-sm-12">

                                                <div class="table-responsive">
                                                      <table class="table table-striped">
                                                            <thead>
                                                                  <tr>
                                                                        <th>Action</th>
                                                                        <th>Item (s)</th>
                                                                        <th>Size/Weight</th>
                                                                        <th>Quantity</th>
                                                                        <th>Remark</th>
                                                                        <!---parent--->
                                                                        <th>Status</th>

                                                                  </tr>
                                                            </thead>
                                                            <tbody>
                                                                  @foreach($supply as $data)

                                                                  <tr>
                                                                        @auth
                                                                        <!---childvendor--->

                                                                        <td>
                                                                              @if(Auth::user()->role_id =='10')
                                                                              <button
                                                                                    class="btn btn-success btn-xs  text-dark">
                                                                                    Accept</button>
                                                                              <button
                                                                                    class="btn btn-danger btn-xs  text-white"
                                                                                    id="reject-{{ $data->id }}"
                                                                                    onclick="toggleClock({{$data->id}})">
                                                                                    Reject</button>

                                                                              @endif
                                                                              @if(Auth::user()->role_id =='9')
                                                                              <a class="text-danger"
                                                                                    href="/{{$username}}/edit-outlet-supply/{{$data->id}}"
                                                                                    title="edit">
                                                                                    <small> <i class="fa fa-edit"></i>
                                                                                          edit</small>
                                                                              </a>
                                                                              @endif
                                                                        </td>
                                                                        @endauth
                                                                        <td  width="30%"> 
                                                                              <input type="text" class="form-control" placeholder="enter a remark" id="remark-{{$data->id}}" style="display:none;">
                                                                        </td>

                                                                        <td width="20%"
                                                                              style="white-space:wrap; line-height:1.6">

                                                                              <small>
                                                                                    {!! nl2br($data->supply) !!}
                                                                              </small>
                                                                        </td>
                                                                        <td width="10%"
                                                                              style="white-space:wrap; line-height:1.6">
                                                                              @if($data->size == 0)
                                                                              <small>{{$data->weight}} </small>
                                                                              @else
                                                                              <small>{{$data->size}}
                                                                                    &nbsp;{{$data->weight}} </small>
                                                                              @endif
                                                                        </td>
                                                                        <td width="10%"
                                                                              style="white-space:wrap; line-height:1.6">
                                                                              <small>
                                                                                    @if($data->supply_qty == 0)
                                                                                    @else
                                                                                    {{$data->supply_qty}}
                                                                                    @endif
                                                                              </small>
                                                                        </td>

                                                                        <td width="30%"
                                                                              style="white-space:wrap; line-height:1.6">
                                                                              <small>
                                                                                    <!--  remark--->
                                                                              </small>
                                                                        </td>
                                                                        <!--  parent--->

                                                                        <td></td>
                                                                  </tr>

                                                                  @endforeach
                                                                  <tr>

                                                                        <th colspan="3" class="text-end">
                                                                        </th>
                                                                        <th></th>
                                                                        <th></th>

                                                                  </tr>
                                                                  <tr>

                                                                        <th colspan="4" class="text-end">
                                                                              @if($status == 'rejected')
                                                                              <span
                                                                                    class="text-danger">{{$data->remark}}</span>
                                                                              @endif
                                                                        </th>

                                                                        <th class="text-end">
                                                                              <h6>Total Items</h6>
                                                                        </th>
                                                                        <th>{{$supply->count()}} </th>

                                                                  </tr>



                                                            </tbody>
                                                      </table>
                                                </div>

                                          </div>


                                    </div>

                              </div>
                              <!---card body --->
                        </div>
                        <!---card --->

                  </div>
            </div>
            <!---row --->
      </div><!-- content-panel -->
      <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
                  <span class="text-muted text-center text-sm-left d-block d-sm-inline-block">Copyright ©
                        LocalEats Africa {{ date('Y')}} </a>. All rights
                        reserved.</span>
                  <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"><i
                              class="mdi mdi-heart text-danger"></i></span>
            </div>
      </footer>
</div><!-- main-panel -->

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js">
</script>
<script type="text/javascript" src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>

<script>
function printDiv() {
      var divContents = document.getElementById("print_invoice").innerHTML;
      var a = window.open();
      a.document.write('<html>');
      a.document.write(
            "<link rel='stylesheet' href='{{ asset('assets/css/style.css') }}' type='text/css' media='print'/>");
      a.document.write('<body> ');
      a.document.write(divContents);
      a.document.write('</body></html>');
      a.document.close();
      a.print();
}
</script>
<script>
//Create PDf from HTML...
function getPDF() {

      var HTML_Width = $(".print_invoice").width();
      var HTML_Height = $(".print_invoice").height();
      var top_left_margin = 15;
      var PDF_Width = HTML_Width + (top_left_margin * 2);
      var PDF_Height = (PDF_Width * 1.5) + (top_left_margin * 2);
      var canvas_image_width = HTML_Width;
      var canvas_image_height = HTML_Height;

      var totalPDFPages = Math.ceil(HTML_Height / PDF_Height) - 1;

      html2canvas($(".print_invoice")[0], {
            allowTaint: true
      }).then(function(canvas) {
            canvas.getContext('2d');

            console.log(canvas.height + "  " + canvas.width);
            var imgData = canvas.toDataURL("image/jpeg", 1.0);
            var pdf = new jsPDF('p', 'pt', [PDF_Width, PDF_Height]);
            pdf.addImage(imgData, 'JPG', top_left_margin, top_left_margin, canvas_image_width,
                  canvas_image_height);

            for (var i = 1; i <= totalPDFPages; i++) {
                  pdf.addPage(PDF_Width, PDF_Height);
                  pdf.addImage(imgData, 'JPG', top_left_margin, -(PDF_Height * i) + (
                        top_left_margin *
                        4), canvas_image_width, canvas_image_height);
            }
            pdf.save("supplies-{{$supply_ref}}.pdf");
      });
}
</script>

<script>
function mypdf() {
      document.getElementById('show-progress').style.display = '';
      document.getElementById('response').style.display = 'none';
      html2canvas($('#print_invoice')[0]).then(function(canvas) {
            var dataUrl = canvas.toDataURL();
            var newDataURL = dataUrl.replace(/^data:image\/png/,
                  "data:application/octet-stream"); //do this to clean the url.
            $("#saveBtn").attr("download", "your_pic_name.png").attr("href",
                  newDataURL); //incase you want to create a download link to save the pic locally.
            var id = document.getElementById('ref').value;
            var showRoute = "{{ route('send-email-pdf', ':id') }}";
            url = showRoute.replace(':id', id);
            // $token = document.getElementsByName("_token")[0].value;
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
                        'img': dataUrl
                  },
                  success: function(data) {
                        document.getElementById('show-progress').style.display = 'none';
                        console.log(data.message);
                        alert(data.message);
                        // document.getElementById('response').style.display = '';
                        // document.getElementById('response').style.color = 'green';
                        // document.getElementById('response').innerHTML = data.message;
                        window.location.reload();
                  },
                  error: function(data) {
                        console.log(data.message);
                        document.getElementById('response').innerHTML = data.message;
                  }
            });

      });
}
</script>


<script>

function toggleClock(data) {
    // get the clock
    var myClock = document.querySelector('#remark-' + data);

    // get the current value of the clock's display property
    var displaySetting = myClock.style.display;

    // also get the clock button, so we can change what it says
    var clockButton = document.querySelector('#reject-' + data);

    // now toggle the clock and the button text, depending on current state
    if (displaySetting == 'block') {
      // clock is visible. hide it
      myClock.style.display = 'none';
      // change button text
      clockButton.innerHTML = 'Reject';
    }
    else {
      // clock is hidden. show it
      myClock.style.display = 'block';
      // change button text
      clockButton.innerHTML = 'Reject';
    }
}
</script>

@endsection