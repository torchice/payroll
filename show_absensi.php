<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Import Data CSV dengan PHP</title>
    <!-- Load File bootstrap.min.css yang ada difolder css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Style untuk Loading -->
    <style>
        #loading{
      background: whitesmoke;
      position: absolute;
      top: 140px;
      left: 82px;
      padding: 5px 10px;
      border: 1px solid #ccc;
    }
    </style>
  </head>
  <body>
    <!--
    -- START HEADER
    -- Membuat Menu Header / Navbar
    -- Hapus saja jika tidak diperlukan
    -->
    <nav class="navbar navbar-inverse" role="navigation">
      <div class="container-fluid">
        <div class="navbar-header">
          <a class="navbar-brand" href="#" style="color: white;"><b>Import Data Excel dengan PHP</b></a>
        </div>
        <p class="navbar-text navbar-right hidden-xs" style="color: white;padding-right: 10px;">
          FOLLOW US ON  
          <a target="_blank" style="background: #3b5998; padding: 0 5px; border-radius: 4px; color: #f7f7f7; text-decoration: none;" href="https://www.facebook.com/mynotescode">Facebook</a> 
          <a target="_blank" style="background: #00aced; padding: 0 5px; border-radius: 4px; color: #ffffff; text-decoration: none;" href="https://twitter.com/mynotescode">Twitter</a> 
          <a target="_blank" style="background: #d34836; padding: 0 5px; border-radius: 4px; color: #ffffff; text-decoration: none;" href="https://plus.google.com/118319575543333993544">Google+</a>
        </p>
      </div>
    </nav>
    <!-- END HEADER -->
    
    <!-- Content -->
    <div style="padding: 0 15px;">
      <!-- 
      -- Buat sebuah tombol untuk mengarahkan ke form import data
      -- Tambahkan class btn agar terlihat seperti tombol
      -- Tambahkan class btn-success untuk tombol warna hijau
      -- class pull-right agar posisi link berada di sebelah kanan
      -->
      <a href="form.php" class="btn btn-success pull-right">
        <span class="glyphicon glyphicon-upload"></span> Import Data
      </a>
      
      <h3>Data Hasil Import</h3>
      
      <hr>
      
      <!-- Buat sebuah div dan beri class table-responsive agar tabel jadi responsive -->
      <div class="table-responsive">
        <table class="table table-bordered">
          <tr>
            <th>No</th>
            <th>Nik</th>
            <th>Nama</th>
        
          </tr>
          <?php
          // Load file koneksi.php
          include("module/modul.php");
       
          $conn=konekin();
        //   $query = mysqli_query($conn, "select email_view,ti_me from detail_stalk where email_owner='".$emailowner."'");
          
        // //   while($row = mysqli_fetch_array($query)){
        //       $emailWhoStalk=$row[0];
        //       $timeStalk=$row[1];
              
        //   echo "<tr>
        //       <td>$emailWhoStalk</td>
        //       <td>$timeStalk</td>
        //   </tr>";
        //   }
      

          // Buat query untuk menampilkan semua data siswa
          $query = mysqli_query($conn,"SELECT pin,nik_pegawai,nama_pegawai FROM absen group by nama_pegawai");
          // Eksekusi querynya
          
          $no = 1; // Untuk penomoran tabel, di awal set dengan 1
          while($row = mysqli_fetch_array($query)){ // Ambil semua data dari hasil eksekusi $sql
            echo "<tr>";
         
            echo "<td>".$row[0]."</td>";
            echo "<td>".$row[1]."</td>";
            echo "<td>".$row[2]."</td>";
            echo "</tr>";
            
            $no++; // Tambah 1 setiap kali looping
          }
          ?>
        </table>
      </div>
    </div>
  </body>
</html