<?php   //make server connection

$conn = mysqli_connect(SERVER, USERNAME, PASSWORD, DATABASE_NAME);
mysqli_set_charset($conn,"utf8");

?>