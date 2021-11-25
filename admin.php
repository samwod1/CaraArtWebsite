<?php
    session_start();
    //echo md5("caraART21");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CARA ART</title>
    <link rel="stylesheet" type="text/css" href="art_system.css">
</head>
<body>
<div class="header">
    <div class = "logo"><img class = "gif" src="cara_art_logo.png" alt = "cara art logo"/></div>
    <ul class = "navigation">
        <li><a href="listart.php" class = "home_page_link">ORDER ART</a></li>
        <li><a href="trackandtrace.php" class = "home_page_link">TRACK N TRACE</a></li>
        <li><a href="index.php" class = "home_page_link">HOME</a></li>
    </ul>
</div>
<?php
include "password.php";

if(isset($_SESSION["sessionpassword"])){
    //we have a session variable
    $password = $_SESSION["sessionpassword"];
    $sessionpassword = $_SESSION["sessionpassword"];
} else{
    $sessionpassword = "";
    $password = strip_tags(isset($_GET["password"]) ? $_GET["password"] : "");
}

$loginOK = ($sessionpassword == "carART21") || (md5($password) == "4a14c3abe899c6a99f6b212e89a4a2c9");

if($password != ""){
    if($loginOK){

        $_SESSION["sessionpassword"] = $password;
        $servername = "devweb2021.cis.strath.ac.uk";
        $username = "gvb19190";
        $mysqlipassword = get_password();
        $dbname = $username;
        $conn = new mysqli($servername, $username, $mysqlipassword, $dbname);
        $artSubmitCheck = FALSE;


        if($conn->connect_error) {
            die("Something went wrong");
        }


        if (isset($_POST["artSubmit"])) {
            $name = $_POST["name"];
            $date = $_POST["date"];
            $width = $_POST["width"];
            $height = $_POST["height"];
            $price = $_POST["price"];
            $description = $_POST["description"];

            $name = strip_tags($name);
            $date = strip_tags($date);
            $width = strip_tags($width);
            $height = strip_tags($height);
            $price = strip_tags($price);
            $description = strip_tags($description);

            $name = $conn->real_escape_string($name);
            $date = $conn->real_escape_string($date);
            $width = $conn->real_escape_string($width);
            $height = $conn->real_escape_string($height);
            $price = $conn->real_escape_string($price);
            $description = $conn->real_escape_string($description);


            $insert = "INSERT INTO `art` (`id`,`name`,`date`,`width`,`height`,`price`,`description`)
                    VALUES (NULL, '$name','$date','$width','$height','$price','$description')";
            if ($conn->query($insert) === TRUE) {
                $artSubmitCheck = TRUE;
            } else {
                die("Something went wrong, please try again later." . $conn->error);

            }
        }


        $sql = "SELECT * FROM `orders`";
        $result = $conn->query($sql);

        if(!$result){
            die("Query failed ".$conn->error); //FIXME dont show big error message
        }
        ?>
        <div class = "admin_wrapper">
        <div>
        <p class = "title">ORDER TABLE</p>
        <table class="table">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Telephone Number</th>
                <th>Email</th>
                <th>Address Line 1</th>
                <th>Address Line 2</th>
                <th>City</th>
                <th>Postcode</th>
                <th>Art ID</th>
            </tr>
            <tr>
                <?php
                if($result->num_rows > 0){
                    while ($row = $result->fetch_assoc()){
                        echo "<tr>";
                        echo "<td>" . $row["id"]. "</td>";
                        echo "<td>" . $row["name"]. "</td>";
                        echo "<td>" . $row["number"]. "</td>";
                        echo "<td>" . $row["email"]. "</td>";
                        echo "<td>" . $row["addressLine1"]. "</td>";
                        echo "<td>" . $row["addressLine2"]. "</td>";
                        echo "<td>" . $row["city"]. "</td>";
                        echo "<td>" . $row["postcode"]. "</td>";
                        echo "<td>" . $row["art_id"]. "</td>";
                        echo "</tr>";
                    }
                }
                ?>
            </tr>
        </table>
        </div>
            <div class="title">TRACK & TRACE TABLE</div>
            <table class="table">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Phone Number</th>
                    <th>Date</th>
                </tr>
                <tr>
                    <?php
                    $sql = "SELECT * FROM `track&trace`";
                    $result = $conn->query($sql);

                    if(!$result){
                        die("Query failed ".$conn->error); //FIXME dont show big error message
                    }

                    if($result->num_rows > 0){
                        while ($row = $result->fetch_assoc()){
                            echo "<tr>";
                            echo "<td>" . $row["id"]. "</td>";
                            echo "<td>" . $row["name"]. "</td>";
                            echo "<td>" . $row["phone number"]. "</td>";
                            echo "<td>" . $row["date"]. "</td>";
                            echo "</tr>";
                        }
                    }
                    ?>
                </tr>


            </table>
            <p class = "title">SUBMIT ART</p>
            <div class = "track">
                <form method="post" action="admin.php?password=caraART21">
                    <p>NAME</p>
                    <input type="text" name="name">
                    <p>DATE OF COMPLETION</p>
                    <input type="text" name="date">
                    <p>WIDTH(mm)</p>
                    <input type="text" name="width">
                    <p>HEIGHT(mm)</p>
                    <input type="text" name="height">
                    <p>PRICE</p>
                    <input type="text" name="price">
                    <p>DESCRIPTION</p>
                    <input type="text" name="description">
                    <p><input type="submit" value = "SUBMIT" name="artSubmit"></p>
                </form>
            <p><?php if($artSubmitCheck){ echo "New art submitted!";}?></p>
            </div>
        <?php

        $conn->close();
    } else{
        ?>
        <div class = "object_wrapper">
            <div class = "object_wrapper_content">
                <h1 class = "title">PASSWORD</h1>
                <p>Please enter the admin password.</p>
                <form method="get" action="admin.php"> <p><input class = "password_incorrect_box" type="text" name="password"> <input class = "submitButton" type="submit"></p> </form>
                <p>Incorrect password, please try again.</p>
            </div>
        </div>
        <?php
    }
} else{
    ?>
        <div class = "object_wrapper">
            <div class = "object_wrapper_content">
                <h1 class = "title">PASSWORD</h1>
                <p>Please enter the admin password.</p>
                <form method="get" action="admin.php"> <p><input class = "password_box" type="text" name="password"> <input class = "submitButton" type="submit"></p> </form>
            </div>
        </div>
    <?php
}
?>
</body>
</html>