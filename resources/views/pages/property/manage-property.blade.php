@extends('inc.frame')


@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="row">
           <div class="col-md-12">
              <div class="card card-primary card-outline">
                <div class="card-header">
                  <h3 class="card-title">
                    <div class="btn btn-primary btn-sm" style="float: left">Total Property : <b> {{ count($prop) }}</b></div>
                  </h3>
                  <button type="button" class="btn btn-primary pull-rigth btn-sm" style="float: right;" data-toggle="modal" data-target="#modal-lg">
                    ADD New Property
                  </button>

                </div>
            </div>
        </div>
    </div>
                <div class="card">
                    <div class="card-body">
                        <div class="p-2" style="float: right"> {{ $props->links() }}</div>
                      <table id="example1" class="table table-bordered table-striped" style=" overflow-y:scroll;display:block;overflow-y: hidden;">
                        <thead>
                        <tr>
                          {{-- <th>No</th> --}}
                          <th>Image</th>
                          <th >Project_Name</th>
                          <th width='70%' >Block</th>
                          <th>Type</th>
                          <th >Unit_Number</th>
                          <th>Net_Area</th>
                          <th>Communal_Area</th>
                          <th>Bed</th>
                          <th>Bath</th>
                          <th>Kitchen</th>
                          <th width='50%'>Price_USD</th>
                          <th>Status</th>
                          <th>___________</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(count($props) > 0)
                            @php
                                $no = 0;
                            @endphp
                            @foreach($props as $prop)
                            @php
                                $no = $no + 1;
                            @endphp
                             <tr>
                                {{-- <td>{{$no}}</td> --}}
                                <td>
                                    <img src=" {{$prop->Floor_Plan_Image}} " style="width: 60px;height:40px" alt="">
                                </td>
                                <td>
                                 @if(count($sites)  > 0)
                                    @foreach ($sites as $site )
                                        @if($site->id == $prop->Site_Id)
                                         {{$site->Site_Name}}
                                        @endif
                                    @endforeach
                                @endif
                               </td>
                               <td>{{ str_replace(' ', '_', $prop->Title)}}</td>
                               <td>
                                @if(count($property_type)  > 0)
                                @foreach ($property_type as $pt )
                                @if($pt->id == $prop->Property_Type_Id)
                                 {{$pt->Property_Type}}
                                 @endif
                                 @endforeach
                                @endif
                               </td>
                                <td> {{$prop->Unit_No}}</td>
                                <td> {{$prop->Size}}</td>
                                <td> {{$prop->Communal_Area}}</td>
                                <td>{{$prop->Bedrooms}}</td>
                                <td>{{$prop->Bathrooms}}</td>
                                <td>{{$prop->Kitchen}}</td>
                                <td>$ {{ number_format($prop->Price_In_USD,2)}}</td>
                                <td>{{$prop->Status}}</td>
                                <td>
                                  <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-lg-{{$prop->id}}">
                                  <i class="fas fa-edit"></i>
                                  </button>
                                  <a type="button" class="btn btn-danger" href="delete-property-{{$prop->id}}" onclick="return confirm('Are you sure you ?');">
                                  <i class="fas fa-trash"></i>
                                </a>
                                </td>
                            </tr>

                            <div class="modal fade" id="modal-lg-{{$prop->id}}">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        {{-- <h4 class="modal-title">New prop</h4> --}}
                                        <button type="button" class="btn btn-success pull-rigth" style="float:right;" data-toggle="modal" data-target="#modal-prop">
                                            ADD New Property Type
                                          </button>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="container-fluid">
                                            <div class="row">
                                            <!-- left column -->
                                            <div class="col-md-12">
                                                <!-- jquery validation -->
                                                <div class="card card-primary">
                                                    <div class="card-header">
                                                        <h3 class="card-title">Edit <small>{{$prop->Unit_No}}</small></h3>
                                                    </div>
                                                <!-- /.card-header -->
                                                <!-- form start -->
                                                <form  action="/edit-property-{{$prop->id}}" method="POST" id="quickForm" enctype="multipart/form-data" >
                                                    @csrf
                                                    <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                            <label>Project Name</label>
                                                            <select class="form-control" name="site" required>
                                                                <option value="{{$prop->Site_Id}}">
                                                                @if(count($sites)  > 0)
                                                                    @foreach ($sites as $pt )
                                                                        @if($pt->id == $prop->Site_Id)
                                                                        {{$pt->Site_Name}}
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            </option>
                                                                @if(count($sites)  > 0)
                                                                    @foreach ($sites as $site )
                                                                    <option value="{{$site->id}}">{{$site->Site_Name}}</option>
                                                                    @endforeach
                                                                @else
                                                                    <option value="">Site Not Found !</option>
                                                                @endif
                                                            </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="form-group">
                                                                <label >Block</label>
                                                                <input type="text" name="title" class="form-control" value="{{$prop->Title}}" required>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">

                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                              <label>Property Type</label>
                                                              <select class="form-control" name="property_type" required>
                                                                   <option value="{{$prop->Property_Type_Id}}">
                                                                    @if(count($property_type)  > 0)
                                                                       @foreach ($property_type as $pt )
                                                                       @if($pt->id == $prop->Property_Type_Id)
                                                                        {{$pt->Property_Type}}
                                                                        @endif
                                                                        @endforeach
                                                                    @endif
                                                                   </option>
                                                                  @if(count($property_type)  > 0)
                                                                      @foreach ($property_type as $pt )
                                                                      <option value="{{$pt->id}}">{{$pt->Property_Type}}</option>
                                                                      @endforeach
                                                                  @else
                                                                      <option value="">Pooperty Type Not Found  !</option>
                                                                  @endif
                                                              </select>
                                                            </div>
                                                          </div>
                                                          <div class="col-sm-4">
                                                            <div class="form-group">
                                                            <label >Floor Number <small>opt</small></label>
                                                            <input type="text" name="floor" class="form-control" value="{{$prop->Floor}}" >
                                                          </div>
                                                        </div>
                                                          <div class="col-sm-4">
                                                            <div class="form-group">
                                                              <label >Unit No</label>
                                                              <input type="text" name="unit_no" class="form-control"  value="{{$prop->Unit_No}}"  required>

                                                            </div>
                                                          </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                            <label >Net Area</label>
                                                            <input type="number" step="any" name="size" class="form-control"  value="{{$prop->Size}}" required>
                                                          </div>
                                                         </div>
                                                         <div class="col-sm-4">
                                                            <div class="form-group">
                                                              <label >Communal Area</label>
                                                              <input type="number" step="any" name="communal_area"  class="form-control"  value="{{$prop->Communal_Area}}" required>
                                                            </div>
                                                        </div>

                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                            <label >Bedrooms <small>opt</small></label>
                                                            <input type="number" name="bedrooms" class="form-control" value="{{$prop->Bedrooms}}">
                                                          </div>
                                                          </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                          <div class="form-group">
                                                            <label >Bathrooms <small>opt</small></label>
                                                            <input type="number" name="bathrooms" class="form-control"  value="{{$prop->Bathrooms}}" >

                                                          </div>
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <div class="form-group">
                                                            <label >Balcony <small>opt</small></label>
                                                            <input type="number" name="balcony" class="form-control"   value="{{$prop->Balcony}}">
                                                          </div>
                                                        </div>
                                                          <div class="col-sm-4">
                                                            <div class="form-group">
                                                            <label >Kitchen <small>opt</small></label>
                                                            <input type="number" name="kitchen" class="form-control"  value="{{$prop->Kitchen}}" >
                                                          </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-3">
                                                          <div class="form-group">
                                                            <label >Total Floor <small>opt</small></label>
                                                            <input type="number" name="total_floor" class="form-control" value="{{$prop->Total_Floor}}" >

                                                          </div>
                                                        </div>
                                                        <div class="col-sm-3">
                                                            <div class="form-group">
                                                              <label >Price In USD</label>
                                                              <input type="number" step="any" name="price_in_usd" class="form-control"  value="{{$prop->Price_In_USD}}" required>

                                                            </div>
                                                          </div>

                                                          <div class="col-sm-6">
                                                            <div class="form-group">
                                                            <label >Floor Plan <small>opt</small></label>
                                                            <input type="file" name="floor_plan_image" class="form-control"  placeholder="Floor Plan Image" >
                                                          </div>
                                                        </div>
                                                    </div>

                                                    </div>

                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary swalDefaultSuccess" onclick="confirm('Are you sure you ? You want to save Change.');" >Save Change</button>
                                                    </div>
                                                </form>
                                                </div>
                                                <!-- /.card -->
                                                </div>

                                               <!--/.col (right) -->
                                              </div>
                                            <!-- /.row -->
                                           </div><!-- /.container-fluid -->

                                        </div>
                                     </div>
                                    <!-- /.modal-content -->
                                   </div>
                                <!-- /.modal-dialog -->
                                </div>

                            @endforeach
                            @else
                             <h2>No prop Found !</h2>
                            @endif
                        </tbody>
                      </table>

                  <div class="p-2" style="float: right"> {{ $props->links() }}</div>

                    </div>
                    <!-- /.card-body -->
                  </div>

              <!-- /.card -->

              <div class="modal fade" id="modal-lg">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                    <div class="modal-header">
                        {{-- <h4 class="modal-title">New prop</h4> --}}
                        <button type="button" class="btn btn-success pull-rigth" style="float:right;" data-toggle="modal" data-target="#modal-prop">
                            ADD New Property Type
                          </button>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                            <!-- left column -->
                            <div class="col-md-12">
                                <!-- jquery validation -->
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Project <small>Information</small></h3>
                                    </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form  action="/add-property" method="POST" id="quickForm" enctype="multipart/form-data" >
                                    @csrf
                                    <div class="card-body">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group">
                                              <label>Project Name</label>
                                              <select class="form-control" name="site" required>
                                                  <option value="">Select Project</option>
                                                  @if(count($sites)  > 0)
                                                      @foreach ($sites as $site )
                                                      <option value="{{$site->id}}">{{$site->Site_Name}}</option>
                                                      @endforeach
                                                  @else
                                                      <option value="">Project Not Found !</option>
                                                  @endif
                                              </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label >Block</label>
                                                <input type="text" name="title" class="form-control"  placeholder="Block" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                              <label>Property Type</label>
                                              <select class="form-control" name="property_type" required>
                                                <option value="">Property Type</option>
                                                  @if(count($property_type)  > 0)
                                                      @foreach ($property_type as $pt )
                                                      <option value="{{$pt->id}}">{{$pt->Property_Type}}</option>
                                                      @endforeach
                                                  @else
                                                      <option value="">Pooperty Type Not Found  !</option>
                                                  @endif
                                              </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                            <label >Floor No <small>opt</small></label>
                                            <input type="text" name="floor" class="form-control"  placeholder="Floor Number" >
                                          </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label >Unit No</label>
                                                <input type="text" name="unit_no" class="form-control"  placeholder="Unit No" required>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                              <label >Total No <small>opt</small></label>
                                              <input type="number" name="total_floor" class="form-control"  placeholder="Total Floor" >
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                            <label >Net Area</label>
                                            <input type="number" step="any" name="size" class="form-control"  placeholder="Net Area" required>
                                          </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                              <label >Communal Area</label>
                                              <input type="number" step="any" name="communal_area"  class="form-control"  placeholder="Communal Area" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                            <label >Bedrooms <small>opt</small></label>
                                            <input type="number" name="bedrooms" class="form-control"  placeholder="Bedrooms">
                                          </div>
                                        </div>
                                        <div class="col-sm-4">
                                          <div class="form-group">
                                            <label >Bathrooms <small>opt</small></label>
                                            <input type="number" name="bathrooms" class="form-control"  placeholder="Bathrooms" >

                                          </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                            <label >Balcony <small>opt</small></label>
                                            <input type="number" name="balcony" class="form-control"  placeholder="Balcony" >
                                          </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                            <label >Kitchen <small>opt</small></label>
                                            <input type="number" name="kitchen" class="form-control"  placeholder="Kitchen" >
                                          </div>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                              <label >Price In USD</label>
                                              <input type="number" step="any" name="price_in_usd"  class="form-control"  placeholder="Price In USD" required>

                                            </div>
                                          </div>
                                          <div class="col-sm-6">
                                            <div class="form-group">
                                            <label >Floor Plan <small>opt</small></label>
                                            <input type="file" name="floor_plan_image" class="form-control"  placeholder="Floor Plan Image" >
                                          </div>
                                        </div>
                                    </div>

                                    </div>

                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary swalDefaultSuccess" >Register</button>
                                    </div>
                                </form>
                                </div>
                                <!-- /.card -->
                                </div>

                               <!--/.col (right) -->
                              </div>
                            <!-- /.row -->
                           </div><!-- /.container-fluid -->

                        </div>
                     </div>
                    <!-- /.modal-content -->
                   </div>
                <!-- /.modal-dialog -->
                </div>

              <div class="modal fade" id="modal-prop">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid">
                            <div class="row">
                            <!-- left column -->
                            <div class="col-md-12">
                                <!-- jquery validation -->
                                <div class="card card-primary">
                                    <div class="card-header">
                                        <h3 class="card-title">Property Type <small>Information</small></h3>
                                    </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form  action="/add-property-type" method="POST" id="quickForm" >
                                    @csrf
                                    <div class="card-body">
                                    <div class="form-group">
                                        <label >Property Type</label>
                                        <input type="text" name="propery_type" class="form-control"  placeholder="Property Type" required>
                                    </div>

                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary swalDefaultSuccess" >Register</button>
                                    </div>
                                </form>
                                </div>
                                <!-- /.card -->
                                <div class="card card-info p-3">
                                    <div class="card-header">
                                        <h3 class="card-title">- {{count($property_type)}} - Property Type <small></small></h3>
                                    </div>
                                    <hr>
                                    @if(count($property_type) > 0)
                                        <div class="form-group">
                                            @foreach ($property_type as $pt)
                                              <a type="button" class="btn btn-info" href="delete-prop-type-{{$pt->id}}" onclick="return confirm('Are you sure you ?');">{{$pt->Property_Type}}</a>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="form-group">
                                            No Property Type Found !!!
                                        </div>
                                    @endif
                                </div>

                               <!--/.col (right) -->
                              </div>
                            <!-- /.row -->
                           </div><!-- /.container-fluid -->

                        </div>
                     </div>
                    <!-- /.modal-content -->
                   </div>
                <!-- /.modal-dialog -->
                </div>
                <!-- /.modal -->
            </div>

  </section>

@endsection
