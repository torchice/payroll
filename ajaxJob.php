<?php
//  $jobinti=$_POST["id"];
include("module/modul.php");
include("module/database.php");

 if(isset($_POST['get_option'])){
   $jobinti=$_POST['get_option'];
     $conn=konekin();
     $query = mysqli_query($conn, "SELECT kode_jobdukung,nama_jobdukung FROM job_pendukung where kode_jobinti=$jobinti order by nama_jobdukung");
     echo "<option value='0'>"."Pilih Job Dukung"."</option>";
     while($row = mysqli_fetch_row($query)){
         $kode_jobdukung=$row[0];
         $nama_jobdukung=$row[1];
         echo "<option value='".$kode_jobdukung."'>".$nama_jobdukung."</option>";
     }
    
 }
 
 if(isset($_POST['namaPilih'])){
   $nikPegawai=$_POST['namaPilih'];
   $conn=konekin();
    $query = mysqli_query($conn,"SELECT nama_pegawai,MAX(jam),MIN(jam),departemen FROM `absen` where nik_pegawai='$nikPegawai';");

    while($row = mysqli_fetch_row($query)){
      $_SESSION['jamMasukPegawai'][0]=$row[1];
      $_SESSION['jamPulangPegawai'][0]=$row[2];
      $departemen=$row[3];
    }
    $conn->close();

    $dateMasuk = new DateTime($_SESSION['jamMasukPegawai'][0]);
    $datePulang = new DateTime($_SESSION['jamPulangPegawai'][0]);
    $jamMasuk = $dateMasuk->format('G');
    $jamPulang = $datePulang->format('G');
    if($departemen=="STAFF"){
      if($jamMasuk<=8){
        $jamMasuk=8;
      }
      $jamlembur = $jamPulang - $jamMasuk - 8;
      
      if($jamlembur<0){
        $jamlembur=0;
      }
      $_SESSION['jamLemburPegawai'][0]=$jamlembur;

      echo "<label id='jamKerjaPegawai1'>Jam Masuk Pegawai1 ".$_SESSION['jamMasukPegawai'][0]. "  - Jam Pulang Pegawai: ".$_SESSION['jamPulangPegawai'][0]. " - Lembur: STAFF ".$_SESSION['jamLemburPegawai'][0] . "<label>&nbsp;";
    }else{
      $dateMasuk = new DateTime($_SESSION['jamMasukPegawai'][0]);
      $datePulang = new DateTime($_SESSION['jamPulangPegawai'][0]);

      $interval = $datePulang->diff($dateMasuk);
      $formatjam=$interval->format('%h hours %i minutes %s seconds');
      
      $jamKerja=$interval->format('%h');
      if($jamKerja>8){
        $jamlembur = $jamKerja - 8;
      }else{
        $jamlembur=0;
      }
      
      if($jamlembur<0){
        $jamlembur=0;
      }
      
      $_SESSION['jamLemburPegawai'][0]=$jamlembur;  

      echo "<label id='jamKerjaPegawai1'>Jam Masuk Pegawai1 ".$_SESSION['jamMasukPegawai'][0]. "  - Jam Pulang Pegawai: ".$_SESSION['jamPulangPegawai'][0]. " - Lembur: ".$_SESSION['jamLemburPegawai'][0] .".<label>&nbsp;";
    }
 }
 if(isset($_POST['namaPilih2'])){
  $nikPegawai=$_POST['namaPilih2'];
  $conn=konekin();
   $query = mysqli_query($conn,"SELECT nama_pegawai,MAX(jam),MIN(jam),departemen FROM `absen` where nik_pegawai='$nikPegawai';");

   while($row = mysqli_fetch_row($query)){
     $_SESSION['jamMasukPegawai'][1]=$row[1];
     $_SESSION['jamPulangPegawai'][1]=$row[2];
     $departemen=$row[3];
   }
   $conn->close();

   $dateMasuk = new DateTime($_SESSION['jamMasukPegawai'][1]);
   $datePulang = new DateTime($_SESSION['jamPulangPegawai'][1]);
   $jamMasuk = $dateMasuk->format('G');
   $jamPulang = $datePulang->format('G');
   if($departemen=="STAFF"){
     if($jamMasuk<=8){
       $jamMasuk=8;
     }
     $jamlembur = $jamPulang - $jamMasuk - 8;
     
     if($jamlembur<0){
       $jamlembur=0;
     }
     $_SESSION['jamLemburPegawai'][1]=$jamlembur;

     echo "<label id='jamKerjaPegawai2'>Jam Masuk Pegawai2 ".$_SESSION['jamMasukPegawai'][1]. "  - Jam Pulang Pegawai: ".$_SESSION['jamPulangPegawai'][1]. " - Lembur: STAFF ".$_SESSION['jamLemburPegawai'][1] . "<label>&nbsp;";
   }else{
     $dateMasuk = new DateTime($_SESSION['jamMasukPegawai'][1]);
     $datePulang = new DateTime($_SESSION['jamPulangPegawai'][1]);

     $interval = $datePulang->diff($dateMasuk);
     $formatjam=$interval->format('%h hours %i minutes %s seconds');
     
     $jamKerja=$interval->format('%h');
     if($jamKerja>8){
       $jamlembur = $jamKerja - 8;
     }else{
       $jamlembur=0;
     }
     
     if($jamlembur<0){
       $jamlembur=0;
     }
     
     $_SESSION['jamLemburPegawai'][1]=$jamlembur;  

     echo "<label id='jamKerjaPegawai2'>Jam Masuk Pegawai2 ".$_SESSION['jamMasukPegawai'][1]. "  - Jam Pulang Pegawai: ".$_SESSION['jamPulangPegawai'][1]. " - Lembur: ".$_SESSION['jamLemburPegawai'][1] .".<label>&nbsp;";
   }
}
if(isset($_POST['namaPilih3'])){

  $conn=konekin();
  $nikPegawai=$_POST['namaPilih3'];
    // $query = mysqli_query($conn,"SELECT nama_pegawai,MAX(jam),MIN(jam),departemen FROM `absen` where nik_pegawai='$nikPegawai';");
    $sql="SELECT nama_pegawai,MAX(jam) as max,MIN(jam) as min,departemen FROM `absen` where nik_pegawai='$nikPegawai'";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
      while($row = $result->fetch_assoc()){
        $_SESSION['jamMasukPegawai'][2]=$row["max"];
        $_SESSION['jamPulangPegawai'][2]=$row["min"];
        $departemen=$row["departemen"];     
      }
    }
    $conn->close();
    $dateMasuk = new DateTime($_SESSION['jamMasukPegawai'][2]);
    $datePulang = new DateTime($_SESSION['jamPulangPegawai'][2]);
    $jamMasuk = $dateMasuk->format('G');
    $jamPulang = $datePulang->format('G');
    if($departemen=="STAFF"){
      if($jamMasuk<=8){
        $jamMasuk=8;
      }
      $jamlembur = $jamPulang - $jamMasuk - 8;
      
      if($jamlembur<0){
        $jamlembur=0;
      }
      $_SESSION['jamLemburPegawai'][2]=$jamlembur;
    }else{
      $dateMasuk = new DateTime($_SESSION['jamMasukPegawai'][2]);
      $datePulang = new DateTime($_SESSION['jamPulangPegawai'][2]);
      $interval = $datePulang->diff($dateMasuk);
      $jamKerja=$interval->format('%h');
      if($jamKerja>8){
        $jamlembur = $jamKerja - 8;
      }else{
        $jamlembur=0;
      }   
      if($jamlembur<0){
        $jamlembur=0;
      }
      $_SESSION['jamLemburPegawai'][2]=$jamlembur;  
    }
    $stringLabel = "<label id='jamKerjaPegawai'>Jam Masuk Pegawai3 ".$_SESSION['jamMasukPegawai'][2]. "  - Jam Pulang Pegawai1: ".$_SESSION['jamPulangPegawai'][2]. " - Lembur: ".$_SESSION['jamLemburPegawai'][2] . "<label>&nbsp;";    
 
  echo $stringLabel;
}
if(isset($_POST['namaPilih4'])){
  $conn=konekin();
  $nikPegawai=$_POST['namaPilih4'];
    // $query = mysqli_query($conn,"SELECT nama_pegawai,MAX(jam),MIN(jam),departemen FROM `absen` where nik_pegawai='$nikPegawai';");
    $sql="SELECT nama_pegawai,MAX(jam) as max,MIN(jam) as min,departemen FROM `absen` where nik_pegawai='$nikPegawai'";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
      while($row = $result->fetch_assoc()){
        $_SESSION['jamMasukPegawai'][3]=$row["max"];
        $_SESSION['jamPulangPegawai'][3]=$row["min"];
        $departemen=$row["departemen"];     
      }
    }
    $conn->close();
    $dateMasuk = new DateTime($_SESSION['jamMasukPegawai'][3]);
    $datePulang = new DateTime($_SESSION['jamPulangPegawai'][3]);
    $jamMasuk = $dateMasuk->format('G');
    $jamPulang = $datePulang->format('G');
    if($departemen=="STAFF"){
      if($jamMasuk<=8){
        $jamMasuk=8;
      }
      $jamlembur = $jamPulang - $jamMasuk - 8;
      
      if($jamlembur<0){
        $jamlembur=0;
      }
      $_SESSION['jamLemburPegawai'][3]=$jamlembur;
    }else{
      $dateMasuk = new DateTime($_SESSION['jamMasukPegawai'][3]);
      $datePulang = new DateTime($_SESSION['jamPulangPegawai'][3]);
      $interval = $datePulang->diff($dateMasuk);
      $jamKerja=$interval->format('%h');
      if($jamKerja>8){
        $jamlembur = $jamKerja - 8;
      }else{
        $jamlembur=0;
      }   
      if($jamlembur<0){
        $jamlembur=0;
      }
      $_SESSION['jamLemburPegawai'][3]=$jamlembur;  
    }
    $stringLabel = "<label id='jamKerjaPegawai'>Jam Masuk Pegawai4 ".$_SESSION['jamMasukPegawai'][3]. "  - Jam Pulang Pegawai1: ".$_SESSION['jamPulangPegawai'][3]. " - Lembur: ".$_SESSION['jamLemburPegawai'][3] . "<label>&nbsp;";    
  
  echo $stringLabel;
}
if(isset($_POST['namaPilih5'])){
  $conn=konekin();
  $nikPegawai=$_POST['namaPilih5'];
    // $query = mysqli_query($conn,"SELECT nama_pegawai,MAX(jam),MIN(jam),departemen FROM `absen` where nik_pegawai='$nikPegawai';");
    $sql="SELECT nama_pegawai,MAX(jam) as max,MIN(jam) as min,departemen FROM `absen` where nik_pegawai='$nikPegawai'";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
      while($row = $result->fetch_assoc()){
        $_SESSION['jamMasukPegawai'][4]=$row["max"];
        $_SESSION['jamPulangPegawai'][4]=$row["min"];
        $departemen=$row["departemen"];     
      }
    }
    $conn->close();
    $dateMasuk = new DateTime($_SESSION['jamMasukPegawai'][4]);
    $datePulang = new DateTime($_SESSION['jamPulangPegawai'][4]);
    $jamMasuk = $dateMasuk->format('G');
    $jamPulang = $datePulang->format('G');
    if($departemen=="STAFF"){
      if($jamMasuk<=8){
        $jamMasuk=8;
      }
      $jamlembur = $jamPulang - $jamMasuk - 8;
      
      if($jamlembur<0){
        $jamlembur=0;
      }
      $_SESSION['jamLemburPegawai'][4]=$jamlembur;
    }else{
      $dateMasuk = new DateTime($_SESSION['jamMasukPegawai'][4]);
      $datePulang = new DateTime($_SESSION['jamPulangPegawai'][4]);
      $interval = $datePulang->diff($dateMasuk);
      $jamKerja=$interval->format('%h');
      if($jamKerja>8){
        $jamlembur = $jamKerja - 8;
      }else{
        $jamlembur=0;
      }   
      if($jamlembur<0){
        $jamlembur=0;
      }
      $_SESSION['jamLemburPegawai'][4]=$jamlembur;  
    }
    $stringLabel = "<label id='jamKerjaPegawai'>Jam Masuk Pegawai5 ".$_SESSION['jamMasukPegawai'][4]. "  - Jam Pulang Pegawai1: ".$_SESSION['jamPulangPegawai'][4]. " - Lembur: ".$_SESSION['jamLemburPegawai'][4] . "<label>&nbsp;";    
  
  echo $stringLabel;
}
if(isset($_POST['namaPilih6'])){
  $conn=konekin();
  $nikPegawai=$_POST['namaPilih6'];
    // $query = mysqli_query($conn,"SELECT nama_pegawai,MAX(jam),MIN(jam),departemen FROM `absen` where nik_pegawai='$nikPegawai';");
    $sql="SELECT nama_pegawai,MAX(jam) as max,MIN(jam) as min,departemen FROM `absen` where nik_pegawai='$nikPegawai'";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
      while($row = $result->fetch_assoc()){
        $_SESSION['jamMasukPegawai'][5]=$row["max"];
        $_SESSION['jamPulangPegawai'][5]=$row["min"];
        $departemen=$row["departemen"];     
      }
    }
    $conn->close();
    $dateMasuk = new DateTime($_SESSION['jamMasukPegawai'][5]);
    $datePulang = new DateTime($_SESSION['jamPulangPegawai'][5]);
    $jamMasuk = $dateMasuk->format('G');
    $jamPulang = $datePulang->format('G');
    if($departemen=="STAFF"){
      if($jamMasuk<=8){
        $jamMasuk=8;
      }
      $jamlembur = $jamPulang - $jamMasuk - 8;
      
      if($jamlembur<0){
        $jamlembur=0;
      }
      $_SESSION['jamLemburPegawai'][5]=$jamlembur;
    }else{
      $dateMasuk = new DateTime($_SESSION['jamMasukPegawai'][5]);
      $datePulang = new DateTime($_SESSION['jamPulangPegawai'][5]);
      $interval = $datePulang->diff($dateMasuk);
      $jamKerja=$interval->format('%h');
      if($jamKerja>8){
        $jamlembur = $jamKerja - 8;
      }else{
        $jamlembur=0;
      }   
      if($jamlembur<0){
        $jamlembur=0;
      }
      $_SESSION['jamLemburPegawai'][5]=$jamlembur;  
    }
    $stringLabel = "<label id='jamKerjaPegawai'>Jam Masuk Pegawai6 ".$_SESSION['jamMasukPegawai'][5]. "  - Jam Pulang Pegawai1: ".$_SESSION['jamPulangPegawai'][5]. " - Lembur: ".$_SESSION['jamLemburPegawai'][5] . "<label>&nbsp;";    
  
  echo $stringLabel;
}
if(isset($_POST['namaPilih7'])){
  $conn=konekin();
  $nikPegawai=$_POST['namaPilih7'];
    // $query = mysqli_query($conn,"SELECT nama_pegawai,MAX(jam),MIN(jam),departemen FROM `absen` where nik_pegawai='$nikPegawai';");
    $sql="SELECT nama_pegawai,MAX(jam) as max,MIN(jam) as min,departemen FROM `absen` where nik_pegawai='$nikPegawai'";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
      while($row = $result->fetch_assoc()){
        $_SESSION['jamMasukPegawai'][6]=$row["max"];
        $_SESSION['jamPulangPegawai'][6]=$row["min"];
        $departemen=$row["departemen"];     
      }
    }
    $conn->close();
    $dateMasuk = new DateTime($_SESSION['jamMasukPegawai'][6]);
    $datePulang = new DateTime($_SESSION['jamPulangPegawai'][6]);
    $jamMasuk = $dateMasuk->format('G');
    $jamPulang = $datePulang->format('G');
    if($departemen=="STAFF"){
      if($jamMasuk<=8){
        $jamMasuk=8;
      }
      $jamlembur = $jamPulang - $jamMasuk - 8;
      
      if($jamlembur<0){
        $jamlembur=0;
      }
      $_SESSION['jamLemburPegawai'][6]=$jamlembur;
    }else{
      $dateMasuk = new DateTime($_SESSION['jamMasukPegawai'][6]);
      $datePulang = new DateTime($_SESSION['jamPulangPegawai'][6]);
      $interval = $datePulang->diff($dateMasuk);
      $jamKerja=$interval->format('%h');
      if($jamKerja>8){
        $jamlembur = $jamKerja - 8;
      }else{
        $jamlembur=0;
      }   
      if($jamlembur<0){
        $jamlembur=0;
      }
      $_SESSION['jamLemburPegawai'][6]=$jamlembur;  
    }
    $stringLabel = "<label id='jamKerjaPegawai'>Jam Masuk Pegawai7 ".$_SESSION['jamMasukPegawai'][6]. "  - Jam Pulang Pegawai1: ".$_SESSION['jamPulangPegawai'][6]. " - Lembur: ".$_SESSION['jamLemburPegawai'][6] . "<label>&nbsp;";    
  
  echo $stringLabel;
}
if(isset($_POST['namaPilih8'])){
  $conn=konekin();
  $nikPegawai=$_POST['namaPilih8'];
    // $query = mysqli_query($conn,"SELECT nama_pegawai,MAX(jam),MIN(jam),departemen FROM `absen` where nik_pegawai='$nikPegawai';");
    $sql="SELECT nama_pegawai,MAX(jam) as max,MIN(jam) as min,departemen FROM `absen` where nik_pegawai='$nikPegawai'";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
      while($row = $result->fetch_assoc()){
        $_SESSION['jamMasukPegawai'][7]=$row["max"];
        $_SESSION['jamPulangPegawai'][7]=$row["min"];
        $departemen=$row["departemen"];     
      }
    }
    $conn->close();
    $dateMasuk = new DateTime($_SESSION['jamMasukPegawai'][7]);
    $datePulang = new DateTime($_SESSION['jamPulangPegawai'][7]);
    $jamMasuk = $dateMasuk->format('G');
    $jamPulang = $datePulang->format('G');
    if($departemen=="STAFF"){
      if($jamMasuk<=8){
        $jamMasuk=8;
      }
      $jamlembur = $jamPulang - $jamMasuk - 8;
      
      if($jamlembur<0){
        $jamlembur=0;
      }
      $_SESSION['jamLemburPegawai'][7]=$jamlembur;
    }else{
      $dateMasuk = new DateTime($_SESSION['jamMasukPegawai'][7]);
      $datePulang = new DateTime($_SESSION['jamPulangPegawai'][7]);
      $interval = $datePulang->diff($dateMasuk);
      $jamKerja=$interval->format('%h');
      if($jamKerja>8){
        $jamlembur = $jamKerja - 8;
      }else{
        $jamlembur=0;
      }   
      if($jamlembur<0){
        $jamlembur=0;
      }
      $_SESSION['jamLemburPegawai'][7]=$jamlembur;  
    }
    $stringLabel = "<label id='jamKerjaPegawai'>Jam Masuk Pegawai8 ".$_SESSION['jamMasukPegawai'][7]. "  - Jam Pulang Pegawai1: ".$_SESSION['jamPulangPegawai'][7]. " - Lembur: ".$_SESSION['jamLemburPegawai'][7] . "<label>&nbsp;";    
  
  echo $stringLabel;
}
if(isset($_POST['namaPilih9'])){
  $conn=konekin();
  $nikPegawai=$_POST['namaPilih9'];
    // $query = mysqli_query($conn,"SELECT nama_pegawai,MAX(jam),MIN(jam),departemen FROM `absen` where nik_pegawai='$nikPegawai';");
    $sql="SELECT nama_pegawai,MAX(jam) as max,MIN(jam) as min,departemen FROM `absen` where nik_pegawai='$nikPegawai'";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
      while($row = $result->fetch_assoc()){
        $_SESSION['jamMasukPegawai'][8]=$row["max"];
        $_SESSION['jamPulangPegawai'][8]=$row["min"];
        $departemen=$row["departemen"];     
      }
    }
    $conn->close();
    $dateMasuk = new DateTime($_SESSION['jamMasukPegawai'][8]);
    $datePulang = new DateTime($_SESSION['jamPulangPegawai'][8]);
    $jamMasuk = $dateMasuk->format('G');
    $jamPulang = $datePulang->format('G');
    if($departemen=="STAFF"){
      if($jamMasuk<=8){
        $jamMasuk=8;
      }
      $jamlembur = $jamPulang - $jamMasuk - 8;
      
      if($jamlembur<0){
        $jamlembur=0;
      }
      $_SESSION['jamLemburPegawai'][8]=$jamlembur;
    }else{
      $dateMasuk = new DateTime($_SESSION['jamMasukPegawai'][8]);
      $datePulang = new DateTime($_SESSION['jamPulangPegawai'][8]);
      $interval = $datePulang->diff($dateMasuk);
      $jamKerja=$interval->format('%h');
      if($jamKerja>8){
        $jamlembur = $jamKerja - 8;
      }else{
        $jamlembur=0;
      }   
      if($jamlembur<0){
        $jamlembur=0;
      }
      $_SESSION['jamLemburPegawai'][8]=$jamlembur;  
    }
    $stringLabel = "<label id='jamKerjaPegawai'>Jam Masuk Pegawai9 ".$_SESSION['jamMasukPegawai'][8]. "  - Jam Pulang Pegawai1: ".$_SESSION['jamPulangPegawai'][8]. " - Lembur: ".$_SESSION['jamLemburPegawai'][8] . "<label>&nbsp;";    
  
  echo $stringLabel;
}
if(isset($_POST['namaPilih10'])){
  $conn=konekin();
  $nikPegawai=$_POST['namaPilih10'];
    // $query = mysqli_query($conn,"SELECT nama_pegawai,MAX(jam),MIN(jam),departemen FROM `absen` where nik_pegawai='$nikPegawai';");
    $sql="SELECT nama_pegawai,MAX(jam) as max,MIN(jam) as min,departemen FROM `absen` where nik_pegawai='$nikPegawai'";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
      while($row = $result->fetch_assoc()){
        $_SESSION['jamMasukPegawai'][9]=$row["max"];
        $_SESSION['jamPulangPegawai'][9]=$row["min"];
        $departemen=$row["departemen"];     
      }
    }
    $conn->close();
    $dateMasuk = new DateTime($_SESSION['jamMasukPegawai'][9]);
    $datePulang = new DateTime($_SESSION['jamPulangPegawai'][9]);
    $jamMasuk = $dateMasuk->format('G');
    $jamPulang = $datePulang->format('G');
    if($departemen=="STAFF"){
      if($jamMasuk<=8){
        $jamMasuk=8;
      }
      $jamlembur = $jamPulang - $jamMasuk - 8;
      
      if($jamlembur<0){
        $jamlembur=0;
      }
      $_SESSION['jamLemburPegawai'][9]=$jamlembur;
    }else{
      $dateMasuk = new DateTime($_SESSION['jamMasukPegawai'][9]);
      $datePulang = new DateTime($_SESSION['jamPulangPegawai'][9]);
      $interval = $datePulang->diff($dateMasuk);
      $jamKerja=$interval->format('%h');
      if($jamKerja>8){
        $jamlembur = $jamKerja - 8;
      }else{
        $jamlembur=0;
      }   
      if($jamlembur<0){
        $jamlembur=0;
      }
      $_SESSION['jamLemburPegawai'][9]=$jamlembur;  
    }
    $stringLabel = "<label id='jamKerjaPegawai'>Jam Masuk Pegawai10 ".$_SESSION['jamMasukPegawai'][9]. "  - Jam Pulang Pegawai1: ".$_SESSION['jamPulangPegawai'][9]. " - Lembur: ".$_SESSION['jamLemburPegawai'][9] . "<label>&nbsp;";    
  
  echo $stringLabel;
}
 
 if(isset($_POST['get_option2'])){
    $kd_jobdukung=$_POST['get_option2'];
      $conn=konekin();
 
      $query = mysqli_query($conn, "SELECT nama_jobdukung,target_bulan FROM job_pendukung where kode_jobdukung=$kd_jobdukung;");
    
      $gajiBorongan=2250000;
      $jamKerja=7;
      $hariKerja=25;

      while($row = mysqli_fetch_row($query)){
          $nama=$row[0];
          $target=$row[1];
          $resultGajiperKG=ceil(1/$target*$gajiBorongan);
          echo "Gaji Per Satuan : Rp " . $resultGajiperKG . " - Target/Bulan :" . $target;
          echo "<input type='hidden' id='hiddenVal' name='hiddenVal' value='".$target."'>";
      }
 
  }

  if(isset($_POST['get_option3'])){
    $output=$_POST['get_option3'];

    $gajiBorongan=2250000;
    $jamKerja=7;
    $hariKerja=25;

    if(isset($_POST['target'])){
        $target=$_POST['target'];
    }
    $totalGaji=ceil($gajiBorongan / $target * $output);
    echo "Total Gaji : Rp " . number_format($totalGaji,2);
    echo "<input type='hidden' id='hiddenGaji' name='hiddenGaji' value='".$totalGaji."'>";
  }

  if(isset($_POST['get_option4'])){
    $output=$_POST['get_option4'];

    $gajiBorongan=2250000;
    $jamKerja=7;
    $hariKerja=25;

    if(isset($_POST['target'])){
        $target=$_POST['target'];
    }
    $totalGaji=ceil($gajiBorongan / $target * $output);
    echo "Total Gaji : Rp " . number_format($totalGaji,2);
    echo "<input type='hidden' id='hiddenGaji' name='hiddenGaji' value='".$totalGaji."'>";
  }

  if(isset($_POST['inputPegawai'])){
   
    $conn= konekin();
    $inputPegawai1=$_POST['inputPegawai'];
    $inputPegawai2=$_POST['inputPegawai2'];
    $inputPegawai3=$_POST['inputPegawai3'];
    $inputPegawai4=$_POST['inputPegawai4'];
    $inputPegawai5=$_POST['inputPegawai5'];
    $inputPegawai6=$_POST['inputPegawai6'];
    $inputPegawai7=$_POST['inputPegawai7'];
    $inputPegawai8=$_POST['inputPegawai8'];
    $inputPegawai9=$_POST['inputPegawai9'];
    $inputPegawai10=$_POST['inputPegawai10'];
    $inputJobinti=$_POST['inputJobinti'];
    $inputJobdukung=$_POST['inputJobdukung'];
    $inputGaji=$_POST['inputGaji'];
    $inputOutput=$_POST['inputOutput'];
    // alert($input_jam_masuk);
    
    if($inputPegawai1 != "0" && $inputPegawai1 != ""){
      $jamMasuk = strval($_SESSION["jamMasukPegawai"][0]);
      $jamPulang = strval($_SESSION["jamPulangPegawai"][0]);
      $jamLembur = intval($_SESSION["jamLemburPegawai"][0]);
      $sql = "INSERT INTO `payroll`(`kode_payroll`, `kode_pegawai`, `kode_jobinti`, `kode_jobdukung`, `output_harian`, `subtotal_gaji`, `tanggal_input`,`jam_masuk`,`jam_pulang`,`jam_lembur`) VALUES ('','$inputPegawai1','$inputJobinti','$inputJobdukung',". $inputOutput.",".$inputGaji.",now(),'$jamMasuk','$jamPulang',".$jamLembur.")";
      if ($conn->query($sql) === TRUE) {
        // echo json_encode("Data Inserted Successfully");
        echo "berhasil";
        // $conn->close();
      }else{
        echo "Error: " . $sql . "<br>" . $conn->error;
      }
    }
    if($inputPegawai2 != "0" && $inputPegawai2 != ""){
      $jamMasuk = strval($_SESSION["jamMasukPegawai"][1]);
      $jamPulang = strval($_SESSION["jamPulangPegawai"][1]);
      $jamLembur = intval($_SESSION["jamLemburPegawai"][1]);
      $sql = "INSERT INTO `payroll`(`kode_payroll`, `kode_pegawai`, `kode_jobinti`, `kode_jobdukung`, `output_harian`, `subtotal_gaji`, `tanggal_input`,`jam_masuk`,`jam_pulang`,`jam_lembur`) VALUES ('','$inputPegawai2','$inputJobinti','$inputJobdukung',". $inputOutput.",".$inputGaji.",now(),'$jamMasuk','$jamPulang',".$jamLembur.")";
      if ($conn->query($sql) === TRUE) {
        // echo json_encode("Data Inserted Successfully");
        echo "berhasil";
        // $conn->close();
      }else{
        echo "Error: " . $sql . "<br>" . $conn->error;
      }
    }
    if($inputPegawai3 != "0" && $inputPegawai3 != ""){
      $jamMasuk = strval($_SESSION["jamMasukPegawai"][2]);
      $jamPulang = strval($_SESSION["jamPulangPegawai"][2]);
      $jamLembur = intval($_SESSION["jamLemburPegawai"][2]);
      $sql = "INSERT INTO `payroll`(`kode_payroll`, `kode_pegawai`, `kode_jobinti`, `kode_jobdukung`, `output_harian`, `subtotal_gaji`, `tanggal_input`,`jam_masuk`,`jam_pulang`,`jam_lembur`) VALUES ('','$inputPegawai3','$inputJobinti','$inputJobdukung',". $inputOutput.",".$inputGaji.",now(),'$jamMasuk','$jamPulang',".$jamLembur.")";
      if ($conn->query($sql) === TRUE) {
        // echo json_encode("Data Inserted Successfully");
        echo "berhasil";
        // $conn->close();
      }else{
        echo "Error: " . $sql . "<br>" . $conn->error;
      }
    }
    if($inputPegawai4 != "0" && $inputPegawai4 != ""){
      $jamMasuk = strval($_SESSION["jamMasukPegawai"][3]);
      $jamPulang = strval($_SESSION["jamPulangPegawai"][3]);
      $jamLembur = intval($_SESSION["jamLemburPegawai"][3]);
      $sql = "INSERT INTO `payroll`(`kode_payroll`, `kode_pegawai`, `kode_jobinti`, `kode_jobdukung`, `output_harian`, `subtotal_gaji`, `tanggal_input`,`jam_masuk`,`jam_pulang`,`jam_lembur`) VALUES ('','$inputPegawai4','$inputJobinti','$inputJobdukung',". $inputOutput.",".$inputGaji.",now(),'$jamMasuk','$jamPulang',".$jamLembur.")";
      if ($conn->query($sql) === TRUE) {
        // echo json_encode("Data Inserted Successfully");
        echo "berhasil";
        // $conn->close();
      }else{
        echo "Error: " . $sql . "<br>" . $conn->error;
      }
    }
    if($inputPegawai5 != "0" && $inputPegawai5 != ""){
      $jamMasuk = strval($_SESSION["jamMasukPegawai"][4]);
      $jamPulang = strval($_SESSION["jamPulangPegawai"][4]);
      $jamLembur = intval($_SESSION["jamLemburPegawai"][4]);
      $sql = "INSERT INTO `payroll`(`kode_payroll`, `kode_pegawai`, `kode_jobinti`, `kode_jobdukung`, `output_harian`, `subtotal_gaji`, `tanggal_input`,`jam_masuk`,`jam_pulang`,`jam_lembur`) VALUES ('','$inputPegawai5','$inputJobinti','$inputJobdukung',". $inputOutput.",".$inputGaji.",now(),'$jamMasuk','$jamPulang',".$jamLembur.")";
      if ($conn->query($sql) === TRUE) {
        // echo json_encode("Data Inserted Successfully");
        echo "berhasil";
        // $conn->close();
      }else{
        echo "Error: " . $sql . "<br>" . $conn->error;
      }
    }
    if($inputPegawai6 != "0" && $inputPegawai6 != ""){
      $jamMasuk = strval($_SESSION["jamMasukPegawai"][5]);
      $jamPulang = strval($_SESSION["jamPulangPegawai"][5]);
      $jamLembur = intval($_SESSION["jamLemburPegawai"][5]);
      $sql = "INSERT INTO `payroll`(`kode_payroll`, `kode_pegawai`, `kode_jobinti`, `kode_jobdukung`, `output_harian`, `subtotal_gaji`, `tanggal_input`,`jam_masuk`,`jam_pulang`,`jam_lembur`) VALUES ('','$inputPegawai6','$inputJobinti','$inputJobdukung',". $inputOutput.",".$inputGaji.",now(),'$jamMasuk','$jamPulang',".$jamLembur.")";
      if ($conn->query($sql) === TRUE) {
        // echo json_encode("Data Inserted Successfully");
        echo "berhasil";
        // $conn->close();
      }else{
        echo "Error: " . $sql . "<br>" . $conn->error;
      }
    }
    if($inputPegawai7 != "0" && $inputPegawai7 != ""){
      $jamMasuk = strval($_SESSION["jamMasukPegawai"][6]);
      $jamPulang = strval($_SESSION["jamPulangPegawai"][6]);
      $jamLembur = intval($_SESSION["jamLemburPegawai"][6]);
      $sql = "INSERT INTO `payroll`(`kode_payroll`, `kode_pegawai`, `kode_jobinti`, `kode_jobdukung`, `output_harian`, `subtotal_gaji`, `tanggal_input`,`jam_masuk`,`jam_pulang`,`jam_lembur`) VALUES ('','$inputPegawai7','$inputJobinti','$inputJobdukung',". $inputOutput.",".$inputGaji.",now(),'$jamMasuk','$jamPulang',".$jamLembur.")";
      if ($conn->query($sql) === TRUE) {
        // echo json_encode("Data Inserted Successfully");
        echo "berhasil";
        // $conn->close();
      }else{
        echo "Error: " . $sql . "<br>" . $conn->error;
      }
    }
    if($inputPegawai8 != "0" && $inputPegawai8 != ""){
      $jamMasuk = strval($_SESSION["jamMasukPegawai"][7]);
      $jamPulang = strval($_SESSION["jamPulangPegawai"][7]);
      $jamLembur = intval($_SESSION["jamLemburPegawai"][7]);
      $sql = "INSERT INTO `payroll`(`kode_payroll`, `kode_pegawai`, `kode_jobinti`, `kode_jobdukung`, `output_harian`, `subtotal_gaji`, `tanggal_input`,`jam_masuk`,`jam_pulang`,`jam_lembur`) VALUES ('','$inputPegawai8','$inputJobinti','$inputJobdukung',". $inputOutput.",".$inputGaji.",now(),'$jamMasuk','$jamPulang',".$jamLembur.")";
      if ($conn->query($sql) === TRUE) {
        // echo json_encode("Data Inserted Successfully");
        echo "berhasil";
        // $conn->close();
      }else{
        echo "Error: " . $sql . "<br>" . $conn->error;
      }
    }
    if($inputPegawai9 != "0" && $inputPegawai9 != ""){
      $jamMasuk = strval($_SESSION["jamMasukPegawai"][8]);
      $jamPulang = strval($_SESSION["jamPulangPegawai"][8]);
      $jamLembur = intval($_SESSION["jamLemburPegawai"][8]);
      $sql = "INSERT INTO `payroll`(`kode_payroll`, `kode_pegawai`, `kode_jobinti`, `kode_jobdukung`, `output_harian`, `subtotal_gaji`, `tanggal_input`,`jam_masuk`,`jam_pulang`,`jam_lembur`) VALUES ('','$inputPegawai9','$inputJobinti','$inputJobdukung',". $inputOutput.",".$inputGaji.",now(),'$jamMasuk','$jamPulang',".$jamLembur.")";
      if ($conn->query($sql) === TRUE) {
        // echo json_encode("Data Inserted Successfully");
        echo "berhasil";
        // $conn->close();
      }else{
        echo "Error: " . $sql . "<br>" . $conn->error;
      }
    }
    if($inputPegawai10 != "0" && $inputPegawai10 != ""){
      $jamMasuk = strval($_SESSION["jamMasukPegawai"][9]);
      $jamPulang = strval($_SESSION["jamPulangPegawai"][9]);
      $jamLembur = intval($_SESSION["jamLemburPegawai"][9]);
      $sql = "INSERT INTO `payroll`(`kode_payroll`, `kode_pegawai`, `kode_jobinti`, `kode_jobdukung`, `output_harian`, `subtotal_gaji`, `tanggal_input`,`jam_masuk`,`jam_pulang`,`jam_lembur`) VALUES ('','$inputPegawai10','$inputJobinti','$inputJobdukung',". $inputOutput.",".$inputGaji.",now(),'$jamMasuk','$jamPulang',".$jamLembur.")";
      if ($conn->query($sql) === TRUE) {
        // echo json_encode("Data Inserted Successfully");
        echo "berhasil";
        // $conn->close();
      }else{
        echo "Error: " . $sql . "<br>" . $conn->error;
      }
    }
   
    $conn->close();
 
  }
 
  
?>