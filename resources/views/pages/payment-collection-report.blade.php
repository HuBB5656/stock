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
    <button class="btn btn-dark border-t-emerald-50 float-start" style="  position:-webkit-sticky; position: sticky; top: 0; background-color:rgb(207, 75, 13)" onclick="Print();">Print</button>
<div class="row">
    <div class="col-lg-2">

    </div>
    <div class="col-8">
        <div class="container text-center">
        <div class="row">
            <div class="col-lg-4">
                <img src="images/logoNewHope.png" alt="">
            </div>
            <div class="col-lg-8">
                <h1 style="font-family: Arial Black" style="letter-spacing: 5px; word-spacing: 10px; line-height: 15px;">N&nbsp;E&nbsp;W &nbsp; H&nbsp;O&nbsp;P&nbsp;E</h1>
                <h3 style="font-family: SimSun-ExtB">Sales Report</h3>
                <hr style=" border: 4px solid rgb(207, 75, 13);background-color:rgb(207, 75, 13)">

            </div>

        </div>
        </div>
        <hr>
        <div class="row">

            <b> <p class="text">NEW HOPE SALES COLLECTION (<i id="date_interval"></i> - <i id="date_interval2"></i> )</p></b>
          <div class="col-12">
            <form  action="/get-sold" method="POST">
                @csrf
                <div class="row" id='soled-form'>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label >From</label>
                            <input type="date" name="soled_from" class="form-control" id="soled_from" onchange="getSoledSummery()">
                            {{-- <input type="number" step="any" onchange="exchangeRatePP({{$sale->id}})"  id="Exchange_Rate_pp_{{$sale->id}}" name="Exchange_Rate" class="form-control"  placeholder="Exchange Rate" required> --}}
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label >To </label>
                            <input type="date" name="soled_to" class="form-control xs" onchange="getSoledSummery()" id="soled_to">
                            {{-- <input type="number" step="any" id="Due_Amount_ETB_pp_{{$sale->id}}" readonly name="Due_Amount_ETB" class="form-control"  placeholder="Due_Amount ETB" required> --}}
                        </div>
                    </div>
                </div>
             </form>
          </div>
          <div class="col-12">
            <table class="table" id="soled-result" style="display: none;  width: 100%;">
                <thead>
                <tr>
                    <th >#</th>
                    <th>Period</th>
                    <th>Amount(USD)</th>
                    <th>Amount(ETB)</th>
                </tr>
                </thead>
                <tbody  id="datas">


                </tbody>
            </table>
          </div>
        </div>
    </div>
    <div class="col-lg-3">

    </div>
</div>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>

<script type="text/javascript">
    function Print() {
        window.print();
    }
</script>
<script type="text/javascript">
    function Print() {
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
                    $('#datas').html('');
                    var  no = 0;
                    $.each(result.data, function(index,value){
                        no = no + 1;
                        rowData = `
                        <tr>
                            <th scope="row">${no}</th>
                            <td>${value.Month}</td>
                            <td>$ ${value.USD.toLocaleString('en-US')} </td>
                            <td>${value.ETB.toLocaleString('en-US')} <small>Birr</small> </td>
                        </tr>
                        `;
                        $('#datas').append(rowData);
                    });

                    var dt = document.getElementById('soled_from').value;
                    var dt2 = document.getElementById('soled_to').value;
                    document.getElementById('date_interval').innerHTML = dt;
                    document.getElementById('date_interval2').innerHTML = dt2;
                },
            });
        }else{
            document.getElementById('soled_from').style.borderColor = "red";
            document.getElementById('soled_to').style.borderColor = "red";
        }
    }
</script>
<script src="plugins/jquery/jquery.min.js"></script>

</html>
