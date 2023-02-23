@extends('inc.frame')


@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
           <div class="col-md-12">
              <div class="card card-primary card-outline">
                <div class="card-header">
                  <h3 class="card-title">
                    <div class="p-2 btn btn-defaoult" style="float: left">Total Users : <b> {{ count($user) }}</b></div>
                  </h3>
                  <button type="button" class="btn btn-primary pull-rigth" style="float: right;" data-toggle="modal" data-target="#modal-lg">
                    ADD New User
                  </button>

                </div>
              </div>

              <div class="card">
                <div class="card-body">
                    <div class="p-2" style="float: right"> {{ $users->links() }}</div>
                  <table id="example1" class="table table-bordered table-striped" style=" overflow-y:scroll;display:block;overflow-y: hidden;">
                    <thead>
                    <tr>
                      <th>No</th>
                      <th>UserName</th>
                      <th>Email</th>
                      <th>Phone</th>
                      <th>Role</th>
                      <th>RegistrationDate</th>
                      <th></th>
                      <th>__________</th>
                    </tr>
                    </thead>
                    <tbody>
                        @if(count($users) > 0)
                        @php
                            $no = 0;
                        @endphp
                        @foreach($users as $user)
                        @php
                            $no = $no + 1;
                        @endphp
                        @if ($user->role != '1' && $user->role != '2')
                         <tr>
                            <td>{{$no}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td> {{$user->phone}}</td>
                            <td>
                            @forelse ($roles as $role )
                                @if ($role->id == $user->role)
                                     <a type="button" class="btn btn-secondary btn-sm" href="#">{{$role->Role_Name}}</a>
                                @endif
                            @empty

                            @endforelse
                            </td>
                            <td>{{$user->created_at->toDateString()}}</td>
                            <td>
                              <a type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-lg-role-{{$user->id}}">Set-Role</a>
                            </td>
                            <td>
                              <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-lg-{{$user->id}}">
                              <i class="fas fa-edit"></i>

                              </button>
                              <a type="button" class="btn btn-danger btn-sm" href="delete-user-{{$user->id}}" onclick="return confirm('Are you sure you ?');">
                                <i class="fas fa-trash"></i>

                              </a>
                            </td>
                        </tr>
                        @endif
                        <div class="modal fade" id="modal-lg-{{$user->id}}">
                            <div class="modal-dialog modal-lg-{{$user->id}}">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title">Edit user</h4>
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
                                                    <h3 class="card-title">user <small>Information</small></h3>
                                                </div>
                                            <!-- /.card-header -->
                                            <!-- form start -->
                                            <form  action="/edit-user-{{$user->id}}" method="POST" id="quickForm" >
                                                @csrf
                                                <div class="card-body">
                                                <div class="form-group">
                                                    <label >Full Name</label>
                                                    <input type="text" name="full_name" class="form-control"  value="{{$user->name}}" required>
                                                </div>
                                                <div class="form-group">
                                                    <label >Email</label>
                                                    <input type="email" name="email" class="form-control"  value="{{$user->email}}"  required>
                                                </div>
                                                <div class="form-group">
                                                    <label for="">Phone</label>
                                                    <input type="text" name="phone" class="form-control" value="{{$user->phone}}"  pattern="[+ , 0]{1}[0 , 9]{9 , 14}">
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



                            <div class="modal fade" id="modal-lg-role-{{$user->id}}">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-lg-ADDROLE">
                                                <i class="fas fa-edit"></i>
                                                Manage Roles
                                            </button>
                                        </h4>
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
                                                        <h3 class="card-title"><small>set role to - </small> {{$user->name}} </h3>
                                                    </div>

                                                <form  action="/set-role-{{$user->id}}" method="POST" id="quickForm" >
                                                    @csrf
                                                    <div class="card-body">
                                                        <div class="row">
                                                            @forelse ($roles as $role)
                                                             @if($role->SuperAdmin != 'on')
                                                                <div class="col-sm-4">
                                                                    <div class="form-group clearfix">
                                                                        <div class="icheck-success d-inline">
                                                                            <input type="radio" id="{{$role->id}}{{$user->id}}" name="role" value="{{$role->id}}"
                                                                                 @if($role->id == $user->role)
                                                                                     @checked(true)
                                                                                @endif>
                                                                            <label for="{{$role->id}}{{$user->id}}">
                                                                                 {{$role->Role_Name}}
                                                                            </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                             @endif
                                                            @empty

                                                            @endforelse
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
                        @endforeach
                        @else
                         <h2>No user Found !</h2>
                        @endif
                    </tbody>
                  </table>

              <div class="p-2" style="float: right"> {{ $users->links() }}</div>

                </div>
                <!-- /.card-body -->
              </div>

              <!-- /.card -->
              <div class="modal fade" id="modal-lg">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">New user</h4>
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
                                        <h3 class="card-title">User <small>Information</small></h3>
                                    </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form  action="/add-user" method="POST" id="quickForm" >
                                    @csrf
                                    <div class="card-body">
                                    <div class="form-group">
                                        <label >Full Name</label>
                                        <input type="text" name="full_name" class="form-control"  placeholder="Full Name" required>
                                    </div>
                                    <div class="form-group">
                                        <label >Email</label>
                                        <input type="email" name="email" class="form-control"  placeholder="Email" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Phone</label>
                                        <input type="text" name="phone" class="form-control" id="" placeholder="+251" pattern="[+ , 0]{1}[0-9]{9,14}">
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



                <div class="modal fade" id="modal-lg-ADDROLE">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title">New Role</h4>
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
                                            <h3 class="card-title">Role </h3>
                                        </div>
                                    <!-- /.card-header -->
                                    <!-- form start -->
                                    <form  action="/add-role" method="POST" id="quickForm" >
                                        @csrf
                                        <div class="card-body">
                                            <div class="form-group">
                                                <label >Role Name</label>
                                                <input type="text" name="Role_Name" class="form-control"  placeholder="Role Name" required>
                                            </div>
                                            <h5>Select Permissions</h5>
                                            <hr>

                                            <div class="row">
                                                <div class="col-sm-4">
                                                  <div class="form-group clearfix">
                                                    <div class="icheck-success d-inline">
                                                      <input type="checkbox" name="Administrator" id="Administrator">
                                                      <label for="Administrator"  title="Permission to Create User, Role and assign permission ">
                                                        Administrator
                                                      </label>
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group clearfix">
                                                      <div class="icheck-success d-inline">
                                                        <input type="checkbox" name="Property"  id="Property">
                                                        <label for="Property" title="Can view, Edit, Add and Delete Property and Project Name">
                                                          Property
                                                        </label>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div class="col-sm-4">
                                                    <div class="form-group clearfix">
                                                      <div class="icheck-success d-inline">
                                                        <input type="checkbox" name="Customer" id="Customer">
                                                        <label for="Customer"  title="Can view, Edit, Add and Delete Customer Data">
                                                         Customer
                                                        </label>
                                                      </div>
                                                    </div>
                                                  </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                  <div class="form-group clearfix">
                                                    <div class="icheck-success d-inline">
                                                      <input type="checkbox" name="SalesAgent" id="SalesAgent" >
                                                      <label for="SalesAgent" title="Can view, Edit, Add and Delete SalesAgent Data">
                                                        SalesAgent
                                                      </label>
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group clearfix">
                                                      <div class="icheck-success d-inline">
                                                        <input type="checkbox" name="Sales" id="Sales">
                                                        <label for="Sales"  title="Can view, Edit, Add and Delete Sales Data. Delete only Marks the record as Deleted rather than Deleting it Permanently">
                                                            Sales
                                                        </label>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div class="col-sm-4">
                                                    <div class="form-group clearfix">
                                                      <div class="icheck-success d-inline">
                                                        <input type="checkbox" name="PaymentSchedule" id="PaymentSchedule" >
                                                        <label for="PaymentSchedule" title="Can view, Edit, Add and Delete Payment Schedules. Delete only Marks the record as Deleted rather than Deleting it Permanently">
                                                            PaymentSchedule
                                                        </label>
                                                      </div>
                                                    </div>
                                                  </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                  <div class="form-group clearfix">
                                                    <div class="icheck-success d-inline">
                                                      <input type="checkbox" name="Payment" id="Payment">
                                                      <label for="Payment"  title="Can view, Edit, Add and Delete Payment. Delete only  Marks the record as Deleted rather than Deleting it Permanently">
                                                        Payment
                                                      </label>
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="col-sm-4">
                                                    <div class="form-group clearfix">
                                                      <div class="icheck-success d-inline">
                                                        <input type="checkbox" name="PaymentRefund" id="PaymentRefund">
                                                        <label for="PaymentRefund"  title="Can view, Edit, Add and Delete Payment Refund.Delete only Marks the record as Deleted rather than Deleting it Permanently">
                                                            PaymentRefund
                                                        </label>
                                                      </div>
                                                    </div>
                                                  </div>
                                                  <div class="col-sm-4">
                                                    <div class="form-group clearfix">
                                                      <div class="icheck-success d-inline">
                                                        <input type="checkbox" name="Resale" id="Resale" >
                                                        <label for="Resale" title="Can view, Edit, Add and Delete Payment Schedules.Delete only Marks the record as Deleted rather than Deleting it Permanently">
                                                            Resale
                                                        </label>
                                                      </div>
                                                    </div>
                                                  </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-4">
                                                  <div class="form-group clearfix">
                                                    <div class="icheck-success d-inline">
                                                      <input type="checkbox" name="Report" id="Report" >
                                                      <label for="Report" title="Can view and print all reports including the Dashboard reports">
                                                        Report
                                                      </label>
                                                    </div>
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
                                <hr>
                                <h5>Manage Roles Here</h5>
                                <div class="row p-2">

                                <table class="table align-baseline" style=" overflow-y:scroll;display:block;overflow-y: hidden;">
                                    <tbody>
                                        @forelse ($roles as $role)
                                        @if($role->SuperAdmin != 'on')
                                        <form  action="/edit-role-{{$role->id}}" method="POST" id="quickForm" >
                                            @csrf
                                           <tr>
                                            <th scope="row ">{{$role->Role_Name}}</th>
                                            <td>
                                                <small>
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-success d-inline">
                                                          <input type="checkbox" name="Administrator" id="Administrator{{$role->id}}" @if ($role->Administrator == 'on')@checked(true)@endif >
                                                          <label for="Administrator{{$role->id}}" title="Can view, Edit, Add and Delete Payment Schedules. Delete only Marks the record as Deleted rather than Deleting it Permanently">
                                                            Administrator
                                                          </label>
                                                        </div>

                                                        <div class="icheck-success d-inline" >
                                                            <input type="checkbox" name="Property" id="Property{{$role->id}}" @if ($role->Property == 'on') @checked(true) @endif >
                                                            <label for="Property{{$role->id}}" title="Can view, Edit, Add and Delete Payment Schedules. Delete only Marks the record as Deleted rather than Deleting it Permanently">
                                                                Property
                                                            </label>
                                                        </div>
                                                      </div>
                                                </small>
                                            </td>
                                            <td>
                                                <small>
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-success d-inline" >
                                                            <input type="checkbox" name="Customer" id="Customer{{$role->id}}" @if ($role->Customer == 'on') @checked(true) @endif >
                                                            <label for="Customer{{$role->id}}" title="Can view, Edit, Add and Delete Payment Schedules. Delete only Marks the record as Deleted rather than Deleting it Permanently">
                                                                Customer
                                                            </label>
                                                        </div>

                                                        <div class="icheck-success d-inline" >
                                                            <input type="checkbox" name="SalesAgent" id="SalesAgent{{$role->id}}" @if ($role->SalesAgent == 'on') @checked(true) @endif >
                                                            <label for="SalesAgent{{$role->id}}" title="Can view, Edit, Add and Delete Payment Schedules. Delete only Marks the record as Deleted rather than Deleting it Permanently">
                                                                SalesAgent
                                                            </label>
                                                        </div>
                                                      </div>
                                                </small>
                                            </td>
                                            <td>
                                                <small>
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-success d-inline" >
                                                            <input type="checkbox" name="PaymentSchedule" id="PaymentSchedule{{$role->id}}" @if ($role->PaymentSchedule == 'on') @checked(true) @endif >
                                                            <label for="PaymentSchedule{{$role->id}}" title="Can view, Edit, Add and Delete Payment Schedules. Delete only Marks the record as Deleted rather than Deleting it Permanently">
                                                                PaymentSchedule
                                                            </label>
                                                        </div>

                                                        <div class="icheck-success d-inline" >
                                                            <input type="checkbox" name="Payment" id="Payment{{$role->id}}" @if ($role->Payment == 'on') @checked(true) @endif >
                                                            <label for="Payment{{$role->id}}" title="Can view, Edit, Add and Delete Payment Schedules. Delete only Marks the record as Deleted rather than Deleting it Permanently">
                                                                Payment
                                                            </label>
                                                        </div>
                                                      </div>
                                                </small>
                                            </td>
                                            <td>
                                                <small>
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-success d-inline" >
                                                            <input type="checkbox" name="PaymentRefund" id="PaymentRefund{{$role->id}}" @if ($role->PaymentRefund == 'on') @checked(true) @endif >
                                                            <label for="PaymentRefund{{$role->id}}" title="Can view, Edit, Add and Delete Payment Schedules. Delete only Marks the record as Deleted rather than Deleting it Permanently">
                                                                PaymentRefund
                                                            </label>
                                                        </div>

                                                        <div class="icheck-success d-inline" >
                                                            <input type="checkbox" name="Sales" id="Sales{{$role->id}}" @if ($role->Sales == 'on') @checked(true) @endif >
                                                            <label for="Sales{{$role->id}}" title="Can view, Edit, Add and Delete Payment Schedules. Delete only Marks the record as Deleted rather than Deleting it Permanently">
                                                                Sales
                                                            </label>
                                                        </div>
                                                      </div>
                                                </small>
                                            </td>
                                            <td>
                                                <small>
                                                    <div class="form-group clearfix">
                                                        <div class="icheck-success d-inline" >
                                                            <input type="checkbox" name="Resale" id="Resale{{$role->id}}" @if ($role->Resale == 'on') @checked(true) @endif >
                                                            <label for="Resale{{$role->id}}" title="Can view, Edit, Add and Delete Payment Schedules. Delete only Marks the record as Deleted rather than Deleting it Permanently">
                                                                Resale
                                                            </label>
                                                        </div>
                                                        <div class="icheck-success d-inline" >
                                                            <input type="checkbox" name="Report" id="Report{{$role->id}}" @if ($role->Report == 'on') @checked(true) @endif >
                                                            <label for="Report{{$role->id}}" title="Can view, Edit, Add and Delete Payment Schedules. Delete only Marks the record as Deleted rather than Deleting it Permanently">
                                                                Report
                                                            </label>
                                                        </div>
                                                      </div>
                                                      <hr>
                                                      <button type="submit" class="btn btn-primary btn-sm">
                                                          <i class="fas fa-save"></i>
                                                          </button>
                                                          <a type="button" class="btn btn-danger btn-sm" href="delete-role-{{$role->id}}" onclick="return confirm('Are you sure you ?');">
                                                            <i class="fas fa-trash"></i>
                                                          </a>
                                                </small>
                                            </td>

                                          </tr>
                                        </form>
                                        @endif
                                        @empty

                                        @endforelse
                                    </tbody>
                                  </table>
                                </div>
                                <!-- /.row -->
                            </div><!-- /.container-fluid -->

                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
            </div>
        </div>
    </div>




  </section>

@endsection
