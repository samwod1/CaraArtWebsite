<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CARA ART</title>
    <link rel="stylesheet" type="text/css" href="art_system.css">

    <script>
        function order(id){
            window.location='https://devweb2021.cis.strath.ac.uk/~gvb19190/assessment2/order.php?id='+id;
        }

        function back(){
            window.location='https://devweb2021.cis.strath.ac.uk/~gvb19190/assessment2/listart.php'
        }
    </script>
</head>
<body>
<?php
require_once "password.php";

$servername = "devweb2021.cis.strath.ac.uk";
$username = "gvb19190";
$mysqlipassword = get_password();
$dbname = $username;
$conn = new mysqli($servername, $username, $mysqlipassword, $dbname);

if($conn->connect_error) {
    die("Something went wrong while connecting to our server, please try again later. " . $conn->connect_error); //FIXME GET RID OF FOR FINAL SUBMISSION
}

$sql = "SELECT * FROM `art`";
$result = $conn->query($sql);

if(!$result){
    die("Query failed ".$conn->error); //FIXME
}

$id = $_GET["id"];
$artName = "";
$price = 0;
$width = 0;
$height = 0;
$description = "";

if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        if($row["id"] === $id){
            $artName = $row["name"];
            $price = $row["price"];
            $width = $row["width"];
            $height = $row["height"];
            $description = $row["description"];
            $image =  $row["image"];
        }
    }
}
?>

<div class = "header">

    <div class = "logo"><img class = "gif" src="cara_art_logo.png" alt = "cara art logo"/></div>

    <ul class = "navigation">
        <li><a href="index.php" class = "home_page_link">HOME</a></li>
        <li><a href="trackandtrace.php" class = "home_page_link">TRACK N TRACE</a></li>
        <li><a href="admin.php" class = "home_page_link">ADMIN</a></li>
    </ul>
</div>

<div><button onclick="back()" class="back_button">Back</button> </div>


<div class = "details_page_contents">
    <div class = "content_wrapper">
        <div class = "second_wrapper">
            <div><h2 class = "art_title"><?php echo $artName ?></h2></div>
            <p>Price: <?php echo $price ?></p>
            <p>Dimensions: <?php echo $width ." x ". $height ?></p>
            <p><?php echo $description?></p>
            <p><?php $a = $_GET["id"]; echo "<button class = 'order_button' onclick='order($a)'>Order</button>" ?></p>
        </div>
    </div>
    <div class = "full_size_picture_wrapper"><p><?php echo '<img class="full_size_picture" alt='.$artName.' src="data:image/jpeg;base64,'.base64_encode($image).'"/>';?></p></div>

</div>

</body>
</html>