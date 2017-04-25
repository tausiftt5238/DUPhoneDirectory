<?php
    header('Content-Type: text/html; charset=utf-8');
    session_start();

    $servername = "localhost";
    $username = "adminman";
    $password = "password";
    $dbname = "directory_uni";

    //create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    $conn->set_charset('utf8mb4');

    $username = $_POST["username"];
    $password = $_POST["password"];

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $ret_str = "";
    $sql = "SELECT * FROM users WHERE username = '".$username."' AND password='".$password."'";

    $result = $conn->query($sql);
    if($result->num_rows == 0) {
        $ret_str = "Wrong Username/Password";
    }
    else {
        $_SESSION["username"] = $username;
        $ret_str = "Success";
    }

    $conn->close();
    echo $ret_str;
?>
