<?php
	include_once("module/modul.php");
	include_once("module/database.php");

    // if(isset($_POST['Show'])){
	// 	insertpegawai();
	// }

	
?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Payroll</title>
	<script src="assets/js/jquery-3.3.1.min.js">

  </script>

	<style type="text/css">

	::selection { background-color: #E13300; color: white; }
	::-moz-selection { background-color: #E13300; color: white; }

	body {
		background-color: #fff;
		margin: 40px;
		font: 13px/20px normal Helvetica, Arial, sans-serif;
		color: #4F5155;
	}

	a {
		color: #003399;
		background-color: transparent;
		font-weight: normal;
	}

	h1 {
		color: #444;
		background-color: transparent;
		border-bottom: 1px solid #D0D0D0;
		font-size: 19px;
		font-weight: normal;
		margin: 0 0 14px 0;
		padding: 14px 15px 10px 15px;
	}

	code {
		font-family: Consolas, Monaco, Courier New, Courier, monospace;
		font-size: 12px;
		background-color: #f9f9f9;
		border: 1px solid #D0D0D0;
		color: #002166;
		display: block;
		margin: 14px 0 14px 0;
		padding: 12px 10px 12px 10px;
	}

	#body {
		margin: 0 15px 0 15px;
	}

	p.footer {
		text-align: right;
		font-size: 11px;
		border-top: 1px solid #D0D0D0;
		line-height: 32px;
		padding: 0 10px 0 10px;
		margin: 20px 0 0 0;
	}

	#container {
		margin: 10px;
		border: 1px solid #D0D0D0;
		box-shadow: 0 0 8px #D0D0D0;
	}
	</style>
		<script>
		function changePegawai(val){
			// alert("ASD");
			var elemenId1 = document.getElementById("namaPegawai");
			
			// var kodeJobinti = elemenId1.options[elemenId1.selectedIndex].text;
			var kodePegawai=elemenId1.value;
        // and update the hidden input's value
        	$('#hiddenName').val(kodePegawai);
			// console.log("test");
			console.log(kodePegawai);
			document.getElementById("hiddenName").innerHTML=kodePegawai;
      };

	</script>
</head>
<body>
<div id="header">

	<form method="GET" action="menu.php">
	
	</form>
</div>
<div id="container">

    <h1>SLIP GAJI PEGAWAI</h1>
	<form method="GET" action="menu.php">
		<input type="submit" name="backBtn" value="X" style="margin-left:1100px">
	</form>
    <div id="body"><br>
    <!-- <?php
        // ListPegawaiGaji();
    ?> -->
	    <form method="GET" action="cellSlip.php">
		Nama Pegawai :
		<?php
			ListPegawaiGaji();
		?><br>
		Tanggal Awal
		<input type='date' name="dateStart" value="Show">
		<br>
		Tanggal Akhir
		<input type='date' name="dateEnd" value="Show">
		<input type="hidden" id="hiddenName" name="hiddenName" value="">
        <br><br><input type='submit' name="ShowGaji" value="Show">
	
	</form>
    <br>
    <br>

	</div>

	<p class="footer">Andy</p>
</div>

</body>
</html>