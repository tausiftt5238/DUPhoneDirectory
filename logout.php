<!doctype html>
<meta charset="utf-8">
<html>
<head>
<?php
    session_start();
    session_unset();
    session_destroy();

?>
</head>
<body onload="window.location.href = 'show'">

</body>
</html>