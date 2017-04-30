<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
if(isset($_SESSION['username'])) {

	$servername = "localhost";
	$username = "adminman";
	$password = "password";
	$dbname = "directory_uni";

	//create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	$conn->set_charset('utf8mb4');

	$ret_str = "";
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	$username = $_SESSION['username'];

	$sql = "SELECT department FROM users WHERE username='".$username."'";
	$result = $conn->query($sql);
	if($result->num_rows>0) {
		$row = $result->fetch_assoc();

		$department = $row["department"];

		$sql = "SELECT department FROM person where ID='". $_POST["id"] ."'";
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();

		if($department == $row["department"]) {

			$sql = "DELETE FROM email WHERE ID='".$_POST["id"]."'";
			if ($conn->query($sql) === TRUE) {
				$ret_str = $ret_str. "Deleted<br>";
			} else {
				$ret_str = $ret_str. "failed: " . $sql . "<br>" . $conn->error;
			}

			$sql = "DELETE FROM phone WHERE ID='".$_POST["id"]."'";
			if ($conn->query($sql) === TRUE) {
				$ret_str = $ret_str. "Deleted<br>";
			} else {
				$ret_str = $ret_str. "failed: " . $sql . "<br>" . $conn->error;
			}

			$sql = "DELETE FROM position WHERE ID='".$_POST["id"]."'";
			if ($conn->query($sql) === TRUE) {
				$ret_str = $ret_str. "Deleted<br>";
			} else {
				$ret_str = $ret_str. "failed: " . $sql . "<br>" . $conn->error;
			}

			$sql = "DELETE FROM person WHERE ID='".$_POST["id"]."'";
			if ($conn->query($sql) === TRUE) {
				$ret_str = $ret_str. "Deleted<br>";
			} else {
				$ret_str = $ret_str. "failed: " . $sql . "<br>" . $conn->error;
			}

		}
		else {
			$ret_str = "failed";
		}

	}
	else {
		$ret_str = "failed";
	}
	echo $ret_str;
	$conn->close();
}
?>