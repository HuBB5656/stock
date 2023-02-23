@extends('inc.frame')


@section('content')

<section class="content">
    <div class="container-fluid">
        <div class="row">
           <div class="col-md-12">
              <div class="card card-primary card-outline">
                <div class="card-header">
                  <h3 class="card-title">
                    <div class="p-2 btn btn-primary" style="float: left">Total Number Of Re-Sales :<b> {{$resale_counter }}</b></div>
                  </h3>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-body">
        <div class="p-2" style="float: right"> {{ $resales->links() }}</div>
      <table id="example1" class="table table-bordered table-striped"  style=" overflow-y:scroll;display:block;overflow-y: hidden;">
        <thead>
        <tr>
          <th>No</th>
          <th>reSaleDate</th>
          <th>PropertyName</th>
          <th>reSalerName</th>
          <th>NewCustomer</th>
          <th>Amount_USD</th>
          <th>ExRate</th>
          <th>Price_Amount_ETB</th>
          <th>SummeryDoc</th>

          <th>_________</th>
        </tr>
        </thead>

        <tbody>
            @if(count($resales) > 0)
            @php
                $no = 0;
            @endphp
            @foreach($resales as $resale)
            @php
                $no = $no + 1;
            @endphp
             <tr>
                <td>{{$no}}</td>
                <td>{{$resale->created_at->toDateString()}}</td>
                <td>{{$resale->Property}}</td>
                <td>{{$resale->Former_Customer}}</td>
                <td>
                    @forelse ($customers as $cust )
                        @if($cust->id == $resale->New_Customer_Id)
                             {{$cust->Full_Name}}
                        @endif
                    @empty

                    @endforelse
                </td>
                <td>$ {{number_format($resale->Resale_Price_USD,2)}}</td>
                <td>{{$resale->Exchange_Rate}}</td>
                <td>{{ number_format($resale->Resale_Price_ETB,2)}} <small>birr</small></td>
                <td>
                    <a type="button" class="btn btn-secondary btn-sm" target="_blanck" href="getResaleDetail-{{$resale->id}}" >
                        <i class="fas fa-book"></i> Summery</a>
                </td>
                <td>
                  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-lg-{{$resale->id}}">
                  <i class="fas fa-edit"></i> </button>
                  <a type="button" class="btn btn-danger btn-sm" href="#" onclick="return confirm('Are you sure you ? delete this resale !');">
                    <i class="fas fa-trash"></i></a>
                </td>
            </tr>

            @endforeach
            @else
             <h2>No resale Found !</h2>
            @endif
        </tbody>
      </table>

      <div class="p-2" style="float: right"> {{ $resales->links() }}</div>

    </div>
    <!-- /.card-body -->
  </div>

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

