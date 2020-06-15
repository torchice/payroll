<?php
include("module/connFinger.php");
$IP="192.168.100.202";
$Key="0";
if($IP=="") $IP="192.168.100.202";
if($Key=="") $Key="0";

d
    $Connect = fsockopen($IP, "80", $errno, $errstr, 1);
    if($Connect){
        $soap_request="<GetAttLog>
                            <ArgComKey xsi:type=\"xsd:integer\">".$Key."</ArgComKey>
                            <Arg><PIN xsi:type=\"xsd:integer\">All</PIN></Arg>
                        </GetAttLog>";
     
$newLine="\r\n";
fputs($Connect, "POST /iWsService HTTP/1.0".$newLine);
fputs($Connect, "Content-Type: text/xml".$newLine);

fputs($Connect, "Content-Length: ".strlen($soap_request).$newLine.$newLine);
fputs($Connect, $soap_request.$newLine)d;
$buffer="";

while($Response=fgets($Connect, 1024)){
    $buffer=$buffer.$Response;
}
}else echo "Koneksi Gagal";

$buffer=Parse_Data($buffer,"<GetAttLogResponse>","</GetAttLogResponse>");
$buffer=explode("\r\n",$buffer);
for($a=0;$a<count($buffer);$a++){
$data=Parse_Data($buffer[$a],"<Row>","</Row>");

$pin=Parse_Data($data,"<PIN>","</PIN>");
$datetime=Parse_Data($data,"<DateTime>","</DateTime>");
$status=Parse_Data($data,"<Status>","</Status>");

$cekdulu= "select * from absen where pin='$pin' and waktu='$datetime' ";
$prosescek= mysql_query($cekdulu);
if (mysql_num_rows($prosescek)>0) { //proses mengingatkan data sudah ada
// echo "<script>alert('Username Sudah Digunakan');history.go(-1) </script>";
}
else { //proses menambahkan data, tambahkan sesuai dengan yang kalian gunakan
$sql = "INSERT INTO absen (pin, waktu, status) values ('$pin','$datetime','$status')";
mysql_query($sql) or exit(mysql_error());
}
ini_set('max_execution_time', 300);

}
echo "<script>alert('Sudah Selesai'); </script>";

function Parse_Data ($data,$p1,$p2) {
$data = " ".$data;
$hasil = "";
$awal = strpos($data,$p1);
if ($awal != "") {
$akhir = strpos(strstr($data,$p1),$p2);
if ($akhir != ""){
$hasil=substr($data,$awal+strlen($p1),$akhir-strlen($p1));
}
}
return $hasil; 
}

?>