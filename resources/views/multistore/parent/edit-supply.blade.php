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
                       Edit Supply for <span class="text-info">{{$outletStoreName}}</span> 
                  </h3>
                  <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                              <li class="breadcrumb-item active" aria-current="page">
                                    <span></span>
                                    Receipt <sup>No:</sup> <span class="text-info">{{$supply_ref}}</span> 
                              </li>
                        </ul>
                  </nav>
            </div>

            <p></p>
            <!--Alert here--->
            <div class="row ">
                  <div class="col-12">
                        @if(session('supply-status'))
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
                                    <div> {!! session('supply-status') !!}</div>
                              </div>
                              <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                        </div>
                        @endif


                        @if(session('supply-error'))
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
                                    <div> {!! session('supply-error') !!}</div>
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
                  <div class="col-12">
                        <form action="" method="post">
                              @csrf
                              <div class="card">
                                    <div class="card-header">
                                          <h3 class="card-title"> </h3>
                                          <h5>All field with <i class="text-danger">*</i> are required</h5>
                                    </div>
                                    <div class="card-body py-3">

                                    <div class="row">
                                                <p><h5>item: </h5></p>
                                                <div class="col-md-6">
                                                      <div class="form-group">
                                                            <input type="text" value="{{$supply->supply}}" name="vendor_name"
                                                                  class="form-control">
                                                      </div>
                                                </div>

                                                <div class="col-md-6">
                                                      <div class="form-group">
                                                          
                                                      </div>
                                                </div>

                                             
                                          </div>
                                          <!--- row-->


                                          </div>
                                          <!--- row-->

                                          <div class="row">
                                                <p></p>
                                                <div class="col-md-6">
                                                </div>
                                                <div
                                                      class="col-md-6 col-12 grid-margin stretch-card justify-content-end">

                                                      <!-- send button here -->
                                                      <div class="card-footer bg-transparent mt-auto">
                                                            <div class="btn-list ">
                                                                  <button type="submit" name="submit"
                                                                        class="btn bg-gradient-primary  text-white">
                                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                                              class="icon icon-tabler icon-tabler-device-floppy"
                                                                              width="24" height="24" viewBox="0 0 24 24"
                                                                              stroke-width="1.5" stroke="currentColor"
                                                                              fill="none" stroke-linecap="round"
                                                                              stroke-linejoin="round">
                                                                              <path stroke="none" d="M0 0h24v24H0z"
                                                                                    fill="none" />
                                                                              <path
                                                                                    d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" />
                                                                              <path
                                                                                    d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                                                                              <path d="M14 4l0 4l-6 0l0 -4" />
                                                                        </svg>
                                                                        Save Changes
                                                                  </button>
                                                            </div>
                                                      </div>

                                                </div>
                                          </div>
                                          <!--- row-->

                                    </div>
                              </div>
                              <!--- card-->
                        </form>
                  </div>
            </div>

      </div>
      <!--- content-wrapper-->
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
<!--- main-panel-->
@endsection