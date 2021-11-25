<?php
require_once "password.php";


$servername = "devweb2021.cis.strath.ac.uk";
$username = "gvb19190";
$mysqlipassword = get_password();
$dbname = $username;
$conn = new mysqli($servername, $username, $mysqlipassword, $dbname);
$currentPage = 0;

if($conn->connect_error) {
    die("Something went wrong while connecting to our server, please try again later. " . $conn->connect_error); //FIXME GET RID OF FOR FINAL SUBMISSION
}

$limit = 12;

$sql = "SELECT COUNT(*) FROM `art`";

$result = $conn->query($sql);

if(!$result){
    die("Query failed ".$conn->error); //FIXME
}

$row = mysqli_fetch_row($result);

$total_rows = $row[0];

$total_pages = ceil($total_rows/$limit);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CARA ART</title>
    <link rel="stylesheet" type="text/css" href="art_system.css">
    <script>

        function more(id){
            window.location='https://devweb2021.cis.strath.ac.uk/~gvb19190/assessment2/details.php?id='+id;
        }

    </script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src = "https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src = "https://cdnjs.cloudflare.com/ajax/libs/twbs-pagination/1.4.1/jquery.twbsPagination.min.js"></script>


</head>
<body>

<div class = "header">

    <div class = "logo"><img class = "gif" src="cara_art_logo.png" alt = "cara art logo"/></div>

    <ul class = "navigation">
        <li><a href="index.php" class = "home_page_link">HOME</a></li>
        <li><a href="trackandtrace.php" class = "home_page_link">TRACK N TRACE</a></li>
        <li><a href="admin.php" class = "home_page_link">ADMIN</a></li>
    </ul>
</div>
<div id="target-content"> loading . . . </div>
<div class="table">

        <ul>
            <?php

            if(!empty($total_pages)){

                for($i=1; $i<=$total_pages; $i++){

                    if($i == 1){

                        ?>
                        <li class="pageitem active" style="display:none" id="<?php echo $i;?>"></a></li>
                        <?php

                    } else{

                        ?>
                        <li class="pageitem" style="display:none"  id="<?php echo $i;?>"></li>
                        <?php

                    }
                }
            }

            ?>
        </ul>
        <input class = "total" type = "hidden" value="<?php echo $total_pages; ?>"/>
        <input class = "totalRows" type = "hidden" value="<?php echo $total_rows;?>"/>
        <input class = "limit" type = "hidden" value ="<?php echo $limit;?>"/>

    <button href= "JavaScript:Void(0)" class = "paginate" id = "prev" data-id="prev">PREVIOUS</button>
    <button href= "JavaScript:Void(0)" class = "paginate" id = "next" data-id="next">NEXT</button>

</div>
<script>

    $(document).ready(function() {

        $("#target-content").load("pagination.php?page=1");

        $("#prev").hide();

        var totalRows = $(".totalRows").attr("value");
        var limit = $(".limit").attr("value");

        if(totalRows <= 12){
            $("#next").hide();
        }

        $(".paginate").click(function() {

            $("#prev").show();

            var direction = $(this).attr("data-id");

            var curPage = $(".pageitem.active").attr("id");

            var totalPages = $(".total").attr("value");


            if(direction === 'prev'){

                curPage = parseInt(curPage) - 1;

            } else{

                curPage = parseInt(curPage) + 1;

            }


            if(parseInt(curPage) >= totalPages){

                $("#next").hide();

            } else{

                $("#next").show();

                if(parseInt(curPage) <= 1){
                    $("#prev").hide();
                } else {
                    $("#prev").show();
                }
            }


            $.ajax({

                url: "pagination.php",

                type: "GET",

                data:{
                    page: curPage
                },

                cache: false,

                success: function(dataResult){
                    $("#target-content").html(dataResult);

                    $(".pageitem").removeClass("active");

                    $("#" + curPage).addClass("active");

                }
            });

        });

    });

</script>
</body>
</html>