<?php
//connection
$servername = "localhost";
$username = "root";
$password = "mysql";
$dbname = "reyesdb";

$db_conx = new mysqli($servername, $username, $password, $dbname);
if($db_conx->connect_error){
    die("Connection Failed : " .$db_conx->connect_error);
    }
?><?php
if (isset($_POST['type']) && isset($_POST['user'])){
	$user = preg_replace('#[^a-z0-9]#i', '', $_POST['user']);
	$sql = "SELECT COUNT(ID) FROM users WHERE UserID='$user' LIMIT 1";
	$query = mysqli_query($db_conx, $sql);
	$exist_count = mysqli_fetch_row($query);
	if($exist_count[0] < 1){
		mysqli_close($db_conx);
		echo "$user does not exist.";
		exit();
	}
	if($_POST['type'] == "Colleague"){
		$sql = "SELECT COUNT(ID) FROM colleagues WHERE UserID='$user' AND accepted='1' OR UserID2='$user' AND accepted='1'";
		$query = mysqli_query($db_conx, $sql);
		$colleague_count = mysqli_fetch_row($query);
		$sql = "SELECT COUNT(ID) FROM blockedusers WHERE blocker='$user' AND blockee='$log_username' LIMIT 1";
		$query = mysqli_query($db_conx, $sql);
		$blockcount1 = mysqli_fetch_row($query);
		$sql = "SELECT COUNT(ID) FROM blockedusers WHERE blocker='$log_username' AND blockee='$user' LIMIT 1";
		$query = mysqli_query($db_conx, $sql);
		$blockcount2 = mysqli_fetch_row($query);
		$sql = "SELECT COUNT(ID) FROM colleagues WHERE UserID='$log_username' AND UserID2='$user' AND accepted='1' LIMIT 1";
		$query = mysqli_query($db_conx, $sql);
		$row_count1 = mysqli_fetch_row($query);
		$sql = "SELECT COUNT(ID) FROM colleagues WHERE UserID='$user' AND UserID2='$log_username' AND accepted='1' LIMIT 1";
		$query = mysqli_query($db_conx, $sql);
		$row_count2 = mysqli_fetch_row($query);
		$sql = "SELECT COUNT(ID) FROM colleagues WHERE UserID='$log_username' AND UserID2='$user' AND accepted='0' LIMIT 1";
		$query = mysqli_query($db_conx, $sql);
		$row_count3 = mysqli_fetch_row($query);
		$sql = "SELECT COUNT(ID) FROM colleagues WHERE UserID='$user' AND UserID2='$log_username' AND accepted='0' LIMIT 1";
		$query = mysqli_query($db_conx, $sql);
		$row_count4 = mysqli_fetch_row($query);
	    if($colleague_count[0] > 99){
            mysqli_close($db_conx);
	        echo "$user currently has the maximum number of colleagues, and cannot accept more.";
	        exit();
        } else if($blockcount1[0] > 0){
            mysqli_close($db_conx);
	        echo "$user has you blocked, we cannot proceed.";
	        exit();
        } else if($blockcount2[0] > 0){
            mysqli_close($db_conx);
	        echo "You must first unblock $user in order to become a colleague with them.";
	        exit();
        } else if ($row_count1[0] > 0 || $row_count2[0] > 0) {
		    mysqli_close($db_conx);
	        echo "You are already colleagues with $user.";
	        exit();
	    } else if ($row_count3[0] > 0) {
		    mysqli_close($db_conx);
	        echo "You have a pending colleague request already sent to $user.";
	        exit();
	    } else if ($row_count4[0] > 0) {
		    mysqli_close($db_conx);
	        echo "$user has requested to colleague with you first. Check your colleague requests.";
	        exit();
	    } else {
	        $sql = "INSERT INTO colleagues(UserID, UserID2, Datemade) VALUES('$log_username','$user',now())";
		    $query = mysqli_query($db_conx, $sql);
			mysqli_close($db_conx);
	        echo "colleague_request_sent";
	        exit();
		}
	} else if($_POST['type'] == "uncolleague"){
		$sql = "SELECT COUNT(ID) FROM colleagues WHERE UserID='$log_username' AND UserID2='$user' AND accepted='1' LIMIT 1";
		$query = mysqli_query($db_conx, $sql);
		$row_count1 = mysqli_fetch_row($query);
		$sql = "SELECT COUNT(ID) FROM colleagues WHERE UserID='$user' AND UserID2='$log_username' AND accepted='1' LIMIT 1";
		$query = mysqli_query($db_conx, $sql);
		$row_count2 = mysqli_fetch_row($query);
	    if ($row_count1[0] > 0) {
	        $sql = "DELETE FROM colleagues WHERE UserID='$log_username' AND UserID2='$user' AND accepted='1' LIMIT 1";
			$query = mysqli_query($db_conx, $sql);
			mysqli_close($db_conx);
	        echo "uncolleague_ok";
	        exit();
	    } else if ($row_count2[0] > 0) {
			$sql = "DELETE FROM colleagues WHERE UserID='$user' AND UserID2='$log_username' AND accepted='1' LIMIT 1";
			$query = mysqli_query($db_conx, $sql);
			mysqli_close($db_conx);
	        echo "uncolleague_ok";
	        exit();
	    } else {
			mysqli_close($db_conx);
	        echo "No connection could be found between your account and $user, therefore we cannot uncolleague you.";
	        exit();
		}
	}
}
?><?php
if (isset($_POST['action']) && isset($_POST['reqid']) && isset($_POST['user1'])){
	$reqid = preg_replace('#[^0-9]#', '', $_POST['reqid']);
	$user = preg_replace('#[^a-z0-9]#i', '', $_POST['user1']);
	$sql = "SELECT COUNT(ID) FROM users WHERE username='$user' AND activated='1' LIMIT 1";
	$query = mysqli_query($db_conx, $sql);
	$exist_count = mysqli_fetch_row($query);
	if($exist_count[0] < 1){
		mysqli_close($db_conx);
		echo "$user does not exist.";
		exit();
	}
	if($_POST['action'] == "accept"){
		$sql = "SELECT COUNT(ID) FROM colleagues WHERE UserID='$log_username' AND UserID2='$user' AND accepted='1' LIMIT 1";
		$query = mysqli_query($db_conx, $sql);
		$row_count1 = mysqli_fetch_row($query);
		$sql = "SELECT COUNT(ID) FROM colleagues WHERE UserID='$user' AND UserID2='$log_username' AND accepted='1' LIMIT 1";
		$query = mysqli_query($db_conx, $sql);
		$row_count2 = mysqli_fetch_row($query);
	    if ($row_count1[0] > 0 || $row_count2[0] > 0) {
		    mysqli_close($db_conx);
	        echo "You are already colleagues with $user.";
	        exit();
	    } else {
			$sql = "UPDATE colleagues SET accepted='1' WHERE ID='$reqid' AND UserID='$user' AND UserID2='$log_username' LIMIT 1";
			$query = mysqli_query($db_conx, $sql);
			mysqli_close($db_conx);
	        echo "accept_ok";
	        exit();
		}
	} else if($_POST['action'] == "reject"){
		mysqli_query($db_conx, "DELETE FROM colleagues WHERE ID= '$reqid' AND UserID='$user' AND UserID2='$log_username' AND accepted='0' LIMIT 1");
		mysqli_close($db_conx);
		echo "reject_ok";
		exit();
	}
}
?>

