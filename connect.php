<?php
$host = "localhost";
$user = "root";
$pass = "1236789";
$dbname = "movie";

$con = mysqli_connect($host, $user, $pass, $dbname);
mysqli_query($con,"set char set utf8");
// if($con) {
//   echo '<span style="color: green;">ok</span>';
// } else {
//   echo '<span style="color: red;">Failed to connect to MySQL: ' . mysqli_connect_error() . '</span>';
// }
?>