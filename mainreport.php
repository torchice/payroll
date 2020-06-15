<?php
include("module/modul.php");
include("module/database.php");
require('fpdf/fpdf.php');

Class myPDF extends FPDF{
    function myCell($w,$h,$x,$t){
        $height=$h/3;
        $first=$height+2;
        $second=$height+$height+$height+3;
        $len=$strlen($t);
        if($len>15){
            $txt=str_split($t,15);
            $this->SetX($x);
            $this->Cell($w,$first,$txt[0],'','','');
            $this->SetX($x);
            $this->Cell($w,$second,$txt[1],'','','');
            $this->SetX($x);
            $this->Cell($w,$h,'','LTRB',0,'L',0);
        }else{
            $this->SetX($x);
            $this->Cell($w,$h,$t,'LTRB',0,'L',0);
        }
    }
}

$pdf = new myPDF();

$pdf = new FPDF('P','mm','A4');
$pdf->AddPage();


$pdf->SetFont('Arial','B',12);
$pdf->Cell(190,7,'LAPORAN PENGGAJIAN',0,1,'C');

// Memberikan space kebawah agar tidak terlalu rapat
$pdf->Cell(10,7,'',0,1);

$pdf->SetFont('Arial','B',10);
$pdf->Cell(25,6,'TANGGAL',1,0);
$pdf->Cell(50,6,'NAMA PEGAWAI',1,0);
$pdf->Cell(45,6,'SPESIFIK KERJA',1,0);
$pdf->Cell(20,6,'OUTPUT',1,0);
$pdf->Cell(35,6,'SUB GAJI',1,0);

$pdf->SetFont('Arial','',10);
$totalGaji=0;
// include 'koneksi.php';
$conn=konekin();
$pdf->Ln();
$fontSize=10;
$tempFontSize=10;
//$cell_width untuk mengatur lebar kolom dari spesifikasi job yang memiliki database kode_jobdukung


$mahasiswa = mysqli_query($conn, "select kode_pegawai,kode_jobdukung,output_harian,subtotal_gaji,tanggal_input from payroll order by kode_pegawai");
while ($row = mysqli_fetch_array($mahasiswa)){
    $cell_width=45; //lebar sel
    $cell_height=10;
  //1,0 untuk memberi border
    // while($pdf->GetStringWidth($row['kode_jobdukung'])>$cell_width){
    //     $pdf->SetFontSize($tempFontSize -= 0.4);
    // }
    
    // $line=1;
    $value=$row['kode_jobdukung'];

    if($pdf->GetStringWidth($value) < $cell_width ){
        $line=1;
    }else{
        // $jumlah=strlen($row['kode_jobdukung']);
        $textLength=strlen($value);
        $errMargin=2;
        $startChar=0;
        $maxChar=0;
        $textArray=array();
        $tmpString="";
        
        while($startChar < $textLength) {
            
            while($pdf->GetStringWidth($tmpString) < ($cell_width-$errMargin) && ($startChar + $maxChar) < $textLength){
                $maxChar++;
                $tmpString=substr($value,$startChar,$maxChar);
            }

            $startChar=$startChar+$maxChar;
            array_push($textArray,$tmpString);
            $maxChar=0;
            $tmpString="";
        
        }
        $line=count($textArray);
        
    }

    $pdf->Cell(25,($line*$cell_height),$row['tanggal_input'],1,0);
    $pdf->Cell(50,($line*$cell_height),$row['kode_pegawai'],1,0);
    $xPos=$pdf->GetX();
    $yPos=$pdf->GetY();

    $pdf->MultiCell($cell_width,$cell_height, $row['kode_jobdukung'],1);
    $pdf->SetXY($xPos + $cell_width , $yPos);
 
    $pdf->Cell(20,($line*$cell_height),$row['output_harian'],1,0);
    $pdf->Cell(35,($line*$cell_height),$row['subtotal_gaji'],1,0);

    $totalGaji+=$row['subtotal_gaji']; 
    $pdf->Ln();
}
$pdf->Cell(135,6,'TOTAL GAJI',1,0);
$pdf->Cell(35,6,$totalGaji,1,0);

$pdf->Output();
?>