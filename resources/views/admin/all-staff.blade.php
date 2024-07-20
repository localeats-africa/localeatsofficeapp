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
                        All Staff (s)
                  </h3>
                  <nav aria-label="breadcrumb">
                        <ul class="breadcrumb">
                              <li class="breadcrumb-item active" aria-current="page">
                                    <span></span><a href="{{ url('new-staff') }}" class="btn btn-block btn-danger"><i
                                                class="fa fa-plus-square"></i> &nbsp;New Staff </a>
                              </li>
                        </ul>
                  </nav>
            </div>
            <p></p>
            <div class="row ">
                  <div class="col-12">
                        <div class="row row-cards">
                              <div class="col-md-4 stretch-card grid-margin">
                                    <div class="card bg-gradient-info card-img-holder text-white">
                                          <div class="card-body">
                                                <img src="{{ asset('assets/images/dashboard/circle.svg')}}"
                                                      class="card-img-absolute" alt="circle-image">
                                                <h4 class="font-weight-normal">Staff (s) <i
                                                            class="mdi mdi-account-multiple  mdi-24px float-end"></i>
                                                </h4>
                                                <h2 class="mb-5">{{$user->count()}}</h2>
                                                <hr class="w-100">
                                                <h6 class="card-text"> online</h6>
                                          </div>
                                    </div>
                              </div>
                        </div>
                  </div>
            </div>
            <p></p>
            <!--Alert here--->
            <div class="row ">
                  <div class="col-12">
                        @if(session('staff-assign'))
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
                                    <div> {!! session('staff-assign') !!}</div>
                              </div>
                              <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                        </div>
                        @endif

                        @if(session('staff-status'))
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
                                    <div> {!! session('staff-status') !!}</div>
                              </div>
                              <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                        </div>
                        @endif

                  </div>
            </div>
            <!---end Alert --->
            <p></p>
            <div class="row">
                  <div class="d-flex">
                        <div class="text-secondary">
                              Show
                              <div class="mx-2 d-inline-block">
                                    <select id="pagination" class="form-control form-control-sm" name="perPage">
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

                                    <form action="{{ route('all-staff') }}" method="GET" role="search">
                                          {{ csrf_field() }}
                                          <div class="input-group mb-2">
                                                <input type="text" class="form-control" placeholder="Search for…"
                                                      name="search">
                                                <button type="submit" class="btn" type="button">Go!</button>
                                          </div>
                                    </form>
                              </div>
                        </div>
                  </div>

                  @foreach($user as $data)
                  @php
                  $words = explode(" ", $data->fullname, 2 );
                  $initials = null;
                  foreach ($words as $w) {
                  $initials .= $w[0];
                  }
                  @endphp
                  <div class="col-md-4 col-12">
                        <div class="card" style=" border:2px;">
                              <div class="card-body p-4 text-center">

                                    <span class="avatar avatar-xl mb-3 rounded">{{$initials}}</span>
                                    <h3 class="m-0 mb-1">{{$data->fullname }}</h3>
                                    <div class="text-secondary">{{ $data->role_name}}</div>

                                    <div class="mt-3">
                                          @if($data->role_id =='3')
                                          <span class="badge bg-primary">{{$data->email}}</span>
                                          @elseif ($data->role_id =='4')
                                          <span class="badge bg-info">{{$data->email}}</span>
                                          @elseif($data->role_id =='5')
                                          <span class="badge bg-warning">{{$data->email}}</span>
                                          @elseif($data->role_id =='6')
                                          <span class="badge bg-danger">{{$data->email}}</span>

                                          @elseif($data->role_id =='7')
                                          <span class="badge bg-success">{{$data->email}}</span>
                                          @else
                                          <span class="badge bg-secondary">{{$data->email}}</span>
                                          @endif
                                    </div>

                              </div>
                              <div class="d-flex">
                                    <a href="mailto:{{$data->email}}" class="card-btn">
                                          <!-- Download SVG icon from http://tabler-icons.io/i/mail -->
                                          <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-muted"
                                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                      d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z" />
                                                <path d="M3 7l9 6l9 -6" />
                                          </svg>
                                    </a>
                                    <a href="tel:{{ $data->phone}}" class="card-btn">
                                          <!-- Download SVG icon from http://tabler-icons.io/i/phone -->
                                          <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-muted"
                                                width="24" height="24" viewBox="0 0 24 24" stroke-width="2"
                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                stroke-linejoin="round">
                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                <path
                                                      d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" />
                                          </svg>
                                    </a>
                                    @if($data->role_id =='7')

                                    @if(empty($data->vendor))
                                    <a href="{{ url('assign-vendor', [$data->id]) }}" class="card-btn"
                                          title="Assign To A Vendor">
                                          <i class="mdi mdi-pot-steam icon me-2  text-muted"></i>
                                    </a>
                                    @else
                                    <div class="dropdown card-btn text-muted">
                                          <a class="dropdown-toggle text-muted " href="#"
                                                data-bs-toggle="dropdown" aria-haspopup="true"
                                                aria-expanded="false" style="text-decoration:none;">Assigned</a>
                                          <div class="dropdown-menu dropdown-menu-end">
                                         <p class="dropdown-item text-dark" style="white-space:wrap; line-height:1.6"> {{ $data->vendor_name}}</p>
                                          </div>
                                    </div>
                                    @endif

                                    @endif
                              </div>


                        </div>
                        <!--card  --->
                        <br>
                  </div>
                  @endforeach
                  <p></p>
                  <div class="d-flex">
                        <p></p>
                        <div class="card-footer d-flex align-items-center">

                              <span></span>
                              <p class="m-0 text-secondary">

                                    Showing
                                    {{ ($user->currentPage() - 1) * $user->perPage() + 1; }} to
                                    {{ min($user->currentPage()* $user->perPage(), $user->total()) }}
                                    of
                                    {{$user->total()}} entries
                              </p>

                              <ul class="pagination m-0 ms-auto">
                                    @if(isset($user))
                                    @if($user->currentPage() > 1)
                                    <li class="page-item ">
                                          <a class="page-link text-danger" href="{{ $user->previousPageUrl() }}"
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
                                          {{ $user->appends(compact('perPage'))->links()  }}
                                    </li>
                                    @if($user->hasMorePages())
                                    <li class="page-item">
                                          <a class="page-link text-danger" href="{{ $user->nextPageUrl() }}">
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

            </div>
            <!--row  --->

            <p></p>


      </div>
      <!--- content wrapper---->
</div>
<!-- main-panel -->
@endsection