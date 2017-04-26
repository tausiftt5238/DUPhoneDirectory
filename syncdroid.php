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
    //array_push($result, array('ID'=>$row['ID'],'name'=>$row['name'],'faculty'=>$row['faculty']));
    $result_array = array();
    $result_array['total'] = $res->num_rows;
    $result_array['ID'] = $row['ID'];
    $result_array['name'] = $row['name'];
    $result_array['department'] = $row['department'];
    $result_array['faculty'] = $row['faculty'];

    $email_sql = "SELECT email FROM email WHERE ID=".$row['ID'];
    $email_result = $conn->query($email_sql);

    $result_array['emailno'] = $email_result->num_rows;
    $index = 0;
    if($email_result->num_rows > 0){
        while($email_row = $email_result->fetch_assoc()){
            $result_array['email'.$index] = $email_row['email'];
            $index++;
        }
    }

    $phone_sql = "SELECT phone FROM phone WHERE ID=".$row['ID'];
    $phone_result = $conn->query($phone_sql);

    $result_array['phoneno'] = $phone_result->num_rows;
    $index = 0;
    if($phone_result->num_rows > 0){
        while($phone_row = $phone_result->fetch_assoc()){
            $result_array['phone'.$index] = $phone_row['phone'];
            $index++;
        }
    }

    $position_sql = "SELECT position FROM position WHERE ID=".$row['ID'];
    $position_result = $conn->query($position_sql);

    $result_array['positionno'] = $position_result->num_rows;
    $index = 0;
    if($position_result->num_rows > 0){
        while($position_row = $position_result->fetch_assoc()){
            $result_array['position'.$index] = $position_row['position'];
            $index++;
        }
    }
    array_push($result, $result_array);
}
echo json_encode(array("result"=>$result));
mysqli_close($con);


?>