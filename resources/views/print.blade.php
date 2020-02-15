<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Print</title>
  <style>
    .print {
      font-family: sans-serif
      width: 210mm;
      height: 297mm;
    }

    .center {
      display: table;
      margin: 0 auto;
    }

    .text-center {
      text-align: center;
    }

    .hidden {
      display: none
    }
  </style>
</head>

<body>
  <div class="hidden">
    <div class="print">
      <div class="center text-center">
        <h3>KPP Pratama Biak</h3>
        <h4>Jl. Adibai No. 1 Sumberkar</h4>
        <p>Nomor Antrian</p>
        <h1 id="antrian">A001</h1>
        <p><span id="hari">Senin</span>, <span id="tanggal">15 Februari 2020</span></p>
        <p id="jam">15:00:58</p>
        <p><b>Lunasi Pajaknya Awasi Penggunaannya</b></p>
      </div>
    </div>
  </div>
  <script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
  <script src="{{asset('js/popper.min.js')}}"></script>
  <script src="{{asset('js/bootstrap.min.js')}}"></script>
  <script src="{{asset('js/printThis.js')}}"></script>
  <script>
    $(".print").printThis({
      importStyle: true
    });
  </script>
</body>

</html>
