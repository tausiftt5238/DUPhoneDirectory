<?php
header('Content-Type: text/html; charset=utf-8');
//mb_internal_encoding("UTF-8");
/**
 * Created by PhpStorm.
 * User: tausiftt5238
 * Date: 4/11/17
 * Time: 12:57 PM
 */

$servername = "localhost";
$username = "directory_uni";
$password = "directory_uni";
$dbname = "directory_uni";

$ret_str = "<option value=\"#\">---</option>";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset('utf8mb4');

// Check connection
if ($conn->connect_error) {
    //die("Connection failed: " . $conn->connect_error);
    $ret_str = $ret_str."failed";
}

$sql = $_POST['query'];

//echo $sql;

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {

        $ret_str = $ret_str."<option value=\"".$row[$_POST['field']]."\">".$row[$_POST['field']]."</option>";
    }
} else {
    $ret_str = $ret_str."0 results";
}

$conn->close();

echo $ret_str;

?>
