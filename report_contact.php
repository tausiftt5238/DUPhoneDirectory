<?php
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

$id = $_POST["id"];

$sql = "SELECT department FROM person WHERE ID='". $id ."'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$department = $row["department"];

$sql = "SELECT username FROM users WHERE department='". $department ."'";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$username = $row["username"];

$sql = "INSERT INTO notifications (username,id) VALUES ('". $username ."','". $id . "')";
$conn->query($sql);

$conn->close();
?>