<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.4.1/css/bootstrap.min.css">

</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-12">
        <input type="hidden" id="data" value="{{$data}}">
        {{$data}}
        <button type="button" class="btn btn-primary" onclick="cekSemuaPrinter()">Cek semua list printer</button><br>
        <input type="text" id="nama_printer" placeholder="Nama printer"><br>
        <button type="button" class="btn btn-primary" onclick="cekPrinter()">Cek printer</button><br>
        <button type="button" class="btn btn-primary" onclick="print()">Print</button>
      </div>
    </div>
  </div>
  <script src="{{asset('js/jquery-3.3.1.min.js')}}"></script>
  <script src="{{asset('js/popper.min.js')}}"></script>
  <script src="{{asset('js/bootstrap.min.js')}}"></script>
  <script>
    function cekSemuaPrinter(){
      $.ajax({
        url:'http://localhost:9100/htbin/kp.py',
        success:function(list_printers){
          let printer = jQuery.parseJSON(list_printers)
          console.log(printer)
        }
      });
    }

    function cekPrinter(){
      $.ajax({url:'http://localhost:9100/htbin/kp.py',
        data:{
          p:$("#nama_printer").val()
        },
        success:function(status){
          console.log(status)
        }
      });
    }

    function print(){
      $.ajax({url:'http://localhost:9100/htbin/kp.py',
        data:{
          p:$("#nama_printer").val(),
          data:$("#data").val()
        },
        success:function(bytes){
          console.log(bytes)
        }
      });
    }
  </script>
</body>

</html>
