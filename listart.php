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
            color: grey;
            padding-bottom: 5%;
        }
        .table{

        }
    </style>
    <script>
        function order(id){
            window.location='https://devweb2021.cis.strath.ac.uk/~gvb19190/assessment2/order.php?id='+id;
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
?>
<div class="title">CARA ART</div>
<div class="subtitle">ORDER ART</div>
<div class="table">
    <table>
        <tr>
            <th>Name</th>
            <th>Date Of Completion</th>
            <th>Width (mm)</th>
            <th>Height (mm)</th>
            <th>Price (£)</th>
            <th>Description</th>
            <th>Order</th>
        </tr>

            <?php
            if($result->num_rows > 0){
                while($row = $result->fetch_assoc()){
                    echo "<tr>";
                    echo "<td>" .$row["name"]. "</td>";
                    echo "<td>" .$row["date"]. "</td>";
                    echo "<td>" .$row["width"]. "</td>";
                    echo "<td>" .$row["height"]. "</td>";
                    echo "<td>" .$row["price"]. "</td>";
                    echo "<td>" .$row["description"]. "</td>";
                    $a = $row["id"];
                    echo "<td><button onclick='order($a)'>Order</button></form>";
                    echo "</tr>";

                }
            }
            ?>


    </table>
</div>
</body>
</html>