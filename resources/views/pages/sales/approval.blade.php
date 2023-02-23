@extends('inc.frame')

@section('content')
<link rel="stylesheet" href="../../plugins/icheck-bootstrap/icheck-bootstrap.min.css">

    <section class="content">
      <div class="row p-2">
        <div class="col-md-3" style="position:-webkit-sticky; position: sticky; top: 0; !important">
          <a href="#" class="btn btn-primary btn-block mb-3">Notifications</a>
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Messages</h3>

              <div class="card-tools">
                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                  <i class="fas fa-minus"></i>
                </button>
              </div>
            </div>
            <div class="card-body p-0">
              <ul class="nav nav-pills flex-column">
                <li class="nav-item active">
                  <a href="#" class="nav-link" onclick="getSalesToApprove()">
                    <i class="fas fa-inbox"></i> Sales Approval
                    <span class="badge bg-warning float-right">{{count($sales)}}</span>
                  </a>
                </li>


                <li class="nav-item">
                  <a href="#" class="nav-link" onclick="getTrushSales()" >
                    <i class="far fa-trash-alt"></i> Trash Sales
                    <span class="badge bg-warning float-right">{{count($trushSales)}}</span>

                  </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link" onclick="getPaymentToApprove()">
                      <i class="fas fa-inbox"></i> Payment Approval
                      <span class="badge bg-warning float-right">{{count($payments)}}</span>

                    </a>
                  </li>

                <li class="nav-item">
                  <a href="#" class="nav-link" onclick="getTrushPayments()" >
                    <i class="far fa-file-alt"></i> Trash Payments
                    <span class="badge bg-warning float-right">{{count($trushSales)}}</span>

                  </a>
                </li>
              </ul>
            </div>
            <!-- /.card-body -->
          </div>


          <!-- /.card -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="card card-primary card-outline">
            <div class="card-header" style="position:-webkit-sticky; position: sticky; top: 0; !important">
              <h3 class="card-title" id="title">Sales Approval</h3>
              <div class="card-tools">
                <div class="input-group input-group-sm">
                  <input type="text" class="form-control" placeholder="Search Mail">
                  <div class="input-group-append">
                    <div class="btn btn-primary">
                      <i class="fas fa-search"></i>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.card-tools -->
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <div class="mailbox-controls" style="position:-webkit-sticky; position: sticky; top:0; !important">
                <!-- Check all button -->
                <button type="button" class="btn btn-default btn-sm checkbox-toggle"><i class="far fa-square"></i>
                </button>
                <div class="btn-group">
                  <button type="button" class="btn btn-default btn-sm">
                    <i class="far fa-trash-alt"></i>
                  </button>
                  <button type="button" class="btn btn-default btn-sm">
                    <i class="fas fa-reply"></i>
                  </button>
                  <button type="button" class="btn btn-default btn-sm">
                    <i class="fas fa-share"></i>
                  </button>
                </div>
                <!-- /.btn-group -->
                <button type="button" class="btn btn-default btn-sm">
                  <i class="fas fa-sync-alt"></i>
                </button>
                <div class="float-right">
                  1-50/200
                  <div class="btn-group">
                    <button type="button" class="btn btn-default btn-sm">
                      <i class="fas fa-chevron-left"></i>
                    </button>
                    <button type="button" class="btn btn-default btn-sm">
                      <i class="fas fa-chevron-right"></i>
                    </button>
                  </div>
                  <!-- /.btn-group -->
                </div>
                <!-- /.float-right -->
              </div>
              <div class="table-responsive mailbox-messages">
                <table class="table table-hover  table-striped" style=" overflow-y:scroll;display:block;overflow-y: hidden;">

                 {{-- Sales Approvalslist --}}

                  <tbody id="sales_approve">
                    @php
                        $no =0;
                    @endphp
                    @forelse ($sales as $sale)
                    @php
                        $no = $no + 1;
                    @endphp
                    <tr>
                        <td>
                          {{$no}}
                        </td>
                        <td class="mailbox-name"><a href="#">
                            @forelse ($customers as $customer)
                                @if ($sale->Customer_Id == $customer->id)
                                    {{str_replace(' ', '_', $customer->Full_Name)}}
                                @endif
                            @empty
                                No Customer not Found.
                            @endforelse

                        </a></td>
                        <td class="mailbox-subject"><b>
                            @forelse ($properties as $property)
                            @if ($sale->Property_Id == $property->id)
                                {{$property->Title}}-{{$property->Unit_No}}
                            @endif
                        @empty
                            No Proprty not Found.
                        @endforelse
                        </b> -
                            Price {{$sale->Price_USD}} $ , Advance {{$sale->Advance_USD}} $ ,
                            Payable in {{$sale->Number_Of_Payments}} round, Finishing {{$sale->Finishing_Percentage}} %.
                        </td>
                        <td class="mailbox-attachment">
                            @if ($sale->approver_one == 'Not Approved' && Auth::user()->role == '1')
                            <div class="btn-group">
                                <button type="button" class="btn btn-success btn-sm">Action</button>
                                <button type="button" class="btn btn-success dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                    <div class="dropdown-menu" role="menu">
                                        {{-- <a href="sales-approval-{{$sale->id}}-1" class="btn btn-success btn-xs">Approve</a> --}}
                                        <a class="dropdown-item" href="sales-approval-{{$sale->id}}-1-Approved" style="color: green" >Approve</a>
                                        <a class="dropdown-item" href="sales-approval-{{$sale->id}}-1-Rejected" style="color: rgb(255, 0, 0)" >Reject </a>
                                        {{-- <a class="dropdown-item" href="salesStatus-Terminated-{{$sale->id}}" style="color: rgb(255, 0, 0)" >Terminate</a> --}}
                                    </div>
                            </div>
                            @elseif ($sale->approver_two == 'Not Approved' && Auth::user()->role == '2')
                            <div class="btn-group">
                                <button type="button" class="btn btn-success btn-sm">Action</button>
                                <button type="button" class="btn btn-success dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                <span class="sr-only">Toggle Dropdown</span>
                                </button>
                                    <div class="dropdown-menu" role="menu">
                                        {{-- <a href="sales-approval-{{$sale->id}}-1" class="btn btn-success btn-xs">Approve</a> --}}
                                        <a class="dropdown-item" href="sales-approval-{{$sale->id}}-2-Approved" style="color: green" >Approve</a>
                                        <a class="dropdown-item" href="sales-approval-{{$sale->id}}-2-Rejected" style="color: rgb(255, 0, 0)" >Reject </a>
                                        {{-- <a class="dropdown-item" href="salesStatus-Terminated-{{$sale->id}}" style="color: rgb(255, 0, 0)" >Terminate</a> --}}
                                    </div>
                            </div>
                            @endif
                       </td>
                        <td class="mailbox-date">
                          <pre> {{$sale->created_at->diffForHumans()}} </pre>
                        </td>
                      </tr>
                    @empty
                    {{-- <tr>
                      <div class="p-3">
                        <h4>No Data To Be Approve.</h4>
                      </div>
                    </tr> --}}
                    @endforelse

                    </tbody>

                    <tbody id="trush_approve" style="display: none;">
                        @php
                        $no =0;
                        @endphp
                        @forelse ($trushSales as $sale)
                        @php
                            $no = $no + 1;
                        @endphp
                        <tr>
                            <td>
                            {{$no}}
                            </td>
                            <td class="mailbox-name">
                                <a href="#">
                                @forelse ($customers as $customer)
                                    @if ($sale->Customer_Id == $customer->id)
                                        {{str_replace(' ', '_', $customer->Full_Name)}}
                                    @endif
                                @empty
                                    No Customer not Found.
                                @endforelse

                               </a>
                            </td>
                            <td class="mailbox-subject"><b>
                                @forelse ($properties as $property)
                                    @if ($sale->Property_Id == $property->id)
                                        {{$property->Title}}-{{$property->Unit_No}}
                                    @endif
                                @empty
                                    No Proprty not Found.
                                @endforelse
                            </b> -
                                Price {{$sale->Price_USD}} $ , Advance {{$sale->Advance_USD}} $ ,
                                Payable in {{$sale->Number_Of_Payments}} round, Finishing {{$sale->Finishing_Percentage}} %.
                            </td>
                            <td class="mailbox-attachment">
                                @if (Auth::user()->role == '1')
                                <div class="btn-group">
                                    <button type="button" class="btn btn-success btn-sm">Action</button>
                                    <button type="button" class="btn btn-success dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                    <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                        <div class="dropdown-menu" role="menu">
                                            {{-- <a href="sales-approval-{{$sale->id}}-1" class="btn btn-success btn-xs">Approve</a> --}}
                                            <a class="dropdown-item" href="delete-sales-{{$sale->id}}" style="color: green" >Approve</a>
                                            <a class="dropdown-item" href="sales-suspondReject-{{$sale->id}}" onclick="return confirm('Are you sure reject this request. this file will be back to sales !!!. ');" style="color: rgb(255, 0, 0)" >Reject </a>
                                            {{-- <a class="dropdown-item" href="salesStatus-Terminated-{{$sale->id}}" style="color: rgb(255, 0, 0)" >Terminate</a> --}}
                                        </div>
                                </div>

                                @elseif (Auth::user()->role == '2')
                                <div class="btn-group">
                                    <button type="button" class="btn btn-success btn-sm">Action</button>
                                    <button type="button" class="btn btn-success dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                    <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                        <div class="dropdown-menu" role="menu">
                                            {{-- <a href="sales-approval-{{$sale->id}}-1" class="btn btn-success btn-xs">Approve</a> --}}
                                            <a class="dropdown-item" href="delete-sales-{{$sale->id}}" style="color: green" >Approve</a>
                                            <a class="dropdown-item" href="sales-suspondReject-{{$sale->id}}" onclick="return confirm('Are you sure reject this request. this file will be back to sales !!!. ');" style="color: rgb(255, 0, 0)" >Reject </a>
                                            {{-- <a class="dropdown-item" href="salesStatus-Terminated-{{$sale->id}}" style="color: rgb(255, 0, 0)" >Terminate</a> --}}
                                        </div>
                                </div>
                                Delete
                                </a>
                                @endif
                        </td>
                            <td class="mailbox-date">
                            <pre> {{$sale->updated_at->diffForHumans()}} </pre>
                            </td>
                        </tr>
                        @empty
                        {{-- <tr>
                            <div class="p-3">
                                <h4>No Trush Sales Data To Be Approve.</h4>
                            </div>
                        </tr> --}}
                        @endforelse
                    </tbody>




                    <tbody id="payment_approve" style="display: none;">
                        @php
                        $no =0;
                        @endphp
                        @forelse ($payments as $payment)
                        @php
                            $no = $no + 1;
                        @endphp
                        <tr>
                            <td>
                            {{$no}}
                            </td>
                            <td class="mailbox-name">
                                <a href="#">
                                 <pre><small>Schedule_ID : {{$payment->PaymentProcess_Id}}</small></pre>
                               </a>
                            </td>
                            <td class="mailbox-subject"><b>
                                <p> {{$payment->Amount_USD}} $</br>
                                    <small>
                                    Vat : {{$payment->VAT_USD}} $,
                                    Exchange Rate : {{$payment->Exchange_Rate}}
                                    CPO Number  : {{$payment->CPO_Number}},
                                    FS Number : {{$payment->FS_Number}},
                                    </small>
                              </p>
                            </td>
                            <td class="mailbox-attachment">
                                @if (Auth::user()->role == '1')
                                <div class="btn-group">
                                    <button type="button" class="btn btn-success btn-sm">Action</button>
                                    <button type="button" class="btn btn-success dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                    <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                        <div class="dropdown-menu" role="menu">
                                            {{-- <a href="sales-approval-{{$sale->id}}-1" class="btn btn-success btn-xs">Approve</a> --}}
                                            <a class="dropdown-item" href="approve-payment-{{$payment->id}}" style="color: green" >Approve</a>
                                            <a class="dropdown-item" href="reject-payment-{{$payment->id}}" onclick="return confirm('Are you sure reject this payment. ');" style="color: rgb(255, 0, 0)" >Reject </a>
                                            {{-- <a class="dropdown-item" href="salesStatus-Terminated-{{$sale->id}}" style="color: rgb(255, 0, 0)" >Terminate</a> --}}
                                        </div>
                                </div>

                                @elseif (Auth::user()->role == '2')
                                <div class="btn-group">
                                    <button type="button" class="btn btn-success btn-sm">Action</button>
                                    <button type="button" class="btn btn-success dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                    <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                        <div class="dropdown-menu" role="menu">
                                            {{-- <a href="sales-approval-{{$sale->id}}-1" class="btn btn-success btn-xs">Approve</a> --}}
                                            <a class="dropdown-item" href="approve-payment-{{$payment->id}}" style="color: green" >Approve</a>
                                            <a class="dropdown-item" href="reject-payment-{{$payment->id}}" onclick="return confirm('Are you sure reject this payment. ');" style="color: rgb(255, 0, 0)" >Reject </a>
                                            {{-- <a class="dropdown-item" href="salesStatus-Terminated-{{$sale->id}}" style="color: rgb(255, 0, 0)" >Terminate</a> --}}
                                        </div>
                                </div>
                                @endif
                        </td>
                            <td class="mailbox-date">
                            <pre> {{$payment->created_at->diffForHumans()}} </pre>
                            </td>
                        </tr>
                        @empty
                        {{-- <tr>
                            <div class="p-3">
                                <h4>No Trush Sales Data To Be Approve.</h4>
                            </div>
                        </tr> --}}
                        @endforelse
                    </tbody>




                    <tbody id="payment_trush_approve" style="display: none;">
                        @php
                        $no =0;
                        @endphp
                        @forelse ($trushSales as $sale)
                        @php
                            $no = $no + 1;
                        @endphp
                        <tr>
                            <td>
                            {{$no}}
                            </td>
                            <td class="mailbox-name">
                                <a href="#">
                                @forelse ($customers as $customer)
                                    @if ($sale->Customer_Id == $customer->id)
                                        {{str_replace(' ', '_', $customer->Full_Name)}}
                                    @endif
                                @empty
                                    No Customer not Found.
                                @endforelse

                               </a>
                            </td>
                            <td class="mailbox-subject"><b>
                                @forelse ($properties as $property)
                                    @if ($sale->Property_Id == $property->id)
                                        {{$property->Title}}-{{$property->Unit_No}}
                                    @endif
                                @empty
                                    No Proprty not Found.
                                @endforelse
                            </b> -
                                Price {{$sale->Price_USD}} $ , Advance {{$sale->Advance_USD}} $ ,
                                Payable in {{$sale->Number_Of_Payments}} round, Finishing {{$sale->Finishing_Percentage}} %.
                            </td>
                            <td class="mailbox-attachment">
                                @if (Auth::user()->role == '1')
                                <div class="btn-group">
                                    <button type="button" class="btn btn-success btn-sm">Action</button>
                                    <button type="button" class="btn btn-success dropdown-toggle dropdown-icon" data-toggle="dropdown">
                                    <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                        <div class="dropdown-menu" role="menu">
                                            {{-- <a href="sales-approval-{{$sale->id}}-1" class="btn btn-success btn-xs">Approve</a> --}}
                                            <a class="dropdown-item" href="delete-sales-{{$sale->id}}" style="color: green" >Approve</a>
                                            <a class="dropdown-item" href="sales-suspondReject-{{$sale->id}}" onclick="return confirm('Are you sure reject this request. this file will be back to sales !!!. ');" style="color: rgb(255, 0, 0)" >Reject </a>
                                            {{-- <a class="dropdown-item" href="salesStatus-Terminated-{{$sale->id}}" style="color: rgb(255, 0, 0)" >Terminate</a> --}}
                                        </div>
                                </div>
                                {{-- <a type="button" class="btn btn-danger btn-sm" href="delete-sales-{{$sale->id}}" onclick="return confirm('Are you sure you delete this file. this file will be permanetly deleted ther is no way to return back !!!. ');">
                                    Delete
                                </a> --}}
                                @elseif (Auth::user()->role == '2')
                                <a type="button" class="btn btn-danger btn-sm" href="delete-sales-{{$sale->id}}" onclick="return confirm('Are you sure you delete this file. this file will be permanetly deleted ther is no way to return back !!!. ');">
                                Delete
                                </a>
                                @endif
                        </td>
                            <td class="mailbox-date">
                            <pre> {{$sale->updated_at->diffForHumans()}} </pre>
                            </td>
                        </tr>
                        @empty
                        {{-- <tr>
                            <div class="p-3">
                                <h4>No Trush Sales Data To Be Approve.</h4>
                            </div>
                        </tr> --}}
                        @endforelse
                    </tbody>
                  </table>
                </table>
                <!-- /.table -->
              </div>

              <!-- /.mail-box-messages -->
            </div>
            <!-- /.card-body -->

          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
    <!-- /.content -->
    </section>
    <!-- jQuery -->
    <script src="../../plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../../dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../../dist/js/demo.js"></script>
  <!-- /.content-wrapper -->
        <script>
            $(function () {
              //Enable check and uncheck all functionality
              $('.checkbox-toggle').click(function () {
                var clicks = $(this).data('clicks')
                if (clicks) {
                  //Uncheck all checkboxes
                  $('.mailbox-messages input[type=\'checkbox\']').prop('checked', false)
                  $('.checkbox-toggle .far.fa-check-square').removeClass('fa-check-square').addClass('fa-square')
                } else {
                  //Check all checkboxes
                  $('.mailbox-messages input[type=\'checkbox\']').prop('checked', true)
                  $('.checkbox-toggle .far.fa-square').removeClass('fa-square').addClass('fa-check-square')
                }
                $(this).data('clicks', !clicks)
              })

              //Handle starring for font awesome
              $('.mailbox-star').click(function (e) {
                e.preventDefault()
                //detect type
                var $this = $(this).find('a > i')
                var fa    = $this.hasClass('fa')

                //Switch states
                if (fa) {
                  $this.toggleClass('fa-star')
                  $this.toggleClass('fa-star-o')
                }
              })
            })
        </script>

<script>
   function getSalesToApprove(){
        document.getElementById('title').innerHTML = 'Sales Approval';
        document.getElementById('sales_approve').style.display = 'block';
        document.getElementById('trush_approve').style.display = 'none';
        document.getElementById('payment_trush_approve').style.display = 'none';
        document.getElementById('payment_approve').style.display = 'none';


    }
   function getTrushSales(){
        document.getElementById('title').innerHTML = 'Trush Sales Approval';
        document.getElementById('sales_approve').style.display = 'none';
        document.getElementById('trush_approve').style.display = 'block';
        document.getElementById('payment_trush_approve').style.display = 'none';
        document.getElementById('payment_approve').style.display = 'none';


    }

    function getPaymentToApprove(){
        document.getElementById('title').innerHTML = 'Payment Approval';
        document.getElementById('sales_approve').style.display = 'none';
        document.getElementById('payment_approve').style.display = 'block';
        document.getElementById('payment_trush_approve').style.display = 'none';

    }
    function getTrushPayments(){
      document.getElementById('title').innerHTML = 'Payment Trush Approval';
        document.getElementById('sales_approve').style.display = 'none';
        document.getElementById('trush_approve').style.display = 'none';
        document.getElementById('payment_trush_approve').style.display = 'block';
        document.getElementById('payment_approve').style.display = 'none';

    }


    function approveOne(id,approval){
        $.ajax({
        type: "POST",
        url: "{{url('sales-approval')}}",
        dataType:'json',
        data:{
               '_token':'{{ csrf_token() }}',
                id:id,
                approval:approval,
            },
        success: function (result) {
            // console.log(result);
        },

        });
    }
  </script>

<script src="../../plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../../plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
{{-- <script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script> --}}

@endsection
