@extends('inc.frame')


@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="row">
           <div class="col-md-12">
              <div class="card card-primary card-outline">
                <div class="card-header">
                  <h3 class="card-title">
                    <i class="fas fa-edit"></i>
                     Sales Details
                  </h3>
                  <div style="float:right">
                    Filter by Sales Date &nbsp;&nbsp;&nbsp;
                      From &nbsp; <input type="date" name="from" id="from" onchange="filterByDate()">&nbsp;&nbsp;
                      To&nbsp; <input type="date" name="to" id="to" onchange="filterByDate()">
                  </div>
                </div>
              </div>
            </div>
        </div>
    </div>
  </section>

  <div class="card">
    <div class="card-body">
        <div class="p-2" style="float: right"> {{ $sales->links() }}</div>
      <table id="example1" class="table table-bordered table-striped"  style=" overflow-y:scroll;display:block;overflow-y: hidden;">
        <thead>
        <tr>
          <th>No</th>
          <th>Block_Code</th>
          <th>Floor_No</th>
          <th>Unit_Number</th>
          <th>Bedrooms</th>
          <th>Sales_Date </th>
          <th>Customer_Name</th>
          <th>Amount_USD</th>
          <th>Price_ETB</th>
          <th>Collected_USD</th>
          <th>Collected_ETB</th>
          <th>Unpaid_USD</th>
          <th>Unpaid_ETB</th>
        </tr>
        </thead>

        <tbody id="fillter">
            @if(count($sales) > 0)
            @php
                $no = 0;
            @endphp
            @foreach($sales as $sale)
            @php
                $no = $no + 1;
            @endphp
             <tr>
                <td>{{$no}}</td>
                    @forelse ($property as $prp)
                        @if($prp->id == $sale->Property_Id)
                            <td>{{$prp->Title}}</td>
                            <td>{{$prp->Floor}}</td>
                            <td>{{$prp->Unit_No}}</td>
                            <td>{{$prp->Bedrooms}}</td>
                        @endif
                    @empty
                    @endforelse
                  <td>{{$sale->Date}}</td>
                    @forelse($customers as $cust)
                            @if($cust->id == $sale->Customer_Id)
                                <td>{{$cust->Full_Name}}</td>
                            @endif
                        @empty
                    @endforelse
                    @forelse ($customers as $cust )
                        @if($cust->id == $sale->New_Customer_Id)
                           <td>  {{$cust->Full_Name}}</td>
                        @endif
                    @empty
                    @endforelse
                <td>{{number_format($sale->Price_USD,2)}}</td>
                <td>{{number_format($sale->Price_ETB,2)}}</td>
                @for ($i=0; $i< sizeof($Collected); $i++)
                    @if ($Collected[$i]['ID'] == $sale->id)
                        <td>{{number_format($Collected[$i]['Collected_USD'],2)}}</td>
                        <td>{{number_format($Collected[$i]['Collected_ETB'],2)}}</td>
                    @endif
                @endfor

                @for ($i=0; $i< sizeof($unpaid); $i++)
                    @if ($unpaid[$i]['ID'] == $sale->id)
                        <td>{{number_format($unpaid[$i]['totatUnpaidUSD'],2)}}</td>
                        <td>{{number_format($unpaid[$i]['totatUnpaidETB'],2)}}</td>
                    @endif
                @endfor
            </tr>


            <script>
                function filterByDate(){
                    var to = document.getElementById('to').value;
                    var from = document.getElementById('from').value;
                $.ajax({
                    type: "POST",
                    url: "{{url('salesFillterByDate')}}",
                    dataType:'json',
                    data:{
                        '_token':'{{ csrf_token() }}',
                            from:from,
                            to:to,
                        },
                    success: function (result) {
                        console.log(result);
                        var rowData = '';
                                $('#fillter').html('');
                                var number=0;
                                $.each(result, function(index,value){
                                    number = number + 1;
                                    rowData = `
                                    <tr>
                                        <td>${number}</td>
                                        <td>${value.block}</td>
                                        <td>${value.floor}</td>
                                        <td>${value.unit_no}</td>
                                        <td>${value.bedrooms}</td>
                                        <td>${value.sales_date}</td>
                                        <td>${value.customer_name}</td>
                                        <td>${value.amount_usd}</td>
                                        <td>${value.amount_etb}</td>
                                        <td>${value.collectd_usd}</td>
                                        <td>${value.collectd_etb}</td>
                                        <td>${value.unpaid_usd}</td>
                                        <td>${value.unpaid_etb}</td>

                                    </tr>



                                    `;
                                $('#fillter').append(rowData);
                                });
                    },

                    });
                }
            </script>
            @endforeach
            @else
             <h2>No sale Found !</h2>
            @endif
        </tbody>
      </table>

  <div class="p-2" style="float: right"> {{ $sales->links() }}</div>

    </div>
    <!-- /.card-body -->
  </div>

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

