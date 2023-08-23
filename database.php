<?php

$hostName= "localhost";
$dbUser= "root";
$dbPassword="";
$dbName="student register";
$yo = mysqli_connect($hostName,$dbUser,$dbPassword,$dbName);
if (!$yo) {
    die("something went wrong ;");
}



?>