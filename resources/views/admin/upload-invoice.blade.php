@extends('layouts.head')
@extends('layouts.header')
@extends('layouts.sidebar')
@extends('layouts.footer')
@section('content')
<!-- main-panel -->
<div class="main-panel">
      <div class="content-wrapper">

            <div class="page-header">
                  <h3 class="page-title">Create Invoice</h3>

                  <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                              <li class="breadcrumb-item active" aria-current="page">
                                    <a id="square" class="blinking-text" href="{{ url('invoice-template') }}">Download Invoice Template</a>
                              </li>
                        </ul>
                  </nav>
            </div>
            <!---Alert --->

            <div class="row">
                  <div class="col-lg-12">

                  @if(session('invoice-status'))
                        <div class="alert  alert-success alert-dismissible" role="alert" id="success">
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

                        @if(session('invoice-error'))
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
                                    <div> {!! session('invoice-error') !!}</div>
                              </div>
                              <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                        </div>
                        @endif
                        @if(session('merge-error'))
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
                                    <div> {!! session('merge-error') !!}</div>
                              </div>
                              <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                        </div>
                        @endif
                  </div>
            </div>
            <!---end---alert--->

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
                        
            <div class="row">
                  <div class="container">
                        <div class="main-body">
                   
                              <div class="row">
                                    <div class="col-lg-5">
                                          <div class="card">
                                                <div class="card-body">
                                                      <div class="d-flex flex-column align-items-center text-center">
                                                            <img src="/assets/images/faces/user.png" alt="Admin"
                                                                  class="rounded-circle p-1 bg-dark" width="110">
                                                            <div class="mt-3">
                                                                  <h4>{{$vendorName}}</h4>
                                                                  <p class="text-secondary mb-1"> </p>

                                                            </div>
                                                      </div>
                                                      <hr class="my-4">


                                                </div>
                                          </div>
                                    </div>
                                    <div class="col-lg-7">
                                          <div class="card">
                                                <div class="card-body">
                                                      <div class="row mb-3">
                                                            <p></p>
                                                            <div class="col-sm-12">
                                                                  <h6 class="mb-0">Platforms</h6>
                                                            </div>
                                                      </div>
                                                     
                                                      <div class="row mb-3">
                                                      @foreach($vendorPlatforms as $platform)
                                                     
                                                            <div class="col-sm-5">
                                                                  <div class="form-group">
                                                                        @if(empty($platform->img_url) )
                                                                        <h6 class="mb-0 col-" style="color:#0C513F;">
                                                                              <i class="mdi mdi-alpha-c-circle text-chow fs-1"
                                                                                    width="44" height="44"></i>
                                                                        </h6>
                                                                        @else
                                                                        <span class="py-1">
                                                                              <img src="{{$platform->img_url}}"
                                                                                    class="rounded-circle" alt=""
                                                                                    width="44" height="44">
                                                                        </span>
                                                                        @endif
                                                                       &nbsp; {{$platform->platform_name}}
                             
                                                                  </div>
                                                            </div>
                                                           

                                                            <div class="col-sm-7">
                                                                  <form method="post" action="{{ route('add-invoice') }}" name="submit"  id=""  enctype="multipart/form-data">
                                                                  @csrf
                                                                  {{csrf_field()}}
                                                                        @foreach (\App\Models\Platforms::where('name', $platform->platform_name)->get('id') as $platform_id)
                                                                        @endforeach 
                                                                        <input type="hidden" name="platform"  value="{{$platform_id->id}}" >
                                                                        <input type="hidden" name="platform_name"  value="{{$platform->platform_name}}" >
                                                                        
                                                                        <input type="hidden" name="vendor"  value="{{$vendorID}}" >
                                                                        <div class="form-group" style="width:100%;">
                                                                              <input type="file" name="file" accept=".xlsx,.xls"
                                                                                    class="file-upload-default " id="file" >
                                                                                    <div class="input-group">
                                                                                          <div class="input-group-prepend">
                                                                                          <button class="file-upload-browse btn btn-sm  bg-gradient-dark  text-white py-2"
                                                                                                type="button"> 
                                                                                                <i class="mdi mdi-cloud-braces fs-24 menu-icon"></i></button>      
                                                                                          </div>
                                                                                          <input type="text" class="form-control file-upload-info"
                                                                                          disabled="" placeholder="xlsx,.xls" style="height:34px;">
                                                                                          <div class="input-group-append">
                                                                                                <button type="submit"  name="submit"
                                                                                                class="btn btn-outline-success btn-sm py-2">
                                                                                                <i class="mdi mdi-upload btn-icon-prepend fs-24"></i> Upload </button>
                                                                                          </div>
                                                                                    </div>
                                                                             
                                                                        </div>
                                                                      
                                                                      
                                                                  </form>
                                                                 
                                                            </div>
                                                           
                                                          
                                                            @endforeach
                                                      </div>
                                                    


                                                </div>
                                                <!---card body --->
                                          </div>
                                          <!---card --->

                                    </div>
                              </div>
                              <!---row --->

                              <div class="row">
                                    <div class="col-md-6">
                                    </div>
                                    <div class="col-md-6 col-12 grid-margin stretch-card justify-content-end">

                                          <!-- send button here -->
                                          <div class="card-footer bg-transparent mt-auto">
                                                <div class="btn-list ">
                                                      <form method="post" action="{{ route('merge-invoice') }}" enctype="multipart/form-data">
                                                      @csrf
                                                      {{csrf_field()}}
                                                      <input type="hidden" value="{{$vendorID}}" name="vendor">
                                                      <button type="submit"  class="btn text-white bg-gradient-primary ">Merge & Compute</button>
                                                </form>

                                                </div>
                                          </div>

                                    </div>
                              </div>
                              <!-- row -->

                        </div>
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


<script>
    $(document).ready(function() {
        $('#submit').submit(function(e) {
            e.preventDefault();

            // Serialize the form data
           const formData = new FormData(form);
            // Send an AJAX request
            $.ajax({
                method: 'POST',
                url: '/add-invoice',
                data: formData,
                dataType: 'json',
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                success: function(response) {
                    // Handle the response message
                    $('#success').text(response.message);
                },
                error: function(xhr, status, error) {
                    // Handle errors if needed
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>


@endsection