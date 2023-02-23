<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        @forelse ($customers as $cust)
            @if($sales->Customer_Id == $cust->id)
            {{$cust->Full_Name}}
            @endif
        @empty
        @endforelse
    </title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

<body style="Padding-top:30px;" class=".d-print-none" id="printableArea">
    {{-- <button class="btn btn-dark border-t-emerald-50 float-start" style="  position:-webkit-sticky; position: sticky; top: 0; background-color:rgb(207, 75, 13)" onclick="Print();" id="button_print">Print</button> --}}
<div class="row">
    <div class="col-lg-2">

    </div>
    <div class="col-12">
        <div class="container text-center">
            <div class="row">
                <div class="col-sm-4">
                    <img src="images/logoNewHope.png" alt="">
                </div>
                <div class="col-sm-8">
                    <h1 style="font-family: Arial Black" style="letter-spacing: 5px; word-spacing: 10px; line-height: 15px;">N&nbsp;E&nbsp;W &nbsp; H&nbsp;O&nbsp;P&nbsp;E</h1>
                    <h3 style="font-family: SimSun-ExtB">
                    @forelse ($customers as $cust)
                        @if($sales->Customer_Id == $cust->id)
                         <b>{{$cust->Full_Name}}</b> <small>Summery Report</small>
                        @endif
                    @empty
                    @endforelse
                    </h3>
                    <hr style=" border: 4px solid rgb(207, 75, 13);background-color:rgb(207, 75, 13)">

                </div>
            </div>

           <div class="container text-center" style="font-family: Franklin Gothic Medium Arial" >
            <div class="row">
              <div class="col-sm-6 p-2 shadow  bg-body-tertiary rounded">
                <div class="p-3" style="background-color: rgb(230, 230, 230);text-align:left;">
                    <H3 style="font-family: Arial Black;color: rgb(207, 75, 13);">Property Detail</H3>
                </div>

                <table class="table align-baseline">
                    <tbody>
                        @forelse ($property as $prt)
                           @if($prt->id == $sales->Property_Id)
                           <tr>
                            <th scope="row ">Block</th>
                            <td>{{$prt->Title}}</td>
                          </tr>
                          <tr>
                            <th scope="row">Floor Number</th>
                            <td>{{$prt->Floor}}</td>
                          </tr>
                          <tr>
                            <th scope="row">Unit Number</th>
                            <td>{{$prt->Unit_No}}</td>
                          </tr>
                          <tr>
                            <th scope="row">Bedrooms</th>
                            <td>{{$prt->Bedrooms}}</td>
                          </tr>

                           @endif
                        @empty

                        @endforelse

                        <tr>
                            <th scope="row">Sales Date</th>
                            <td colspan="2">{{$sales->Date}}</td>
                          </tr>
                          <tr>
                            <th scope="row"> Price (USD)</th>
                            <td colspan="2">{{number_format($sales->Price_USD)}} <small>USD</small></td>
                          </tr> <tr>
                            <th scope="row"> Price (ETB)</th>
                            <td colspan="2">{{number_format($sales->Price_ETB)}} <small>Birr</small></td>
                          </tr>


                    </tbody>
                  </table>
              </div>
                <div class="col-sm-6 p-2 shadow bg-body-tertiary rounded">
                    <div class="p-3" style="background-color: rgb(230, 230, 230);text-align:left;">
                       <H3 style="font-family: Arial Black;color: rgb(207, 75, 13);">Payments Summery</H3>
                    </div>
                    <table class="table align-baseline">
                        <tbody>
                            @php
                                $totalDueAmountEtb = 0;
                                $totalPaidAmountUSD = 0;
                            @endphp
                        @forelse ($paymentSchedules as $paymentSchedule)
                            @if($paymentSchedule->Sales_Id == $sales->id && $paymentSchedule->Status == 'Paid')
                                @forelse ($payments as $payment)
                                    @if ($payment->PaymentProcess_Id == $paymentSchedule->id)
                                        @php
                                            $totalDueAmountEtb = $totalDueAmountEtb + $paymentSchedule->Due_Amount_USD;
                                            $totalPaidAmountUSD = $totalPaidAmountUSD + $payment->Amount_USD;
                                        @endphp
                                    @endif
                                @empty
                                @endforelse
                            @endif
                        @empty
                        @endforelse
                        <tr>
                            <th scope="row ">Advance Amount (USD)</th>
                            <td>{{number_format($sales->Advance_USD)}} <small>USD</small></td>
                        </tr>
                        <tr>
                            <th scope="row">Total Due Amount (USD)</th>
                            <td>{{number_format($sales->Price_USD)}} <small>USD</small></td>
                        </tr>
                        <tr>
                            <th scope="row">Total Paid Amount (USD)</th>
                            <td>{{number_format($totalPaidAmountUSD)}} <small>USD</small></td>
                        </tr>
                        <tr>
                            <th scope="row">Remaining Balance (USD)</th>
                            <td>{{number_format($sales->Price_USD - $totalPaidAmountUSD)}} <small>USD</small></td>
                        </tr>

                        </tbody>
                    </table>
                     Remaining Balance With Current Rate
                    <hr>
                    <table class="table align-baseline">
                        <tbody>
                        {{-- <tr>
                            <th scope="row">Total Due Amount (ETB)</th>
                            <td>{{number_format(($sales->Price_USD - $totalPaidAmountUSD) * $rate->rate)}} <small>Birr</small></td>
                        </tr> --}}
                        <tr>
                            <th scope="row">Remaining Balance (ETB)</th>
                            <td>{{number_format(($sales->Price_USD - $totalPaidAmountUSD) * $rate->rate)}} <small>Birr</small></td>
                        </tr>

                        </tbody>
                    </table>

               </div>
            </div>
            <div class="row">
                <div class="col-sm-12 p-2 shadow  mt-2 bg-body-tertiary rounded">
                    <div class="p-3" style="background-color: rgb(230, 230, 230);text-align:left;">
                       <H3 style="font-family: Arial Black;color: rgb(207, 75, 13);">Payment Detail</H3>
                    </div>
                    <table class="table" style=" overflow-y:scroll;display:block;overflow-y: hidden;">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="row ">FSNumber</th>
                            <th scope="row">CPONumber</th>
                            <th scope="row">PaymentDate</th>
                            <th scope="row">PaymentType</th>
                            <th scope="row">ConStage</th>
                            <th scope="row">PaidAmount(USD)</th>
                            <th scope="row">Vat(USD)</th>
                            <th scope="row">ExchangeRate</th>
                            <th scope="row">PaidAmount(ETB)</th>
                            <th scope="row">Vat(ETB)</th>
                            <th scope="row">TotalPaid(ETB)</th>
                          </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 0;
                            @endphp
                            @forelse ($paymentSchedules as $paymentSchedule)
                                @php
                                 $totalAmountEtb = 0;
                                @endphp
                                @if($paymentSchedule->Sales_Id == $sales->id && $paymentSchedule->Status == 'Paid')
                                    @forelse ($payments as $payment)
                                    @if ($payment->PaymentProcess_Id == $paymentSchedule->id)
                                    @php
                                        $no = $no + 1;
                                        $totalAmountEtb = $totalAmountEtb + $payment->Amount_ETB;
                                    @endphp
                                    <tr>
                                        <td>{{$no}}</td>
                                        <td>{{$payment->FS_Number}}</td>
                                        <td>{{$payment->CPO_Number}}</td>
                                        <td>{{$payment->created_at->toDateString()}}</td>
                                        <td>{{$payment->Payment_Type}}</td>
                                        <td>{{$paymentSchedule->Construction_Stage}}</td>
                                        <td>{{$payment->Amount_USD}}</td>
                                        <td>{{$payment->VAT_USD}}</td>
                                        <td>{{$payment->Exchange_Rate}}</td>
                                        <td>{{$payment->Amount_ETB}}</td>
                                        <td>{{$payment->VAT_ETB}}</td>
                                        <td>{{$payment->VAT_ETB + $payment->Amount_ETB}} </td>
                                      </tr>
                                    @endif
                                    @empty
                                    @endforelse
                                @endif
                            @empty
                            @endforelse
                        </tbody>
                      </table>
                </div>
            </div>
          </div>
        <hr>
       </div>
    </div>
    <div class="col-lg-2">

    </div>
</div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
<script src="plugins/jquery/jquery.min.js"></script>
<script type="text/javascript">
    // function Print() {
    //     window.print();
    // }
</script>
<script type="text/javascript">
    function Print() {
        document.getElementById('button_print').style.display = 'none';
        document.getElementById('soled-form').style.display = 'none';
        var printContents = document.getElementById("printableArea").innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
    }
</script>
<script >
    function getSoledSummery(){
        if(document.getElementById('soled_from').value != '' && document.getElementById('soled_to').value != ''){
            document.getElementById('soled-result').style.display = 'block';
            document.getElementById('soled-form').style.display = 'none';

            $.ajax({
                type: "POST",
                url: "{{url('getSoldPrice')}}",
                dataType:'json',
                data:{
                    '_token':'{{ csrf_token() }}',
                        from:document.getElementById('soled_from').value,
                        to:document.getElementById('soled_to').value,
                    },
                success: function (result) {
                    // console.log(result);
                    $('#db_data').html('');
                    $.each(result.data, function(index,value){
                        rowData = `
                            <p>${value.Month} - ${value.count}</p>
                        `;
                        $('#db_data').append(rowData);
                    });
                    // document.getElementById('priceUSD').value = result.Price_In_USD;
                    document.getElementById('from_date').innerHTML = document.getElementById('soled_from').value;
                    document.getElementById('to_date').innerHTML = document.getElementById('soled_to').value;
                    document.getElementById('total_sold_count').innerHTML = result.totalcount;
                    document.getElementById('duration').innerHTML = result.duration.toFixed(0);
                    document.getElementById('two_bed').innerHTML = result.two_bed_room;
                    document.getElementById('three_bed').innerHTML = result.three_bed_room;
                },
            });
        }else{
            document.getElementById('soled_from').style.borderColor = "red";
            document.getElementById('soled_to').style.borderColor = "red";
        }
    }
</script>

</html>

