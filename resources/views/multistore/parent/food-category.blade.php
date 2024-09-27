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
                        Food Category
                  </h3>
            </div>
            <!--Alert here--->
            <div class="row">
                  <div class="col-12">

                        @if(session('add-food-type'))
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
                                    <div> {!! session('add-food-type') !!}</div>
                              </div>
                              <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                        </div>
                        @endif

                        @if(session('error'))
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
                                    <div> {!! session('error') !!}</div>
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
                  <div class="col-12">
                  </div>
            </div>
            <p></p>

            <form method="post" action="{{ route('add-food-category') }}" name="submit" enctype="multipart/form-data">
                  @csrf
                  {{csrf_field()}}
                  <div class="row">
                        <div class="col-md-4 grid-margin stretch-card">
                              <div class="card">
                                    <div class="card-body">
                                          <div class="form-label required">Enter Category <i class="text-danger">*</i>
                                          </div>
                                          <input type="text" class="form-control" name="food_category">

                                          @error('food_category')
                                          <div class="alert alert-danger alert-dismissible" role="alert">
                                                <div class="d-flex">
                                                      <div>
                                                            <!-- Download SVG icon from http://tabler-icons.io/i/alert-circle -->
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                  class="icon alert-icon" width="24" height="24"
                                                                  viewBox="0 0 24 24" stroke-width="2"
                                                                  stroke="currentColor" fill="none"
                                                                  stroke-linecap="round" stroke-linejoin="round">
                                                                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                  <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                                                                  <path d="M12 8v4" />
                                                                  <path d="M12 16h.01" />
                                                            </svg>
                                                      </div>
                                                      <div>
                                                            {{ $message }}
                                                      </div>
                                                </div>
                                                <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                                          </div>
                                          @enderror
                                    </div>
                              </div>
                        </div>

                        <div class="col-md-4 grid-margin stretch-card">
                              <!-- send button here -->
                              <div class="card-footer bg-transparent mt-auto">
                                    <input type="hidden" name="parent" value="{{$parentID}}">
                                    <div class="btn-list ">
                                          <button type="submit" name="submit"
                                                class="btn bg-gradient-primary btn-sm  text-white">
                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                      class="icon icon-tabler icon-tabler-device-floppy" width="24"
                                                      height="24" viewBox="0 0 24 24" stroke-width="1.5"
                                                      stroke="currentColor" fill="none" stroke-linecap="round"
                                                      stroke-linejoin="round">
                                                      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                      <path
                                                            d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" />
                                                      <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                                      <path d="M14 4l0 4l-6 0l0 -4" />
                                                </svg>
                                                Add New
                                          </button>
                                    </div>
                              </div>
                        </div>


                        <div class="col-md-4 grid-margin stretch-card">

                        </div>


                  </div>
                  <!--- row---->

            </form>


            <!-- row -->
            <div class="row">
                  <div class="col-md-12">
                        <div class="card">
                              <div class="card-header">
                                    <h4 class="card-title">List </h4>
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

                                                      <form action="{{ route('food-type') }}" method="GET"
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
                                                      <th class="w-1"><input class="form-check-input m-0 align-middle"
                                                                  type="checkbox" aria-label="Select all product">
                                                      </th>
                                                      <th>SN</th>
                                                      <th>Food Category</th>
                                                      <th></th>
                                                </tr>
                                          </thead>
                                          <tbody>
                                                @foreach($foodCategory as $data)
                                                <tr>
                                                      <td><input class="form-check-input m-0 align-middle"
                                                                  type="checkbox" aria-label="Select"></td>
                                                      <td class="py-1">
                                                            {{$loop->iteration}}
                                                      </td>

                                                      <td class="text-capitalize">{{$data->food_category}}</td>


                                                      <td class="text-end">
                                                            <span class="dropdown">
                                                                  <button
                                                                        class="btn dropdown-toggle align-text-top text-danger"
                                                                        data-bs-boundary="viewport"
                                                                        data-bs-toggle="dropdown">Actions</button>
                                                                  <div class="dropdown-menu ">
                                                                        <a class="dropdown-item text-capitalize text-dark"
                                                                              href="delete-platform/{{$data->id}}">
                                                                              <small>Delete</small>
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
                                          {{ ($foodCategory->currentPage() - 1) * $foodCategory->perPage() + 1; }} to
                                          {{ min($foodCategory->currentPage()* $foodCategory->perPage(), $foodCategory->total()) }}
                                          of
                                          {{$foodCategory->total()}} entries
                                    </p>

                                    <ul class="pagination m-0 ms-auto">
                                          @if(isset($foodCategory))
                                          @if($foodCategory->currentPage() > 1)
                                          <li class="page-item ">
                                                <a class="page-link text-danger"
                                                      href="{{ $foodCategory->previousPageUrl() }}" tabindex="-1"
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
                                                {{ $foodCategory->appends(compact('perPage'))->links()  }}
                                          </li>
                                          @if($foodCategory->hasMorePages())
                                          <li class="page-item">
                                                <a class="page-link text-danger"
                                                      href="{{ $foodCategory->nextPageUrl() }}">
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
            <!-- row -->
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
<!-- End custom js for this page -->
@endsection