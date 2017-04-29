<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
$servername = "localhost";
$username = "adminman";
$password = "password";
$dbname = "directory_uni";

$ret_str = "";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset('utf8mb4');

// Check connection
if ($conn->connect_error) {
	//die("Connection failed: " . $conn->connect_error);
	$ret_str = $ret_str."failed";
}

$loggedDept = "";
if(isset($_SESSION["username"])) {
	$sql = "SELECT department FROM users WHERE username='". $_SESSION["username"] ."'";
	$result = $conn->query($sql);
	if($result->num_rows>0) {
		$row = $result->fetch_assoc();
		$loggedDept = $row["department"];
	}
}

$id = $_POST['id'];
$sql = "SELECT * FROM person WHERE ID = '".$id."' ";

$result = $conn->query($sql);

if ($result->num_rows > 0) {

	$ret_str = $ret_str."<div id='fullcontact'>";
	// output data of each row
	while($row = $result->fetch_assoc()) {
		//$ret_str = $ret_str."<div class=\"row\">";
		//$ret_str = $ret_str."<!--<div class=\"col-sm-4\">--><li><div class=\"card\">";
		$ret_str = $ret_str."  <div class=\"container\" style='background-color: white'>";
		$ret_str = $ret_str."    <h1>".$row['name']."</h1>";
		$ret_str = $ret_str."    <p>".$row['department']."</p>";
		$ret_str = $ret_str."    <p>".$row['faculty']."</p>";
		//$ret_str = $ret_str."Email: <br>";

		$pos_sql = "SELECT position FROM position WHERE ID='".$id."'";
		$pos_result = $conn->query($pos_sql);

		if($pos_result->num_rows > 0) {
			$ret_str = $ret_str."    <p class=\"title\">";
			while($pos_row = $pos_result->fetch_assoc()){
				$ret_str = $ret_str.$pos_row['position']."<br>";
			}
			$ret_str = $ret_str."</p>";
		}

		$email_sql = "SELECT email FROM email WHERE ID='".$id."'";
		$email_result = $conn->query($email_sql);

		if($email_result->num_rows > 0) {
			$ret_str = $ret_str."    <p>Email:<br>";
			while($email_row = $email_result->fetch_assoc()){
				$ret_str = $ret_str.$email_row['email']."<br>";
			}
			$ret_str = $ret_str."</p>";
		}

		$phone_sql = "SELECT phone FROM phone WHERE ID='".$id."' ";
		$phone_result = $conn->query($phone_sql);

		if($phone_result->num_rows > 0){
			$ret_str = $ret_str."    <p>Contact:<br>";
			while($phone_row = $phone_result->fetch_assoc()){
				$ret_str = $ret_str.$phone_row['phone']."<br>";
			}
			$ret_str = $ret_str."</p>";

		}
		$ret_str = $ret_str."</div>";//</div><!--/div--></li>";

		if($row['department']==$loggedDept) {
			$ret_str = $ret_str."   <button onclick='edit(\"".$row['ID']."\")'>Edit</button>";
		}

	}
	$ret_str = $ret_str."<button onclick='rewind()'>Back</button>";
	$ret_str = $ret_str."</div>";
} else {
	$ret_str = $ret_str."0 results";
}
$conn->close();


echo $ret_str;
?>
