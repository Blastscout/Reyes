<?php
$servername = "127.0.0.1";
$username = "root";
$password = "mysql";
$dbname = "reyesdb";
$db_conx = new mysqli($servername, $username, $password, $dbname);



$notification_list = "";
$sql = "SELECT * FROM notifications WHERE UserID LIKE BINARY '$log_username' ORDER BY date_time DESC";
$result = $db_conx->query($sql);
$numrows = $result->num_rows;
if($numrows < 1){
	$notification_list = "You do not have any notifications";
} else {
	while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		$noteid = $row["ID"];
		$initiator = $row["initiator"];
		$app = $row["app"];
		$note = $row["note"];
		$date_time = $row["date_time"];
		$date_time = strftime("%b %d, %Y", strtotime($date_time));
		$notification_list .= "<p><a href='user.php?u=$initiator'>$initiator</a> | $app<br />$note</p>";
	}
}
mysqli_query($db_conx, "UPDATE users SET notescheck=now() WHERE UserID='$log_username' LIMIT 1");
?><?php
$colleague_requests = "";
$sql = "SELECT * FROM colleagues WHERE UserID2='$log_username' AND accepted='0' ORDER BY Datemade ASC";
$result = $db_conx->query($sql);
$numrows = $result->num_rows;
if($numrows < 1){
	$colleague_requests = 'No colleague requests';
} else {
	while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		$reqID = $row["ID"];
		$user1 = $row["UserID"];
		$datemade = $row["Datemade"];
		$datemade = strftime("%B %d", strtotime($datemade));
		$thumbquery = mysqli_query($db_conx, "SELECT picture FROM users WHERE UserID='$user1' LIMIT 1");
		$thumbrow = mysqli_fetch_row($thumbquery);
		$user1picture = $thumbrow[0];
		$user1pic = '<img src="user/'.$user1.'/'.$user1picture.'" alt="'.$user1.'" class="user_pic">';
		if($user1picture == NULL){
			$user1pic = '<img src="images/demo/avatar.png" alt="'.$user1.'" class="user_pic">';
		}
		$colleague_requests .= '<div id="colleaguereq_'.$reqID.'" class="colleaguerequests">';
		$colleague_requests .= '<a href="user.php?u='.$user1.'">'.$user1pic.'</a>';
		$colleague_requests .= '<div class="user_info" id="user_info_'.$reqID.'">'.$datemade.' <a href="user.php?u='.$user1.'">'.$user1.'</a> requests colleagueship<br /><br />';
		$colleague_requests .= '<button onclick="colleagueReqHandler(\'accept\',\''.$reqID.'\',\''.$user1.'\',\'user_info_'.$reqID.'\')">accept</button> or ';
		$colleague_requests .= '<button onclick="colleagueReqHandler(\'reject\',\''.$reqID.'\',\''.$user1.'\',\'user_info_'.$reqID.'\')">reject</button>';
		$colleague_requests .= '</div>';
		$colleague_requests .= '</div>';
	}
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Notifications and Colleague Requests</title>
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="style/style.css">
<style type="text/css">
div#notesBox{float:left; width:200px; border:#F0F 1px dashed; margin-right:60px; padding:10px;}
div#colleagueReqBox{float:left; width:200px; border:#F0F 1px dashed; padding:10px;}
div.colleaguerequests{height:74px; border-bottom:#CCC 1px solid; margin-bottom:8px;}
img.user_pic{float:left; width:68px; height:68px; margin-right:8px;}
div.user_info{float:left; font-size:14px;}
</style>
<script src="js/main.js"></script>
<script src="js/ajax.js"></script>
<script type="text/javascript">
function colleagueReqHandler(action,reqid,user1,elem){
	var conf = confirm("Press OK to '"+action+"' this colleague request.");
	if(conf != true){
		return false;
	}
	_(elem).innerHTML = "processing ...";
	var ajax = ajaxObj("POST", "php_parsers/COLLEAGUE_system.php");
	ajax.onreadystatechange = function() {
		if(ajaxReturn(ajax) == true) {
			if(ajax.responseText == "accept_ok"){
				_(elem).innerHTML = "<b>Request Accepted!</b><br />Your are now colleagues";
			} else if(ajax.responseText == "reject_ok"){
				_(elem).innerHTML = "<b>Request Rejected</b><br />You chose to reject colleagueship with this user";
			} else {
				_(elem).innerHTML = ajax.responseText;
			}
		}
	}
	ajax.send("action="+action+"&reqid="+reqid+"&user1="+user1);
}
</script>
</head>
<body>
<div id="pageMiddle">
  <!-- START Page Content -->
  <div id="notesBox"><h2>Notifications</h2><?php echo $notification_list; ?></div>
  <div id="colleagueReqBox"><h2>Friend Requests</h2><?php echo $colleague_requests; ?></div>
  <div style="clear:left;"></div>
  <!-- END Page Content -->
</div>
</body>
</html>
