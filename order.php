<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CARA ART</title>
    <link rel="stylesheet" type="text/css" href="art_system.css">

    <script>
        function order(){

        }
    </script>
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
<?php
//TODO Make address more complicated and user friendly
require_once "password.php";

//connecting to phpmyadmin
$servername = "devweb2021.cis.strath.ac.uk";
$username = "gvb19190";
$mysqlipassword = get_password();
$dbname = $username;
$conn = new mysqli($servername, $username, $mysqlipassword, $dbname);

if($conn->connect_error) {
    die("Something went wrong while connecting to our server, please try again later. " . $conn->connect_error); //FIXME GET RID OF FOR FINAL SUBMISSION
}

//querying art database
$sql = "SELECT * FROM `art`";
$result = $conn->query($sql);
$id = isset($_GET["id"])?$_GET["id"]:0;
$artName = "";

if(!$result){
    die("Query failed ".$conn->error); //FIXME
}

//Finding the name corresponding to id
if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        if($row["id"] === $id){
            $artName = $row["name"];
        }
    }
}

if (isset($_POST["submit"])){
    $name = $_POST["name"];
    $number = $_POST["number"];
    $email = $_POST["email"];
    $addressLine1 = $_POST["addressLine1"];
    $addressLine2 = $_POST["addressLine2"];
    $city = $_POST["city"];
    $postcode = $_POST["postcode"];

    $name = $conn->real_escape_string($name);
    $number = $conn->real_escape_string($number);
    $email = $conn->real_escape_string($email);
    $addressLine1 = $conn->real_escape_string($addressLine1);
    $addressLine2 = $conn->real_escape_string($addressLine2);
    $city = $conn->real_escape_string($city);
    $postcode = $conn->real_escape_string($postcode);


    $sql = "INSERT INTO `orders` (`id`,`name`,`number`,`email`,`addressLine1`,`addressLine2`,`city`,`postcode`,`art_id`)
            VALUES (NULL, '$name','$number','$email','$addressLine1','$addressLine2','$city','$postcode','$id')";

    if($conn->query($sql) === TRUE){

    } else{
        die("Something went wrong: " . $conn->error);
    }
    ?>
    <div class="title">ORDER ART</div>
    <div><p class = "title"><?php echo "(".$id.") " . $artName; ?></p></div>
    <div><p class = "title">Thank you for ordering your request has been submitted.</p></div>
    <button class = "home_page_button"><a href = "index.php" class = "home_page_link">BACK TO HOME</a></button>
    <?php
} else{
?>
<div class="title">ORDER ART</div>
<div>
    <p class = "title"><?php echo "(".$id.") " . $artName; ?></p>
</div>

<div class = "track">
    <form method = "post" action = "<?php echo "order.php?id=".$id ?>">
        <p>Name</p>
        <input type = "text" name = "name">
        <p>Phone-number</p>
        <input type="text" name="number">
        <p>Email</p>
        <input type = "text" name = "email">
        <p>Address Line 1</p>
        <input type = "text" name = "addressLine1">
        <p>Address Line 2</p>
        <input type = "text" name = "addressLine2">
        <p>City</p>
        <input type = "text" name = "city">
        <p>Postcode</p>
        <input type = "text" name = "postcode">
        <p><input type = "submit" value = "Order" name = "submit"></p>
    </form>
</div>
</body>
</html>
<?php
}
?>