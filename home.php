<?php
session_start();
$ret = $_SESSION['row'];
if(!isset($ret['UserID'])){
	header('location:login.html');
	}
?>
<html>
<head>
<title> Your Profile </title>


</head>
<body>

<div class="container">

<a class="float-right" href="logout.php">Logout</a>
<h1> Welcome <?php echo $ret['FirstName']; echo $ret['LastName'];?> </h1>

</div>

</body>

</html>
