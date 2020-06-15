<?php 
    session_start(); 
    if (isset($_SESSION['is_logged'])){
        echo "
        <div class='top-bar tri-white-bottom'>
            <div class='container'>
                <div class='pull-right'>
                    <ul class='login-info'>
                        <li> <a>Hello, ". $_SESSION['email'] ."</a></li>
                        <li> <a href='logout.php'>LOGOUT</a> </li>
                    </ul>
                </div>
            </div>
        </div>";
    } else {
         echo "
        <div class='top-bar tri-white-bottom'>
            <div class='container'>
                <span class='numb'>O'Clock Social Website</span>
                <div class='pull-right'>
                    <ul class='login-info'>
                        <li> <a href='login.php'>Login</a> </li>
                        <li> <a href='register.php'>Register</a> </li>
                    </ul>
                </div>
            </div>
        </div>";
    }
    
?>

<!-- buat iklan -->
<html>
    <style>
     
    </style>
<header>
    <div class="sticky">
        <div class="container">
            <!-- Logo -->
            <!-- Navigation -->
            <nav class="navbar">
                <!-- NAV -->
                <ul class="nav-right">
                    <li class="scroll"><a href="index.php"></a><img src="images/foto1.jpg" width="100px" height="100px"></li>
                    <li class="scroll"><a href="menu.php"></a><img src="images/foto2.jpg" width="100px" height="100px"></li>
                    <li class="scroll"><a href="about.php"></a><img src="images/promo-img-1.jpg" width="100px" height="100px"></li>
                    <li class="scroll"><a href="contact.php"></a><img src="images/promo-img-2.jpg" width="100px" height="100px"></li>
                </ul>
            </nav>
        </div>
    </div>
</header>
</html>

