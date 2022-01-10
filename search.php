<?php

$search = $_POST["search"];

$conn = mysqli_connect("localhost","root","","fetch_function") or die("NOt connect to database");
$sql = "SELECT * FROM student WHERE first_name LIKE '%{$search}%' OR last_name LIKE '%{$search}%'  ";
$result = mysqli_query($conn,$sql);
$output = "";
if(mysqli_num_rows($result) > 0){
    $output = "<table>
                <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Edit</th>
                <th>Delete</th>
                </tr>";

                while($row = mysqli_fetch_assoc($result)){
                    $output .="<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['first_name']} {$row['last_name']}</td>
                        <td><button class='edit-btn' data-eid='{$row['id']}'>Edit</button></td>
                        <td><button class='delete-btn' data-id='{$row['id']}'>Delete</button></td>
                    </tr>";
                }

                $output .= "</table>";

                mysqli_close($conn);

                echo $output;
}else{
        echo "record not found";
}

?>