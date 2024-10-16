<?php 
$con = mysqli_connect("localhost", "root", "", "user");

if(!$con) 
{
    die("Connection failed: " . mysqli_connect_error());
}
// else{
//     // echo "php active";
// }

?>