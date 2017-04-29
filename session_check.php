<?php
    header('Content-Type: text/html; charset=utf-8');
    session_start();
    if(isset($_SESSION['username'])) {
		if($_SESSION['username'])
    		echo 'ADMIN';
		else
			echo 'USER';
	}
    else
        echo 'FALSE';
?>