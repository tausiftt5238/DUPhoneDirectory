<?php
    header('Content-Type: text/html; charset=utf-8');
    $servername = "localhost";
    $username = "directory_uni";
    $password = "directory_uni";
    $dbname = "directory_uni";

    //create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    $conn->set_charset('utf8mb4');

    $username = $_POST["username"];
    $invitecode = $_POST["invitecode"];
    $password = $_POST["password"];

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $ret_str = "";
    $sql = "SELECT * FROM invites WHERE invitecode = '".$_POST["invitecode"]."'";

    $result = $conn->query($sql);
    if($result->num_rows == 0) {
        $ret_str = "Invalid Invite Code";
    }
    else {
        $row = $result->fetch_assoc();
        $department = $row['department'];
        $sql = "INSERT into users (username,password,department) VALUES ('".$username."','".$password . "','".$department."')";
        if ($conn->query($sql) === TRUE) {
            $ret_str = "Success";
            $sql2 = "DELETE FROM `invites` WHERE invitecode ='".$invitecode."'";
            $conn->query($sql2);
        } else {
            $ret_str = "Invalid Invite Code";
        }
    }

    $conn->close();
    echo $ret_str;
?>
