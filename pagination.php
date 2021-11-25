<?php

require_once "password.php";

$server_name = "devweb2021.cis.strath.ac.uk";

$user_name = "gvb19190";

$password = get_password();

$db = $user_name;

$conn = new mysqli($server_name, $user_name, $password,$db);

if ($conn->connect_error) {

    die("Connection failed: ");
}

$limit = 12;

if (isset($_GET["page"])) { $page_number  = $_GET["page"]; } else { $page_number=1; };

$initial_record = ($page_number-1) * $limit;

if($initial_record < 0 ){
    $initial_record = $initial_record * -1;
}

$sql = "SELECT * FROM art LIMIT $initial_record, $limit";

$result = $conn->query($sql);

if(!$result){
    die("Something went wrong:" . $conn->error);
}

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
    <script>
        function more(id){
            window.location = 'https://devweb2021.cis.strath.ac.uk/~gvb19190/assessment2/details.php?id='+id;
        }
    </script>
</head>
<body>
<div class = "table_wrapper">
<table class="table" id = "list_art">
    <th>Name</th>
    <th>Price</th>
    <th> </th>
    <th> </th>

    <?php
    if($result->num_rows > 0){
        while ($row = $result->fetch_assoc()){

            ?>
                <tr >
                    <td><?php echo $row["name"]; ?></td>

                    <td><?php echo $row["price"]; ?></td>

                    <td><?php echo '<img class="thumbnail" alt='.$row['name'].' src="data:image/jpeg;base64,'.base64_encode($row['image']).'"/>';?></td>

                    <td><button class = "more_button" onclick = more(<?php echo $row["id"]?>)>+</button></td>
                </tr>
    <?php
        }
    }
    ?>
</table>
</div>
</body>
