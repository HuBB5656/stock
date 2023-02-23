@extends('inc.frame')


@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="row">
           <div class="col-md-12">
              <div class="card card-primary card-outline">
                <div class="card-header">
                  <h3 class="card-title">
                    <div class="btn-sm" style="float: left">Total Customers : <b> {{ count($customer) }}</b></div>
                  </h3>
                  <button type="button" class="btn btn-primary pull-rigth btn-sm" style="float: right;" data-toggle="modal" data-target="#modal-lg">
                    ADD New Customer
                  </button>
                </div>
            </div>
        </div>
    </div>
    </div>
                <div class="card">
                    <div class="card-body">
                        <div class="p-2" style="float: right"> {{ $customers->links() }}</div>
                      <table id="example1" class="table table-bordered table-striped" style=" overflow-y:scroll;display:block;overflow-y: hidden;">
                        <thead>
                        <tr>
                          <th>No</th>
                          <th style="width: 50%">Full_Name</th>
                          <th>Gender</th>
                          <th>Profession</th>
                          {{-- <th>Reg_Date</th> --}}
                          <th>Primary_Phone</th>
                          <th>CustomerAddress</th>
                          <th>Primary_Email</th>
                          <th>SummaryDoc    </th>
                          <th>___________</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(count($customers) > 0)
                            @php
                                $no = 0;
                            @endphp
                            @foreach($customers as $customer)
                            @php
                                $no = $no + 1;
                            @endphp
                             <tr>
                                <td>{{$no}}</td>
                                <td>{{ str_replace(' ', '_', $customer->Full_Name)}}</td>
                                <td>{{$customer->Gender}}</td>
                                <td> {{$customer->Profession}}</td>
                                {{-- <td>{{$customer->created_at}}</td> --}}
                                <td>{{$customer->Primary_Phone}}</td>
                                <td>{{$customer->Address1}}</td>
                                <td>{{$customer->Primary_Email}}</td>
                                <td>
                                    <a type="button" class="btn btn-secondary btn-sm" target="_blank" href="getCustomerSalesDetail-{{$customer->id}}">
                                        <i class="fas fa-book"></i>
                                        Summary
                                    </a>
                                </td>
                                <td>
                                  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-lg-{{$customer->id}}">
                                  <i class="fas fa-edit"></i>
                                  </button>
                                  <a type="button" class="btn btn-danger btn-sm" href="delete-customer-{{$customer->id}}" onclick="return confirm('Are you sure you ? Permanently Delete {{$customer->Full_Name}}');">
                                    <i class="fas fa-trash"></i>

                                </a>
                                </td>
                            </tr>

                            <div class="modal fade" id="modal-lg-{{$customer->id}}">
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
                                                        <h3 class="card-title"><i class="fas fa-edit"></i>
                                                            {{$customer->Full_Name}}</small></h3>
                                                    </div>
                                                <!-- /.card-header -->
                                                <!-- form start -->
                                                <form  action="/edit-customer-{{$customer->id}}" method="POST" id="quickForm" >
                                                    @csrf
                                                    <div class="card-body">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label >Customer Name</label>
                                                                    <input type="text" name="customer_name" class="form-control"  value="{{$customer->Full_Name}}" required>
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label >Gender</label>
                                                                    <select class="form-control" name="gender" required>
                                                                        <option value="{{$customer->Gender}}"> {{$customer->Gender}}</option>
                                                                        <option value="M">Male</option>
                                                                        <option value="F">Female</option>

                                                                    </select>

                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label >Primary_Phone </label>
                                                                    <input type="text" name="primary_phone" class="form-control" value="{{$customer->Primary_Phone}}" required pattern="[+ , 0]{1}[0-9]{9,14}">
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label >Profession <small>opt</small></label>
                                                                    <input type="text" name="profession" class="form-control"  value="{{$customer->Profession}}" >
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="row">

                                                            <div class="col-4">
                                                                <div class="form-group">
                                                                    <label >Secondary_Phone <small>opt</small> </label>
                                                                    <input type="text" name="secondary_phone" class="form-control" value="{{$customer->Secondary_Phone}}" pattern="[+ , 0]{1}[0-9]{9,14}">
                                                                </div>
                                                            </div>
                                                            <div class="col-4">
                                                                <div class="form-group">
                                                                    <label >Address1 <small>opt</small></label>
                                                                    <input type="text" name="address1" class="form-control"  value="{{$customer->Address1}}" >
                                                                </div>
                                                            </div>
                                                            <div class="col-4">
                                                                <div class="form-group">
                                                                    <label >Address2 <small>opt</small></label>
                                                                    <input type="text" name="address2" class="form-control" value="{{$customer->Address2}}" >
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">

                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label >Primary_Email <small>opt</small> </label>
                                                                    <input type="email" name="primary_email" class="form-control" value="{{$customer->Primary_Email}}">
                                                                </div>
                                                            </div>
                                                            <div class="col-6">
                                                                <div class="form-group">
                                                                    <label >Secondary_Email <small>opt</small></label>
                                                                    <input type="email" name="secondary_email" class="form-control"  value="{{$customer->Secondary_Email}}" >
                                                                </div>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary swalDefaultSuccess"  onclick="return confirm('Are you sure you want to save changes ?');" >Save Change</button>
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
                             <h2>No customer Found !</h2>
                            @endif
                        </tbody>
                      </table>

                  <div class="p-2" style="float: right"> {{ $customers->links() }}</div>

                    </div>
                    <!-- /.card-body -->
                  </div>

              <!-- /.card -->

              <div class="modal fade" id="modal-lg">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">New customer</h4>
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
                                        <h3 class="card-title">customer <small>Information</small></h3>
                                    </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form  action="/add-customer" method="POST" id="quickForm" >
                                    @csrf
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label >Customer Name</label>
                                                    <input type="text" name="customer_name" class="form-control"  placeholder="customer Name" required>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label >Gender</label>
                                                    <select class="form-control" name="gender" required>
                                                        <option value="">Select</option>
                                                        <option value="M">Male</option>
                                                        <option value="F">Female</option>

                                                    </select>

                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">

                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label >Primary_Phone </label>
                                                    <input type="text" name="primary_phone" class="form-control"  placeholder="Primary Phone" required pattern="[+ , 0]{1}[0-9]{9,14}">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label >Profession <small>opt</small></label>
                                                    <input type="text" name="profession" class="form-control"  placeholder="Profession" >
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">

                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label >Secondary_Phone <small>opt</small> </label>
                                                    <input type="text" name="secondary_phone" class="form-control"  placeholder="Secondary_Phone" pattern="[+ , 0]{1}[0-9]{9,14}">
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label >Address1 <small>opt</small></label>
                                                    <input type="text" name="address1" class="form-control"  placeholder="Address1" >
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label >Address2 <small>opt</small></label>
                                                    <input type="text" name="address2" class="form-control"  placeholder="Address2" >
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">

                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label >Primary_Email <small>opt</small> </label>
                                                    <input type="text" name="primary_email" class="form-control"  placeholder="Primary_Email">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label >Secondary_Email <small>opt</small></label>
                                                    <input type="text" name="secondary_email" class="form-control"  placeholder="Secondary_Email" >
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
                <!-- /.modal -->

  </section>

@endsection
