<?php

    $connection = mysqli_connect("localhost", "root", "", "ticketing");

    if(!$connection)
    {
        die("Connection Failed: ".mysqli_connect_error());
    }
?>