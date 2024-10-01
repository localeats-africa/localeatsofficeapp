</style>
<!-- main-panel -->
<div class="main-panel">
      <div class="content-wrapper">
            <div class="page-header">
                  <h3 class="page-title">
                        <span class="text-info">{{$vendorName}}</span> >>>> Add New Sales
                  </h3>
            </div>

            <p></p>
            <!--Alert here--->
            <div class="row ">
                  <div class="col-12">
                      


                  </div>
            </div>
            <!---end Alert --->



            <div class="row">
                  <h6 class="text-danger">Check multiple one or more food item, enter each quantity, enter
                        total price and date</h6>
                  <p></p>
                  <div class="col-md-6 col-12 list-wrapper">
                        <form method="post" action="{{ route('add-vendor-offline-soup') }}" name="submit"
                              enctype="multipart/form-data">
                              @csrf
                              {{csrf_field()}}
                              <h6>Soup</h6>

                              <ul class="d-flex flex-column-reverse ">
                                    @foreach($vendorSoup as $data)
                                    <li>
                                          <div class="form-check">
                                                <label class="form-check-label">
                                                      <input class="checkbox" type="checkbox" name="soup[]"
                                                            value="{{$data->soup}}" multiple="multiple">{{$data->soup}}
                                                      <i class="input-helper"></i>
                                                </label>
                                          </div>

                                          <i class="remove"></i>
                                          <input type="hidden" value="{{ $data->id }}" name="soup_id[]">

                                          <input class="form-control" type="text" name="soup_price[]"
                                                value="{{$data->soup_price}}" style="width:85px;" disabled>

                                          <div class="btn btn-sm" id="decreaseSoup-{{ $data->id }}"
                                                onclick="decreaseSoup({{$data->id}})" value="Decrease Value">-</div>

                                          <input type="text" class="form-control" name="soup_qty[]" value="1"
                                                style="width:85px;" id="soup-{{ $data->id }}">

                                          <div class="btn btn-sm" id="increaseSoup-{{ $data->id }}"
                                                onclick="increaseSoup({{$data->id}})" value="Increase Value">+</div>

                                    </li>

                                    @endforeach
                              </ul>

                              <div class="form-group">
                                    <h6 for="">Date</h6>
                                    <br>
                                    <div class="input-group date">

                                          <input type="text" class="form-control" value="{{ date('Y-m-d')}}" id="date1"
                                                name="date" placeholder="Enter expenses" />
                                          <input id="vendor" name="vendor" type="hidden" value="{{ $vendor_id }}" />
                                          <button type="submit" name="submit"
                                                class="btn bg-gradient-primary btn-sm  text-white">Save Soup</button>
                                    </div>
                              </div>

                        </form>

                  </div>
                  <div class="col-md-6 col-12 list-wrapper">
                        <form method="post" action="{{ route('add-vendor-offline-swallow') }}" name="submit"
                              enctype="multipart/form-data">
                              @csrf
                              {{csrf_field()}}
                              <h6>Swallow</h6>
                              <ul class="d-flex flex-column-reverse ">
                                    @foreach($vendorSwallow as $data)
                                    <li>
                                          <div class="form-check">
                                                <label class="form-check-label">
                                                      <input class="checkbox" type="checkbox" name="swallow[]"
                                                            value="{{$data->swallow}}">{{$data->swallow}}
                                                </label>
                                          </div>

                                          <i class="remove"></i>
                                          <input class="form-control" type="text" name="swallow_price[]"
                                                value="{{$data->swallow_price}}" style="width:85px;" disabled>

                                          <div class="btn btn-sm" id="decreaseSwallow-{{ $data->id }}"
                                                onclick="decreaseSwallow({{$data->id}})" value="Decrease Value">-</div>

                                          <input type="text" class="form-control" name="swallow_qty[]" value="1"
                                                style="width:85px;" id="swallow-{{ $data->id }}">

                                          <div class="btn btn-sm" id="increaseSwallow-{{ $data->id }}"
                                                onclick="increaseSwallow({{$data->id}})" value="Increase Value">+</div>

                                    </li>
                                    @endforeach
                              </ul>

                              <div class="form-group">
                                    <h6 for="">Date</h6>
                                    <br>
                                    <div class="input-group date">

                                          <input type="text" class="form-control" value="{{ date('Y-m-d')}}" id="date2"
                                                name="date" placeholder="Enter expenses" />
                                          <input id="vendor" name="vendor" type="hidden" value="{{ $vendor_id }}" />
                                          <button type="submit" name="submit"
                                                class="btn bg-gradient-primary btn-sm  text-white">Save Swallow</button>
                                    </div>
                              </div>
                        </form>

                  </div>
            </div>


            <div class="row">
                  <div class="col-md-6 col-12 list-wrapper">
                        <form method="post" action="{{ route('add-vendor-offline-protein') }}" name="submit"
                              enctype="multipart/form-data">
                              @csrf
                              {{csrf_field()}}
                              <h6>Protein</h6>
                              <ul class="d-flex flex-column-reverse ">
                                    @foreach($vendorProtein as $data)
                                    <li>
                                          <div class="form-check">
                                                <label class="form-check-label">
                                                      <input class="checkbox" type="checkbox" name="protein[]"
                                                            value="{{$data->protein}}">{{$data->protein}}
                                                </label>
                                          </div>

                                          <i class="remove"></i>
                                          <input class="form-control" type="text" name="protein_price[]"
                                                value="{{$data->protein_price}}" style="width:85px;" disabled>

                                          <div class="btn btn-sm" id="decreaseProtein-{{ $data->id }}"
                                                onclick="decreaseProtein({{$data->id}})" value="Decrease Value">-</div>

                                          <input type="text" class="form-control" name="protein_qty[]" value="1"
                                                style="width:85px;" id="protein-{{ $data->id }}">

                                          <div class="btn btn-sm" id="increaseProtein-{{ $data->id }}"
                                                onclick="increaseProtein({{$data->id}})" value="Increase Value">+</div>


                                    </li>
                                    @endforeach
                              </ul>

                              <div class="form-group">
                                    <h6 for="">Date</h6>
                                    <br>
                                    <div class="input-group date">

                                          <input type="text" class="form-control" value="{{ date('Y-m-d')}}" id="date3"
                                                name="date" placeholder="Enter expenses" />
                                          <input id="vendor" name="vendor" type="hidden" value="{{ $vendor_id }}" />
                                          <button type="submit" name="submit"
                                                class="btn bg-gradient-primary btn-sm  text-white">Save Protein</button>
                                    </div>
                              </div>
                        </form>

                  </div>


                  <div class="col-md-6 col-12 list-wrapper">
                        <form method="post" action="{{ route('add-vendor-offline-others') }}" name="submit"
                              enctype="multipart/form-data">
                              @csrf
                              {{csrf_field()}}
                              <h6>Others</h6>
                              <ul class="d-flex flex-column-reverse ">
                                    @foreach($vendorOthersFoodItem as $data)
                                    <li>
                                          <div class="form-check">
                                                <label class="form-check-label">
                                                      <input class="checkbox" type="checkbox" name="others[]"
                                                            value="{{$data->others}}">{{$data->others}}
                                                </label>
                                          </div>

                                          <i class="remove"></i>
                                          <input class="form-control" type="text" name="others_price[]"
                                                value="{{$data->others_price}}" style="width:85px;" disabled>

                                          <div class="btn btn-sm" id="decreaseOthers-{{ $data->id }}"
                                                onclick="decreaseOthers({{$data->id}})" value="Decrease Value">-</div>

                                          <input type="text" class="form-control" name="others_qty[]" value="1"
                                                style="width:85px;" id="others-{{ $data->id }}">

                                          <div class="btn btn-sm" id="increaseOthers-{{ $data->id }}"
                                                onclick="increaseOthers({{$data->id}})" value="Increase Value">+</div>



                                    </li>
                                    @endforeach
                              </ul>
                              <div class="form-group">
                                    <h6 for="">Date</h6>
                                    <br>
                                    <div class="input-group date">

                                          <input type="text" class="form-control" value="{{ date('Y-m-d')}}" id="date4"
                                                name="date" placeholder="Enter expenses" />
                                          <input id="vendor" name="vendor" type="hidden" value="{{ $vendor_id }}" />
                                          <button type="submit" name="submit"
                                                class="btn bg-gradient-primary btn-sm  text-white">Save Others</button>
                                    </div>
                              </div>
                        </form>

                  </div>

            </div>
            <!---row--->
            <p></p>


           
      </div>