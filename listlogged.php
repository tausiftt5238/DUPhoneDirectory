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
		//die("Connection failed: " . $conn->connect_error);
		$ret_str = $ret_str."failed";
	}

	$sql = "SELECT department FROM users WHERE username='". $_SESSION["username"] . "'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$department = $row['department'];

	$sql = "SELECT * FROM person INNER JOIN position on person.ID = position.ID WHERE department='".$department."'";
	$sql = $sql." ORDER BY name ASC";
	//$ret_str = $ret_str.$sql;
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {

		$ret_str = $ret_str."<div id='contactlist'>";
		// output data of each row
		while($row = $result->fetch_assoc()) {

			$ret_str = $ret_str."<!--<div class=\"col-sm-4\">--><li><div class=\"card\">";
			$ret_str = $ret_str."  <div class=\"container\">";
			$ret_str = $ret_str."    <h3>".$row['name']."</h3>";
			$ret_str = $ret_str."<p class=\"title\">".$row['position']."</p>";
			$ret_str = $ret_str."    <p>".$row['department']."</p>";
			$ret_str = $ret_str."    <p>".$row['faculty']."</p>";
			$ret_str = $ret_str."   <p><button onclick='details(\"".$row['ID']."\")'>Contact</button></p>";

			$ret_str = $ret_str."</div></div><!--/div--></li>";

		}
		$ret_str = $ret_str."</div>";
	}
	$conn->close();
}

echo $ret_str;

?>