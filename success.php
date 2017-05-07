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
            	$sql = "SELECT faculty from facdept WHERE department='".$department."'";
            	$result = $conn->query($sql);
            	$row = $result->fetch_assoc();

            	$faculty = $row["faculty"];

				$sql = "INSERT into person(name, department, faculty) VALUES ('" . $_POST["name"] . "','" . $department . "','" . $faculty . "')";
				if ($conn->query($sql) === TRUE) {
					$ret_str = $ret_str. "Added to person<br>";
				} else {
					$ret_str = $ret_str. "failed: " . $sql . "<br>" . $conn->error;
				}

				$sql = "SELECT ID from person WHERE name='" . $_POST["name"] . "' and department='" . $department . "' and faculty = '" . $faculty . "'";
				$result = $conn->query($sql);
				$row = $result->fetch_assoc();
				$id = $row['ID'];

				$emails = $_POST['email'];
				$emails = explode("#",$emails);

				foreach ($emails as $email) {
					$sql = "INSERT into email (ID,email) VALUES ('" . $id . "','" . $email . "')";
					if ($conn->query($sql) === TRUE) {
						$ret_str = $ret_str. $email. "added to email <br>";
					} else {
						$ret_str = $ret_str. "failed: " . $sql . "<br>" . $conn->error;
					}
				}

				$phones = $_POST['phone'];
				$phones = explode("#",$phones);

				foreach ($phones as $phone) {
					$sql = "INSERT into phone (ID,phone) VALUES ('" . $id . "','" . $phone . "')";
					if ($conn->query($sql) === TRUE) {
						$ret_str = $ret_str. $phone."added to phone <br>";
					} else {
						$ret_str = $ret_str. "failed: " . $sql . "<br>" . $conn->error;
					}
				}

				$sql = "INSERT into position (ID,position) VALUES ('" . $id . "','" . $_POST["position"] . "')";
				if ($conn->query($sql) === TRUE) {
					$ret_str = $ret_str. "added to position <br>";
				} else {
					$ret_str = $ret_str. "failed: " . $sql . "<br>" . $conn->error;
				}
			}
			else {
				$ret_str = "failed";
			}
			echo $ret_str;
            $conn->close();
        }
?>
