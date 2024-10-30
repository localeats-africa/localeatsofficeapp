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
                        Leave a comment on {{$invoice_ref}}
                  </h3>
            </div>
            <!--Alert here--->
            <div class="row">
                  <div class="col-12">
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

            <form method="post" action="{{ route('add-role') }}" name="submit" enctype="multipart/form-data">
                  @csrf
                  {{csrf_field()}}
                  <div class="row">
                        <div class="col-md-12 grid-margin stretch-card">
                              <div class="card">
                                    <div class="card-body">
                                          <div class="form-label required">New Comment <i class="text-danger">*</i>
                                          </div>

                                          <textarea id="description" class="form-control"></textarea>
                                          <div id="content">{!! old('description') !!}</div>

                                    </div>
                              </div>
                        </div>






                  </div>
                  <!--- row---->

            </form>


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



<script src="https://cdn.jsdelivr.net/npm/quill@2/dist/quill.core.js"></script>

<script>
tinymce.init({
      selector: 'textarea#description',
      menubar: false,
      plugins: 'code table lists image',
      toolbar: 'undo redo | blocks | bold italic |',
});
</script>



@endsection

