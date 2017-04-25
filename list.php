<?php
        header('Content-Type: text/html; charset=utf-8');

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

        $name = $_POST["name"];
        $dept = $_POST["department"];
        $faculty = $_POST["faculty"];
        $position = $_POST["position"];
        $sql = "SELECT * FROM person INNER JOIN position on person.ID = position.ID";
        $count = 0;
        if($name!="#"||$dept!="#"||$faculty!="#"||$position!="#")
          $sql = $sql." WHERE ";

        if($name!="#") {
          $count++;
          $sql = $sql." name LIKE '%".$name."%'";
        }

        if($dept!="#") {
          $count++;
          if($count > 1)
              $sql = $sql." AND ";
          $sql = $sql." department LIKE '%".$dept."%'";
        }

        if($faculty!="#") {
          $count++;
          if($count > 1)
              $sql = $sql." AND ";
          $sql = $sql." faculty LIKE '%".$faculty."%'";
        }

        if($position!="#") {
          $count++;
          if($count > 1)
              $sql = $sql." AND ";
          $sql = $sql." position LIKE '%".$position."%'";
        }
        //$ret_str = $ret_str.$sql;
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {

			$ret_str = $ret_str."<div id='contactlist'>";
            // output data of each row
            while($row = $result->fetch_assoc()) {
                //$ret_str = $ret_str."<div class=\"row\">";
                $ret_str = $ret_str."<!--<div class=\"col-sm-4\">--><li><div class=\"card\">";
                $ret_str = $ret_str."  <div class=\"container\">";
                $ret_str = $ret_str."    <h1>".$row['name']."</h1>";
                $ret_str = $ret_str."<p class=\"title\">".$row['position']."</p>";
                $ret_str = $ret_str."    <p>".$row['department']."</p>";
                $ret_str = $ret_str."    <p>".$row['faculty']."</p>";
                $ret_str = $ret_str."   <p><button onclick='details(\"".$row['ID']."\")'>Contact</button></p>";
                /*$ret_str = $ret_str."Email: <br>";

                $email_sql = "SELECT email FROM email WHERE ID=".$row['ID'];
                $email_result = $conn->query($email_sql);

                if($email_result->num_rows > 0){
                    while($email_row = $email_result->fetch_assoc()){
                        $ret_str = $ret_str.$email_row['email']."<br>";
                    }
                }

                $ret_str = $ret_str."Phone: <br>";

                $phone_sql = "SELECT phone FROM phone WHERE ID=".$row['ID'];
                $phone_result = $conn->query($phone_sql);

                if($phone_result->num_rows > 0){
                    while($phone_row = $phone_result->fetch_assoc()){
                        $ret_str = $ret_str.$phone_row['phone']."<br>";
                    }
                }*/
                $ret_str = $ret_str."</div></div><!--/div--></li>";

            }
            $ret_str = $ret_str."</div>";
        } else {
            $ret_str = $ret_str."0 results";
        }
        $conn->close();


        echo $ret_str;
?>
