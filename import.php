<?php
ini_set('max_execution_time', 300); 
/*
--
--
-- Terimakasih telah mengunjungi blog kami.
-- Jangan lupa untuk Like dan Share catatan-catatan yang ada di blog kami.
*/
// Load file koneksi.php
include("module/modul.php");
if(isset($_POST['import'])){ // Jika user mengklik tombol Import
  // Load librari PHPExcel nya
  require_once 'PHPExcel/PHPExcel.php';
  $conn=konekin();

  $sql = "DELETE FROM `absen`;";
  if ($conn->query($sql) === TRUE) {
    echo "Record deleted successfully";
   // echo $sql;
  } else {
    echo "Error deleting record: " . $conn->error;
  }
  // "localhost:3309","root","3KJSvjbFRFTLdA76","pabrik");
  $mysqli = new mysqli("localhost", "root", "", "pabrik");
  $inputFileType = 'CSV';
  $inputFileName = 'tmp/data.csv';
  $reader = PHPExcel_IOFactory::createReader($inputFileType);
  $excel = $reader->load($inputFileName);
  $numrow = 1;
  $worksheet = $excel->getActiveSheet();
  foreach ($worksheet->getRowIterator() as $row) {
    // Cek $numrow apakah lebih dari 1
    // Artinya karena baris pertama adalah nama-nama kolom
    // Jadi dilewat saja, tidak usah diimport
    if($numrow > 1){
      // START -->
      // Skrip untuk mengambil value nya
      $cellIterator = $row->getCellIterator();
      $cellIterator->setIterateOnlyExistingCells(false); // Loop all cells, even if it is not set
      $get = array(); // Valuenya akan di simpan kedalam array,dimulai dari index ke 0
      foreach ($cellIterator as $cell) {
        array_push($get, $cell->getValue()); // Menambahkan value ke variabel array $get
      }
      // <-- END
      // Ambil data value yang telah di ambil dan dimasukkan ke variabel $get
      $pin = $get[0]; // Ambil data NIS
      $nik = $get[1]; // Ambil data nik
      $nama = $get[2]; // Ambil data nama
      $tanggal = $get[3]; // Ambil data tanggal
      $jam = $get[4]; // Ambil data jam
      $departemen = $get[11];
      // Cek jika semua data tidak diisi
      if($pin == "" && $nama == "" && $nik == "" && $tanggal == "" && $jam == "")
        continue; // Lewat data pada baris ini (masuk ke looping selanjutnya / baris selanjutnya)
      // Proses simpan ke Database
      // Buat query Insert
    //   pin,nik_pegawai,nama_pegawai
      $nama=$mysqli->real_escape_string($nama);
      $sql = "INSERT INTO `absen`(`pin`, `nik_pegawai`,`nama_pegawai`,`tanggal`,`jam`,`departemen`) VALUES ('".$pin ."','".$nik."','".$nama."','".$tanggal."','".$jam . "','". $departemen."')";

      if ($mysqli->query($sql) === TRUE) {
        $_SESSION["data_absensi"]="available";
     
          // echo "<script>alert('Anda telah menstalk');</script>";
      } else {
          echo "Error: " . $sql . "<br>" . $conn->error;
      }

    }
    $numrow++; // Tambah 1 setiap kali looping
  }
    header('location:payroll.php');
}

?>