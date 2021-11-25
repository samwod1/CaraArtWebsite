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

<?php

require_once "password.php";

function printForm(){
    global $id, $artName, $name, $number, $email, $addressLine1, $addressLine2, $city, $postcode,
    $nameEmpty, $numberEmpty, $emailEmpty, $addressLine1Empty, $addressLine2Empty, $cityEmpty, $postcodeEmpty

    ?>
    <div class = "header">

        <div class = "logo"><img class = "gif" src="cara_art_logo.png" alt = "cara art logo"/></div>

        <ul class = "navigation">
            <li><a href="index.php" class = "home_page_link">HOME</a></li>
            <li><a href="trackandtrace.php" class = "home_page_link">TRACK N TRACE</a></li>
            <li><a href="admin.php" class = "home_page_link">ADMIN</a></li>
        </ul>
    </div>

    <div class="title">ORDER ART</div>
    <div>
        <p class = "title"><?php echo "(".$id.") " . $artName; ?></p>
    </div>

    <?php
    if($nameEmpty){
        echo "<p class = 'title'>Please enter a name</p>";
    }
    if ($numberEmpty){
        echo "<p class = 'title'>Please enter a phone number</p>";
    }
    if ($emailEmpty){
        echo "<p class = 'title'>Please enter a email</p>";
    }
    if ($addressLine1Empty || $addressLine2Empty || $cityEmpty || $postcodeEmpty){
        echo "<p class = 'title'>Please enter a full address</p>";
    }
    ?>

    <div class = "track">
        <form method = "post" action = "<?php echo "order.php?id=".$id ?>">
            <p>Name</p>
            <input type = "text" name = "name" value = "<?php echo $name?>">
            <p>Phone-number</p>
            <input type="text" name="number" value = "<?php echo $number?>">
            <p>Email</p>
            <input type = "text" name = "email" value = "<?php echo $email?>">
            <p>Address Line 1</p>
            <input type = "text" name = "addressLine1" value = "<?php echo $addressLine1?>">
            <p>Address Line 2</p>
            <input type = "text" name = "addressLine2" value = "<?php echo $addressLine2?>">
            <p>City</p>
            <input type = "text" name = "city" value = "<?php echo $city?>">
            <p>Postcode</p>
            <input type = "text" name = "postcode" value = "<?php echo $postcode?>">
            <p><input type = "submit" value = "Order" name = "submit"></p>
        </form>
    </div>
<?php
}

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

$name = strip_tags(!empty($_POST["name"])) ? ($_POST["name"]) : "";
$number = strip_tags(!empty($_POST["number"])) ? ($_POST["number"]) : "";
$email = strip_tags(!empty($_POST["email"])) ? ($_POST["email"]) : "";
$addressLine1 = strip_tags(!empty($_POST["addressLine1"])) ? ($_POST["addressLine1"]) : "";
$addressLine2 = strip_tags(!empty($_POST["addressLine2"])) ? ($_POST["addressLine2"]) : "";
$city = strip_tags(!empty($_POST["city"])) ? ($_POST["city"]) : "";
$postcode = strip_tags(!empty($_POST["postcode"])) ? ($_POST["postcode"]) : "";
$errorCheck = FALSE;
$nameEmpty = FALSE;
$numberEmpty = FALSE;
$emailEmpty = FALSE;
$addressLine1Empty = FALSE;
$addressLine2Empty = FALSE;
$cityEmpty = FALSE;
$postcodeEmpty = FALSE;


if($name === "" && $number === "" && $email === "" && $addressLine1 === ""
    && $addressLine2 === "" && $city === "" && $postcode === ""){
    printForm();
} else {
    if($name === ""){
        $nameEmpty = TRUE;
        $errorCheck = TRUE;
    }
    if ($number === ""){
        $numberEmpty = TRUE;
        $errorCheck = TRUE;
    }
    if($emailEmpty === ""){
        $emailEmpty = TRUE;
        $errorCheck = TRUE;
    }
    if($addressLine1 === ""){
        $addressLine1Empty = TRUE;
        $errorCheck = TRUE;
    }
    if($addressLine2 === ""){
        $addressLine2Empty = TRUE;
        $errorCheck = TRUE;
    }
    if($city === ""){
        $cityEmpty = TRUE;
        $errorCheck = TRUE;
    }
    if($postcode === ""){
        $cityEmpty = TRUE;
        $errorCheck = TRUE;
    }


    if (!$errorCheck){

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
        printForm();
    }
}
?>
</body>
</html>

