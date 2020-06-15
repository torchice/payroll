<?php

$conn = mysqli_connect("localhost","root","","ftm");
if (mysqli_connect_errno()) {
    echo "Failed to connect to Database :" . mysqli_connect_error();
}
return $conn;
?>