<?php
//connection
$servername = "localhost";
$username = "root";
$password = "mysql";
$dbname = "reyesdb";

$db_conx = new mysqli($servername, $username, $password, $dbname);
if($db_conx->connect_error){
	die("Connection Failed : " .$conn->connect_error);
	}
if($user_ok != true || $log_username == "") {
	exit();
}
?><?php
if (isset($_POST['type']) && isset($_POST['blockee'])){
	$blockee = preg_replace('#[^a-z0-9]#i', '', $_POST['blockee']);
	$sql = "SELECT COUNT(ID) FROM users WHERE UserID='$blockee' LIMIT 1";
	$query = mysqli_query($db_conx, $sql);
	$exist_count = mysqli_fetch_row($query);
	if($exist_count[0] < 1){
		mysqli_close($db_conx);
		echo "$blockee does not exist.";
		exit();
	}
	$sql = "SELECT ID FROM blockedusers WHERE UserID='$log_username' AND UserID2='$blockee' LIMIT 1";
	$query = mysqli_query($db_conx, $sql);
	$numrows = mysqli_num_rows($query);
	if($_POST['type'] == "block"){
	    if ($numrows > 0) {
			mysqli_close($db_conx);
	        echo "You already have this member blocked.";
	        exit();
	    } else {
			$sql = "INSERT INTO blockedusers(UserID, UserID2, blockdate) VALUES('$log_username','$blockee',now())";
			$query = mysqli_query($db_conx, $sql);
			mysqli_close($db_conx);
	        echo "blocked_ok";
	        exit();
		}
	} else if($_POST['type'] == "unblock"){
	    if ($numrows == 0) {
		    mysqli_close($db_conx);
	        echo "You do not have this user blocked, therefore we cannot unblock them.";
	        exit();
	    } else {
			$sql = "DELETE FROM blockedusers WHERE UserID='$log_username' AND UserID2='$blockee' LIMIT 1";
			$query = mysqli_query($db_conx, $sql);
			mysqli_close($db_conx);
	        echo "unblocked_ok";
	        exit();
		}
	}
}
?>
