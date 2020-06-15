<?php
include("module/modul.php");
include("module/database.php");
require('fpdf/fpdf.php');
$conn=konekin();
$namaPegawai=$_GET['hiddenName'];
$tanggalAwal=$_GET['dateStart'];
$tanggalAkhir=$_GET['dateEnd'];
$formatTanggal1=date("d F Y",strtotime($_GET['dateStart']));
$formatTanggal2=date("d F Y",strtotime($_GET['dateEnd']));



$pdf = new FPDF('P','mm','A5');


$pdf->SetFont('Arial','B',12);

// Memberikan space kebawah agar tidak terlalu rapat
$pdf->Cell(10,7,'',0,1);
$pdf->SetFont('Arial','B',10);

$pdf->SetFont('Arial','',10);
$totalGaji=0;
// include 'koneksi.php';

$pdf->Ln();
// select `kode_pegawai`,subtotal_gaji from payroll where `kode_pegawai`='andy' group by `kode_pegawai`;
if($namaPegawai == "" || $namaPegawai == "0"){
    $mahasiswa = mysqli_query($conn, "select kode_pegawai,SUM(subtotal_gaji) AS VALUE_SUM from payroll where tanggal_input >= '" . $tanggalAwal ."' AND tanggal_input <= '". $tanggalAkhir ."' group by kode_pegawai");
}else{
    $mahasiswa = mysqli_query($conn, "select kode_pegawai,SUM(subtotal_gaji) AS VALUE_SUM from payroll where tanggal_input >= '" . $tanggalAwal ."' AND tanggal_input <= '". $tanggalAkhir ."' AND kode_pegawai='" .$namaPegawai."' group by kode_pegawai");
}

while ($row = mysqli_fetch_array($mahasiswa)){
    $pdf->AddPage();
    $pdf->Cell(64,7,"PERIODE ".$tanggalAwal." S/D $tanggalAkhir ",0,1,'C');
    $pdf->Ln();
    $nama=$row['kode_pegawai'];
    $pdf->Cell(20,6,"NAMA       : ");
    $pdf->Cell(100,6, $nama);
    $pdf->Ln();
    $pdf->Cell(20,6,"PERIODE :");
    $pdf->Cell(100,6,$formatTanggal1 . " - " . $formatTanggal2);
    $pdf->Ln();
    $pdf->Cell(20,6,"LEMBUR  : Rp. 0,00");
    $pdf->Ln();
    $pdf->Cell(20,6,"POTONGAN ");
    $pdf->Ln();
    $pdf->Cell(20,6,"BPJS        :  (Rp. ,00)");
    $pdf->Ln();
    $pdf->Cell(20,6,"PPH         :  (Rp. ,00)");
    $pdf->Ln();
    $pdf->Line(30, 65, 100-30, 65);
    $pdf->Ln();
    $pdf->Cell(20,6,"Total Gaji  : ");
    $pdf->Cell(100,6,"Rp. ".$row['VALUE_SUM'] .",00",3,0);
    // $totalGaji+=$row['subtotal_gaji']; 
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();
    $pdf->Ln();$pdf->Ln();
    $pdf->Cell(30,50,"Penerima");
    // $pdf->Line(30, 262, 100-30, 262);
  
}

$pdf->Output();

?>