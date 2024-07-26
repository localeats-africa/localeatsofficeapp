@extends('layouts.head')
@extends('layouts.header')
@extends('layouts.sidebar')
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
                  <h3 class="page-title">Invoice</h3>
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
                              <form action="{{ route('export-invoice', [$invoice_ref]) }}" method="post" name="submit"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" value="{{$invoice_ref}}" name="invoice_ref">
                                    <button type="submit" name="submit" class="btn btn-info">Export To
                                          Excel</button>
                              </form>
                              <nav style="--bs-breadcrumb-divider: '';" aria-label="breadcrumb">
                                    <p id="response"></p>
                                    <ol class="breadcrumb">
                                          <li class="breadcrumb-item">
                                                <button class="btn btn-outline-dark  text-dark" onclick="printDiv()">
                                                      <i class="fa fa-print"></i></button>
                                          </li>
                                          <li class="breadcrumb-item">
                                                <button class="btn btn-outline-dark  text-dark" onclick="getPDF()">
                                                      <i class="fa fa-download"></i></button>
                                          </li>
                                          <li class="breadcrumb-item">
                                                <input type="hidden" value="{{$invoice_ref}}" name="ref" id="ref">
                                                <input type="hidden" value="{{$vendor}}" name="vendor" id="vendor">
                                                <button onclick="mypdf()" class="btn btn-outline-dark  text-dark">
                                                      <i class="fa fa-envelope"></i></button>
                                                <div class="progress" id="show-progress" style="display:none;">
                                                      <span class="progress-bar progress-bar-animated"> &nbsp; &nbsp; loading
                                                            ...</span>
                                                      <!-- <div class="progress-bar progress-bar-striped  progress-bar-animated"
                                                            role="progressbar" aria-valuenow="75" aria-valuemin="0"
                                                            aria-valuemax="100" style="width: 75%"></div> -->
                                                </div>

                                          </li>

                                          <li class="breadcrumb-item">
                                                <button class="btn btn-outline-dark  text-dark">
                                                      <i class="fa fa-whatsapp"></i></button>
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
                                                      <h4>LocalEats Africa</h4>
                                                      <div class="mt-1 text-secondary" style="line-height:1.7">
                                                            <small>2nd floor,10 Hughes Avenue, <br>
                                                                  Alagomeji, Yaba Lagos</small>
                                                            <br>
                                                            <small> <i class="mdi mdi-email"></i>
                                                                  hi@localeats.africa
                                                                  <br>
                                                                  <i class="mdi mdi-web-check"></i>
                                                                  www.localeats.africa</small>


                                                      </div>
                                                </div>
                                          </div>

                                          <div class="col-md-6 col-6">
                                                <div class="row mb-3">
                                                      <p></p>
                                                      <div class="col-sm-12" style="text-align:right;">
                                                            <h6 class="mb-0">{{$vendorBusinessName}}</h6>
                                                            <div class="mt-1 text-secondary ">
                                                                  <small> {{$vendorAddress}} <br>
                                                                        {{$vendorState}} -
                                                                        {{$vendorCountry}}</small>

                                                                  <p class="text-secondary mb-1">
                                                                  <h6></h6>
                                                                  <h6><span class="text-dark mb-1">Contact:</span>
                                                                        &nbsp;&nbsp;
                                                                        {{$vendorFname}}&nbsp;{{$vendorLname}}</h6>

                                                                  <i class="fa fa-phone"></i>
                                                                  {{$vendorPhone}}</small>
                                                                  </p>

                                                                  <p>
                                                                  <h6><span class="text-dark mb-1">Bank Name:</span>
                                                                        &nbsp;&nbsp; {{$vendorBankName}}</h6>
                                                                  <h6> <span class="text-dark mb-1">Account
                                                                              Number:</span>
                                                                        &nbsp;&nbsp;{{$vendorAccountNumber}}</h6>
                                                                  <h6><span class="text-dark mb-1">Account Name:</span>
                                                                        &nbsp;&nbsp;{{$vendorAccountName}}</h6>

                                                                  </p>
                                                            </div>
                                                            <p></p>
                                                            <br><br>
                                                            <div class="mt-1">
                                                                  <h4 id="invoice_ref">Invoice ID: {{$invoice_ref}}</h4>

                                                                  @if($payment_status == 'paid')
                                                                  <h3 class="text-success text-uppercase">
                                                                        {{$payment_status}}</h3>
                                                                  @else
                                                                  <h3 class="text-info text-uppercase">
                                                                        {{$payment_status}}</h3>
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
                                                                        <th>Item (s)</th>
                                                                        <th>Order Ref</th>
                                                                        <th>Delivery Date</th>
                                                                        <th>Food Price</th>
                                                                        <th>Extra</th>
                                                                  </tr>
                                                            </thead>
                                                            <tbody>
                                                                  @foreach($orders as $data)

                                                                  <tr>
                                                                        <td width="50%"
                                                                              style="white-space:wrap; line-height:1.6">
                                                                              <small>
                                                                                    {!! nl2br($data->description) !!}
                                                                              </small>
                                                                        </td>
                                                                        <td><small>{{$data->order_ref}}</small></td>
                                                                        <td><small>{{ date('d/m/Y', strtotime($data->delivery_date))}}</small>
                                                                        </td>
                                                                        <td><small>{{number_format(floatval($data->food_price))}}</small>
                                                                        </td>
                                                                        <td><small>{{number_format(floatval($data->extra))}}</small>
                                                                        </td>

                                                                  </tr>

                                                                  @endforeach
                                                                  <tr>

                                                                        <th colspan="3" class="text-end">
                                                                        </th>
                                                                        <th></th>
                                                                        <th></th>

                                                                  </tr>
                                                                  <tr>
                                                                        <th colspan="3" class="text-end">
                                                                              @auth
                                                                              @if(Auth::user()->role_id =='2')
                                                                              @if($payment_status == 'paid')
                                                                              @else
                                                                              <input type="hidden" value="{{$vendor}}" id="vendor_id">
                                                                              <input type="hidden" value="{{$invoice_ref}}" id="invoiceRef">
                                                                              <button onclick="markAsPaid()"
                                                                                    class="btn btn-block btn-success text-dark">Mark
                                                                                    This Invoice As Paid</button>
                                                                              @endif
                                                                              @else
                                                                              @endif
                                                                              @endauth
                                                                        </th>

                                                                        <th class="text-end">
                                                                              <h6>Total Amount (₦)</h6>
                                                                              <span id="response"></span>
                                                                        </th>
                                                                        <th>{{number_format($payout, 2)}}
                                                                        </th>

                                                                  </tr>


                                                                  <tr>
                                                                        <th colspan="4" class="text-end">
                                                                              <h6>Total Order (s)</h6>
                                                                        </th>
                                                                        <th>{{$orders->count() }}</th>

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
function markAsPaid() {
      document.getElementById('response').style.display = 'none';
      var id = document.getElementById('invoiceRef').value;
      var vendor_id = document.getElementById('vendor_id').value;
      var showRoute = "{{ route('mark-invoice-paid', ':id') }}";
      url = showRoute.replace(':id', id);

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
                  'vendor_id': vendor_id
            },
            success: function(data) {
                  console.log(data.message);
                  alert(data.message);
                  // document.getElementById('response').style.display = '';
                  // document.getElementById('response').style.color = 'green';
                  // document.getElementById('response').innerHTML = data.message;
                  window.location.reload();
            },
            error: function(data) {
                  console.log(data);
            },
            complete: function() {
                  setTimeout(ajax, 1000);
            }
      });
}
</script>

<script>
function exportInvoice() {
      var id = document.getElementById('invoice_ref').value;
      var showRoute = "{{ route('export-invoice', ':id') }}";
      url = showRoute.replace(':id', id);

      window.location = url;

}
</script>
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
            pdf.save("invoice-{{$invoice_ref}}.pdf");
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

                        document.getElementById('response').style.display = '';
                        document.getElementById('response').style.color = 'green';
                        document.getElementById('response').innerHTML = data.message;

                  },
                  error: function(data) {
                        console.log(data.message);
                        document.getElementById('response').innerHTML = data.message;
                  }
            });

      });
}
</script>

@endsection