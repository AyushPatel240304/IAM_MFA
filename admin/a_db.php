<?php
    $conn =  mysqli_connect("localhost","root","","adm");

    if ($conn){
        echo "Connected";
    }
    else {
        die ("Error".mysqli_connect_error());
    }

?>