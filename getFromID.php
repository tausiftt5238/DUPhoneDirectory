<?php
header('Content-Type: text/html; charset=utf-8');
session_start();

$servername = "localhost";
$username = "adminman";
$password = "password";
$dbname = "directory_uni";

$ret_str = "";

if(isset($_SESSION['username'])) {
	$conn = new mysqli($servername, $username, $password, $dbname);
	$conn->set_charset('utf8mb4');

	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
		$ret_str = $ret_str . "failed";
	}

	$id = $_POST['id'];
	$sql = "SELECT name FROM person WHERE id='".$id."'";

	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$ret_str = $ret_str.$row["name"]."\n";

	$sql = "SELECT position FROM position WHERE id='".$id."'";

	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$ret_str = $ret_str.$row["position"]."\n";

	$sql = "SELECT email from email WHERE id='".$id."'";

	$emailres = $conn->query($sql);
	$ret_str = $ret_str.$emailres->num_rows."\n";

	$sql = "SELECT phone from phone WHERE id='".$id."'";
	$phoneres = $conn->query($sql);
	$ret_str = $ret_str.$phoneres->num_rows."\n";

	while($row = $emailres->fetch_assoc()) {
		$ret_str = $ret_str.$row["email"]."\n";
	}

	while($row = $phoneres->fetch_assoc()) {
		$ret_str = $ret_str.$row["phone"]."\n";
	}


}

echo $ret_str;
?>