@extends('inc.frame')


@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="row">
           <div class="col-md-12">
              <div class="card card-primary card-outline">
                <div class="card-header">
                  <h3 class="card-title">
                    <div class="btn-sm" style="float: left">Total sales :<b> {{ count($sale) }}</b></div>
                     &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    @if($rate)
                        <a href="getCurrentRate" class="btn btn-light">
                            <small class="xs" style="color:rgb(6, 6, 199)" >Exchange Rate On : {{$rate->created_at->toDateString()}}</small>
                            &nbsp;&nbsp;
                            <i style="color:blue"> 1 USD = {{$rate->rate}} Birr </i>
                            &nbsp;&nbsp;
                            <i class="fa fa-recycle" style="color: rgb(255, 94, 0)"> Refresh</i>
                        </a>
                      @endif
                    </p>
                  </h3>

                  <button type="button" class="btn btn-primary btn-sm pull-rigth" style="float: right;" data-toggle="modal" data-target="#modal-lg">
                    ADD New sales
                  </button>
                </div>
            </div>
        </div>
    </div>
</div>
                <div class="card">
                    <div class="card-body">
                        <div class="p-2" style="float: right"> {{ $sales->links() }}</div>
                      <table id="example1" class="table table-bordered table-striped" style=" overflow-y:scroll;display:block;overflow-y: hidden;">
                        <thead>
                        <tr>
                          <th>Status</th>
                          <th>Sales_Date</th>
                          <th>Propperty_Name</th>
                          <th>Customer_Name</th>
                          <th>Price_USD </th>
                          {{-- <th>Discount</th>
                          <th>Rate</th>
                          <th>#Payment</th> --}}
                          <th>Finish_%</th>
                          <th>SalesAgent</th>
                          <th>PaymentSchedule</th>
                          <th>MakeReSales</th>
                          <th>___________</th>
                        </tr>
                        </thead>
                        <tbody>
                            @if(count($sales) > 0)

                            @foreach($sales as $sale)

                             <tr>
                                <td>
                                    <div class="btn-group">
                                        @if($sale->Status == 'Active')
                                        <button type="button" class="btn btn-success btn-sm">{{$sale->Status}}</button>
                                        <button type="button" class="btn btn-success dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                        @elseif($sale->Status == 'Cancelled')
                                        <button type="button" class="btn btn-danger btn-xs">{{$sale->Status}}</button>
                                        <button type="button" class="btn btn-danger dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                        @else
                                        <button type="button" class="btn btn-danger btn-sm">{{$sale->Status}}</button>
                                        <button type="button" class="btn btn-danger dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                        @endif
                                          <span class="sr-only">Toggle Dropdown</span>
                                        </button>
                                        <div class="dropdown-menu" role="menu">
                                        <a class="dropdown-item" href="salesStatus-Active-{{$sale->id}}" style="color: green" >
                                        Active</a>
                                          <a class="dropdown-item" href="salesStatus-Cancelled-{{$sale->id}}" style="color: rgb(255, 0, 0)" >Cancel</a>
                                          {{-- <a class="dropdown-item" href="salesStatus-Terminated-{{$sale->id}}" style="color: rgb(255, 0, 0)" >Terminate</a> --}}
                                      </div>
                                </td>
                                <td>{{$sale->Date}}</td>
                                <td>
                                    @if(count($properties) > 0)
                                      @foreach($properties as $ppt)
                                          @if($ppt->id == $sale->Property_Id)
                                          {{$ppt->Title}}
                                          @endif
                                      @endforeach
                                    @endif
                                </td>
                                <td>
                                    @if(count($customers) > 0)
                                    @foreach($customers as $cust)
                                        @if($cust->id == $sale->Customer_Id)
                                        {{$cust->Full_Name}}
                                        @endif
                                    @endforeach
                                  @endif
                                </td>
                                <td>$_{{ number_format($sale->Price_USD,2)}}</td>
                                {{-- <td>$ {{$sale->Discount_USD}}</td>
                                <td>{{$sale->Exchange_Rate}}</td>
                                <td>{{$sale->Number_Of_Payments}}</td> --}}
                                <td>{{$sale->Finishing_Percentage}} %</td>
                                <td>
                                    @if(count($salesPersons) > 0)
                                    @foreach($salesPersons as $sp)
                                        @if($sp->id == $sale->Salesperson_Id)
                                        {{$sp->Full_Name}}
                                        @endif
                                    @endforeach
                                  @endif
                                </td>
                                {{-- <td>{{$sale->Status}}</td> --}}
                                <td>
                                    @if ($sale->approver_one == 'Approved' && $sale->approver_two == 'Approved')
                                    <a type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-lg-PaymentProcess-{{$sale->id}}">
                                        <i class="fas fa-cash"></i>
                                        Set-Schedule
                                    </a>
                                    @elseif ($sale->approver_one == 'Rejected' || $sale->approver_two == 'Rejected')
                                    <a style="pointer-events: none;" type="button" title="reject" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-lg-PaymentProcess-{{$sale->id}}">
                                        <i class="fas fa-cash"></i>
                                        Rejected
                                    </a>
                                    @else
                                    <a style="pointer-events: none;" type="button" title="reject" class="btn btn-default btn-sm" data-toggle="modal" data-target="#modal-lg-PaymentProcess-{{$sale->id}}">
                                        <i class="fas fa-cash"></i>
                                        Pending
                                    </a>

                                    @endif

                                </td>
                                <td>
                                    <a href="#" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#modal-lg-resale-{{$sale->id}}" >
                                       <i class="fas fa-recycle"></i>
                                        Resale
                                    </a>
                                </td>
                                <td style="width: 70%;">
                                  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-lg-{{$sale->id}}">
                                  <i class="fas fa-edit"></i>
                                  </button>
                                  <a type="button" class="btn btn-danger btn-sm" href="suspend-sales-{{$sale->id}}" onclick="return confirm('Are you sure you delete this file. this file permanetly deleted whene its approved by admin. ');">
                                    <i class="fas fa-trash"></i>
                                </a>
                                </td>
                            </tr>

                            {{-- Re Sales --}}

                            <div class="modal fade" id="modal-lg-resale-{{$sale->id}}">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">
                                            Re-Sale
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

                                                <form  action="/addResale" method="POST" id="quickForm" >
                                                    @csrf
                                                    <div class="card-body">

                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label >Former Customer</label>
                                                                @forelse ($customers as $cust )
                                                                    @if($cust->id == $sale->Customer_Id)
                                                                    <input type="text" name="former_customer" class="form-control" readonly value="{{$cust->Full_Name}}" required>
                                                                    @endif
                                                                @empty
                                                                <input type="text" name="former_customer" class="form-control"  value="" required>
                                                                @endforelse
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label >Property</label>
                                                                @forelse ($properties as $property )
                                                                    @if($property->id == $sale->Property_Id)
                                                                    <input type="text" name="property" class="form-control" readonly value="{{$property->Title}} / {{$property->Unit_No}}" required>
                                                                    @endif
                                                                @empty
                                                                    <input type="text" name="property" class="form-control"  value="" required>
                                                                @endforelse
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label >Sold Date</label>
                                                                <input type="date" name="sold_date" readonly required class="form-control" value="{{$sale->Date}}">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-4">
                                                            <div class="form-group">
                                                                <label >Sold Amount USD</label>
                                                                <input type="number" step="any" name="sold_amount_USD" class="form-control" value="{{$sale->Price_USD}}" readonly required>
                                                            </div>
                                                        </div>

                                                        <div class="col-4">
                                                            <div class="form-group">
                                                                <label >Soled Amount ETB</label>
                                                                <input type="number" step="any" name="sold_amount_ETB" readonly  class="form-control"  value="{{$sale->Price_ETB}}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="form-group">
                                                                <label >Paid Amount USD</label>
                                                                @php
                                                                    $paid = 0;
                                                                @endphp
                                                                @forelse ($paymentProcess as $pp )
                                                                    @if($pp->Sales_Id == $sale->id && $pp->Status == 'Paid')
                                                                    @php
                                                                        $paid = $paid + $pp->Due_Amount_USD;
                                                                    @endphp
                                                                    @endif
                                                                @empty
                                                                    {{-- <input type="number" step="any"  name="paid_amount_USD" class="form-control" required>         --}}
                                                                @endforelse
                                                                <input type="number" step="any"  name="paid_amount_USD" class="form-control" readonly value="{{$paid}}" required>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="row">
                                                        <div class="col-4">
                                                            <div class="form-group">
                                                                <label >Paid Amount ETB</label>
                                                                @php
                                                                    $paid = 0;
                                                                @endphp
                                                                @forelse ($paymentProcess as $pp )
                                                                    @if($pp->Sales_Id == $sale->id && $pp->Status == 'Paid')
                                                                    @php
                                                                        $paid = $paid + $pp->Due_Amount_ETB;
                                                                    @endphp
                                                                    @endif
                                                                @empty
                                                                @endforelse
                                                                <input type="number" step="any"  name="paid_amount_ETB" class="form-control" readonly value="{{$paid}}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label >New Customer</label>
                                                                <select class="form-control" name="new_customer_Id" required>
                                                                    <option value="">Select Customer</option>
                                                                    @forelse ($customers as $cust )
                                                                        @if($cust->id != $sale->Customer_Id)
                                                                        <option value="{{$cust->id}}">{{$cust->Full_Name}}</option>
                                                                        @endif
                                                                    @empty
                                                                    @endforelse
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="form-group">
                                                                <label >Resale Price USD</label>
                                                                <input type="number" step="any" name="resale_amount_USD" class="form-control" onchange="exchangeRateRS({{$sale->id}})"  id="USD_RS_{{$sale->id}}" required>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-4">
                                                            <div class="form-group">
                                                                <label >Exchange Rate</label>
                                                                <input type="number" step="any" name="exchange_rate" class="form-control" onchange="exchangeRateRS({{$sale->id}})"  id="Exchange_Rate_RS_{{$sale->id}}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="form-group">
                                                                <label >Resale Price ETB</label>
                                                                <input type="number" step="any" name="resale_amount_ETB" readonly id="ETB_RS_{{$sale->id}}" class="form-control" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="form-group">
                                                                <label >Remark</label>
                                                                <input type="text" name="remark"  class="form-control" placeholder="Remark">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary swalDefaultSuccess" >Save</button>
                                                    </div>
                                                </form>

                                                    {{-- <h3 class="card-title">payment <small>for Sales ID : {{$sale->id}}</small></h3> --}}
                                                </div>
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

                            {{-- Payment Schedule --}}

                            <div class="modal fade" id="modal-lg-PaymentProcess-{{$sale->id}}">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">
                                            @if(count($customers) > 0)
                                            @foreach($customers as $cust)
                                                @if($cust->id == $sale->Customer_Id)
                                                {{$cust->Full_Name}}
                                                @endif
                                            @endforeach
                                          @endif
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

                                                <form  action="/add-PaymentProcess-{{$sale->id}}" method="POST" id="quickForm" >
                                                    @csrf
                                                    <div class="card-body">

                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label >Due Date</label>
                                                                <input type="date" name="Due_Date" class="form-control"  placeholder="Due Date" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label >Payment Type</label>

                                                                <select class="form-control" name="Payment_Type" required>
                                                                    <option value="">Select Type</option>
                                                                    <option value="Deposit">Deposit</option>
                                                                    <option value="Payment 1">Payment 1</option>
                                                                    <option value="Payment 2">Payment 2</option>
                                                                    <option value="Payment 3">Payment 3</option>
                                                                    <option value="Payment 4">Payment 4</option>
                                                                    <option value="Payment 5">Payment 5</option>
                                                                    <option value="Payment 6">Payment 6</option>
                                                                    <option value="Payment 7">Payment 7</option>
                                                                    <option value="Payment 8">Payment 8</option>
                                                                    <option value="Payment 9">Payment 9</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label >Construction Stage % <small>opt</small></label>
                                                                <input type="number" max="100" name="Construction_Stage" class="form-control"  placeholder="Construction_Stage">
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-4">
                                                            <div class="form-group">
                                                                <label >Amount USD</label>
                                                                <input type="number" step="any" name="Due_Amount_USD" class="form-control" onchange="exchangeRatePP({{$sale->id}})" id="Due_Amount_USD_pp_{{$sale->id}}"  placeholder="Amount USD" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="form-group">
                                                                <label >Exchange Rate</label>
                                                                <input type="number" step="any" onchange="exchangeRatePP({{$sale->id}})"  id="Exchange_Rate_pp_{{$sale->id}}" name="Exchange_Rate" class="form-control" @if($rate) value="{{$rate->rate}}" @endif required>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="form-group">
                                                                <label >Amount ETB</label>
                                                                <input type="number" step="any" id="Due_Amount_ETB_pp_{{$sale->id}}" readonly name="Due_Amount_ETB" class="form-control"  placeholder="Due_Amount ETB" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary swalDefaultSuccess" >Save</button>
                                                    </div>
                                                </form>
                                                <div class="row">

                                                    <div class="col-md-12">
                                                        <div class="card-header">

                                                        <h5><a href="">Payment Schedule.</a></h5>

                                                    </div>

                                                      <!-- The time line -->
                                                      <div class="timeline">
                                                        @if(count($paymentProcess) > 0)
                                                            @foreach($paymentProcess as $pp)
                                                                @if($pp->Sales_Id == $sale->id)
                                                                <div>
                                                                    <a type="button" class="btn btn-primary btn-sm">
                                                                        <i class="fas fa-usd"></i>
                                                                       $ {{number_format($pp->Due_Amount_USD,2)}}
                                                                    </a>
                                                                    @if($pp->Status != 'Paid')
                                                                        <a type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-lg-pay-{{$pp->id}}">
                                                                        <i>Pay</i>
                                                                        </a>
                                                                    @endif

                                                                    <div class="timeline-item">
                                                                      <h3 class="timeline-header no-border">
                                                                          &nbsp;&nbsp;&nbsp;
                                                                           <small>Due Amount ETB </small> : {{number_format($pp->Due_Amount_ETB,2)}} <small>Birr</small> &nbsp;&nbsp;&nbsp;
                                                                           <small>Due Date</small>  : {{$pp->Due_Date}} &nbsp;&nbsp;&nbsp;
                                                                           <small>Type</small>  : {{$pp->Payment_Type}} &nbsp;&nbsp;&nbsp;
                                                                           <small>Status  </small> :
                                                                            @if($pp->Status == 'Paid')
                                                                              <i style="color: rgb(26, 224, 0)">{{$pp->Status}}</i>
                                                                            @elseif($pp->Status == 'Partialy Paid')
                                                                              <i style="color: rgb(243, 251, 2)">{{$pp->Status}}</i>
                                                                            @elseif($pp->Status == 'Not Paid')
                                                                              <i style="color: rgb(245, 4, 4)">{{$pp->Status}}</i>
                                                                            @else
                                                                              <i style="color: rgb(4, 32, 245)">{{$pp->Status}}</i>
                                                                            @endif
                                                                      </h3>
                                                                    </div>
                                                                 </div>
                                                                @endif
                                                            @endforeach
                                                        @endif
                                                        <div>
                                                            <i class="fas fa-clock bg-gray"></i>
                                                          </div>
                                                      </div>
                                                    </div>
                                                </div>
                                                    {{-- <h3 class="card-title">payment <small>for Sales ID : {{$sale->id}}</small></h3> --}}
                                                </div>
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




              <div class="modal fade" id="modal-lg-{{$sale->id}}">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Edit sale</h4>
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
                                        <h3 class="card-title">sales <small>Information</small></h3>
                                    </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form  action="/edit-sales-{{$sale->id}}" method="POST" id="quickForm" >
                                    @csrf
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Date</label>
                                                        <input type="date" name="Date" class="form-control" value="{{$sale->Date}}" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Customer</label>
                                                    <select class="form-control" name="Customer_Id" required>
                                                        <option value="{{$sale->Customer_Id}}">
                                                            @if(count($customers) > 0)
                                                            @foreach ($customers as $cust )
                                                            @if($sale->Customer_Id == $cust->id)
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
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Exchange Rate</label>
                                                        <input type="number" onchange="advance()" name="Exchange_Rate" value="{{$sale->Exchange_Rate}}"class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Property</label>
                                                    <select class="form-control" name="Property_Id" required>
                                                        <option value="{{$sale->Property_Id}}">
                                                            @if(count($properties) > 0)
                                                            @foreach ($properties as $ppt )
                                                            @if($sale->Property_Id == $ppt->id)
                                                              {{$ppt->Title}}
                                                            @endif

                                                            @endforeach
                                                            @endif
                                                        </option>
                                                        @if(count($properties) > 0)
                                                        @foreach ($properties as $prp )
                                                         @if( $prp->Status == 'Available')
                                                         <option value="{{$prp->id}}"> {{$prp->Title}}</option>
                                                         @endif
                                                        @endforeach
                                                        @else
                                                          <option value="Female">No Properties List Found !!!</option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Price USD $</label>
                                                        <input type="number" onchange="advance()"  step="any" name="Price_USD" value="{{$sale->Price_USD}}" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Discount_USD $</label>
                                                        <input type="number" step="any" name="Discount_USD" value="{{$sale->Discount_USD}}" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Advance_Percentage $</label>
                                                        <input type="number" step="any" name="Advance_Percentage" value="{{$sale->Advance_Percentage}}" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Advance_USD $</label>
                                                        <input type="number" step="any" name="Advance_USD"  value="{{$sale->Advance_USD}}" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Price ETB</label>
                                                        <input type="number" step="any" name="Price_ETB" value="{{$sale->Price_ETB}}" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Advance_ETB</label>
                                                        <input type="number" step="any" name="Advance_ETB" value="{{$sale->Advance_ETB}}" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="">Number Of Payments</label>
                                                        <input type="number" name="Number_Of_Payments" value="{{$sale->Number_Of_Payments}}" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="">Finishing Percentage</label>
                                                        <input type="number" step="any" min="0" max="99" name="Finishing_Percentage" value="{{$sale->Finishing_Percentage}}" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="">Sales Persons</label>
                                                    <select class="form-control" name="Salesperson_Id" required>
                                                        <option value="{{$sale->Salesperson_Id}}">
                                                            @if(count($salesPersons) > 0)
                                                            @foreach ($salesPersons as $spi )
                                                            @if($sale->Salesperson_Id == $spi->id)
                                                              {{$spi->Full_Name}}
                                                            @endif

                                                            @endforeach
                                                            @endif
                                                        </option>
                                                        @if(count($salesPersons) > 0)
                                                        @foreach ($salesPersons as $spi )
                                                         <option value="{{$spi->id}}">{{$spi->Full_Name}}</option>

                                                        @endforeach
                                                        @else
                                                          <option value="Female">No Sales Persons List Found !!!</option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">

                                            <div class="col-6">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="">Contract ID <small>opt</small></label>
                                                            <input type="text" name="contract_id" class="form-control"  value="{{$sale->Contract_ID}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="">Contract Doc <small>opt</small></label>
                                                            <input type="file"  name="contract_doc" class="form-control" value="" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="">Remark <small>opt</small></label>
                                                            <textarea name="remark"  rows="5" class="form-control" placeholder="Remark ..." >{{$sale->Remark}}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                    <div class="modal-footer justify-content-between">
                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary swalDefaultSuccess" onclick="return confirm('Are you sure you ? update this data !!!');" >Save Change</button>
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
                             <h2>No sale Found !</h2>
                            @endif
                        </tbody>
                      </table>

                  <div class="p-2" style="float: right"> {{ $sales->links() }}</div>

                    </div>
                    <!-- /.card-body -->


              @if(count($paymentProcess) > 0)
              @foreach($paymentProcess as $pp)
                   <div class="modal fade" id="modal-lg-pay-{{$pp->id}}">
                       <div class="modal-dialog modal-lg">
                           <div class="modal-content">
                           <div class="modal-header">
                               <h4 class="modal-title">
                                 $ {{$pp->Due_Amount_USD}} &nbsp;&nbsp;&nbsp;&nbsp; <small style="font-size: 15px;">Due Date : {{$pp->Due_Date}}</small>
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

                                       <form  action="/add-payment-{{$pp->id}}" method="POST" id="quickForm" enctype="multipart/form-data" >
                                           @csrf
                                           <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label >FS Number</label>
                                                        <input type="text" name="FS_Number" class="form-control"  placeholder="FS Number" onchange="exchangeRate({{$pp->id}})" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label >CPO Number <small>opt</small></label>
                                                        <input type="text" name="CPO_Number" class="form-control"  placeholder="CPO Number">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label >Paid Date</label>
                                                        <input type="date" name="Paid_Date" class="form-control" onmousemove="vatExchangeRate({{$pp->id}})" placeholder="Paid Date" required>
                                                    </div>
                                                </div>
                                            </div>

                                           <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label >Payment Type</label>

                                                    <select class="form-control" name="Payment_Type" required>
                                                            {{-- @if($pp->Status == 'Not Paid') --}}
                                                                <option selected value="{{$pp->Payment_Type}}">{{$pp->Payment_Type}}</option>
                                                            {{-- @endif --}}
                                                    </select>
                                                </div>
                                            </div>
                                               <div class="col-3">
                                                   <div class="form-group">
                                                       <label >Amount USD</label>
                                                       <input type="number" step="any" name="Amount_USD" class="form-control" onchange="exchangeRate({{$pp->id}})" id="Amount_USD_{{$pp->id}}" value="{{$pp->Due_Amount_USD}}" required>
                                                   </div>
                                               </div>
                                               <div class="col-3">
                                                   <div class="form-group">
                                                       <label >Exg Rate</label>
                                                       <input type="number" step="any" onchange="exchangeRate({{$pp->id}})"  id="Exchange_Rate_{{$pp->id}}" name="Exchange_Rate" class="form-control"  @if($rate) value="{{$rate->rate}}" @endif required>
                                                   </div>
                                               </div>
                                               <div class="col-3">
                                                <div class="form-group">
                                                    <label for="">VAT USD</label>
                                                    <input type="number" step="any" id="VAT_USD_{{$pp->id}}" onclick="exchangeRate({{$pp->id}})" name="VAT_USD" class="form-control" readonly required>
                                                </div>
                                              </div>
                                           </div>
                                           <div class="row">

                                            <div class="col-4">
                                                <div class="form-group">
                                                    <label >Amount ETB</label>
                                                    <input type="number" step="any" id="Amount_ETB_{{$pp->id}}" readonly name="Amount_ETB" class="form-control"  required>
                                                </div>
                                            </div>
                                               <div class="col-4">
                                                   <div class="form-group">
                                                       <label for="">VAT ETB</label>
                                                       <input type="number" step="any" id="VAT_ETB_{{$pp->id}}" readonly name="VAT_ETB" class="form-control" id="" placeholder="VAT ETB" required>
                                                   </div>
                                               </div>
                                               <div class="col-4">
                                                   <div class="form-group">
                                                       <label for="">Remark</label>
                                                       <input type="text" name="Remark" class="form-control" id="" placeholder="Remark" >
                                                   </div>
                                               </div>
                                           </div>
                                            <hr>
                                           <div class="row">
                                            <div class="col-sm-6">
                                            <div class="row">
                                                <div class="col-12">
                                                    <label for="">Attach Receipt <small><option value=""></option></small> </label>
                                                    <input type="file" name="receipt" class="form-control" id="" placeholder="Attach Receipt " >
                                                </div>
                                                <div class="col-4" >
                                                    <label for="">Vat %</label>
                                                    <input type="number" name="vat" id="vat" class="form-control" id="" value="12" onchange="vatExchangeRate({{$pp->id}})">
                                                </div>
                                            </div>

                                            </div>
                                            <div class="col-sm-6 ">
                                            <div  style="float: right" class="p-2">
                                                <p><b>Total</b></p>
                                                <i id="total_{{$pp->id}}"></i> <small>Birr</small>
                                            </div>

                                            </div>

                                           </div>
                                           </div>
                                           <div class="modal-footer justify-content-between">
                                               <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                               <button type="submit" class="btn btn-primary swalDefaultSuccess" >Save</button>
                                           </div>
                                       </form>

                                           {{-- <h3 class="card-title">payment <small>for Sales ID : {{$sale->id}}</small></h3> --}}
                                       </div>
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
                       @endforeach
                       @endif

              <!-- /.card -->

              <div class="modal fade" id="modal-lg">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">New sale</h4>
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
                                        <h3 class="card-title">sales <small>Information</small></h3>
                                    </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form  action="/add-sales" method="POST" id="quickForm" >
                                    @csrf
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">Date</label>
                                                        <input type="date" name="Date" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">Customer</label>
                                                    <select class="form-control" name="Customer_Id" required>
                                                        <option value="">Select Customer</option>
                                                        @if(count($customers) > 0)
                                                        @foreach ($customers as $cust )
                                                         <option value="{{$cust->id}}">{{$cust->Full_Name}}</option>

                                                        @endforeach
                                                        @else
                                                          <option value="">No Customer List Found !!!</option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">Sales Agent</label>
                                                    <select class="form-control" name="Salesperson_Id" required>
                                                        <option value="">Select Sales Agent</option>
                                                        @if(count($salesPersons) > 0)
                                                        @foreach ($salesPersons as $spi )
                                                         <option value="{{$spi->id}}">{{$spi->Full_Name}}</option>
                                                        @endforeach
                                                        @else
                                                          <option value="">No Sales Persons List Found !!!</option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">Property</label>
                                                    <select class="form-control" onchange="getProprtyPrice()" id="property" name="Property_Id" required>
                                                        <option value="">Select Property</option>
                                                        @if(count($properties) > 0)
                                                        @foreach ($properties as $prp )
                                                        @if( $prp->Status == 'Available')
                                                        <option value="{{$prp->id}}"> {{$prp->Title}} /  {{$prp->Unit_No}}</option>
                                                        @endif
                                                        @endforeach
                                                        @else
                                                          <option value="">No Properties List Found !!!</option>
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">Price USD $</label>
                                                        <input type="number"  step="any" onchange="advance()"  id="priceUSD" name="Price_USD" class="form-control" required>
                                                </div>
                                            </div>

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">Discount_USD</label>
                                                        <input type="number" step="any" id="Discount_USD" value="0" onchange="advance()" name="Discount_USD" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">Exchange Rate</label>
                                                        <input type="number" onchange="advance()" step="any" id="ex_rate" name="Exchange_Rate" @if($rate) value="{{$rate->rate}}" @endif class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">Price ETB</label>
                                                        <input  type="number"  step="any" readonly="readonly" name="Price_ETB" id="priceETB" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label for="">Advance %</label>
                                                        <input type="number" step="any" id="Advance_Percentage" min="0" max="100" onchange="advance()" name="Advance_Percentage" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="">Advance_USD</label>
                                                        <input  type="number" step="any" readonly="readonly" id="Advance_USD" name="Advance_USD" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="">Advance_ETB</label>
                                                        <input  type="number" step="any" readonly="readonly" id="Advance_ETB" name="Advance_ETB" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="">No Of Payments</label>
                                                        <input type="number" name="Number Of Payments" class="form-control" required>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="">Finishing %</label>
                                                        <input type="number" step="any" min="0" max="100" name="Finishing_Percentage" class="form-control" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-6">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="">Contract ID <small>opt</small></label>
                                                            <input type="text" name="contract_id" class="form-control" >
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="">Contract Doc <small>opt</small></label>
                                                            <input type="file"  name="contract_doc" class="form-control" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="">Remark <small>opt</small></label>
                                                            <textarea name="remark"  rows="5" class="form-control" placeholder="Remark ..." ></textarea>
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
    </div>
  </section>
  <script>
    function getProprtyPrice() {
      var x = document.getElementById("property").value;
      var ex_rate = document.getElementById("ex_rate").value;
      if(ex_rate == ''){
        document.getElementById("ex_rate").style.borderColor = 'red';
      }
      var size = 0;
      $.ajax({
        type: "POST",
        url: "{{url('getPropertyPrice')}}",
        dataType:'json',
        data:{
               '_token':'{{ csrf_token() }}',
                id:x,
            },
        success: function (result) {
            // console.log(parseFloat(result.Price_In_USD.toLocaleString('en-US')));
            document.getElementById('priceUSD').value = result.Price_In_USD;
        },

        });
    }
    function exchangeRate(){
      var ex_rate = document.getElementById("ex_rate").value;
      var usd = document.getElementById('priceUSD').value;
      var Ex = ex_rate * usd;
      document.getElementById('priceETB').value = Ex;
    }


    function advance(){
        var x = document.getElementById("property").value;
        var ex_rate = document.getElementById("ex_rate").value;
        var Discount_USD = document.getElementById("Discount_USD").value;
        var Price_USD = document.getElementById('priceUSD').value;
        var Advance_Percentage = document.getElementById("Advance_Percentage").value;

        var adv =  Price_USD  *  Advance_Percentage /100;
            var advETB = adv * ex_rate;
            var priceETB = ex_rate * Price_USD;
            document.getElementById('Advance_USD').value = adv.toFixed(2);
            document.getElementById('Advance_ETB').value = advETB.toFixed(2);
            document.getElementById('priceETB').value = priceETB.toFixed(2);
    //   $.ajax({
    //     type: "POST",
    //     url: "{{url('getPropertyPrice')}}",
    //     dataType:'json',
    //     data:{
    //            '_token':'{{ csrf_token() }}',
    //             id:x,
    //         },
    //     success: function (result) {
    //         console.log(result.Size);
    //         var adv =  result.Size * (Price_USD - Discount_USD ) *  Advance_Percentage /100;
    //         var advETB = adv * ex_rate;
    //         var priceETB = ex_rate * Price_USD;
    //         var finshing = result.Size * (Price_USD - Discount_USD ) / 100;
    //         document.getElementById('Advance_USD').value = adv.toFixed(2);
    //         document.getElementById('Advance_ETB').value = advETB.toFixed(2);
    //         document.getElementById('priceETB').value = priceETB.toFixed(2);
    //     },

    //     });

    }
</script>

<script>
    function exchangeRate(id){
     var ex_rate = document.getElementById("Exchange_Rate_"+id).value;
     var amount_usd = document.getElementById("Amount_USD_"+id).value;
     var priceETB = ex_rate * amount_usd;
      document.getElementById("Amount_ETB_"+id).value = priceETB.toFixed(2) ;

      var vat = document.getElementById("vat").value;
      var vat_usd = amount_usd * vat / 100;
      var vatETB =  ex_rate * vat_usd;
      var usd_total = parseFloat(amount_usd) + parseFloat(vat_usd);
      var etb_total =  usd_total * ex_rate;
      document.getElementById('total_'+id).innerHTML = etb_total.toLocaleString('en-US');

   }
   function vatExchangeRate(id){
     var ex_rate = document.getElementById("Exchange_Rate_"+id).value;
     var amount_usd = document.getElementById("Amount_USD_"+id).value;
     var vat = document.getElementById("vat").value;
     var vat_usd = amount_usd * vat / 100;
     var vatETB =  ex_rate * vat_usd;
     var usd_total = parseFloat(amount_usd) + parseFloat(vat_usd);
     var etb_total =  usd_total * ex_rate;
      document.getElementById("VAT_ETB_"+id).value = vatETB.toFixed(2);
      document.getElementById("VAT_USD_"+id).value = vat_usd.toFixed(2);
      document.getElementById('total_'+id).innerHTML = etb_total.toLocaleString('en-US');

   }

   function exchangeRatePP(id){
     var ex_rate = document.getElementById("Exchange_Rate_pp_"+id).value;
     var amount_usb = document.getElementById("Due_Amount_USD_pp_"+id).value;
     var priceETB = ex_rate * amount_usb;
      document.getElementById("Due_Amount_ETB_pp_"+id).value = priceETB.toFixed(2) ;
   }
   function exchangeRateRS(id){
     var ex_rate = document.getElementById("Exchange_Rate_RS_"+id).value;
     var amount_usb = document.getElementById("USD_RS_"+id).value;
     var priceETB = ex_rate * amount_usb;
      document.getElementById("ETB_RS_"+id).value = priceETB.toFixed(2) ;
   }

 </script>

@endsection
