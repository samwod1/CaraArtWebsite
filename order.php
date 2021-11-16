<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CARA ART</title>
    <style>
        .title{
            text-align: center;
            font-size: 300%;
        }
        .subtitle{
            text-align: center;
            font-size: 200%;
            color: black;
        }
        .art_title{
            text-align: left;
            font-size: 200%;
            color: black;
        }
        .art_subtitle{
            text-align: left;
            font-size: 20px;
            color: black;
        }
    </style>
    <script>
        function order(){

        }
    </script>
</head>
<body>
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
$id = $_GET["id"];
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
    $address = $_POST["address"];
    $name = $conn->real_escape_string($name);
    $number = $conn->real_escape_string($number);
    $email = $conn->real_escape_string($email);
    $address = $conn->real_escape_string($address);
    $sql = "INSERT INTO `orders` (`id`,`name`,`number`,`email`,`address`,`art_id`)
            VALUES (NULL, '$name','$number','$email','$address','$id')";

    if($conn->query($sql) === TRUE){

    } else{
        die("Something went wrong: " . $conn->error);
    }
    ?>
    <div class="title">CARA ART</div>
    <div class="subtitle">ORDER ART</div>
    <div><p class = "art_title"><?php echo "(".$id.") " . $artName; ?></p></div>
    <div><p>Thank you for ordering your request has been submitted.</p></div>
    <?php
} else{
?>
<div class="title">CARA ART</div>
<div class="subtitle">ORDER ART</div>
<div>
    <p class = "art_title"><?php echo "(".$id.") " . $artName; ?></p>
</div>
<div>
    <p class="art_subtitle">Order this artwork:</p>
</div>
<div>
    <form method = "post" action = "<?php echo "order.php?id=".$id ?>">
        <p>Name: <input type = "text" name = "name"></p>
        <p>Phone-number: <input type="text" name="number"></p>
        <p>Email: <input type = "text" name = "email"></p>
        <p>Address: <input type = "text" name = "address"></p>
        <p><input type = "submit" value = "Order" name = "submit"></p>
    </form>
</div>
</body>
</html>
<?php
}
?>