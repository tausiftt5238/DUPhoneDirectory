<?php
header('Content-Type: text/html; charset=utf-8');
$servername = "localhost";
$username = "adminman";
$password = "password";
$dbname = "directory_uni";

$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset('utf8mb4');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "select * from person";

$res = mysqli_query($conn,$sql);

$result = array();

while($row = mysqli_fetch_array($res)){
    array_push($result,
        array('ID'=>$row['ID'],
            'name'=>$row['name'],
            'faculty'=>$row['faculty']
        ));
    }
echo json_encode(array("result"=>$result));
mysqli_close($con);


?>