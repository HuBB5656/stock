@extends('inc.frame')


@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="row">
           <div class="col-md-12">
              <div class="card card-primary card-outline">
                <div class="card-header">
                  <h3 class="card-title">
                    <div class="btn btn-primary btn-sm" style="float: left">Total Number Of paymentRefund :<b> {{ count($paymentRefund) }}</b></div>
                  </h3>
                  <button type="button" class="btn btn-primary pull-rigth btn-sm" style="float: right;" data-toggle="modal" data-target="#modal-lg">
                    ADD New paymentRefund
                  </button>
                </div>
            </div>
        </div>
    </div>
    </div>
                <div class="card">
                    <div class="card-body">
                        <div class="p-2" style="float: right"> {{ $paymentRefunds->links() }}</div>
                      <table id="example1" class="table table-bordered table-striped" style=" overflow-y:scroll;display:block;overflow-y: hidden;">
                        <thead>
                        <tr>
                          <th>No</th>
                          <th>Refund_Date</th>
                          <th>Customer_Name</th>
                          <th>Refund_Amount</th>
                          <th>VAT_Credit_Due</th>
                          <th>Registered_at</th>
                          <th>Remarks</th>
                          <th>_______</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(count($paymentRefunds) > 0)
                            @php
                                $no = 0;
                            @endphp
                            @foreach($paymentRefunds as $paymentRefund)
                            @php
                                $no = $no + 1;
                            @endphp
                             <tr>
                                <td>{{$no}}</td>
                                <td>{{$paymentRefund->Date}}</td>
                                <td>
                                    @if(count($customers) > 0)
                                    @foreach ($customers as $cust )
                                     @if($cust->id == $paymentRefund->Customer_Id)
                                      {{$cust->Full_Name}}
                                     @endif
                                    @endforeach
                                    @else
                                     No Customer List Found !!!
                                    @endif

                                </td>
                                <td> {{number_format($paymentRefund->Refund_Amount,2)}}</td>
                                <td>{{number_format($paymentRefund->VAT_Credit_Due,2)}}</td>
                                <td>{{$paymentRefund->created_at}}</td>
                                <td>{{$paymentRefund->Remarks}}</td>

                                <td>
                                  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-lg-{{$paymentRefund->id}}">
                                  <i class="fas fa-edit"></i>
                                  </button>
                                  <a type="button" class="btn btn-danger btn-sm" href="delete-paymentRefund-{{$paymentRefund->id}}" onclick="return confirm('Are you sure you ?');">
                                    <i class="fas fa-trash"></i>
                                  </a>
                                </td>
                            </tr>

                            <div class="modal fade" id="modal-lg-{{$paymentRefund->id}}">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Edit paymentRefund</h4>
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
                                                        <h3 class="card-title">paymentRefund <small>Information</small></h3>
                                                    </div>
                                                <!-- /.card-header -->
                                                <!-- form start -->
                                                <form  action="/edit-paymentRefund-{{$paymentRefund->id}}" method="POST" id="quickForm" >
                                                    @csrf
                                                    <div class="card-body">
                                                    <div class="form-group">
                                                        <label >Date</label>
                                                        <input type="date" name="Date" class="form-control"  value="{{$paymentRefund->Date}}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Customer</label>
                                                        <select class="form-control" name="Customer_Id" required>
                                                            <option value="{{$paymentRefund->Customer_Id}}">
                                                                @if(count($customers) > 0)
                                                                @foreach ($customers as $cust )
                                                                @if($paymentRefund->Customer_Id == $cust->id)
                                                                  {{$cust->Full_Name}}
                                                                @endif

                                                                @endforeach
                                                                @endif
                                                            </option>
                                                            @if(count($customers) > 0)
                                                            @foreach ($customers as $cust )
                                                             <option value="{{$cust->id}}">{{$cust->Full_Name}}</option>

                                                            @endforeach
                                                            @else
                                                              <option value="Female">No Customer List Found !!!</option>
                                                            @endif
                                                        </select>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Refund Amount</label>
                                                        <input type="number" name="Refund_Amount" class="form-control" id="" value="{{$paymentRefund->Refund_Amount}}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">VAT Credit Due</label>
                                                        <input type="number" name="VAT_Credit_Due" class="form-control" id="" value="{{$paymentRefund->VAT_Credit_Due}}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="">Remarks</label>
                                                        <input type="text" name="Remarks" class="form-control" id="" value="{{$paymentRefund->Remarks}}" required>
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
                             <h2>No paymentRefund Found !</h2>
                            @endif
                        </tbody>
                      </table>

                  <div class="p-2" style="float: right"> {{ $paymentRefunds->links() }}</div>

                    </div>
                    <!-- /.card-body -->
                  </div>

              <!-- /.card -->

              <div class="modal fade" id="modal-lg">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">New paymentRefund</h4>
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
                                        <h3 class="card-title">paymentRefund <small>Information</small></h3>
                                    </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form  action="/add-paymentRefund" method="POST" id="quickForm" >
                                    @csrf
                                    <div class="card-body">
                                    <div class="form-group">
                                        <label >Date</label>
                                        <input type="date" name="Date" class="form-control"  placeholder="Date" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Customer</label>
                                        <select class="form-control" name="Customer_Id" required>
                                            <option value="">
                                                Selecte Customer
                                            </option>
                                            @if(count($customers) > 0)
                                            @foreach ($customers as $cust )
                                             <option value="{{$cust->id}}">{{$cust->Full_Name}}</option>

                                            @endforeach
                                            @else
                                              <option value="Female">No Customer List Found !!!</option>
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Refund Amount</label>
                                        <input type="number" name="Refund_Amount" class="form-control" id="" placeholder="Refund Amount" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="">VAT Credit Due</label>
                                        <input type="number" name="VAT_Credit_Due" class="form-control" id="" placeholder="VAT Credit Due" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="">Remarks</label>
                                        <input type="text" name="Remarks" class="form-control" id="" placeholder="Remarks" required>
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



































