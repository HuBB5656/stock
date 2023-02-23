@extends('inc.frame')


@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="row">
           <div class="col-md-12">
              <div class="card card-primary card-outline">
                <div class="card-header">
                  <h3 class="card-title">
                    <div class="p-2 btn btn-defaoult" style="float: left">Total Number Of Project :<b> {{ count($site) }}</b></div>
                  </h3>
                  <button type="button" class="btn btn-primary pull-rigth" style="float: right;" data-toggle="modal" data-target="#modal-lg">
                    ADD New Project
                  </button>

                </div>
              </div>

              <div class="card">
                <div class="card-body">
                    <div class="p-2" style="float: right"> {{ $sites->links() }}</div>
                  <table id="example1" class="table table-bordered table-striped" style=" overflow-y:scroll;display:block;overflow-y: hidden;">
                    <thead>
                    <tr>
                      <th>No</th>
                      <th>Project_Name</th>
                      <th>Project_Address</th>
                      <th>Number_Of_Buildings</th>
                      <th>Regitration_Date</th>
                      <th>________________</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if(count($sites) > 0)
                        @php
                            $no = 0;
                        @endphp
                        @foreach($sites as $site)
                        @php
                            $no = $no + 1;
                        @endphp
                         <tr>
                            <td>{{$no}}</td>
                            <td>{{$site->Site_Name}}</td>
                            <td>{{$site->Site_Address}}</td>
                            <td> {{$site->Number_Of_Buildings}}</td>
                            <td>{{$site->created_at}}</td>

                            <td>
                              <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-lg-{{$site->id}}">
                              <i class="fas fa-edit"></i>

                                Edit
                              </button>
                              <a type="button" class="btn btn-danger" href="delete-site-{{$site->id}}" onclick="return confirm('Are you sure you ?');">Delete</a>
                            </td>
                        </tr>

                        <div class="modal fade" id="modal-lg-{{$site->id}}">
                            <div class="modal-dialog modal-lg-{{$site->id}}">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Edit Site</h4>
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
                                                    <h3 class="card-title">Site <small>Information</small></h3>
                                                </div>
                                            <!-- /.card-header -->
                                            <!-- form start -->
                                            <form  action="/edit-site-{{$site->id}}" method="POST" id="quickForm" >
                                                @csrf
                                                <div class="card-body">
                                                <div class="form-group">
                                                    <label >Site Name</label>
                                                    <input type="text" name="site_name" class="form-control"  value="{{$site->Site_Name}}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label >Site Address</label>
                                                    <input type="text" name="site_address" class="form-control"  value="{{$site->Site_Address}}"  required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Number Of Buildings</label>
                                                    <input type="number" name="number_of_buildings" class="form-control" id="" value="{{$site->Number_Of_Buildings}}"  required>
                                                </div>
                                                </div>

                                                <div class="modal-footer justify-content-between">
                                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary swalDefaultSuccess" onclick="return confirm('Are you sure you want to save changes ?');" >Save Change</button>
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
                         <h2>No Site Found !</h2>
                        @endif
                    </tbody>
                  </table>

              <div class="p-2" style="float: right"> {{ $sites->links() }}</div>

                </div>
                <!-- /.card-body -->
              </div>

              <!-- /.card -->

              @php
                  error_log('erereee');
              @endphp

              <div class="modal fade" id="modal-lg">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">New Site</h4>
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
                                        <h3 class="card-title">Site <small>Information</small></h3>
                                    </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form  action="/add-site" method="POST" id="quickForm" >
                                    @csrf
                                    <div class="card-body">
                                    <div class="form-group">
                                        <label >Site Name</label>
                                        <input type="text" name="site_name" class="form-control"  placeholder="Site Name" required>
                                    </div>
                                    <div class="form-group">
                                        <label >Site Address</label>
                                        <input type="text" name="site_address" class="form-control"  placeholder="Site Address" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Number Of Buildings</label>
                                        <input type="number" name="number_of_buildings" class="form-control" id="" placeholder="Number Of Buildings" required>
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
                <!-- /.modal -->
            </div>
        </div>
    </div>
  </section>

@endsection



































