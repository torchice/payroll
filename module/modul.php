<?php
    session_start(); 
    // include('database.php');
//    $get_option="";


    function konekin(){
        $conn = mysqli_connect("localhost","root","","pabrik");
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

?>