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
                        Add New Platform
                  </h3>
            </div>
            <!--Alert here--->
            <div class="row">
                  <div class="col-12">

                        @if(session('add-platform'))
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
                                    <div> {!! session('add-platform') !!}</div>
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
            <form method="post" action="{{ route('add-platform') }}" name="submit" enctype="multipart/form-data">
                  @csrf
                  {{csrf_field()}}
                  <div class="row">
                        <div class="col-md-4 grid-margin stretch-card">
                              <div class="card">
                                    <div class="card-body">
                                          <div class="form-label required">Platform Name <i class="text-danger">*</i>
                                          </div>
                                          <input type="text" class="form-control" name="name" placeholder="" value="">
                                          @error('name')
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
                              <div class="card">
                                    <div class="card-body">
                                          <div class="form-group">

                                                <label>Logo </label>
                                                <input type="file" name="logo" class="file-upload-default" id="logo">
                                                <div class="input-group col-xs-12">
                                                      <input type="text" class="form-control file-upload-info"
                                                            disabled="" placeholder="Upload Image">
                                                      <span class="input-group-append">
                                                            <button
                                                                  class="file-upload-browse btn btn-sm  bg-gradient-dark  text-white py-3"
                                                                  type="button">  <i class="mdi mdi-cloud-braces fs-24 menu-icon"></i></button>
                                                      </span>
                                                </div>
                                          </div>
                                          @error('logo')
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
                              <div class="card">
                                    <div class="card-body text-center">
                                          <div class="form-label ">Preview
                                          </div>
                                           <img id="logo-preview" src="" style="max-height: 50px;">
      
                                    </div>
                              </div>
                        </div>


                  </div>
                  <!--- row---->

                  <!-- row -->
                  <div class="row">
                        <div class="col-md-6">
                        </div>
                        <div class="col-md-6 col-12 grid-margin stretch-card justify-content-end">

                              <!-- send button here -->
                              <div class="card-footer bg-transparent mt-auto">
                                    <div class="btn-list ">
                                          <button type="submit" name="submit"
                                                class="btn bg-gradient-primary  text-white">
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
                                                Submit
                                          </button>
                                    </div>
                              </div>

                        </div>
                  </div>
                  <!-- row -->
            </form>
      </div>
      <!--- content wrapper---->
</div>
<!-- main-panel -->


<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

<script type="text/javascript">
$(document).ready(function(e) {

      $('#logo').change(function() {
            let reader = new FileReader();
            reader.onload = (e) => {
                  $('#logo-preview').attr('src', e.target
                        .result);
            }
            reader.readAsDataURL(this.files[0]);
      });

});
</script>
@endsection