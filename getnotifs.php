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
	if($_SESSION['username']!='admin')
		$sql = "SELECT * FROM notifications WHERE username='". $_SESSION["username"] ."'";
	else
		$sql = "SELECT * FROM notifications";

	$result = $conn->query($sql);
	while($row = $result->fetch_assoc()) {
		$id = $row["id"];
		$time = $row["time"];

		$sql = "SELECT name from person WHERE ID='". $id ."'";
		$nameres = $conn->query($sql);
		$namerow = $nameres->fetch_assoc();

		$name = $namerow["name"];
		$header = "<tr><td><a onclick='edit(\"".$id."\")'>";
		$footer = "</a></td></tr>";
		$str = "Contact details of ". $name ." reported at ". $time;
		$ret_str = $ret_str . $header . $str . $footer;
	}

}
$conn->close();

echo $ret_str;

?>