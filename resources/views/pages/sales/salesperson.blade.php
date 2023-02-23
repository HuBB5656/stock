@extends('inc.frame')


@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
           <div class="col-md-12">
              <div class="card card-primary card-outline">
                <div class="card-header">
                  <h3 class="card-title">
                    <div class=" btn btn-primary btn-sm" style="float: left">Total Number Of Sales Agent :<b> {{ count($salesperson) }}</b></div>
                  </h3>
                  <button type="button" class="btn btn-primary pull-rigth btn-sm" style="float: right;" data-toggle="modal" data-target="#modal-lg">
                    ADD New Sales Agent
                  </button>
                </div>
            </div>
        </div>
    </div>
    </div>
                <div class="card">
                    <div class="card-body">
                        <div class="p-2" style="float: right"> {{ $salespersons->links() }}</div>
                      <table id="example1" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th>No</th>
                          <th>Full Name</th>
                          <th>Company Name</th>
                          <th>Gender</th>
                          {{-- <th>email</th> --}}
                          <th>Phone</th>
                          <th>Regi_Date</th>
                          <th>___________</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(count($salespersons) > 0)
                            @php
                                $no = 0;
                            @endphp
                            @foreach($salespersons as $salesperson)
                            @php
                                $no = $no + 1;
                            @endphp
                             <tr>
                                <td>{{$no}}</td>
                                <td>{{$salesperson->Full_Name}}</td>
                                <td>{{$salesperson->Company_Name}}</td>
                                <td>{{$salesperson->Gender}}</td>
                                {{-- <td>
                                    @php
                                     $name = strtolower($salesperson->Full_Name);
                                     $email = str_replace(' ', '', $name).$salesperson->id.'@newHops.com';
                                    @endphp
                                    {{$email}}
                                </td> --}}

                                <td> {{$salesperson->Phone}}</td>
                                <td>{{$salesperson->created_at->toDateString()}}</td>

                                <td>
                                  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-lg-{{$salesperson->id}}">
                                  <i class="fas fa-edit"></i>
                                  </button>
                                  <a type="button" class="btn btn-danger btn-sm" href="delete-salesperson-{{$salesperson->id}}" onclick="return confirm('Are you sure you ? delete {{$salesperson->Full_Name}}');">
                                  <i class="fas fa-trash"></i>

                                </a>
                                </td>
                            </tr>

                            <div class="modal fade" id="modal-lg-{{$salesperson->id}}">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title"> Edit {{$salesperson->Full_Name}}</h4>
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
                                                        <h3 class="card-title">{{$salesperson->Full_Name}} <small>Information</small></h3>
                                                    </div>
                                                <!-- /.card-header -->
                                                <!-- form start -->
                                                <form  action="/edit-salesperson-{{$salesperson->id}}" method="POST" id="quickForm" >
                                                    @csrf
                                                    <div class="card-body">
                                                    <div class="form-group">
                                                        <label >Full Name</label>
                                                        <input type="text" name="full_name" class="form-control"  value="{{$salesperson->Full_Name}}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label >Company Name</label>
                                                        <input type="text" name="company_name" class="form-control"  value="{{$salesperson->Company_Name}}" >
                                                    </div>
                                                    <div class="form-group">
                                                        <label > Gender</label>
                                                        <select class="form-control" name="gender" required>
                                                            <option value="{{$salesperson->Gender}}">{{$salesperson->Gender}}</option>
                                                            <option value="Male">Male</option>
                                                            <option value="Female">Female</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Phone</label>
                                                        <input type="text" name="phone" class="form-control" id="" value="{{$salesperson->Phone}}" pattern="[+ , 0]{1}[0-9]{9,14}" >
                                                    </div>
                                                    </div>

                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary swalDefaultSuccess" onclick="return confirm('Are you sure you ?  {{$salesperson->Full_Name}}`s change.');">Save Changes</button>
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
                             <h2>No salesperson Found !</h2>
                            @endif
                        </tbody>
                      </table>

                  <div class="p-2" style="float: right"> {{ $salespersons->links() }}</div>

                    </div>
                    <!-- /.card-body -->
                  </div>

              <!-- /.card -->

              <div class="modal fade" id="modal-lg">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">New salesperson</h4>
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
                                        <h3 class="card-title">Sales Agent <small>Information</small></h3>
                                    </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form  action="/add-salesperson" method="POST" id="quickForm" >
                                    @csrf
                                    <div class="card-body">
                                    <div class="form-group">
                                        <label >Full Name</label>
                                        <input type="text" name="full_name" class="form-control"  placeholder="Full Name" required>
                                    </div>
                                    <div class="form-group">
                                        <label >Company Name</label>
                                        <input type="text" name="company_name" class="form-control"  placeholder="Company Name" >
                                    </div>
                                    <div class="form-group">
                                        <label > Gender</label>
                                        <select class="form-control" name="gender" required>
                                            <option value="">Select</option>
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Phone</label>
                                        <input type="text" name="phone" class="form-control" id="" placeholder="Phone" pattern="[+ , 0]{1}[0-9]{9,14}" >
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
  </section>

@endsection




