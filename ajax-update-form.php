<?php

$id = $_POST["id"];
$first_name = $_POST["first_name"];
$lname = $_POST["last_name"];

$conn = mysqli_connect("localhost","root","","fetch_function") or die("NOt connect to database");
echo $sql = " UPDATE student SET first_name = {$first_name} , last_name = {$last_name} WHERE id = {$id} ";

if(mysqli_query($conn,$sql)){
    echo 1;
}else{
    echo 0;
}  


?>
