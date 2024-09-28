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
                        All Food Menu
                  </h3>
                  <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                              <li class="breadcrumb-item active" aria-current="page">
                                    <span></span><a href="{{ url(auth()->user()->username, 'new-meal-menu') }}" class="btn btn-block btn-danger"><i
                                                class="fa fa-plus-square"></i> &nbsp;Create New Food Menu </a>
                              </li>
                        </ul>
                  </nav>
            </div>
            <!--Alert here--->
            <div class="row">
                  <div class="col-12">

                        @if(session('add-menu'))
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
                                    <div> {!! session('add-menu') !!}</div>
                              </div>
                              <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                        </div>
                        @endif

                        @if(session('food-status'))
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
                                    <div> {!! session('food-status') !!}</div>
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
            <!--end row here--->

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
                                                &nbsp; &nbsp;
                                    <!-- <span class="card-title">
                                          <button class="btn btn-outline-danger btn-sm delete_all"
                                                data-url="{{ url('bulk-delete-foodmenu') }}">Delete All
                                                Selected</button>
                                    </span> -->
                                          </div>
                                          <div class="ms-auto text-secondary">
                                                Search:
                                                <div class="ms-2 d-inline-block">

                                                      <form action="{{ url(auth()->user()->username, 'meal-menu') }}" method="GET" role="search">
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
                                                      <th>Posted by</th>
                                                      <th>Item</th>
                                                      <th>Price </th>
                                                      <th>Category</th>
                                                      <th></th>
                                                </tr>
                                          </thead>
                                          <tbody>
                                                @foreach($foodMenu as $data)
                                                <tr id="tr_{{$data->id}}">


                                                      <td class="text-sm"><small>{{$data->fullname}}</small></td>
                                                      <td><small>{{$data->food_item}}</small></td>
                                                      <td class="text-capitalize"><small>{{$data->price}}</small> </td>

                                                      <td><small>{{$data->category}}</small></td>

                                                      <!--- admin approve/edit --->
                                                      <td class="text-end">
                                                            <span class="dropdown">
                                                                  <button
                                                                        class="btn dropdown-toggle align-text-top text-danger"
                                                                        data-bs-boundary="viewport"
                                                                        data-bs-toggle="dropdown">Actions</button>
                                                                  <div class="dropdown-menu text-center ">

                                                                        <form action="{{ route('delete-food-menu', [$data->id]) }}"
                                                                              method="post" name="submit"
                                                                              enctype="multipart/form-data">
                                                                              @csrf

                                                                                    <input type="hidden"
                                                                                          value="{{$data->id}}">
                                                                                    <button type="submit"
                                                                                          class="text-dark btn btn-block">Delete</button>
                                                                             
                                                                        </form>
                                                                      
                                                                        <a class="dropdown-item btn btn-sm text-capitalize text-dark"
                                                                              href="edit-food-menu/{{$data->id}}">
                                                                              Edit
                                                                        </a>

                                                                  </div>
                                                            </span>
                                                      </td>



                                                </tr>
                                                @endforeach

                                          </tbody>

                                    </table>
                              </div>
                              <div class="card-footer d-flex align-items-center">
                                    <p class="m-0 text-secondary">

                                          Showing
                                          {{ ($foodMenu->currentPage() - 1) * $foodMenu->perPage() + 1; }} to
                                          {{ min($foodMenu->currentPage()* $foodMenu->perPage(), $foodMenu->total()) }}
                                          of
                                          {{$foodMenu->total()}} entries
                                    </p>

                                    <ul class="pagination m-0 ms-auto">
                                          @if(isset($foodMenu))
                                          @if($foodMenu->currentPage() > 1)
                                          <li class="page-item ">
                                                <a class="page-link text-danger"
                                                      href="{{ $foodMenu->previousPageUrl() }}" tabindex="-1"
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
                                                {{ $foodMenu->appends(compact('perPage'))->links()  }}
                                          </li>
                                          @if($foodMenu->hasMorePages())
                                          <li class="page-item">
                                                <a class="page-link text-danger" href="{{ $foodMenu->nextPageUrl() }}">
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
</div>


<script type="text/javascript">
$(document).ready(function() {

      $('#master').on('click', function(e) {
            if ($(this).is(':checked', true)) {
                  $(".form-check-input").prop('checked', true);
            } else {
                  $(".form-check-input").prop('checked', false);
            }
      });

      $('.delete_all').on('click', function(e) {

            var allVals = [];
            $(".form-check-input:checked").each(function() {
                  allVals.push($(this).attr('data-id'));
            });

            if (allVals.length <= 0) {
                  alert("Please select row.");
            } else {

                  var check = confirm("Are you sure you want to delete this row?");
                  if (check == true) {

                        var join_selected_values = allVals.join(",");


                        $.ajax({
                              url: $(this).data('url'),
                              method: 'POST',
                              enctype: 'multipart/form-data',
                              headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]')
                                          .attr('content')
                              },
                              data: 'ids=' + join_selected_values,
                              success: function(data) {
                                    if (data['success']) {
                                          $(".form-check-input:checked").each(
                                                function() {
                                                      $(this).parents(
                                                                  "tr")
                                                            .remove();
                                                });
                                          alert(data['success']);
                                    } else if (data['error']) {
                                          alert(data['error']);
                                    } else {
                                          alert(
                                                'Whoops Something went wrong!!'
                                          );
                                    }
                              },
                              error: function(data) {
                                    alert(data.responseText);
                              }
                        });

                        $.each(allVals, function(index, value) {
                              $('table tr').filter("[data-row-id='" + value + "']")
                                    .remove();
                        });
                  }
            }
      });
});
</script>
@endsection