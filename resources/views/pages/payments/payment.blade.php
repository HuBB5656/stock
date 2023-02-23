@extends('inc.frame')


@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="row">
           <div class="col-md-12">
              <div class="card card-primary card-outline">
                <div class="card-header">
                  <h3 class="card-title">
                    <div class="btn btn-primary btn-sm" style="float: left">Total Number Of payment :<b> {{ count($payment) }}</b></div>
                  </h3>
                </div>
            </div>
        </div>
    </div>
    </div>
                <div class="card">
                    <div class="card-body">
                        <div class="p-2" style="float: right"> {{ $payments->links() }}</div>
                      <table id="example1" class="table table-bordered table-striped"  style=" overflow-y:scroll;display:block;overflow-y: hidden;">
                        <thead>
                        <tr>
                          <th>No</th>
                          <th>payment_Date</th>
                          <th>Payment_Type</th>
                          <th>Amount_USD</th>
                          <th>Exchange_Rate</th>
                          <th>Amount_ETB</th>
                          <th>VAT_USD</th>
                          <th>VAT_ETB</th>

                          <th>_________</th>
                        </tr>
                        </thead>
        {{-- 'Paid_Date', 'Sales_Id', 'Payment_Type', 'Amount_USD', 'Exchange_Rate', 'Amount_ETB', 'VAT_USD', 'VAT_ETB', 'Remark', --}}


                        <tbody>
                            @if(count($payments) > 0)
                            @php
                                $no = 0;
                            @endphp
                            @foreach($payments as $payment)
                            @php
                                $no = $no + 1;
                            @endphp
                             <tr>
                                <td>{{$no}}</td>
                                <td>{{$payment->Paid_Date}}</td>
                                <td>{{$payment->Payment_Type}}</td>
                                <td>$ {{number_format($payment->Amount_USD,2)}}</td>
                                <td>{{$payment->Exchange_Rate}}</td>
                                <td>{{ number_format($payment->Amount_ETB,2)}} <small>birr</small></td>
                                <td>$ {{number_format($payment->VAT_USD,2)}} </td>
                                <td>{{number_format($payment->VAT_ETB,2)}} <small>birr</small></td>

                                <td>
                                  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-lg-{{$payment->id}}">
                                  <i class="fas fa-edit"></i> </button>
                                  <a type="button" class="btn btn-danger btn-sm" href="delete-payment-{{$payment->id}}" onclick="return confirm('Are you sure you ? delete this payment !');">
                                    <i class="fas fa-trash"></i></a>
                                </td>
                            </tr>

                            <div class="modal fade" id="modal-lg-{{$payment->id}}">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Edit payment</h4>
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
                                                        <h3 class="card-title">payment <small>Information</small></h3>
                                                    </div>
                                                <!-- /.card-header -->
                                                <!-- form start -->
                                                <form  action="/edit-payment-{{$payment->id}}" method="POST" id="quickForm" >
                                                    @csrf
                                                    <div class="card-body">

                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label >Paid Date</label>
                                                                <input type="date" name="Paid_Date" class="form-control"  value="{{$payment->Paid_Date}}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label for="">Sales ID</label>
                                                                <select class="form-control" name="Sales_Id" required>
                                                                    <option value="{{$payment->Sales_Id}}">
                                                                     @if(count($sales) > 0)
                                                                        @foreach ($sales as $spi )
                                                                         @if($spi->id  == $payment->Sales_Id)
                                                                         {{$spi->id}}
                                                                         @endif
                                                                        @endforeach
                                                                        @endif

                                                                    </option>
                                                                    @if(count($sales) > 0)
                                                                    @foreach ($sales as $spi )
                                                                     <option value="{{$spi->id}}">{{$spi->id}}</option>

                                                                    @endforeach
                                                                    @else
                                                                      <option value="">No Sales Persons List Found !!!</option>
                                                                    @endif
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <div class="form-group">
                                                                <label >Payment Type</label>

                                                                <select class="form-control" name="Payment_Type" required>
                                                                    <option value="{{$payment->Payment_Type}}">{{$payment->Payment_Type}}</option>
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
                                                    </div>

                                                    <div class="row">
                                                        <div class="col-4">
                                                            <div class="form-group">
                                                                <label >Amount USD</label>
                                                                <input type="number" name="Amount_USD" class="form-control" onchange="exchangeRate()" id="Amount_USD" value="{{$payment->Amount_USD}}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="form-group">
                                                                <label >Exchange Rate</label>
                                                                <input type="number" onchange="exchangeRate()"  id="Exchange_Rate" name="Exchange_Rate" class="form-control" value="{{$payment->Exchange_Rate}}"  required>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="form-group">
                                                                <label >Amount ETB</label>
                                                                <input type="number" id="Amount_ETB" readonly name="Amount_ETB" class="form-control" value="{{$payment->Amount_ETB}}" required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">

                                                        <div class="col-4">
                                                            <div class="form-group">
                                                                <label for="">VAT USD</label>
                                                                <input type="number" id="VAT_USD" onchange="vatExchangeRate()" name="VAT_USD" class="form-control" value="{{$payment->VAT_USD}}" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="form-group">
                                                                <label for="">VAT ETB</label>
                                                                <input type="number" id="VAT_ETB" readonly name="VAT_ETB" class="form-control" value="{{$payment->VAT_ETB}}"required>
                                                            </div>
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="form-group">
                                                                <label for="">Remark</label>
                                                                <input type="text" name="Remark" class="form-control" id="" value="{{$payment->Remark}}" >
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </div>
                                                    <div class="modal-footer justify-content-between">
                                                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary swalDefaultSuccess" onclick="return confirm('Are you sure you ? Save Change !');" >Save Changes</button>
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
                             <h2>No payment Found !</h2>
                            @endif
                        </tbody>
                      </table>

                  <div class="p-2" style="float: right"> {{ $payments->links() }}</div>

                    </div>
                    <!-- /.card-body -->
                  </div>

              <!-- /.card -->

              <div class="modal fade" id="modal-lg">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">New payment</h4>
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
                                        <h3 class="card-title">payment <small>Information</small></h3>
                                    </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form  action="/add-payment" method="POST" id="quickForm" >
                                    @csrf
                                    <div class="card-body">

                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label >Paid Date</label>
                                                <input type="date" name="Paid_Date" class="form-control"  placeholder="Paid Date" required>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="">Sales ID</label>
                                                <select class="form-control" name="Sales_Id" required>
                                                    <option value="">Select Property</option>
                                                    @if(count($sales) > 0)
                                                    @foreach ($sales as $spi )
                                                     <option value="{{$spi->id}}">{{$spi->id}}</option>

                                                    @endforeach
                                                    @else
                                                      <option value="">No Sales Persons List Found !!!</option>
                                                    @endif
                                                </select>
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
                                    </div>

                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label >Amount USD</label>
                                                <input type="number" name="Amount_USD" class="form-control" onchange="exchangeRate1()" id="Amount_USD1"  placeholder="Amount USD" required>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label >Exchange Rate</label>
                                                <input type="number" onchange="exchangeRate1()"  id="Exchange_Rate1" name="Exchange_Rate" class="form-control"  placeholder="Exchange Rate" required>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label >Amount ETB</label>
                                                <input type="number" id="Amount_ETB1" readonly name="Amount_ETB" class="form-control"  placeholder="Amount ETB" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="">VAT USD</label>
                                                <input type="number" id="VAT_USD1" onchange="vatExchangeRate1()" name="VAT_USD" class="form-control" id="" placeholder="VAT USD" required>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="">VAT ETB</label>
                                                <input type="number" id="VAT_ETB1" readonly name="VAT_ETB" class="form-control" id="" placeholder="VAT ETB" required>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group">
                                                <label for="">Remark</label>
                                                <input type="text" name="Remark" class="form-control" id="" placeholder="Remark" >
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

  <script>

    function exchangeRate(){
      var ex_rate = document.getElementById("Exchange_Rate").value;
      var amount_usb = document.getElementById("Amount_USD").value;
       document.getElementById("Amount_ETB").value = ex_rate * amount_usb;
    }
    function vatExchangeRate(){
      var ex_rate = document.getElementById("Exchange_Rate").value;
      var amount_usb = document.getElementById("VAT_USD").value;
       document.getElementById("VAT_ETB").value = ex_rate * amount_usb;
    }
  </script>

  <script>
     function exchangeRate1(){
      var ex_rate = document.getElementById("Exchange_Rate1").value;
      var amount_usb = document.getElementById("Amount_USD1").value;
       document.getElementById("Amount_ETB1").value = ex_rate * amount_usb;
    }
    function vatExchangeRate1(){
      var ex_rate = document.getElementById("Exchange_Rate1").value;
      var amount_usb = document.getElementById("VAT_USD1").value;
       document.getElementById("VAT_ETB1").value = ex_rate * amount_usb;
    }

  </script>

@endsection



































  {{-- <button type="button" class="btn btn-primary pull-rigth" style="float: right;" data-toggle="modal" data-target="#modal-lg">
                    ADD New payment
                  </button> --}}
