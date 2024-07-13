<div>
      @if (session()->has('message'))
      <div class="alert alert-success">
            {{ session('message') }}
      </div>
      @endif


      <form>
            <div class=" add-input">
                  <div class="row">
                        <div class="col-md-3">
                              <div class="form-group">
                                    <select class="js-example-basic-single text-secondary " style="width:100%"
                                          name="platform" wire:model="platform.0">
                                          <option> Search
                                          </option>
                                          @foreach($platforms as $key => $data)
                                          <option value="{{$data->name}}">
                                                {{$data->name}}</option>
                                          @endforeach
                                    </select>

                                    @error('platform.0') <span class="text-danger error">{{ $message }}</span>@enderror
                              </div>
                        </div>
                        <div class="col-md-3">
                              <div class="form-group">
                                    <select class="js-example-basic-single2 text-secondary " style="width:100%"
                                          name="vendor" wire:model="vendor.0">
                                          <option> Search
                                          </option>
                                          @foreach($vendors as $key => $vdata)
                                          <option value="{{$vdata->vendor_name}}">
                                                {{$vdata->vendor_name}}</option>
                                          @endforeach
                                    </select>

                                    @error('vendor.0') <span class="text-danger error">{{ $message }}</span>@enderror
                              </div>
                        </div>

                        <div class="col-md-4">
                              <div class="form-group">

                                    <input type="file" name="file" accept=".xlsx,.xls" class="file-upload-default"
                                          id="file" wire:model="file.0">
                                    <div class="input-group col-xs-12">
                                          <input type="text" class="form-control file-upload-info" disabled=""
                                                placeholder=". xlsx, .xls">
                                          <span class="input-group-append">
                                                <button
                                                      class="file-upload-browse btn btn-sm  bg-gradient-dark  text-white py-3"
                                                      type="button"> <i
                                                            class="mdi mdi-cloud-braces fs-24 menu-icon"></i></button>
                                          </span>
                                    </div>

                              </div>
                        </div>
                        <div class="col-md-2">
                              <button class="btn text-white btn-info btn-sm"
                                    wire:click.prevent="add({{$i}})">Add</button>
                        </div>
                  </div>
            </div>

            @foreach($inputs as $key => $value)
            <div class=" add-input">
                  <div class="row">
                        <div class="col-md-3">
                              <div class="form-group">
                                    <select class="js-example-basic-single text-secondary " style="width:100%"
                                          name="platform" wire:model="platform.{{ $value }}">
                                          <option> Search
                                          </option>
                                          @foreach($platforms as $key => $data)
                                          <option value="{{$data->name}}">
                                                {{$data->name}}</option>
                                          @endforeach
                                    </select>

                                    @error('platform.'.$value) <span
                                          class="text-danger error">{{ $message }}</span>@enderror
                              </div>
                        </div>
                        <div class="col-md-3">
                              <div class="form-group">
                                    <select class="js-example-basic-single2 text-secondary " style="width:100%"
                                          name="vendor" wire:model="vendor.{{ $value }}">
                                          <option> Search
                                          </option>
                                          @foreach($vendors as $key => $vdata)
                                          <option value="{{$vdata->vendor_name}}">
                                                {{$vdata->vendor_name}}</option>
                                          @endforeach
                                    </select>
                                    @error('vendor.'.$value) <span
                                          class="text-danger error">{{ $message }}</span>@enderror
                              </div>
                        </div>
                        <div class="col-md-4">
                              <div class="form-group">

                                    <input type="file" name="file" accept=".xlsx,.xls" class="file-upload-default"
                                          id="file" wire:model="file.{{ $value }}">
                                    <div class="input-group col-xs-12">
                                          <input type="text" class="form-control file-upload-info" disabled=""
                                                placeholder=". xlsx, .xls">
                                          <span class="input-group-append">
                                                <button
                                                      class="file-upload-browse btn btn-sm  bg-gradient-dark  text-white py-3"
                                                      type="button"> <i
                                                            class="mdi mdi-cloud-braces fs-24 menu-icon"></i></button>
                                          </span>
                                    </div>

                              </div>
                        </div>
                        <div class="col-md-2">
                              <button class="btn btn-danger btn-sm"
                                    wire:click.prevent="remove({{$key}})">Remove</button>
                        </div>
                  </div>
            </div>
            @endforeach

            <div class="row">
                  <div class="col-md-12">
                        <button type="button" wire:click.prevent="store()"
                              class="btn btn-success btn-sm">Submit</button>
                  </div>
            </div>

      </form>
</div>