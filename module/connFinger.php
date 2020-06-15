<?php

$conn = mysqli_connect("localhost","root","3KJSvjbFRFTLdA76","ftm");
if (mysqli_connect_errno()) {
    echo "Failed to connect to Database :" . mysqli_connect_error();
}
return $conn;
?>