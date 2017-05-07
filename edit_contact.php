<?php
header('Content-Type: text/html; charset=utf-8');
session_start();
if(isset($_SESSION['username'])) {

	$servername = "localhost";
	$username = "directory_uni";
	$password = "directory_uni";
	$dbname = "directory_uni";

	//create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	$conn->set_charset('utf8mb4');

	$ret_str = "";
	$len = 0;
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

			$sql = "UPDATE person SET name='". $_POST["name"] ."' WHERE ID='".$_POST["id"]."'";
			if ($conn->query($sql) === TRUE) {
				$ret_str = $ret_str. "Added to person<br>";
			} else {
				$ret_str = $ret_str. "failed: " . $sql . "<br>" . $conn->error;
			}

			$emails = $_POST['email'];
			$emails = explode("#",$emails);
			$prevmails = $_POST['prevmail'];
			$prevmails = explode("#", $prevmails);

			$len = count($emails);
			$prevlen = count($prevmails);

			for($i=0; $i < $prevlen && $_POST['prevmail']!=""; $i++) {
				$sql = "UPDATE email SET email='". $emails[$i] ."' WHERE ID='". $_POST["id"] ."' AND email='".$prevmails[$i]."'";
				if ($conn->query($sql) === TRUE) {
					$ret_str = $ret_str. $email. "updated email <br>";
				} else {
					$ret_str = $ret_str. "failed: " . $sql . "<br>" . $conn->error;
				}
			}
			if($len>$prevlen) {
				for($i=$prevlen; $i < $len; $i++) {
					$sql = "INSERT into email (ID,email) VALUES ('" . $_POST["id"] . "','" . $emails[$i] . "')";
					if ($conn->query($sql) === TRUE) {
						$ret_str = $ret_str. $email. "added to email <br>";
					} else {
						$ret_str = $ret_str. "failed: " . $sql . "<br>" . $conn->error;
					}
				}
			}
			if($_POST['prevmail']=="") {
				for($i=0; $i < $len; $i++) {
					$sql = "INSERT into email (ID,email) VALUES ('" . $_POST["id"] . "','" . $emails[$i] . "')";
					if ($conn->query($sql) === TRUE) {
						$ret_str = $ret_str. $email. "added to email <br>";
					} else {
						$ret_str = $ret_str. "failed: " . $sql . "<br>" . $conn->error;
					}
				}
			}

			$phones = $_POST['phone'];
			$phones = explode("#",$phones);
			$prevphones = $_POST['prevphone'];
			$prevphones = explode("#", $prevphones);

			$len = count($phones);
			$prevlen = count($prevphones);

			for($i=0; $i < $prevlen && $_POST['prevphone']!=""; $i++) {
				$sql = "UPDATE phone SET phone='". $phones[$i] ."' WHERE ID='". $_POST["id"] ."' AND phone='".$prevphones[$i]."'";
				if ($conn->query($sql) === TRUE) {
					$ret_str = $ret_str. $email. "updated phone <br>";
				} else {
					$ret_str = $ret_str. "failed: " . $sql . "<br>" . $conn->error;
				}
			}
			if($len>$prevlen) {
				for($i=$prevlen; $i < $len; $i++) {
					$sql = "INSERT into phone (ID,phone) VALUES ('" . $_POST["id"] . "','" . $phones[$i] . "')";
					if ($conn->query($sql) === TRUE) {
						$ret_str = $ret_str. $email. "added to phone <br>";
					} else {
						$ret_str = $ret_str. "failed: " . $sql . "<br>" . $conn->error;
					}
				}
			}

			if($_POST['prevphone']=="") {
				for($i=0; $i < $len; $i++) {
					$sql = "INSERT into phone (ID,phone) VALUES ('" . $_POST["id"] . "','" . $phones[$i] . "')";
					if ($conn->query($sql) === TRUE) {
						$ret_str = $ret_str. $email. "added to phone <br>";
					} else {
						$ret_str = $ret_str. "failed: " . $sql . "<br>" . $conn->error;
					}
				}
			}

			$sql = "UPDATE position SET position='". $_POST["position"] ."' WHERE ID='".$_POST["id"]."'";
			if ($conn->query($sql) === TRUE) {
				$ret_str = $ret_str. "added to position <br>";
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
	echo $ret_str.$len.$prevlen;
	$conn->close();
}
?>