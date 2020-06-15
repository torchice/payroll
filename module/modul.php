<?php
    session_start(); 
    // include('database.php');
//    $get_option="";


    function konekin(){
        $conn = mysqli_connect("localhost:3309","root","3KJSvjbFRFTLdA76","pabrik");
        if (mysqli_connect_errno()) {
            echo "Failed to connect to Database :" . mysqli_connect_error();
        }
        return $conn;
    }

    function insertpegawai(){
        $conn = konekin();
        $namakaryawan=$_POST['namakaryawan'];
        $nikkaryawan=$_POST['nikpegawai'];
        // select email from member where username='".$profileId."'
        $query = mysqli_query($conn, "SELECT kode_pegawai FROM pegawai where nik_pegawai='$nikkaryawan'");
        $nikkaryawanCek="";
        while($row = mysqli_fetch_row($query)){
            $nikkaryawanCek=$row[0];
        }
      
        if($nikkaryawanCek==""){
            $sql = "INSERT INTO `pegawai`(`nik_pegawai`,`nama_pegawai`, `status_aktif`) VALUES ('".$nikkaryawan . "','".$namakaryawan."','1')";
      
            if ($conn->query($sql) === TRUE) {
                echo "<script>alert('Pegawai berhasil ditambahkan');</script>";
            } else {
                echo "<script>alert('".$sql."');</script>";
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        }else{
            echo "<script>alert('Data Pegawai Duplicated');</script>";
        }
        // select email from member where username='".$profileId."'
        $conn->close();
    }

    // function ListPegawai(){
    //     $conn=konekin();
      
    //     for($x=1; $x<=10;$x+=1){
    //         $query = mysqli_query($conn, "SELECT kode_pegawai,nama_pegawai FROM pegawai order by nama_pegawai;");
    //         echo "<select class='abc' id='namaPegawai".$x."' onchange='changeName(this.val);'>";
    //         echo "<option value='0' selected></option>";
    //         while($row = mysqli_fetch_row($query)){
    //             $kode_pegawai=$row[0];
    //             $nama_pegawai=$row[1];
    //             echo "<option value='$nama_pegawai'>$nama_pegawai</option>";
    //         }
    //         echo "</select>";
    //         echo "<br>";
    //     }
      
    // }

    function ListAbsensi(){
        $conn=konekin();
       
        // echo "<label>Nama Pegawai</label><br>";
        for($x=1; $x<=10;$x+=1){
            $query = mysqli_query($conn, "SELECT nik_pegawai,nama_pegawai,min(jam) as awalmasuk FROM absen group by nama_pegawai order by nama_pegawai;");
            echo "Nama Pegawai ".$x.": ";
            echo "<select id='namaPegawai".$x."' onchange='changeName$x(this.val);'>";
            echo "<option value='0' selected></option>";
            while($row = mysqli_fetch_row($query)){
                $kode_pegawai=$row[0];
                $nama_pegawai=$row[1];
                $awalmasuk=$row[2];
                echo "<option value='$kode_pegawai'>$nama_pegawai</option>";
                $_SESSION["jamKerjaPegawai$x"]="0";
            }
            echo "</select>";
            echo "&nbsp;&nbsp;";     
      
            // echo "<label id='jamKerj aPegawai$x'>0 jam<label>&nbsp;";
            // echo "<input type='text' name='jamkerjaPegawai'". $x."id='jamkerjaPegawai".$x."' value='".$awalmasuk."' disabled>";
            echo "<br>";
        }
      
    }

    function ListPegawaiGaji(){
        $conn=konekin();
      
            $query = mysqli_query($conn, "SELECT kode_pegawai FROM payroll group by kode_pegawai order by kode_pegawai ;");
            echo "<select id='namaPegawai' onchange='changePegawai(this.val);'>";
            echo "<option value='0' selected>Semua</option>";
            while($row = mysqli_fetch_row($query)){
                $nama_pegawai=$row[0];
                echo "<option value='$nama_pegawai'>$nama_pegawai</option>";
                
            }
            echo "</select>&nbsp;";  

    }

    function ShowJobInti()
    {
        // $jobinti=$get_option;
        $conn=konekin();
        $query = mysqli_query($conn, "SELECT kode_jobinti,nama_jobinti FROM job_inti order by nama_jobinti");
        echo "<select id='jobinti' onchange='fetch_select(this.val);'>";
        echo "<option value='0'>"."Pilih Job Inti"."</option>";
        while($row = mysqli_fetch_row($query)){
            $kode_jobinti=$row[0];
            $nama_jobinti=$row[1];
            
            echo "<option value='$kode_jobinti'>$nama_jobinti</option>";
        }
     echo "</select>";
    }

    function updateProfile(){
        echo "test2";
        $conn = Konekin();
        $nama=$_POST['nama'];
        $username=$_POST['username'];
        $bio=$_POST['bio'];
        $gender=$_POST['gender'];
        $phone=$_POST['phone'];  
        
        $id=$_SESSION['logged'];

        $sql="UPDATE `member` SET `username`='$username',`nama`='$nama',`bio`='$bio',`phone_number`='$phone',`gender`='$gender' WHERE EMAIL='$id'";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Edit berhasil dilakukan');</script>";
            echo $sql;
        } else {
            echo "Error deleting record: " . $conn->error;
        }
        $conn->close(); 
    }
    function insertIklan(){
        $conn= konekin();
        $isiIklan=$_POST['deskripsiIklan'];
        

        $sql = "INSERT INTO `iklan`(`isi_iklan`, `status_aktif`) VALUES ('".$isiIklan."','0')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Insert Iklan berhasil dilakukan');</script>";
        } else {
            echo "<script>alert('".$isiIklan."');</script>";
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
        $conn->close();
        // echo 
    }

    function checkFollow(){
        $conn = konekin();
        
        $id=$_SESSION['logged'];

         if(isset($_GET['followBtn'])){  
            $profileId=$_SESSION['profileId'];
            $query = mysqli_query($conn, "select email from member where username='".$profileId."'");
            while($row = mysqli_fetch_array($query)){
                $emailFriend=$row[0];
            }             
                if($_GET['followBtn']=='follow'){
                    $sql = "INSERT INTO `relation_list` (`email_owner`, `email_follow`) VALUES ('$id', '$emailFriend');";

                    if ($conn->query($sql) === TRUE) {
                        // echo "New record created successfully";
                    } else {
                        echo "Error: " . $sql . "<br>" . $conn->error;
                    }
                    $conn->close();
                    // echo "follow";
                }elseif($_GET['followBtn']=='unfollow'){    
                    $sql = "DELETE FROM `relation_list` WHERE email_follow='" .$emailFriend ."' and email_owner='$id';";

                    if ($conn->query($sql) === TRUE) {
                        // echo "Record deleted successfully";
                        // echo $sql;
                    } else {
                        echo "Error deleting record: " . $conn->error;
                    }
                    $conn->close(); 
                }  
         }
    }
    function takeEmail($profileId){
        $conn = Konekin();
        $query = mysqli_query($conn, "select email from member where username='".$profileId."'");
        while($row = mysqli_fetch_array($query)){
            $emailFriend=$row[0];
        }
        return $emailFriend;
    }

    function showPhoto(){
        $conn = Konekin();
        $id=$_SESSION['logged'];
        
        $query = mysqli_query($conn, "select foto_profile from member where email='$id'");
          while($row = mysqli_fetch_array($query)){
              echo "<img src='data:image/jpeg;base64,".base64_encode($row[0])."' id='pp' width='250px' height='250px'/>";
          }
    }
    function showPhotofriend($profileId){
        $conn = konekin();

        $query = mysqli_query($conn, "select email from member where username='".$profileId."'");
        while($row = mysqli_fetch_array($query)){
            $emailFriend=$row[0];
        }
       
        $query = mysqli_query($conn, "select foto_profile from member where email='$emailFriend'");
          while($row = mysqli_fetch_array($query)){
              echo "<img src='data:image/jpeg;base64,".base64_encode($row[0])."' id='pp' width='250px' height='250px'/>";
          }
   
        }
    function logout(){
        echo "<script>alert('logout dilakukan');</script>";
    }
    
    function showprofile(){
        $conn = Konekin();
        
        $id=$_SESSION['logged'];
        
        $query = mysqli_query($conn, "select * from member where email='".$id."'");
        while($row = mysqli_fetch_assoc($query)){
            $username=$row['username'];
            $bio=$row['bio'];
            $pp=$row['foto_profile'];
            $phone=$row['phone_number'];
     
            $nama=$row['nama'];
        }
        $query = mysqli_query($conn, "select count(email) from post where email='$id'");
        while($row = mysqli_fetch_array($query)){
            $totalPost=$row[0];
        }
        $query = mysqli_query($conn, "select count(email_owner) from relation_list where email_owner='$id'");
        while($row = mysqli_fetch_array($query)){
            $totalFollowing=$row[0];
        }
        $query = mysqli_query($conn, "select count(email_follow) from relation_list where email_follow='$id'");
        while($row = mysqli_fetch_array($query)){
            $totalFollower=$row[0];
        }
        echo "<label id='username'>".$username."</label>&nbsp;&nbsp;&nbsp;
        <button class='btn-sm' id='gotoprofile' onclick='href=''>Edit profile</button>

          <!-- 3dot setting -->
          <div class='navbar-header'>
            <div id='3dot' class='test'>
            
            </div>
          </div>
          <form method='post'>
          <div class='popup' onclick='myFunction()'>
              <span class='popuptext' id='myPopup'>
                  <div id='block'><button type='submit' name='logout' class='btn-xs'>LogOut</button></div>
                  <div id='changePass'><button onclick='location.href='http://localhost/!probis/probis2-master/landing/changePassword.php'' class='btn-xs'>Change Password</button></div>
              </span>
          </div>
        </form>
          <!-- end 3 dot -->
          <br>
          <br>
        <label id='totalPost'>".$totalPost."</label>&nbsp;Post 
        <label id='totalFollower'>".$totalFollower."</label>&nbsp;Follower 
        <label id='totalFollowing'>".$totalFollowing."</label>&nbsp;Following 
        <br>
        <label id='nama'>$nama</label><br>
        <div id='bio'>".$bio."
        </div>
        <label id='phonenumber'>".$phone."</label>";
    }
    function prevStalk($profileId,$emailFriend){
        $conn = Konekin();
        // diisi emailowner pemilik profile
        $query = mysqli_query($conn, "SELECT COUNT(email_view) FROM detail_stalk WHERE email_owner='".$emailFriend."'");
        
        while($row = mysqli_fetch_array($query)){
            $prevStalk=$row[0];
        }
    }

    function tambahStalk($emailFriend,$emailowner){
        $conn=konekin();
        
        $time= date("Y-m-d H:i:s");
        $sql = "INSERT INTO `detail_stalk`(`email_owner`, `email_view`,`ti_me`) VALUES ('".$emailFriend."','".$emailowner."','".$time."')";

        if ($conn->query($sql) === TRUE) {
            // echo "<script>alert('Anda telah menstalk');</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
    function showStalk($emailowner){
        $conn=konekin();
        $query = mysqli_query($conn, "select email_view,ti_me from detail_stalk where email_owner='".$emailowner."'");
        
        while($row = mysqli_fetch_array($query)){
            $emailWhoStalk=$row[0];
            $timeStalk=$row[1];
            
        echo "<tr>
            <td>$emailWhoStalk</td>
            <td>$timeStalk</td>
        </tr>";
        }
    }
    function showprofilefriend($profileId){
        $conn = Konekin();
        
        $emailowner=$_SESSION['logged'];

        if(isset($_GET['profileId'])){
            $profileId=$_GET['profileId'];
        }
        
        $_SESSION['profileId']=$profileId;
   
        $query = mysqli_query($conn, "select email from member where username='".$profileId."'");
        
        while($row = mysqli_fetch_array($query)){
            $emailFriend=$row[0];
        }

        if($emailFriend==""){
            // echo "<script>alert('username tidak ditemukan');</script>";
        }else{
            prevStalk($profileId,$emailFriend);
            tambahStalk($emailFriend,$emailowner);
            echo "<form method='GET'>";
            $query = mysqli_query($conn, "select * from member where email='$emailFriend'");
            while($row = mysqli_fetch_assoc($query)){
                $username=$row['username'];
                $bio=$row['bio'];
                $pp=$row['foto_profile'];
                $phone=$row['phone_number'];
                $nama=$row['nama'];
            }
            $query = mysqli_query($conn, "select count(email) from post where email='$emailFriend'");
            while($row = mysqli_fetch_array($query)){
                $totalPost=$row[0];
            }
            $query = mysqli_query($conn, "select count(email_owner) from relation_list where email_owner='$emailFriend'");
            while($row = mysqli_fetch_array($query)){
                $totalFollowing=$row[0];
            }
            $query = mysqli_query($conn, "select count(email_follow) from relation_list where email_follow='$emailFriend'");

            while($row = mysqli_fetch_array($query)){
                $totalFollower=$row[0];
                
            }
            echo "<label id='username'>".$username."</label>&nbsp;&nbsp;&nbsp;";
            // email owner diisi email yg login
            // email follow diisi email profile

            $query = mysqli_query($conn, "select email_owner FROM relation_list WHERE EMAIL_FOLLOW='".$emailFriend."' and email_owner='".$emailowner."';");
            $var="";
            while($row = mysqli_fetch_row($query)){
        /*     kalau 0 berarti sudah difollow*/
                $var=$row[0];
            }
            if($var==""){
                echo "<button type='submit' class='btn-sm' name='followBtn' value='follow'>Follow</button>";
            }else{
                echo "<button type='submit' class='btn-sm' name='followBtn' value='unfollow'>Following</button>";
            }
            echo "
            <!-- 3dot setting -->
                <div class='navbar-header'>
                <div id='3dot' class='test'>
                </div>
                </div>
                <div class='popup' onclick='myFunction()'>
                    <span class='popuptext' id='myPopup'>
                        <div id='block'><button action='' class='btn-xs'>Block</button></div>
                    </span>
                </div>

            <!-- end 3 dot -->
            <br>
            <br>
            <label id='totalPost'>".$totalPost."</label>&nbsp;Post 
            <label id='totalFollower'>".$totalFollower."</label>&nbsp;Follower 
            <label id='totalFollowing'>".$totalFollowing."</label>&nbsp;Following 
            <br>
            <label id='nama'>$nama</label><br>
            <div id='bio'>".$bio."
            </div>
            <label id='phonenumber'>".$phone."</label>";
            echo "</form>";
         }
    }

    function showprofilepostfriend($profileId){
        $conn = Konekin();
        if(isset($_GET['profileId'])){
            $profileId=$_GET['profileId'];
        }

        $query = mysqli_query($conn, "select email from member where username='".$profileId."'");
        while($row = mysqli_fetch_array($query)){
            $emailFriend=$row[0];
        }

        $query = mysqli_query($conn, "select * from post where email='$emailFriend'");
        while($row = mysqli_fetch_assoc($query)){
            echo"<div class='col-md-4' >
            <img src='data:image/jpeg;base64,". base64_encode($row['foto'])."' id='photo1' class='post' width='250px' height='250px;'/>
            <div id='totalLike'>
            </div>
            <!-- <div id='caption'>
              Post 1
            </div> -->
          </div>";
        }
    }

    function showprofilepost(){
        $conn = Konekin();
         $id=$_SESSION['logged'];
        $query = mysqli_query($conn, "select * from post where email='$id'");
            
        while($row = mysqli_fetch_assoc($query)){
            echo"<div class='col-md-4' >";
            echo"
            <img src='data:image/jpeg;base64,". base64_encode($row['foto'])."' id='photo1' class='post' width='250px' height='250px;'/>
            <div id='totalcomment'>
                ".$row['total_comment']."
            </div>
            <!-- <div id='caption'>
              Post 1
            </div> -->
          ";
          echo "</div>";
        }
    }

    //Separator Rupih
    function makeRupiah($bilangan){
        $rupiah = "Rp " . number_format($bilangan,0,',','.');
        return $rupiah;
    }
    


    //UNTUK MENGIRIM EMAIL
    function sendmail($kirim, $pesan, $judul, $balas){
        require '../PHPMailer/PHPMailerAutoload.php';
        $mail = new PHPMailer;
        
//      $mail->SMTPDebug = 2;                               // Enable verbose debug

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'cinemasmovieplex@gmail.com';                 // SMTP username
        $mail->Password = 'JJACmovie';                           // SMTP password
        $mail->SMTPSecure = 'tls';              // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;  
        
        $mail->setFrom('cateringnyamnyam@gmail.com', $judul);
        $mail->addAddress($kirim, 'Hai !');     // Add a recipient
        $mail->addReplyTo($balas, 'Catering Nyam-Nyam');
        $mail->addCC('cateringnyamnyam@gmail.com');
        $mail->addBCC('cateringnyamnyam@gmail.com');
        
        // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        // $mail->isHTML(true);                                  // Set email format
        
        $mail->Subject = $judul;
        $mail->Body    = $pesan;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        if(!$mail->send()) {
            echo "<script>alert('Pesan Tidak Terkirim');</script>";
            $error = $mail->ErrorInfo;

        } else {
            echo "<script>alert('Pesan Sudah Terkirim');</script>";
        }
    }
    function PesanBaru($kirim){
        require '../PHPMailer/PHPMailerAutoload.php';
        $mail = new PHPMailer;
        
//        $mail->SMTPDebug = 2;                               // Enable verbose debug output

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'cinemasmovieplex@gmail.com';                 // SMTP username
        $mail->Password = 'JJACmovie';                           // SMTP password
        $mail->SMTPSecure = 'tls';              // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;  
        
        $mail->setFrom('cateringnyamnyam@gmail.com', 'Olaaa !');
        $mail->addAddress($kirim, 'Hai !');     // Add a recipient
        $mail->addReplyTo('cateringnyamnyam@gmail.com', 'Catering Nyam-Nyam');
        $mail->addCC('cateringnyamnyam@gmail.com');
        $mail->addBCC('cateringnyamnyam@gmail.com');
        
        // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        // $mail->isHTML(true);                                  // Set email format to HTML
        
        $mail->Subject = 'Selamat Datang Member di Nyam-Nyam';
        $mail->Body    = "
        <table style='border-collapse: collapse; font-family: Arial,sans-serif; font-weight: normal; margin: 0 auto; width: 600px;' border='0' width='600' cellspacing='0' cellpadding='0' align='center'>
        <tbody>
        <tr>
        <td style='border-collapse: collapse; margin: 0; max-width: 600px;'>
        <table style='border-collapse: collapse; font-family: Roboto,Arial; font-weight: normal; margin: 0 auto; width: 600px;' border='0' width='600' cellspacing='0' cellpadding='0' align='center'>
        <tbody>
        <tr>
        <td style='width: 100%; border-collapse: collapse; color: #b0bec5; font-family: Roboto,arial; font-size: 10px; font-weight: normal; line-height: 11px; padding-bottom: 10px; padding-top: 24px;' align='center' width='100%'>Hubungi Customer Service untuk permasalahan akun anda | 031 503 6160</td>
        </tr>
        <tr>
        <td style='line-height: 0px; padding-bottom: 7px;' align='center'><img src='https://ci3.googleusercontent.com/proxy/ziFajG5dlmmjM6ehY553SVbyNjqCdNQRRiHl10Nigw0RFBcv_aENOzNE1WGbAsbizDcvcDJd9x2zzwjn1YKUMVX23jh8ieSForjLbRaLRvbG_gA0fSDFLNH8mF--=s0-d-e1-ft#https://services.google.com/fh/files/emails/gcp_grayplainborderline.png' alt='' width='61' height='2' /></td>
        </tr>
        </tbody>
        </table>
        </td>
        </tr>
        <tr>
        </tr>
        <tr>
        <td style='border-collapse: collapse; margin: 0;' bgcolor='#eceff1'>
        <table style='border-collapse: collapse; font-family: Roboto,Arial; font-weight: normal; margin: 0 auto; width: 100%;' border='0' width='100%' cellspacing='0' cellpadding='0' align='center'>
        <tbody>
        <tr>
        <td style='border-collapse: collapse; color: #607d8b; font-family: Roboto,arial; font-size: 12px; line-height: 14px; padding-bottom: 10px; padding-top: 9px; padding-left: 32px;'><span style='font-weight: 500;'>Surabaya, Indonesia 2017</span></td>
        </tr>
        </tbody>
        </table>
        </td>
        </tr>
        <tr>
        <td style='background-image: url('https://ci5.googleusercontent.com/proxy/QW6X9nb2ojkLjawl-oRROlOov0BcVg6tdBoC5QlZxM8MuoE5O9M95QB31WXTvfVfPbAxTjHusP1n6WRGsdtVkaEUPgI3NFS0bSi3LhjgSrABx_Wu_Gv50Dq3dbt7evE=s0-d-e1-ft#http://services.google.com/fh/files/emails/cloud_partner_hero_desktop.png'); background-repeat: no-repeat; border-collapse: collapse; display: block; margin: 0; padding: 0; height: 100%!important;' valign='top' bgcolor='#151123' width='100%' height='265'>
        <div style='height: auto; margin: 0 auto; width: 100%;'>
        <table style='border-collapse: collapse; font-family: Roboto,Arial; font-weight: normal; margin: auto; width: 100%;' border='0' width='100%' cellspacing='0' cellpadding='0' align='center'>
        <tbody>
        <tr>
        <td style='padding-left: 50px; border-collapse: collapse; padding-bottom: 21px; padding-top: 31px; text-align: left; color: #ffffff; font-size: 12px; line-height: 24px;' align='left'><img src='https://1.bp.blogspot.com/-YkwfSwvrtKc/WjkfoOO96nI/AAAAAAAAHPo/GN8MYVr9DpcDvQ-cRhqBoZmTlQLgMIAgwCK4BGAYYCw/s200/logoputihpanjang.png' alt='' width='153' height='51' /></td>
        </tr>
        <tr>
        <td style='border-collapse: collapse; color: #ffffff; font-family: Roboto,arial; font-size: 24px; line-height: 28px; font-weight: normal; padding: 3px 50px 0px 50px; text-align: left;' align='left'>Pemesanan Tanpa Batas</td>
        </tr>
        <tr>
        <td style='border-collapse: collapse; color: #ffffff; font-family: Roboto,arial; font-size: 16px; line-height: 24px; font-weight: normal; padding: 3px 50px 22px 50px; text-align: left;' align='left'>Surabaya | We Are Open 10:00am - 11:00pm</td>
        </tr>
        <tr>
        <td style='border-collapse: collapse; padding-bottom: 32px; padding-left: 50px;' align='left'>
        <table style='margin: auto; border-collapse: collapse; border-radius: 3px; color: #2979ff; font-family: Roboto,Arial; font-weight: normal;' cellspacing='0' cellpadding='0' align='left' bgcolor='#2979ff'>
        </table>
        </td>
        </tr>
        </tbody>
        </table>
        </div>
        </td>
        </tr>
        <tr>
        <td style='padding-bottom: 64px; border-collapse: collapse; margin: 0; max-width: 600px;'>
        <table style='border-collapse: collapse; font-family: Roboto,Arial; font-weight: normal; margin: 0 auto; width: 536px;' border='0' width='536' cellspacing='0' cellpadding='0' align='center'>
        <tbody>
        <tr>
        <td style='border-collapse: collapse; color: #607d8b; font-family: Roboto,arial; font-size: 14px; font-weight: normal; line-height: 24px; padding-bottom: 9px; padding-top: 23px; text-align: left;'>
        <div>
        <div>
        <div>All materials and contents (texts, graphics, and every attributes) of Nyam-Nyam or Nyam-Nyam website are copyrights and trademarks of Nyam-Nyam.com.</div>
        </div>
        </div>
        </td>
        </tr>
        <tr>
        </tr>
        </tbody>
        </table>
        <table style='border-collapse: collapse; font-family: Roboto,Arial; font-weight: normal; margin: 0 auto; width: 536px;' border='0' width='536' cellspacing='0' cellpadding='0' align='center'>
        <tbody>
        <tr>
        <td style='border-collapse: collapse; color: #607d8b; font-family: Roboto,arial; font-size: 20px; font-weight: bold; line-height: 32px; padding-bottom: 22px; padding-top: 19px; text-align: center;'>Selamat Datang</td>
        </tr>
        <tr>
        </tr>
        <tr>
        <td style='border-collapse: collapse; color: #607d8b; font-family: Roboto,arial; font-size: 14px; font-weight: normal; line-height: 24px; padding-bottom: 30px; padding-top: 1px;'>
        <div>
        <div>
        <div>
        <div>Anda dapat memulai pemesanan mulai sekarang akun anda sudah dapat di gunakan dan dapatkan pesanan makanan yang anda inginkan ! Gracias !</div>
        </div>
        </div>
        </div>
        </td>
        </tr>
        </tbody>
        </table>
        <table style='border-collapse: collapse; font-family: Roboto,Arial; font-weight: normal; margin: 0 auto; width: 536px;' border='0' width='536' cellspacing='0' cellpadding='0' align='center'>
        <tbody>
        <tr>
        <td style='border-collapse: collapse;'>
        <table style='width: 100%;' width='100%' cellspacing='0' cellpadding='0'>
        <tbody>
        <tr>
        <td style='width: 40%; border-collapse: collapse;' align='center'>
        <table style='margin: auto; border-collapse: collapse; border-radius: 3px; color: #2979ff; font-family: Roboto,Arial; font-weight: normal;' cellspacing='0' cellpadding='0' align='center' bgcolor='#2979ff'>
        <tbody>
        <tr>
        <td style='border-collapse: collapse;'><a style='background-color: #2979ff; border-bottom-left-radius: 3px; border-bottom-right-radius: 0; border-color: #2979ff; border-radius: 3px; border-style: solid; border-top-left-radius: 3px; border-top-right-radius: 0; border-width: 9px 0px 5px 17px; color: #ffffff; display: inline-block; font-family: Roboto,Arial; font-size: 14px; font-weight: 500; line-height: 18px; margin: 0; text-align: center; text-decoration: none;' href='https://www.google.com/appserve/mkt/p/MejsfAta-IjVfNjLQ72EpgWaeTi-eHMoTrQAdqEusD45Gw6bBoN0QaYA7q_mOgPn3yigQGCKMTXI16OowzZdOEUvQCIGhnCXRueRKUqm_zZhf2yVB7aUMbu6K_4_Ewe-JLZQVvaD7Kp53qsLYQIjj4JH9L3Hek3179BQgDxPiSCeEalkgXoeaK18nk13rMJdaZ88wp1lpl0qWbo-HkiViha8D8cREpn1EaE=' target='_blank' data-saferedirecturl='https://www.google.com/url?hl=id&amp;q=https://www.google.com/appserve/mkt/p/MejsfAta-IjVfNjLQ72EpgWaeTi-eHMoTrQAdqEusD45Gw6bBoN0QaYA7q_mOgPn3yigQGCKMTXI16OowzZdOEUvQCIGhnCXRueRKUqm_zZhf2yVB7aUMbu6K_4_Ewe-JLZQVvaD7Kp53qsLYQIjj4JH9L3Hek3179BQgDxPiSCeEalkgXoeaK18nk13rMJdaZ88wp1lpl0qWbo-HkiViha8D8cREpn1EaE%3D&amp;source=gmail&amp;ust=1497607428273000&amp;usg=AFQjCNEVnDsHodllaHUTGvDc8R9X_mrW2A'> <span style='display: block;'><img style='border: none; outline: none; text-decoration: none; width: 23px; height: 21px;' src='https://ci6.googleusercontent.com/proxy/ddDUyuXVascFQ_0qw64oQiE6THS70BacGjW3la8aPTdYJDUuOUvZwzzz2qpQNtow0fZdOlmZDe9vTRp6DtzaQxKYCMrOYuF9JuPydqY6STFR=s0-d-e1-ft#http://services.google.com/fh/files/emails/gcp_cta_icon.png' alt='' width='23' height='21' /></span> </a></td>
        <td style='border-collapse: collapse;'><a style='background-color: #2979ff; border-bottom-left-radius: 0; border-bottom-right-radius: 3px; border-color: #2979ff; border-radius: 3px; border-style: solid; border-top-left-radius: 0; border-top-right-radius: 3px; border-width: 10px 17px 10px 10px; color: #ffffff; display: inline-block; font-family: Roboto,Arial; font-size: 14px; font-weight: 500; line-height: 18px; margin: 0; text-align: center; text-decoration: none;' href='http://localhost/probis2/landing'> <span style='display: block; padding-left: 6px; padding-right: 6px;'>Masuk</span> </a></td>
        </tr>
        </tbody>
        </table>
        </td>
        </tr>
        </tbody>
        </table>
        </td>
        </tr>
        </tbody>
        </table>
        </td>
        </tr>
        <tr>
        <td style='background-color: #ffffff; border-collapse: collapse; margin: 0; max-width: 600px; padding-top: 36px; height: 4px; font-size: 0;' bgcolor='#f6f8fa'>
        <table style='border-collapse: collapse; font-family: Roboto,Arial; font-weight: normal; margin: 0 auto; width: 568px;' border='0' width='568' cellspacing='0' cellpadding='0' align='center'>
        <tbody>
        <tr>
        <td style='border-collapse: collapse; height: 4px; line-height: 4px; margin: 0; padding: 0; text-align: right; vertical-align: bottom;' align='right' valign='bottom' height='4'><img style='line-height: 4px; margin: 0; outline: none; padding: 0; text-decoration: none; vertical-align: bottom;' src='https://ci4.googleusercontent.com/proxy/-6Aq9G4rubJjhtE5_QMl98n1Qv-O68BOEtWJX5XFc13Qk4GrqKziohUWtGKFswtR5tWYxo73Fsp49MnV7EpMzGDDAM47TfjLfbKTXvgoGELPQc-yWQZYdC6IumLBrf44Fw=s0-d-e1-ft#http://services.google.com/fh/files/emails/gcp_newsletter_signature_bar.png' alt='' width='136' height='4' /></td>
        </tr>
        </tbody>
        </table>
        </td>
        </tr>
        <tr>
        <td style='background: #2d3a3f; border-collapse: collapse; margin: 0; max-width: 600px;'>
        <table style='border-collapse: collapse; font-family: Roboto,Arial; font-weight: normal; margin: 0 auto; width: 600px; background: #2d3a3f;' border='0' width='600' cellspacing='0' cellpadding='0' align='center'>
        <tbody>
        <tr>
        <td style='background: #37474f; border-collapse: collapse; margin: 0; max-width: 536px; padding: 14px 32px 12px 32px;'>
        <table style='border-collapse: collapse; font-family: Roboto,Arial; font-weight: normal; margin: 0 auto; width: 536px;' border='0' width='536' cellspacing='0' cellpadding='0' align='center'>
        <tbody>
        <tr>
        <td style='border-collapse: collapse; color: #ffffff; font-family: Roboto,arial; font-size: 15px; font-weight: 500;'>
        <table style='border-collapse: collapse; font-family: Roboto,Arial; font-weight: normal; margin: 0 auto; width: 400px;' border='0' width='400' cellspacing='0' cellpadding='0' align='left'>
        <tbody>
        <tr>
        <td style='border-collapse: collapse; color: #ffffff; font-family: Roboto,arial; font-size: 15px; font-weight: 500;'>Not subscribed to our newsletter yet? <a style='color: #2979ff; text-decoration: none; white-space: nowrap;' href='localhost/probis2/landing/login.php' target='_blank' data-saferedirecturl='#'>Sign in</a></td>
        </tr>
        </tbody>
        </table>
        <table style='border-collapse: collapse; font-family: Roboto,Arial; font-weight: normal; margin: 0 auto; width: 112px;' border='0' width='112' cellspacing='0' cellpadding='0' align='right'>
        <tbody>
        <tr>
        <td style='padding-right: 12px; border-collapse: collapse; color: #ffffff; font-family: Roboto,arial; font-size: 15px; font-weight: 500;' width='20'><img style='outline: none; text-decoration: none;' src='https://ci6.googleusercontent.com/proxy/3xumwASXTquIfQszbuEIXXP3ZFZ5QXHIZ94CrXeyvCZdeN77dAW0o7yCOekGbMnyFfsdLmxyM_NUn8hduDbFwleRotcCyYFBmDdqNRWlQAdXjOKpwBdIl-zAhFzxcMcdMOzz4wc=s0-d-e1-ft#http://services.google.com/fh/files/emails/gcp_newsletter_oct_feedback_icon.png' alt='Feedback' width='20' /></td>
        <td style='padding-bottom: 10px; border-collapse: collapse; color: #2979ff; font-size: 15px; font-family: roboto,arial; font-weight: 500; text-align: left;' width='92'><a style='color: #2979ff; font-size: 15px; text-decoration: none;' href='localhost/probis2/landing/contact.php'>Feedback</a></td>
        </tr>
        </tbody>
        </table>
        </td>
        </tr>
        </tbody>
        </table>
        </td>
        </tr>
        <tr>
        <td style='background-color: #2d3a3f; border-collapse: collapse; margin: 0; max-width: 600px;' bgcolor='#2d3a3f'>
        <table style='border-collapse: collapse; font-family: Roboto,Arial; font-weight: normal; margin: 0 auto; width: 600px;' border='0' width='600' cellspacing='0' cellpadding='0' align='center'>
        <tbody>
        <tr>
        <td style='border-collapse: collapse; color: #90a4ae; font-size: 10px; line-height: 18px; padding: 17px 32px 40px 32px; padding-bottom: 5px;'>&copy; 2017 Nyam-Nyam.com Inc. Surabaya, Ngagel Jaya Tengah 56, 60286&nbsp;<br /><br />Email ini dikirim untuk konfirmasi pendaftaran email anda, sehingga dapat diverifikasi sebagai akun yang valid.<br /><br /></td>
        </tr>
        <tr>
        <td style='border-collapse: collapse; padding: 23px 0 31px 0;'>
        </td>
        </tr>
        </tbody>
        </table>
        </td>
        </tr>
        </tbody>
        </table>
        </td>
        </tr>
        </tbody>
        </table>";
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        if(!$mail->send()) {
            $error = $mail->ErrorInfo;
        }
    }


    //Mengirim Email Konfirmasi Pembayaran
    function PesanPembayaran($kirim,$nama_menu,$harga,$nama_lengkap,$alamat,$deskripsi,$tambah_kuota,$tanggal_kirim,$keterangan){
        require '../PHPMailer/PHPMailerAutoload.php';
        $mail = new PHPMailer;
        
//        $mail->SMTPDebug = 2;                               // Enable verbose debug output

        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = 'cinemasmovieplex@gmail.com';                 // SMTP username
        $mail->Password = 'JJACmovie';                           // SMTP password
        $mail->SMTPSecure = 'tls';              // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;  
        
        $mail->setFrom('cateringnyamnyam@gmail.com', 'Hola!! Konfirmasi Pembayaran Anda !');
        $mail->addAddress($kirim, 'Hai !');     // Add a recipient
        $mail->addReplyTo('cateringnyamnyam@gmail.com', 'Hola!! Konfirmasi Pembayaran');
        $mail->addCC('cateringnyamnyam@gmail.com');
        $mail->addBCC('cateringnyamnyam@gmail.com');
        
        // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
        // $mail->isHTML(true);                                  // Set email format to HTML
        
        $mail->Subject = 'Kurang Sedikit lagi Nikmati Makanan anda !';
        $mail->Body    = "
        <table style='border-collapse: collapse; font-family: Arial,sans-serif; font-weight: normal; margin: 0 auto; width: 600px;' border='0' width='600' cellspacing='0' cellpadding='0' align='center'>
        <tbody>
        <tr>
        <td style='border-collapse: collapse; margin: 0; max-width: 600px;'>
        <table style='border-collapse: collapse; font-family: Roboto,Arial; font-weight: normal; margin: 0 auto; width: 600px;' border='0' width='600' cellspacing='0' cellpadding='0' align='center'>
        <tbody>
        <tr>
        <td style='width: 100%; border-collapse: collapse; color: #b0bec5; font-family: Roboto,arial; font-size: 10px; font-weight: normal; line-height: 11px; padding-bottom: 10px; padding-top: 24px;' align='center' width='100%'>Hubungi Customer Service untuk permasalahan akun anda | 031 503 6160</td>
        </tr>
        <tr>
        <td style='line-height: 0px; padding-bottom: 7px;' align='center'><img src='https://ci3.googleusercontent.com/proxy/ziFajG5dlmmjM6ehY553SVbyNjqCdNQRRiHl10Nigw0RFBcv_aENOzNE1WGbAsbizDcvcDJd9x2zzwjn1YKUMVX23jh8ieSForjLbRaLRvbG_gA0fSDFLNH8mF--=s0-d-e1-ft#https://services.google.com/fh/files/emails/gcp_grayplainborderline.png' alt='' width='61' height='2' /></td>
        </tr>
        </tbody>
        </table>
        </td>
        </tr>
        <tr>
        </tr>
        <tr>
        <td style='border-collapse: collapse; margin: 0;' bgcolor='#eceff1'>
        <table style='border-collapse: collapse; font-family: Roboto,Arial; font-weight: normal; margin: 0 auto; width: 100%;' border='0' width='100%' cellspacing='0' cellpadding='0' align='center'>
        <tbody>
        <tr>
        <td style='border-collapse: collapse; color: #607d8b; font-family: Roboto,arial; font-size: 12px; line-height: 14px; padding-bottom: 10px; padding-top: 9px; padding-left: 32px;'><span style='font-weight: 500;'>Surabaya, Indonesia 2017</span></td>
        </tr>
        </tbody>
        </table>
        </td>
        </tr>
        <tr>
        <td style='background-image: url('https://ci5.googleusercontent.com/proxy/QW6X9nb2ojkLjawl-oRROlOov0BcVg6tdBoC5QlZxM8MuoE5O9M95QB31WXTvfVfPbAxTjHusP1n6WRGsdtVkaEUPgI3NFS0bSi3LhjgSrABx_Wu_Gv50Dq3dbt7evE=s0-d-e1-ft#http://services.google.com/fh/files/emails/cloud_partner_hero_desktop.png'); background-repeat: no-repeat; border-collapse: collapse; display: block; margin: 0; padding: 0; height: 100%!important;' valign='top' bgcolor='#151123' width='100%' height='265'>
        <div style='height: auto; margin: 0 auto; width: 100%;'>
        <table style='border-collapse: collapse; font-family: Roboto,Arial; font-weight: normal; margin: auto; width: 100%;' border='0' width='100%' cellspacing='0' cellpadding='0' align='center'>
        <tbody>
        <tr>
        <td style='padding-left: 50px; border-collapse: collapse; padding-bottom: 21px; padding-top: 31px; text-align: left; color: #ffffff; font-size: 12px; line-height: 24px;' align='left'><img src='https://1.bp.blogspot.com/-YkwfSwvrtKc/WjkfoOO96nI/AAAAAAAAHPo/GN8MYVr9DpcDvQ-cRhqBoZmTlQLgMIAgwCK4BGAYYCw/s200/logoputihpanjang.png' alt='' width='153' height='51' /></td>
        </tr>
        <tr>
        <td style='border-collapse: collapse; color: #ffffff; font-family: Roboto,arial; font-size: 24px; line-height: 28px; font-weight: normal; padding: 3px 50px 0px 50px; text-align: left;' align='left'>Konfirmasi Pesanan Anda, Segera !</td>
        </tr>
        <tr>
        <td style='border-collapse: collapse; color: #ffffff; font-family: Roboto,arial; font-size: 16px; line-height: 24px; font-weight: normal; padding: 3px 50px 22px 50px; text-align: left;' align='left'>". $nama_menu ."</td>
        </tr>
        <tr>
        <td style='border-collapse: collapse; padding-bottom: 32px; padding-left: 50px;' align='left'>
        <table style='margin: auto; border-collapse: collapse; border-radius: 3px; color: #2979ff; font-family: Roboto,Arial; font-weight: normal;' cellspacing='0' cellpadding='0' align='left' bgcolor='#2979ff'>
        </table>
        </td>
        </tr>
        </tbody>
        </table>
        </div>
        </td>
        </tr>
        <tr>
        <td style='padding-bottom: 64px; border-collapse: collapse; margin: 0; max-width: 600px;'>
        <table style='border-collapse: collapse; font-family: Roboto,Arial; font-weight: normal; margin: 0 auto; width: 536px;' border='0' width='536' cellspacing='0' cellpadding='0' align='center'>
        <tbody>
        <tr>
        <td style='border-collapse: collapse; color: #607d8b; font-family: Roboto,arial; font-size: 14px; font-weight: normal; line-height: 24px; padding-bottom: 9px; padding-top: 23px; text-align: left;'>
        <div>
        <div>
        <div>All materials and contents (texts, graphics, and every attributes) of Nyam-Nyam or Nyam-Nyam website are copyrights and trademarks of Nyam-Nyam.com.</div>
        </div>
        </div>
        </td>
        </tr>
        <tr>
        </tr>
        </tbody>
        </table>
        <table style='border-collapse: collapse; font-family: Roboto,Arial; font-weight: normal; margin: 0 auto; width: 536px;' border='0' width='536' cellspacing='0' cellpadding='0' align='center'>
        <tbody>
        <tr>
        <td style='border-collapse: collapse; color: #607d8b; font-family: Roboto,arial; font-size: 20px; font-weight: bold; line-height: 32px; padding-bottom: 22px; padding-top: 19px; text-align: center;'>Konfirmasi Pesanan</td>
        </tr>
        <tr>
        </tr>
        <tr>
        <td style='border-collapse: collapse; color: #607d8b; font-family: Roboto,arial; font-size: 14px; font-weight: normal; line-height: 24px; padding-bottom: 30px; padding-top: 1px;'>
        <div>
        <div>
        <div>
        <div>Untuk dapat memesan terlebih dahulu anda membayar tagihan pemesanan makanan anda, setelah itu dapat anda konfirmasi pembayaran anda. Informasi Pemesanan : <br><br>
        Nama : <b>". $nama_lengkap ."</b><br>
        Alamat : <b>". $alamat ."</b><br>
        Nama Menu : <b>". $nama_menu ."</b><br>
        Deskripsi : <b>". $deskripsi ."</b><br>
        Tambah Kuota : <b>". $tambah_kuota ."</b><br>
        Tanggal Kirim : <b>". $tanggal_kirim ."</b><br>
        Keterangan : <b>". $keterangan ."</b><br>
        Total Harga : <b>". $harga ."</b><br>
        
        </div>
        </div>
        </div>
        </div>
        </td>
        </tr>
        </tbody>
        </table>
        <table style='border-collapse: collapse; font-family: Roboto,Arial; font-weight: normal; margin: 0 auto; width: 536px;' border='0' width='536' cellspacing='0' cellpadding='0' align='center'>
        <tbody>
        <tr>
        <td style='border-collapse: collapse;'>
        <table style='width: 100%;' width='100%' cellspacing='0' cellpadding='0'>
        <tbody>
        <tr>
        <td style='width: 40%; border-collapse: collapse;' align='center'>
        <table style='margin: auto; border-collapse: collapse; border-radius: 3px; color: #2979ff; font-family: Roboto,Arial; font-weight: normal;' cellspacing='0' cellpadding='0' align='center' bgcolor='#2979ff'>
        <tbody>
        <tr>
        <td style='border-collapse: collapse;'><a style='background-color: #2979ff; border-bottom-left-radius: 3px; border-bottom-right-radius: 0; border-color: #2979ff; border-radius: 3px; border-style: solid; border-top-left-radius: 3px; border-top-right-radius: 0; border-width: 9px 0px 5px 17px; color: #ffffff; display: inline-block; font-family: Roboto,Arial; font-size: 14px; font-weight: 500; line-height: 18px; margin: 0; text-align: center; text-decoration: none;' href='https://www.google.com/appserve/mkt/p/MejsfAta-IjVfNjLQ72EpgWaeTi-eHMoTrQAdqEusD45Gw6bBoN0QaYA7q_mOgPn3yigQGCKMTXI16OowzZdOEUvQCIGhnCXRueRKUqm_zZhf2yVB7aUMbu6K_4_Ewe-JLZQVvaD7Kp53qsLYQIjj4JH9L3Hek3179BQgDxPiSCeEalkgXoeaK18nk13rMJdaZ88wp1lpl0qWbo-HkiViha8D8cREpn1EaE=' target='_blank' data-saferedirecturl='https://www.google.com/url?hl=id&amp;q=https://www.google.com/appserve/mkt/p/MejsfAta-IjVfNjLQ72EpgWaeTi-eHMoTrQAdqEusD45Gw6bBoN0QaYA7q_mOgPn3yigQGCKMTXI16OowzZdOEUvQCIGhnCXRueRKUqm_zZhf2yVB7aUMbu6K_4_Ewe-JLZQVvaD7Kp53qsLYQIjj4JH9L3Hek3179BQgDxPiSCeEalkgXoeaK18nk13rMJdaZ88wp1lpl0qWbo-HkiViha8D8cREpn1EaE%3D&amp;source=gmail&amp;ust=1497607428273000&amp;usg=AFQjCNEVnDsHodllaHUTGvDc8R9X_mrW2A'> <span style='display: block;'><img style='border: none; outline: none; text-decoration: none; width: 23px; height: 21px;' src='https://ci6.googleusercontent.com/proxy/ddDUyuXVascFQ_0qw64oQiE6THS70BacGjW3la8aPTdYJDUuOUvZwzzz2qpQNtow0fZdOlmZDe9vTRp6DtzaQxKYCMrOYuF9JuPydqY6STFR=s0-d-e1-ft#http://services.google.com/fh/files/emails/gcp_cta_icon.png' alt='' width='23' height='21' /></span> </a></td>
        <td style='border-collapse: collapse;'><a style='background-color: #2979ff; border-bottom-left-radius: 0; border-bottom-right-radius: 3px; border-color: #2979ff; border-radius: 3px; border-style: solid; border-top-left-radius: 0; border-top-right-radius: 3px; border-width: 10px 17px 10px 10px; color: #ffffff; display: inline-block; font-family: Roboto,Arial; font-size: 14px; font-weight: 500; line-height: 18px; margin: 0; text-align: center; text-decoration: none;' href='http://localhost/probis2/landing/kon-cfBreak.php'> <span style='display: block; padding-left: 6px; padding-right: 6px;'>Konfirmasi</span> </a></td>
        </tr>
        </tbody>
        </table>
        </td>
        </tr>
        </tbody>
        </table>
        </td>
        </tr>
        </tbody>
        </table>
        </td>
        </tr>
        <tr>
        <td style='background-color: #ffffff; border-collapse: collapse; margin: 0; max-width: 600px; padding-top: 36px; height: 4px; font-size: 0;' bgcolor='#f6f8fa'>
        <table style='border-collapse: collapse; font-family: Roboto,Arial; font-weight: normal; margin: 0 auto; width: 568px;' border='0' width='568' cellspacing='0' cellpadding='0' align='center'>
        <tbody>
        <tr>
        <td style='border-collapse: collapse; height: 4px; line-height: 4px; margin: 0; padding: 0; text-align: right; vertical-align: bottom;' align='right' valign='bottom' height='4'><img style='line-height: 4px; margin: 0; outline: none; padding: 0; text-decoration: none; vertical-align: bottom;' src='https://ci4.googleusercontent.com/proxy/-6Aq9G4rubJjhtE5_QMl98n1Qv-O68BOEtWJX5XFc13Qk4GrqKziohUWtGKFswtR5tWYxo73Fsp49MnV7EpMzGDDAM47TfjLfbKTXvgoGELPQc-yWQZYdC6IumLBrf44Fw=s0-d-e1-ft#http://services.google.com/fh/files/emails/gcp_newsletter_signature_bar.png' alt='' width='136' height='4' /></td>
        </tr>
        </tbody>
        </table>
        </td>
        </tr>
        <tr>
        <td style='background: #2d3a3f; border-collapse: collapse; margin: 0; max-width: 600px;'>
        <table style='border-collapse: collapse; font-family: Roboto,Arial; font-weight: normal; margin: 0 auto; width: 600px; background: #2d3a3f;' border='0' width='600' cellspacing='0' cellpadding='0' align='center'>
        <tbody>
        <tr>
        <td style='background: #37474f; border-collapse: collapse; margin: 0; max-width: 536px; padding: 14px 32px 12px 32px;'>
        <table style='border-collapse: collapse; font-family: Roboto,Arial; font-weight: normal; margin: 0 auto; width: 536px;' border='0' width='536' cellspacing='0' cellpadding='0' align='center'>
        <tbody>
        <tr>
        <td style='border-collapse: collapse; color: #ffffff; font-family: Roboto,arial; font-size: 15px; font-weight: 500;'>
        <table style='border-collapse: collapse; font-family: Roboto,Arial; font-weight: normal; margin: 0 auto; width: 400px;' border='0' width='400' cellspacing='0' cellpadding='0' align='left'>
        <tbody>
        <tr>
        <td style='border-collapse: collapse; color: #ffffff; font-family: Roboto,arial; font-size: 15px; font-weight: 500;'>Not subscribed to our newsletter yet? <a style='color: #2979ff; text-decoration: none; white-space: nowrap;' href='localhost/probis2/landing/login.php' target='_blank' data-saferedirecturl='#'>Sign in</a></td>
        </tr>
        </tbody>
        </table>
        <table style='border-collapse: collapse; font-family: Roboto,Arial; font-weight: normal; margin: 0 auto; width: 112px;' border='0' width='112' cellspacing='0' cellpadding='0' align='right'>
        <tbody>
        <tr>
        <td style='padding-right: 12px; border-collapse: collapse; color: #ffffff; font-family: Roboto,arial; font-size: 15px; font-weight: 500;' width='20'><img style='outline: none; text-decoration: none;' src='https://ci6.googleusercontent.com/proxy/3xumwASXTquIfQszbuEIXXP3ZFZ5QXHIZ94CrXeyvCZdeN77dAW0o7yCOekGbMnyFfsdLmxyM_NUn8hduDbFwleRotcCyYFBmDdqNRWlQAdXjOKpwBdIl-zAhFzxcMcdMOzz4wc=s0-d-e1-ft#http://services.google.com/fh/files/emails/gcp_newsletter_oct_feedback_icon.png' alt='Feedback' width='20' /></td>
        <td style='padding-bottom: 10px; border-collapse: collapse; color: #2979ff; font-size: 15px; font-family: roboto,arial; font-weight: 500; text-align: left;' width='92'><a style='color: #2979ff; font-size: 15px; text-decoration: none;' href='localhost/probis2/landing/contact.php'>Feedback</a></td>
        </tr>
        </tbody>
        </table>
        </td>
        </tr>
        </tbody>
        </table>
        </td>
        </tr>
        <tr>
        <td style='background-color: #2d3a3f; border-collapse: collapse; margin: 0; max-width: 600px;' bgcolor='#2d3a3f'>
        <table style='border-collapse: collapse; font-family: Roboto,Arial; font-weight: normal; margin: 0 auto; width: 600px;' border='0' width='600' cellspacing='0' cellpadding='0' align='center'>
        <tbody>
        <tr>
        <td style='border-collapse: collapse; color: #90a4ae; font-size: 10px; line-height: 18px; padding: 17px 32px 40px 32px; padding-bottom: 5px;'>&copy; 2017 Nyam-Nyam.com Inc. Surabaya, Ngagel Jaya Tengah 56, 60286&nbsp;<br /><br />Email ini dikirim untuk konfirmasi pembayaran pesanan anda, sehingga dapat kami kirim pesanan anda segera.<br /><br /></td>
        </tr>
        <tr>
        <td style='border-collapse: collapse; padding: 23px 0 31px 0;'>
        </td>
        </tr>
        </tbody>
        </table>
        </td>
        </tr>
        </tbody>
        </table>
        </td>
        </tr>
        </tbody>
        </table>";
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        if(!$mail->send()) {
            $error = $mail->ErrorInfo;
        }
    }
?>