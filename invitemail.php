<?php
header('Content-Type: text/html; charset=utf-8');
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();
$servername = "localhost";
$username = "adminman";
$password = "password";
$dbname = "directory_uni";

if(isset($_SESSION["username"]) && $_SESSION["username"] == "admin") {
	//create connection
	$conn = new mysqli($servername, $username, $password, $dbname);
	$conn->set_charset('utf8mb4');
	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	$email = $_POST["email"];
	$department = $_POST["department"];

	$length = 10;

	$inviteCode = "";
	$characters = "0123456789abcdefghijklmnopqrstuvwxyz";
	for ($p = 0; $p < $length; $p++) {
		$inviteCode .= $characters[mt_rand(0, strlen($characters))];
	}

	$sql = "INSERT INTO invites(email,department,invitecode) VALUES ('" . $email . "','" . $department . "','" . $inviteCode . "')";

	$conn->query($sql);

	require_once 'lib/swift_required.php';

	$subject = 'Invite to DU Holud Boi'; // Give the email a subject
	$address = "http://103.251.247.107/weblab/phone_directory/signup.html";
	$body = "To sign up to DU Holud Boi use the following invite code: " . $inviteCode . " at this link: " . $address."Your department is ".$department;

	printf("\n\nhere\n\n");
	$transport = Swift_SmtpTransport::newInstance('smtp.gmail.com', 465, "ssl")
		->setUsername('duholudboi@gmail.com')
		->setPassword('directory_uni')
		->setEncryption('ssl');

	$mailer = Swift_Mailer::newInstance($transport);

	$message = Swift_Message::newInstance($subject)
		->setFrom(array('noreply@holudboi.com' => 'Holud Boi'))
		->setTo(array($email))
		->setBody($body);

	$result = $mailer->send($message);

	$conn->close();

	echo "Invite Sent";
}
else {
	echo $_SESSION["username"];
}

?>