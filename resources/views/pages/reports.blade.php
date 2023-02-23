<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>New Hopes Sales Reports</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
</head>

<body style="Padding-top:50px;" class=".d-print-none" id="printableArea">
    <button class="btn btn-dark border-t-emerald-50 float-start" style="  position:-webkit-sticky; position: sticky; top: 0; background-color:rgb(207, 75, 13)" onclick="Print();" id="button_print">Print</button>
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
                <h3 style="font-family: SimSun-ExtB">Sales Report</h3>
                <hr style=" border: 4px solid rgb(207, 75, 13);background-color:rgb(207, 75, 13)">

            </div>

        </div>
        </div>

        <div class="container text-center" style="font-family: Franklin Gothic Medium Arial" >
            <div class="row">
            <div class="col-sm-6 p-2 shadow  mb-5 bg-body-tertiary rounded">
               <div class="p-5" style="background-color: rgb(230, 230, 230);text-align:left;">
                <H2 style="font-family: Arial Black;color: rgb(207, 75, 13);">New Sales</H2>
                <h4>  TOTAL UNIT</h2>
                <p> <b> {{$no_of_appartama}}/{{count($properties)}} APARTMENT</b></p>

                <p style="color: rgb(207, 75, 13);"><b>{{$two_bed_room}}- 2 BED ROOM </b></p>
                <p style="color: rgb(207, 75, 13);"><b>{{$three_bed_room}}- 3 BED ROO</b></p>

                <hr>
                     <form  action="/get-sold" method="POST">
                        @csrf
                        <div class="row" id='soled-form'>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label >From</label>
                                    <input type="date" name="soled_from" class="form-control" id="soled_from" onchange="getSoledSummery()">
                                    {{-- <input type="number" step="any" onchange="exchangeRatePP({{$sale->id}})"  id="Exchange_Rate_pp_{{$sale->id}}" name="Exchange_Rate" class="form-control"  placeholder="Exchange Rate" required> --}}
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label >To </label>
                                    <input type="date" name="soled_to" class="form-control xs" onchange="getSoledSummery()" id="soled_to">
                                    {{-- <input type="number" step="any" id="Due_Amount_ETB_pp_{{$sale->id}}" readonly name="Due_Amount_ETB" class="form-control"  placeholder="Due_Amount ETB" required> --}}
                                </div>
                            </div>
                        </div>
                     </form>
                <div id="soled-result" style="display: none;">
                <label >SOLD APARTMENT ( <b><i id="total_sold_count"></i></b> )</label><br>
                 <small><i id="from_date"></i> &nbsp; - &nbsp;<i id="to_date"></i> </small>
                    <div id='db_data'>

                    </div>
                </div>
                <hr>

                Duration
               <b id="duration"></b> Months <br>
                <b id="two_bed"></b> - Two bed room <br>
                <b id="three_bed"></b> - Three bed room <br>
              </div>
            </div>
            <div class="col-sm-6 p-2 shadow  mb-5 bg-body-tertiary rounded">
                <div class="p-5" style="background-color: rgb(230, 230, 230);text-align:left;">
                    <p style="font-family: SimSun-ExtB">REMAINING UNSOLD  UNIT</p>
                    <p><b>{{$no_of_appartama - $soled_appartama}}/{{$no_of_appartama}} ( Appartama) </b></p>
                    <p style="color: rgb(207, 75, 13);">Total amount of sold unit</p>
                    <p style="color: rgb(207, 75, 13);">({{$soled_appartama}} Apartment) </p>
                    <p> <b>ETB {{number_format($soled_appartama_price_etb)}}</b></p>
                    <p  style="color: rgb(207, 75, 13);">Advance payment</p>
                    <p  style="color: rgb(207, 75, 13);">collected 20% </p>
                    <p> <b>ETB {{number_format($soled_appartama_advavce_etb)}} </b></p>
                    <hr>
                    <p>Expected 2nd payment collection after
                       <b>42</b>  days for <b>{{$soled_appartama}}</b> Apartment <br>
                       <b>12th floor ETB {{number_format($expected_sales_payable_etb)}}</b>
                    </p>
                    <p>Expected 2nd payment collection after
                        <b>42</b>  days for <b>34</b> Apartment <br>
                        <b>12th floor ETB 64,633,846.32</b>
                     </p>
                </div>
            </div>
            </div>
        </div>
        <hr>
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
