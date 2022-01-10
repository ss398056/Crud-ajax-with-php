<?php
$sid = $_POST['id'];
$conn = mysqli_connect("localhost","root","","fetch_function") or die("NOt connect to database");
$sql = "DELETE FROM student WHERE id = {$sid}";

if(mysqli_query($conn,$sql)){
    echo 1;
}else{
    echo 0;
}   


?>