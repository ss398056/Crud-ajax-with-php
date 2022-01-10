<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title> Insert with Ajex in Php</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
    #success-message{
        position : absolute;
        background : skyblue;
        color : green;
        padding : 10px;
        margin : 10px;
        display : none;
        margin-right : 15px;
        margin-top: 15px;
    }
    #error-message{
        position : absolute;
        background : skyblue;
        color : red;
        padding : 10px;
        margin : 10px;
        display : none;
        margin-right : 15px;
        margin-top: 15px;
        border-radius : 5px;

    }
    .delete-btn{
        background : red;
        color : #fff;
        border : 0;
        padding : 4px 10px;
        border-radius : 3px;
        margin-left : 20px;
        cursor : pointer;
    }
    .edit-btn{
        background : green;
        color : #fff;
        border : 0;
        padding : 4px 10px;
        border-radius : 3px;
        margin-left : 20px;
        cursor : pointer;
    }
    #model{
      background-color: rbga(0,0,0,0.7);
      position : fixed;
      opacity: 98%;
      left : 300px;
      top : 0;
      width: 100%;
      height: 100%;
      z-index : 100%;
      display : none;
  }

  #model-form{
      background-color: #fff;
      border : 3px solid blue;
      width: 30%;
      position : relative;
      top : 20%;
      left : calc(50%-15);
      padding: 15px;
      border-radius : 4px;

  }
  #model-form h2{
      margin : 0 0 15px;
    padding : 10px;
    border-bottom : 3px solid blue;
  }
  #close-btn{
      background : red;
      color : white;
      width : 30px;
      height : 30px;
      text-align : center;
      position : absolute;
      top : -15px;
      right : -15px;
      border-radius : 15px;
      cursor : pointer;
  }
  h1{
     float : left;
  }
#search{
    float : right;
    text-align: right;
}

    </style>
</head>
<body>
<div id="header">
    <h1>Crud Php with Ajax</h1>

    <input type="text" id="search" placeholder="Search">

</div>
<div id="error-message"></div>
<div id="success-message"></div>

<div id="nav">
<form action="" id="addform">
    First Name : <input type="text" id="fname">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    Last Name : <input type="text" id="lname">&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="submit" value="Save" id="save">
</form>
</div>

<table id="table-data">
<!--Live Search Table Show here-->
</table>

<div id="showdata">
    <h2>Student Data</h2>
<table id="table-load">
    <!--Data Comes dynamically from database-->
</table>
</div>



<div id="model">
    <div id="model-form">
        <h2>Edit Form</h2>
        <table>
       <!--Data Comes dynamically from database-->
        </table>
        <div id="close-btn">X</div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js" 
integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script>
    $(document).ready(function(){
        //Load Data From Database
        function loadTable(){
            $.ajax({
            url : "ajax-load.php",
            type : "POST",
            success : function(data){
                $("#table-load").html(data);
            }
        });
        }
        loadTable();        //Load Table Records from database using function


        //Insert New Records
        $("#save").on("click" , function(e){
            e.preventDefault();
            var fname = $("#fname").val();
            var lname = $("#lname").val();

            if(fname == "" || lname == ""){
                $("#error-message").html("<i>Fill all fields are required.</i>").slideDown();
                $("#save").mouseleave(function(){
                    $("#error-message").hide();
                });
            }else{
                $.ajax({
                    url : "insert-records.php",
                    type : "POST",
                    data : {first_name: fname , last_name: lname},
                    success : function(data){
                        if(data == 1){
                             loadTable();
                             $("#addform").trigger("reset");
                             $("#success-message").html("Data Inserted Successfully.").slideDown();
                                        $("#save").mouseleave(function(){
                                        $("#success-message").hide();
                                    });          
                           }else{
                                 $("#error-message").html("Can't save records.").slideDown();
                                }  
                    }
            });
            }
        });


        //Delete Records
        $(document).on("click",".delete-btn" ,function(){
            if(confirm("Do you really want to delete this record")){
            
            var studentId = $(this).data("id");
            var element = this;
        $.ajax({
                url : "delete-records.php",
                type : "POST",
                data : {id : studentId},
                success : function(data){
                    if(data == 1){
                        $(element).closest("tr").fadeOut();
                    }else{
                        $("#error-message").html("Can't Delete record.").slideDown();
                    }
                }
        });
        }    
        });


        // Fetch Data on Form Filds
        $(document).on("click",".edit-btn",function(){
            $("#model").show();
            var studentId = $(this).data("eid");

            $.ajax({
                url : "update-records.php",
                type : "POST",
                data : {id: studentId},
                success : function(data){
                    $("#model-form table").html(data);
                }
            })  
        });

       //Hide model box
       $("#close-btn").on("click",function(){
           $("#model").hide();
       }); 

       //Save Update Form
          $(document).on("click","#edit-btn", function(){
           var first_name = $("#edit-fname").val();
           var last_name = $("#edit-lname").val();
           var id = $("#edit-id").val();

           $.ajax({
               url : "ajax-update-form.php",
               type : "POST",
               data : {id : id, first_name : first_name, last_name : last_name },
               success : function(data){
                   if(data == 1){
                    $("#model").hide();
                    loadTable();
                   }
                   
               }
           }) 
       }); 

       //Live Search
       $("#search").on("keyup", function(){
           var search_tearm = $(this).val();

           $.ajax({
               url : "search.php",
               type : "POST",
               data : {search : search_tearm},
               success : function(data){
                   $("#table-data").html(data);
               }

           })
       });     
    });
</script>
    
</body>
</html>