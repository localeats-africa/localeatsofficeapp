<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Invoice </title>

      <style>
      body {
            margin-top: 20px;
            color: #2e323c;
            background: #f5f6fa;
            position: relative;
            height: 100%;
      }

      .container {
  width: 100%;
  padding-right: 15px;
  padding-left: 15px;
  margin-right: auto;
  margin-left: auto;
}


.row {
  display: -ms-flexbox;
  display: flex;
  -ms-flex-wrap: wrap;
  flex-wrap: wrap;
  margin-right: -15px;
  margin-left: -15px;
}

.no-gutters {
  margin-right: 0;
  margin-left: 0;
}

.no-gutters > .col,
.no-gutters > [class*="col-"] {
  padding-right: 0;
  padding-left: 0;
}

.col-1, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-10, .col-11, .col-12, .col,
.col-auto, .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm,
.col-sm-auto, .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12, .col-md,
.col-md-auto, .col-lg-1, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg,
.col-lg-auto, .col-xl-1, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl,
.col-xl-auto {
  position: relative;
  width: 100%;
  padding-right: 15px;
  padding-left: 15px;
}

.col {
  -ms-flex-preferred-size: 0;
  flex-basis: 0;
  -ms-flex-positive: 1;
  flex-grow: 1;
  max-width: 100%;
}
  .col-sm-1 {
    -ms-flex: 0 0 8.333333%;
    flex: 0 0 8.333333%;
    max-width: 8.333333%;
  }
  .col-sm-2 {
    -ms-flex: 0 0 16.666667%;
    flex: 0 0 16.666667%;
    max-width: 16.666667%;
  }
  .col-sm-3 {
    -ms-flex: 0 0 25%;
    flex: 0 0 25%;
    max-width: 25%;
  }
  .col-sm-4 {
    -ms-flex: 0 0 33.333333%;
    flex: 0 0 33.333333%;
    max-width: 33.333333%;
  }
  .col-sm-5 {
    -ms-flex: 0 0 41.666667%;
    flex: 0 0 41.666667%;
    max-width: 41.666667%;
  }
  .col-sm-6 {
    -ms-flex: 0 0 50%;
    flex: 0 0 50%;
    max-width: 50%;
  }
  .col-sm-7 {
    -ms-flex: 0 0 58.333333%;
    flex: 0 0 58.333333%;
    max-width: 58.333333%;
  }
  .col-sm-8 {
    -ms-flex: 0 0 66.666667%;
    flex: 0 0 66.666667%;
    max-width: 66.666667%;
  }
  .col-sm-9 {
    -ms-flex: 0 0 75%;
    flex: 0 0 75%;
    max-width: 75%;
  }
  .col-sm-10 {
    -ms-flex: 0 0 83.333333%;
    flex: 0 0 83.333333%;
    max-width: 83.333333%;
  }
  .col-sm-11 {
    -ms-flex: 0 0 91.666667%;
    flex: 0 0 91.666667%;
    max-width: 91.666667%;
  }
  .col-sm-12 {
    -ms-flex: 0 0 100%;
    flex: 0 0 100%;
    max-width: 100%;
  }

  .card {
  position: relative;
  display: -ms-flexbox;
  display: flex;
  -ms-flex-direction: column;
  flex-direction: column;
  min-width: 0;
  word-wrap: break-word;
  background-color: #fff;
  background-clip: border-box;
  border: 1px solid rgba(0, 0, 0, 0.125);
  border-radius: 0.25rem;
}

.card > hr {
  margin-right: 0;
  margin-left: 0;
}

.card > .list-group:first-child .list-group-item:first-child {
  border-top-left-radius: 0.25rem;
  border-top-right-radius: 0.25rem;
}

.card > .list-group:last-child .list-group-item:last-child {
  border-bottom-right-radius: 0.25rem;
  border-bottom-left-radius: 0.25rem;
}

.card-body {
  -ms-flex: 1 1 auto;
  flex: 1 1 auto;
  min-height: 1px;
  padding: 1.25rem;
}

.card-title {
  margin-bottom: 0.75rem;
}

.card-subtitle {
  margin-top: -0.375rem;
  margin-bottom: 0;
}

.card-text:last-child {
  margin-bottom: 0;
}

.card-link:hover {
  text-decoration: none;
}

.card-link + .card-link {
  margin-left: 1.25rem;
}

.card-header {
  padding: 0.75rem 1.25rem;
  margin-bottom: 0;
  background-color: rgba(0, 0, 0, 0.03);
  border-bottom: 1px solid rgba(0, 0, 0, 0.125);
}

.card-header:first-child {
  border-radius: calc(0.25rem - 1px) calc(0.25rem - 1px) 0 0;
}

.card-header + .list-group .list-group-item:first-child {
  border-top: 0;
}

.card-footer {
  padding: 0.75rem 1.25rem;
  background-color: rgba(0, 0, 0, 0.03);
  border-top: 1px solid rgba(0, 0, 0, 0.125);
}

.card-footer:last-child {
  border-radius: 0 0 calc(0.25rem - 1px) calc(0.25rem - 1px);
}

.table-responsive {
  display: block;
  width: 100%;
  overflow-x: auto;
  -webkit-overflow-scrolling: touch;
}

.table-responsive > .table-bordered {
  border: 0;
}

.table {
  width: 100%;
  margin-bottom: 1rem;
  color: #212529;
}

.table th,
.table td {
  padding: 0.75rem;
  vertical-align: top;
  border-top: 1px solid #dee2e6;
}

.table thead th {
  vertical-align: bottom;
  border-bottom: 2px solid #dee2e6;
}

.table tbody + tbody {
  border-top: 2px solid #dee2e6;
}

.table-sm th,
.table-sm td {
  padding: 0.3rem;
}

.table-bordered {
  border: 1px solid #dee2e6;
}

.table-bordered th,
.table-bordered td {
  border: 1px solid #dee2e6;
}

.table-bordered thead th,
.table-bordered thead td {
  border-bottom-width: 2px;
}

.table-borderless th,
.table-borderless td,
.table-borderless thead th,
.table-borderless tbody + tbody {
  border: 0;
}

.table-striped tbody tr:nth-of-type(odd) {
  background-color: rgba(0, 0, 0, 0.05);
}


      .invoice-container {
            padding: 1rem;
      }

      .invoice-container .invoice-header .invoice-logo {
            margin: 0.8rem 0 0 0;
            display: inline-block;
            font-size: 1.6rem;
            font-weight: 700;
            color: #2e323c;
      }

      .invoice-container .invoice-header .invoice-logo img {
            max-width: 130px;
      }

      .invoice-container .invoice-header address {
            font-size: 0.8rem;
            color: #9fa8b9;
            margin: 0;
      }

      .invoice-container .invoice-details {
            margin: 1rem 0 0 0;
            padding: 1rem;
            line-height: 180%;
      }

      .invoice-container .invoice-details .invoice-num {
            text-align: right;
            font-size: 0.8rem;
      }

      .invoice-container .invoice-body {
            padding: 1rem 0 0 0;
      }

      .invoice-container .invoice-footer {
            text-align: center;
            font-size: 0.7rem;
            margin: 5px 0 0 0;
      }

      .invoice-status {
            text-align: center;
            padding: 1rem;
            background: #ffffff;
            -webkit-border-radius: 4px;
            -moz-border-radius: 4px;
            border-radius: 4px;
            margin-bottom: 1rem;
      }

      .invoice-status h2.status {
            margin: 0 0 0.8rem 0;
      }

      .invoice-status h5.status-title {
            margin: 0 0 0.8rem 0;
            color: #9fa8b9;
      }

      .invoice-status p.status-type {
            margin: 0.5rem 0 0 0;
            padding: 0;
            line-height: 150%;
      }

      .invoice-status i {
            font-size: 1.5rem;
            margin: 0 0 1rem 0;
            display: inline-block;
            padding: 1rem;
            background: #f5f6fa;
            -webkit-border-radius: 50px;
            -moz-border-radius: 50px;
            border-radius: 50px;
      }

      .invoice-status .badge {
            text-transform: uppercase;
      }

      @media (max-width: 767px) {
            .invoice-container {
                  padding: 1rem;
            }
      }


      .custom-table {
            border: 1px solid #e0e3ec;
      }

      .custom-table thead {
            background: #007ae1;
      }

      .custom-table thead th {
            border: 0;
            color: #ffffff;
      }

      .custom-table>tbody tr:hover {
            background: #fafafa;
      }

      .custom-table>tbody tr:nth-of-type(even) {
            background-color: #ffffff;
      }

      .custom-table>tbody td {
            border: 1px solid #e6e9f0;
      }


      .card {
            background: #ffffff;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
            border: 0;
            margin-bottom: 1rem;
      }

      .text-success {
            color: #00bb42 !important;
      }

      .text-muted {
            color: #9fa8b9 !important;
      }

      .custom-actions-btns {
            margin: auto;
            display: flex;
            justify-content: flex-end;
      }

      .custom-actions-btns .btn {
            margin: .3rem 0 .3rem .3rem;
      }
      </style>

</head>

<body>

      <div class="container">
            <div class="row" style="display: flex;">
                  <div class="col-sm-12">
                        <div class="card">
                              <div class="card-body p-0">
                                    <div class="invoice-container">
                                          <div class="invoice-header">
                                                <!-- Row start -->
                                                <!-- Row end -->
                                                <!-- Row start -->
                                                <div class="row" style="display: flex;">
                                                      <div class="col-sm-6">
                                                            <img src="{{ asset('assets/images/logo.png') }}" alt="Admin"
                                                                  class="invoice-logo" width="110">
                                                            <h4>LocalEats Africa</h4>
                                                      </div>
                                                      <div class="col-sm-6">
                                                            <div stlye="text-align: right;">
                                                                  <address class=" text-right">
                                                                        @foreach($data as $value)
                                                                        <h6> {{ $value['business_name'] }}</h6>
                                                                        @endforeach
                                                                  </address>
                                                                  <address class="text-right">
                                                                        @foreach($data as $value)
                                                                        {{ $value['address'] }} <br>
                                                                        {{ $value['state'] }} -
                                                                        {{ $value['country'] }}

                                                                        @endforeach
                                                                  </address>
                                                                  <address class="text-right">
                                                                        <h6>Contact:&nbsp;&nbsp;
                                                                              @foreach($data as $value)
                                                                              {{ $value['first_name'] }}&nbsp;
                                                                              {{ $value['last_name'] }}
                                                                              @endforeach
                                                                        </h6>
                                                                  </address>
                                                                  <address class="text-right">
                                                                        @foreach($data as $value)
                                                                        {{ $value['phone'] }}
                                                                        @endforeach
                                                                  </address>
                                                                  <address class="text-right">
                                                                        <h4>Invoice ID:
                                                                              @foreach($data as $value)
                                                                              {{ $value['invoice_ref'] }}
                                                                              @endforeach</h4>
                                                                        <h3 class="text-info text-uppercase">
                                                                              @foreach($data as $value)
                                                                              {{ $value['payment_status'] }}
                                                                              @endforeach
                                                                        </h3>
                                                                  </address>
                                                            </div>
                                                      </div>
                                                </div>
                                                <!-- Row end -->
                                                <!-- Row start -->
                                                <div class="row" style="display: flex;">
                                                      <div class="col-sm-9 ">
                                                            <div class="invoice-details">
                                                                  <address>
                                                                        2nd floor,10 Hughes Avenue, <br>
                                                                        Alagomeji, Yaba Lagos
                                                                  </address>
                                                                  <address>
                                                                        <i class="mdi mdi-email"></i>
                                                                        hi@localeats.africa<br>
                                                                        <i class="mdi mdi-web-check"></i>
                                                                        www.localeats.africa
                                                                  </address>
                                                            </div>
                                                      </div>
                                                      <div class="col-sm-3">
                                                            <div class="invoice-details">
                                                                  <div class="invoice-num">
                                                                        <div>Invoice - #009</div>
                                                                        <div>January 10th 2020</div>
                                                                  </div>
                                                            </div>
                                                      </div>
                                                </div>
                                                <!-- Row end -->
                                          </div>
                                          <div class="invoice-body">
                                                <!-- Row start -->
                                                <div class="row" style="display: flex;">
                                                      <div class="col-sm-12">
                                                            <div class="table-responsive">
                                                                  <table class="table ">
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
                                                                              @foreach($data as $value)

                                                                              <tr>
                                                                                    <td width="50%"
                                                                                          style="white-space:wrap">
                                                                                          <small>
                                                                                                {{ $value['description'] }}
                                                                                          </small>
                                                                                    </td>
                                                                                    <td>
                                                                                          {{ $value['order_invoice_ref'] }}
                                                                                     
                                                                                    </td>
                                                                                    <td>
                                                                                          {{ $value['delivery_date'] }}
                                                                                     
                                                                                    </td>
                                                                                    <td>
                                                                                          {{ $value['food_price'] }}
                                                                                     
                                                                                    </td>
                                                                                    <td>
                                                                                          {{ $value['extra'] }}
                                                                                     
                                                                                    </td>

                                                                              </tr>

                                                                              @endforeach
                                                                        </tbody>
                                                                  </table>
                                                            </div>
                                                      </div>
                                                </div>
                                                <!-- Row end -->
                                          </div>
                                          <div class="invoice-footer">
                                                Thank you for your Business.
                                          </div>
                                    </div>
                              </div>
                        </div>
                  </div>
            </div>
      </div>
</body>

</html>