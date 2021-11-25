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
//TODO Make address more complicated and user friendly
require_once "password.php";

function printForm(){
    global $nameEmpty, $phoneNumberEmpty, $dateEmpty, $name, $phoneNumber, $date;
    ?>
    <div class = "header">

        <div class = "logo"><img class = "gif" src="cara_art_logo.png" alt = "cara art logo"/></div>

        <ul class = "navigation">
            <li><a href="listart.php" class = "home_page_link">ORDER ART</a></li>
            <li><a href="index.php" class = "home_page_link">HOME</a></li>
            <li><a href="admin.php" class = "home_page_link">ADMIN</a></li>
        </ul>
    </div>

    <div>
        <p class="title">Enter details:</p>
    </div>
    <?php
    if($nameEmpty){
        echo "<p class = 'title'>Please enter a name</p>";
    }
    if ($phoneNumberEmpty){
        echo "<p class = 'title'>Please enter a phone number</p>";
    }
    if ($dateEmpty){
        echo "<p class = 'title'>Please enter a date</p>";
    }
    ?>

    <div class = "track">
        <form method = "post" action = "trackandtrace.php">
            <p>NAME</p>
            <input type = "text" name = "name" value = <?php echo $name ?> >
            <p>PHONE-NUMBER</p>
            <input type="text" name="phoneNumber" value = <?php echo $phoneNumber ?>>
            <p>DATE</p>
            <input type = "datetime-local" name = "date">
            <p><input type = "submit" value = "Submit" name = "submit" value = <?php echo $date ?>></p>
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
$sql = "SELECT * FROM `track&trace`";
$result = $conn->query($sql);

if(!$result){
    die("Query failed ".$conn->error); //FIXME
}


$name =strip_tags(!empty($_POST["name"])) ? ($_POST["name"]) : "";
$phoneNumber = strip_tags(!empty($_POST["phoneNumber"])) ? ($_POST["phoneNumber"]) : "";
$date = strip_tags(!empty($_POST["date"])) ? ($_POST["date"]) : "";
$nameEmpty = FALSE;
$phoneNumberEmpty = FALSE;
$dateEmpty = FALSE;
$errorCheck = FALSE;

if($name === "" && $phoneNumber === "" && $date === ""){
    printForm();
} else{
        if ($name === ""){
            $nameEmpty = TRUE;
            $errorCheck = TRUE;
        }
        if ($phoneNumber === ""){
            $phoneNumberEmpty = TRUE;
            $errorCheck = TRUE;
        }

        if ($date === ""){
            $dateEmpty = TRUE;
            $errorCheck = TRUE;
        }


        if (!$errorCheck){

            $name = $conn->real_escape_string($name);
            $phoneNumber = $conn->real_escape_string($phoneNumber);
            $date = $conn->real_escape_string($date);

            $sql = "INSERT INTO `track&trace` (`id`,`name`,`phone number`,`date`)
                    VALUES (NULL, '$name','$phoneNumber','$date')";

            if($conn->query($sql) === TRUE){

            } else{
                die("Something went wrong");
            }
            ?>
            <div><p class = "title">Thank you for submitting track & trace details.</p></div>
            <button onclick = "window.location = 'index.html'" class = "order_button">Home</button>
            <?php
        } else{
            printForm();
        }
}
?>
</body>
</html>
