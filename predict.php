<?php
    $servername = "localhost";
    $username = "directory_uni";
    $password = "directory_uni";
    $dbname = "names";
     
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    } 

    $sql = "SELECT * FROM people";
    $result = $conn->query($sql);  
    if ($result->num_rows > 0) { 
        // output data of each row
        $ret_str = "predicted names:\n";
	while($row = $result->fetch_assoc()) {
		$pos = strpos($row["name"], $_GET['name']);
		if($pos !== false)
			$ret_str = $ret_str.$row["name"]."<br/>";        	
	}
	echo $ret_str;
    } else { 
        echo "0 results";
    }
    $conn->close();
?>

