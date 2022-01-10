<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../js/jquery-3.6.0.min.js"></script>
    <title>Ajex in Php Intoduction</title>
    <link rel="stylesheet" href="../css/style.css">

</head>

<body>
<div id="header">
    <h1>Php with Ajax</h1>
</div>

<div id="nav">
<input type="button" value="Load Data" id="load-button">
</div>

<div id="showdata">
    <h2>Student Data</h2>
<table id="table-load">
    <tr>
    <th>Id</th>
    <th>Name</th>
    </tr>
    <tr>
    <td>1</td>
    <td>Sandeep</td>
    </tr>
</table>
</div>

<script>
$(document).ready(function(){
    $("#load-button").on("click",function(e){
        $.ajax({
            url : "ajax-load.php",
            type : "POST",
            success : function(data){
                $("#table-load").html(data);
            }
        })
    })
});
</script>
</body>
</html>