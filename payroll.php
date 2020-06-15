
<?php 
    // session_start();
    // include_once("../../module/database.php");
    
    include("module/modul.php");
    if(empty($_SESSION["data_absensi"])){
      echo"<script>";
      echo"alert('Silahkan ambil data terlebih dahulu');";
      echo"setTimeout(function(){";
      echo"window.location.href='form.php'";
      echo"},1);";
      echo "</script>";
      // header("location:form.php");
    }
?>


<!DOCTYPE html>  
<html lang="en">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">
<!-- <link rel="icon" type="image/png" sizes="16x16" href="../plugins/images/favicon.png"> -->
<title>Pabrik | Payroll</title>
<script src="assets/js/jquery-3.3.1.min.js">

  </script>

<!-- Bootstrap Core CSS -->
 <!-- <link href="assets/md5bootstrap/css/bootstrap.min.css" rel="stylesheet"> -->
 <!-- <link href="assets/md5bootstrap/css/bootstrap.css" rel="stylesheet"> -->
 <!-- <link href="assets/md5bootstrap/css/md.lite.min.css" rel="stylesheet"> -->
 <!-- <link href="assets/md5bootstrap/css/style.css" rel="stylesheet">
 <link href="assets/md5bootstrap/css/mdb.min.css" rel="stylesheet">
 <link href="assets/md5bootstrap/js/bootstrap.js" rel="stylesheet">
 <link href="assets/md5bootstrap/js/jquery.min.js" rel="stylesheet">
 <link href="assets/md5bootstrap/js/mdb.min.js" rel="stylesheet"> -->
<!-- < <link href="assets/css/animate.css" rel="stylesheet"> --> 
<!-- Custom CSS -->
 <!-- <link href="assets/css/style.css" rel="stylesheet"> -->  
<!-- color CSS -->

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
  <style>
    /* .md-outline.select-wrapper+label {
    top: .5em !important;
    z-index: 2 !important;
    } */
  </style>

<script>
  $(document).ready(function() {
  // $('.mdb-select').materialSelect();
  // $('.select-wrapper.md-form.md-outline input.select-dropdown').bind('focus blur', function () {
  // $(this).closest('.select-outline').find('label').toggleClass('active');
  // $(this).closest('.select-outline').find('.caret').toggleClass('active');
  // });
  });
  function insertPay(val){
      // alert("success");
        var elemenId1 = document.getElementById("namaPegawai1");
        var namaPegawai1 = elemenId1.options[elemenId1.selectedIndex].text;
        var elemenId2 = document.getElementById("namaPegawai2");
        var namaPegawai2 = elemenId2.options[elemenId2.selectedIndex].text;
        var elemenId3 = document.getElementById("namaPegawai3");
        var namaPegawai3 = elemenId3.options[elemenId3.selectedIndex].text;
        var elemenId4 = document.getElementById("namaPegawai4");
        var namaPegawai4 = elemenId4.options[elemenId4.selectedIndex].text;
        var elemenId5 = document.getElementById("namaPegawai5");
        var namaPegawai5 = elemenId5.options[elemenId5.selectedIndex].text;
        var elemenId6 = document.getElementById("namaPegawai6");
        var namaPegawai6 = elemenId6.options[elemenId6.selectedIndex].text;
        var elemenId7 = document.getElementById("namaPegawai7");
        var namaPegawai7 = elemenId7.options[elemenId7.selectedIndex].text;
        var elemenId8 = document.getElementById("namaPegawai8");
        var namaPegawai8 = elemenId8.options[elemenId8.selectedIndex].text;
        var elemenId9 = document.getElementById("namaPegawai9");
        var namaPegawai9 = elemenId9.options[elemenId9.selectedIndex].text;
        var elemenId10 = document.getElementById("namaPegawai10");
        var namaPegawai10 = elemenId10.options[elemenId10.selectedIndex].text;
        var elemenId11 = document.getElementById("jobinti");
        var namaJobinti = elemenId11.options[elemenId11.selectedIndex].text;
        var elemenId12 = document.getElementById("sub_category");
        var namaJobdukung = elemenId12.options[elemenId12.selectedIndex].text;
        var elemenId13 = document.getElementById("output_harian").value;
        var elemenId14 = document.getElementById("hiddenGaji").value;

        console.log("PEgawai");
        console.log(namaPegawai1);
        $.ajax({
          type: 'POST',
          url: 'ajaxJob.php',
          data:{
            inputPegawai:namaPegawai1,
            inputPegawai2:namaPegawai2,
            inputPegawai3:namaPegawai3,
            inputPegawai4:namaPegawai4,
            inputPegawai5:namaPegawai5,
            inputPegawai6:namaPegawai6,
            inputPegawai7:namaPegawai7,
            inputPegawai8:namaPegawai8,
            inputPegawai9:namaPegawai9,
            inputPegawai10:namaPegawai10,
            inputJobinti:namaJobinti,
            inputJobdukung:namaJobdukung,
            inputGaji:elemenId14,
            inputOutput:elemenId13
          },
          success:function(data){
            // document.getElementById("sub_category").innerHTML=response;
              // var dataParsed = JSON.parse(data);
              // console.log(dataParsed);
              alert("Data Success");
              // document.getElementById("hasil").innerHTML=data;
          }
        })
      };

      function changeName1(val){
        var elemenId1   = document.getElementById("namaPegawai1")
        // var kodeJobinti = elemenId1.options[elemenId1.selectedIndex].text;
        var namapegawai=elemenId1.value;
        console.log("test nama select");
        // console.log(elemenId1);
        $.ajax({
          type: 'POST',
          url: 'ajaxJob.php',
          data:{
            namaPilih:namapegawai
          },
          success:function(response){
            document.getElementById("jamKerjaPegawai1").innerHTML=response;
          }
        })
        
      };

      function changeName2(val){
        var elemenId1 = document.getElementById("namaPegawai2")
        // var kodeJobinti = elemenId1.options[elemenId1.selectedIndex].text;
        var namapegawai=elemenId1.value;
        console.log("test nama select");
        // console.log(elemenId1);
        $.ajax({
          type: 'POST',
          url: 'ajaxJob.php',
          data:{
            namaPilih2:namapegawai
          },
          success:function(response){
            document.getElementById("jamKerjaPegawai2").innerHTML=response;
          }
        })
        
      };

      function changeName3(val){
        var elemenId1 = document.getElementById("namaPegawai3")
        // var kodeJobinti = elemenId1.options[elemenId1.selectedIndex].text;
        var namapegawai=elemenId1.value;
        console.log("test nama select");
        // console.log(elemenId1);
        $.ajax({
          type: 'POST',
          url: 'ajaxJob.php',
          data:{
            namaPilih3:namapegawai,
          },
          success:function(response){
            document.getElementById("jamKerjaPegawai3").innerHTML=response;
          }
        })
        
      };

      function changeName4(val){
        var elemenId1 = document.getElementById("namaPegawai4")
        // var kodeJobinti = elemenId1.options[elemenId1.selectedIndex].text;
        var namapegawai=elemenId1.value;
        console.log("test nama select");
        // console.log(elemenId1);
        $.ajax({
          type: 'POST',
          url: 'ajaxJob.php',
          data:{
            namaPilih4:namapegawai,
          },
          success:function(response){
            document.getElementById("jamKerjaPegawai4").innerHTML=response;
          }
        })
        
      };

      function changeName5(val){
        var elemenId1 = document.getElementById("namaPegawai5")
        // var kodeJobinti = elemenId1.options[elemenId1.selectedIndex].text;
        var namapegawai=elemenId1.value;
        console.log("test nama select");
        // console.log(elemenId1);
        $.ajax({
          type: 'POST',
          url: 'ajaxJob.php',
          data:{
            namaPilih5:namapegawai,
          },
          success:function(response){
            document.getElementById("jamKerjaPegawai5").innerHTML=response;
          }
        })
        
      };

      function changeName6(val){
        var elemenId1 = document.getElementById("namaPegawai6")
        // var kodeJobinti = elemenId1.options[elemenId1.selectedIndex].text;
        var namapegawai=elemenId1.value;
        console.log("test nama select");
        // console.log(elemenId1);
        $.ajax({
          type: 'POST',
          url: 'ajaxJob.php',
          data:{
            namaPilih6:namapegawai,
          },
          success:function(response){
            document.getElementById("jamKerjaPegawai6").innerHTML=response;
          }
        })
        
      };

      function changeName7(val){
        var elemenId1 = document.getElementById("namaPegawai7")
        // var kodeJobinti = elemenId1.options[elemenId1.selectedIndex].text;
        var namapegawai=elemenId1.value;
        console.log("test nama select");
        // console.log(elemenId1);
        $.ajax({
          type: 'POST',
          url: 'ajaxJob.php',
          data:{
            namaPilih7:namapegawai,
          },
          success:function(response){
            document.getElementById("jamKerjaPegawai7").innerHTML=response;
          }
        })
        
      };

      function changeName8(val){
        var elemenId1 = document.getElementById("namaPegawai8")
        // var kodeJobinti = elemenId1.options[elemenId1.selectedIndex].text;
        var namapegawai=elemenId1.value;
        console.log("test nama select");
        // console.log(elemenId1);
        $.ajax({
          type: 'POST',
          url: 'ajaxJob.php',
          data:{
            namaPilih8:namapegawai,
          },
          success:function(response){
            document.getElementById("jamKerjaPegawai8").innerHTML=response;
          }
        })
        
      };

      function changeName9(val){
        var elemenId1 = document.getElementById("namaPegawai9")
        // var kodeJobinti = elemenId1.options[elemenId1.selectedIndex].text;
        var namapegawai=elemenId1.value;
        console.log("test nama select");
        // console.log(elemenId1);
        $.ajax({
          type: 'POST',
          url: 'ajaxJob.php',
          data:{
            namaPilih9:namapegawai,
          },
          success:function(response){
            document.getElementById("jamKerjaPegawai9").innerHTML=response;
          }
        })
        
      };

      function changeName10(val){
        var elemenId1 = document.getElementById("namaPegawai10")
        var namapegawai=elemenId1.value;
        console.log("test nama select");
        // console.log(elemenId1);
        $.ajax({
          type: 'POST',
          url: 'ajaxJob.php',
          data:{
            namaPilih10:namapegawai,
          },
          success:function(response){
            document.getElementById("jamKerjaPegawai10").innerHTML=response;
          }
        })
        
      };

    //function untuk jobInti
   function fetch_select(val){
        var elemenId1 = document.getElementById("jobinti");
        // var kodeJobinti = elemenId1.options[elemenId1.selectedIndex].text;
        var kodeJobinti=elemenId1.value;
        console.log("test");
        console.log(kodeJobinti);
        $.ajax({
          type: 'POST',
          url: 'ajaxJob.php',
          data:{
            get_option:kodeJobinti,
          },
          success:function(response){
            document.getElementById("sub_category").innerHTML=response;
            document.getElementById("output_harian").value=0;
            document.getElementById("subtotalGaji").innerHTML="Total Gaji: ";
            document.getElementById("gajiperKg").innerHTML="Gaji Per Satuan :";
            
          }
        })
        
      };
   //function untuk jobSekunder untuk nampilin Gaji/output
      function fetch_select2(val){
        var elemenId1 = document.getElementById("sub_category");
        // var kodeJobinti = elemenId1.options[elemenId1.selectedIndex].text;
        var kodeJobdukung=elemenId1.value;
        console.log("test");
        console.log(kodeJobdukung);
        $.ajax({
          type: 'POST',
          url: 'ajaxJob.php',
          data:{
            get_option2:kodeJobdukung,
          },
          success:function(response){
            document.getElementById("gajiperKg").innerHTML=response;
            document.getElementById("output_harian").value=0;
            document.getElementById("subtotalGaji").innerHTML="Total Gaji: ";
          }
        })
      };

      //function untuk nampilin subtotalGaji
      function fetch_select3(val){
        var elemenId1 = document.getElementById("output_harian");
        var hiddenVal=document.getElementById("hiddenVal").value;
        // var kodeJobinti = elemenId1.options[elemenId1.selectedIndex].text;
        var nilai=elemenId1.value;
        console.log("test");
        console.log(nilai);
        $.ajax({
          type: 'POST',
          url: 'ajaxJob.php',
          data:{
            get_option3:nilai,
            target:hiddenVal
            
          },
          success:function(response){
            document.getElementById("subtotalGaji").innerHTML=response;
          }
        })
      };


 
</script>
</head>
<body>
<div class="preloader">
  <div class="cssload-speeding-wheel"></div>
</div>
<section id="wrapper">
                    <h3 >Payroll</h3>
                    <H2>Masukkan Data Payroll</h2>
                  <form method="GET" action="menu.php">
                  <input type="submit" name="backBtn" value="X" style="margin-left:1100px">
                </form>
                  <form method="post" action="#">
                          <?php 
                            ListAbsensi();
                          ?>
                          <br>
                          <label id='jamKerjaPegawai1'>Jam Kerja Pegawai 1: 0 jam</label>
                          <label>             
                          <br>
                          <label id='jamKerjaPegawai2'>Jam Kerja Pegawai 2: 0 jam</label><br>
                          <label id='jamKerjaPegawai3'>Jam Kerja Pegawai 3: 0 jam</label><br>
                          <label id='jamKerjaPegawai4'>Jam Kerja Pegawai 4: 0 jam</label><br>
                          <label id='jamKerjaPegawai5'>Jam Kerja Pegawai 5: 0 jam</label><br>
                          <label id='jamKerjaPegawai6'>Jam Kerja Pegawai 6: 0 jam</label><br>
                          <label id='jamKerjaPegawai7'>Jam Kerja Pegawai 7: 0 jam</label><br>
                          <label id='jamKerjaPegawai8'>Jam Kerja Pegawai 8: 0 jam</label><br>
                          <label id='jamKerjaPegawai9'>Jam Kerja Pegawai 9: 0 jam</label><br>
                          <label id='jamKerjaPegawai10'>Jam Kerja Pegawai 10: 0 jam</label><br>
                        <label>Job Inti</label>
                        <?php
                            ShowJobInti();
                        ?>
                      </div><br>
                         <label>Job Spesifik</label>
                         <select id='sub_category' onchange='fetch_select2();'>
                         </select><br>
                          <label id='gajiperKg'>Gaji Per Satuan : </label>
                    </div><br>
                         <label>Output : </label>
                          <input type='number' name='output_harian' id='output_harian' onchange='fetch_select3();'/>
                    </div>
                    
                    <div id='subtotalGaji'>Total Gaji : </div>
                    <button onclick='insertPay();'>Done</button>
                    <div id='hasil'>
                    </div>
                  </form>
      </div>            
  
</section>
<!-- jQuery -->

</body>
</html>
