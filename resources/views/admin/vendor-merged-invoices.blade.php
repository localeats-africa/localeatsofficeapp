@extends('layouts.head')
@extends('layouts.header')
@extends('layouts.sidebar')
@extends('layouts.footer')
@section('content')
<!-- main-panel -->
<div class="main-panel">
      <div class="content-wrapper">
            <div class="page-header">
                  <h3 class="page-title">
                        Merged Invoices
                  </h3>
            </div>

            <!--row-deck-->
            <p></p>
            <!--Alert here--->
            <div class="row ">
                  <div class="col-12">

                        @if(session('invoice'))
                        <div class="alert  alert-success alert-dismissible" role="alert">
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
                                    <div> {!! session('invoice') !!}</div>
                              </div>
                              <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                        </div>
                        @endif

                        @if(session('invoice-status'))
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
                                    <div> {!! session('invoice-status') !!}</div>
                              </div>
                              <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                        </div>
                        @endif
                  </div>
            </div>
            <!---end Alert --->
            <p></p>
            <div class="row ">
                  <div class="col-12">
                        <div class="card">
                              <div class="card-header">
                                    <h3 class="card-title"> </h3>
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

                                                      <form action="{{ route('vendor-merged-invoices') }}" method="GET"
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
                                                      <th>Upload Date</th>
                                                      <th>Vendor</th>
                                                      <th>Invoice Ref.</th>
                                                      <th>Invoice Date</th>

                                                      <th></th>
                                                </tr>
                                          </thead>
                                          <tbody>
                                                @foreach($orders as $data)
                                                <tr>
                                                      <td>{{date('d/m/Y',  strtotime($data->created_at))}}</td>
                                                      <td class="text-sm">{{$data->vendor_name}} </td>
                                                      <td>{{ $data->invoice_ref}}</td>

                                                      <td>
                                                            @if($data->invoice_start_date == null)
                                                            @else
                                                            {{date('d/m/Y',  strtotime($data->invoice_start_date))}} -
                                                            {{date('d/m/Y',  strtotime($data->invoice_end_date))}}
                                                            @endif
                                                      </td>

                                                      <td class="">
                                                            @auth
                                                            @if(Auth::user()->role_id == '2')
                                                            <span class="dropdown">
                                                                  <button
                                                                        class="btn dropdown-toggle align-text-top text-danger"
                                                                        data-bs-boundary="viewport"
                                                                        data-bs-toggle="dropdown"
                                                                        style="padding:0;">Action</button>


                                                                  <div class="dropdown-menu ">
                                                                        <a class="dropdown-item text-danger"
                                                                              href="computed-invoice/{{$data->id}}/{{$data->number_of_order_merge}}/{{$data->invoice_ref}}">View
                                                                        </a>
                                                                        <br>
                                                                        <a class="dropdown-item text-danger"
                                                                              href="invoice-comment/{{$data->invoice_ref}}">Comments
                                                                        </a>
                                                                        <br>
                                                                        @if($data->payment_status == 'paid')
                                                                        @else

                                                                        <input type="hidden" id="vendor_id"
                                                                              value="{{$data->vendor_id}}">
                                                                        <input type="hidden" id="invoice_ref"
                                                                              value="{{$data->invoice_ref}}">
                                                                        <a class="dropdown-item text-danger"
                                                                              href="delete-invoice/{{$data->invoice_ref}}">
                                                                              Delete</a>

                                                                        @endif

                                                                  </div>
                                                            </span>
                                                            <p id="response"></p>

                                                            @endif

                                                            @if(Auth::user()->role_id == '6')
                                                            <span class="dropdown">
                                                                  <button
                                                                        class="btn dropdown-toggle align-text-top text-danger"
                                                                        data-bs-boundary="viewport"
                                                                        data-bs-toggle="dropdown"
                                                                        style="padding:0;">Action</button>

                                                                  <div class="dropdown-menu ">

                                                                        <a class="dropdown-item text-dark"
                                                                              href="computed-invoice/{{$data->id}}/{{$data->number_of_order_merge}}/{{$data->invoice_ref}}"
                                                                             ><small>View</small></a>
                                                                        <br>
                                                                        <a class="dropdown-item text-dark"
                                                                              href="invoice-comment/{{$data->invoice_ref}}"><small>Comments</small>
                                                                        </a>
                                                                        <br>
                                                                  </div>

                                                            </span>
                                                            @endif

                                                            @if(Auth::user()->role_id == '8')
                                                            <span class="dropdown">
                                                                  <button
                                                                        class="btn dropdown-toggle align-text-top text-danger"
                                                                        data-bs-boundary="viewport"
                                                                        data-bs-toggle="dropdown"
                                                                        style="padding:0;">Action</button>
                                                            <div class="dropdown-menu ">

                                                                  <a class="dropdown-item text-dark"
                                                                        href="computed-invoice/{{$data->id}}/{{$data->number_of_order_merge}}/{{$data->invoice_ref}}"
                                                                      ><small>View</small></a>
                                                                  <br>
                                                                  <a class="dropdown-item text-dark"
                                                                        href="invoice-comment/{{$data->invoice_ref}}"><small>Comments</small>
                                                                  </a>
                                                                  <br>

                                                            </div>
                                                            </span>
                                                            @endif
                                                            @endauth
                                                      </td>

                                                </tr>
                                                @endforeach

                                          </tbody>

                                    </table>
                              </div>
                              <div class="card-footer d-flex align-items-center">
                                    <p class="m-0 text-secondary">

                                          Showing
                                          {{ ($orders->currentPage() - 1) * $orders->perPage() + 1; }} to
                                          {{ min($orders->currentPage()* $orders->perPage(), $orders->total()) }}
                                          of
                                          {{$orders->total()}} entries
                                    </p>

                                    <ul class="pagination m-0 ms-auto">
                                          @if(isset($orders))
                                          @if($orders->currentPage() > 1)
                                          <li class="page-item ">
                                                <a class="page-link text-danger" href="{{ $orders->previousPageUrl() }}"
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
                                                {{ $orders->appends(compact('perPage'))->links()  }}
                                          </li>
                                          @if($orders->hasMorePages())
                                          <li class="page-item">
                                                <a class="page-link text-danger" href="{{ $orders->nextPageUrl() }}">
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
      <!--- content-wrapper-->
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

<script type="text/javascript">
function deleteInvoice() {
      document.getElementById('response').style.display = 'none';
      var id = document.getElementById('invoice_ref').value;
      var vendor_id = document.getElementById('vendor_id').value;
      var showRoute = "{{ route('delete-invoice', ':id') }}";
      url = showRoute.replace(':id', id);

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
                  'vendor_id': vendor_id
            },
            success: function(data) {
                  console.log(data.message);
                  document.getElementById('response').style.display = '';
                  document.getElementById('response').style.color = 'green';
                  document.getElementById('response').innerHTML = data.message;
                  // location.reload();
            },
            error: function(data) {
                  console.log(data);
            }
      });

}
</script>
@endsection