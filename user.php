<?php
if(isset($_GET["u"])){
	$u = (int)$_GET["u"];
} else {
    header("location: home.php");
    exit();	
}
?>
<?php

$servername = "127.0.0.1";
$username = "root";
$password = "mysql";
$dbname = "reyesdb";
session_start();

$email = $_POST['email'];
$pass = $_POST['psw'];

$db_conx = new mysqli($servername, $username, $password, $dbname);
// Check connection
if (!$db_conx) {
 die("Connection failed: " . mysqli_connect_error());
}
// Initialize any variables that the page might echo
$firstname = "";
$lastname = "";
$state = "";
$city = "";
$yearslicensed = "";
// Make sure the _GET UserID is set, and sanitize it

// Select the member from the users table
$sql = "SELECT * FROM users WHERE UserID ='$u' LIMIT 1";
$user_query = mysqli_query($db_conx, $sql);
// Now make sure that user exists in the table
$numrows = $user_query->num_rows;
if($numrows < 1){
	echo "$u That user does not exist or is not yet activated, press back";
    exit();	
}
// Check to see if the viewer is the account owner
$isOwner = "no";
if($u == $log_username && $user_ok == true){
	$isOwner = "yes";
}
// Fetch the user row from the query above
while ($row = mysqli_fetch_array($user_query, MYSQLI_ASSOC)) {
	$profile_id = $row["UserID"];
	$firstname = $row["FirstName"];
	$lastname = $row["LastName"];
	$state = $row["State"];
	$city = $row["City"];
	$yearslicensed = $row["YearsLincensed"];
}
?>
<?php
$isColleague = false;
$ownerBlockViewer = false;
$viewerBlockOwner = false;
if($u != $log_username && $user_ok == true){
	$colleague_check = "SELECT ID FROM colleagues WHERE UserID='$log_username' AND UserID2='$u' AND accepted='1' OR UserID='$u' AND UserID2='$log_username' AND accepted='1' LIMIT 1";
	if(mysqli_num_rows(mysqli_query($db_conx, $colleague_check)) > 0){
        $iscolleague = true;
    }
	$block_check1 = "SELECT ID FROM blockedusers WHERE UserID2='$u' AND UserID='$log_username' LIMIT 1";
	if(mysqli_num_rows(mysqli_query($db_conx, $block_check1)) > 0){
        $ownerBlockViewer = true;
    }
	$block_check2 = "SELECT ID FROM blockedusers WHERE UserID='$log_username' AND UserID2='$u' LIMIT 1";
	if(mysqli_num_rows(mysqli_query($db_conx, $block_check2)) > 0){
        $viewerBlockOwner = true;
    }
}
?><?php 
$colleague_button = '<button disabled>Request As Colleague</button>';
$block_button = '<button disabled>Block User</button>';
// LOGIC FOR Colleague BUTTON
if($isColleague == true){
	$colleague_button = '<button onclick="colleagueToggle(\'uncolleague\',\''.$u.'\',\'colleagueBtn\')">Uncolleague</button>';
} else if($user_ok == true && $u != $log_username && $ownerBlockViewer == false){
	$colleague_button = '<button onclick="colleagueToggle(\'colleague\',\''.$u.'\',\'colleagueBtn\')">Request As Colleague</button>';
}
// LOGIC FOR BLOCK BUTTON
if($viewerBlockOwner == true){
	$block_button = '<button onclick="blockToggle(\'unblock\',\''.$u.'\',\'blockBtn\')">Unblock User</button>';
} else if($user_ok == true && $u != $log_username){
	$block_button = '<button onclick="blockToggle(\'block\',\''.$u.'\',\'blockBtn\')">Block User</button>';
}
?><?php
$colleaguesHTML = '';
$colleagues_view_all_link = '';
$sql = "SELECT COUNT(ID) FROM colleagues WHERE UserID='$u' AND accepted='1' OR UserID2='$u' AND accepted='1'";
$query = mysqli_query($db_conx, $sql);
$query_count = mysqli_fetch_row($query);
$colleague_count = $query_count[0];
if($colleague_count < 1){
	$colleaguesHTML = $u." has no colleagues yet";
} else {
	$max = 18;
	$all_colleagues = array();
	$sql = "SELECT UserID FROM colleagues WHERE UserID2='$u' AND accepted='1' ORDER BY RAND() LIMIT $max";
	$query = mysqli_query($db_conx, $sql);
	while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		array_push($all_colleagues, $row["UserID"]);
	}
	$sql = "SELECT UserID2 FROM colleagues WHERE UserID ='$u' AND accepted='1' ORDER BY RAND() LIMIT $max";
	$query = mysqli_query($db_conx, $sql);
	while ($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		array_push($all_colleagues, $row["UserID2"]);
	}
	$colleagueArrayCount = count($all_colleagues);
	if($colleagueArrayCount > $max){
		array_splice($all_colleagues, $max);
	}
	if($colleague_count > $max){
		$colleagues_view_all_link = '<a href="view_colleagues.php?u='.$u.'">view all</a>';
	}
	$orLogic = '';
	foreach($all_colleagues as $key => $user){
			$orLogic .= "UserID='$user' OR ";
	}
	$orLogic = chop($orLogic, "OR ");
	$sql = "SELECT UserID, Picture FROM users WHERE $orLogic";
	$query = mysqli_query($db_conx, $sql);
	while($row = mysqli_fetch_array($query, MYSQLI_ASSOC)) {
		$colleagues_username = $row["FirstName"]; echo " "; $row["LastName"];
		$colleague_picture = $row["Picture"];
		if($colleague_pic != ""){
			$colleague_pic = 'user/'.$colleagues_username.'/'.$colleague_picture.'';
		} else {
			$colleague_pic = 'images/avatar.png';
		}
		$colleaguesHTML .= '<a href="user.php?u='.$colleagues_username.'"><img class="colleaguepics" src="'.$colleague_pic.'" alt="'.$colleagues_username.'" title="'.$colleagues_username.'"></a>';
	}
}
?>
<!DOCTYPE html>

<html lang="">
<head>
<title>REYES REAL ESTATE NETWORK</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link href="layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
</head>
<body id="top">
<style>
input[type=text], input[type=password] {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid #ccc;
  box-sizing: border-box;
}
</style>
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<div class="wrapper row0">
  <div id="topbar" class="hoc clear"> 
    <!-- ################################################################################################ -->
    <div class="fl_left">
      <ul class="nospace">
        <li><a href="index.html"><i class="fas fa-home fa-lg"></i></a></li>
        <li><a href="#">About</a></li>
        <li><a href="mailto:ogorzalm@go.stockton.edu">Contact</a></li>
        <li><a href=LOGIN.html>Login</a></li>
        <li><a href=SIGN-UPPAGE.html>Register</a></li>
		<li><a href=complaintForm.html>File Complaint</a></li>
      </ul>
    </div>
    <div class="fl_right">
      <ul class="nospace">
        <li><i class="fas fa-phone rgtspace-5"></i> +00 (123) 456 7890</li>
        <li><i class="fas fa-envelope rgtspace-5"></i> <a href="mailto:ogorzalm@go.stockton.edu">ogorzalm@go.stockton.edu</a></li>
      </ul>
    </div>
    <!-- ################################################################################################ -->
  </div>
</div>
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<div class="wrapper row1">
  <header id="header" class="hoc clear"> 
    <!-- ################################################################################################ -->
    <div id="logo" class="one_quarter first">
      <h1><a href="index.html"><b>REYES REAL ESTATE SOCIAL NETWORK</b></a></h1>
      <p>Meet the perfect agent for you.</p>
    </div>
    <div class="one_quarter"><strong><i class="fas fa-phone rgtspace-5"></i> Call Us:</strong> +00 (123) 456 7890</div>
    <div class="one_quarter"><strong><i class="far fa-clock rgtspace-5"></i> Mon. - Sat.:</strong> 08:00am - 18:00pm</div>
    <div class="one_quarter">
      <form action="#" method="post">
        <label>
          <select>
            <option value="" selected="selected" disabled="disabled">Language</option>
            <option value="English">Default</option>
            <option value="Spanish">Spanish</option>
          </select>
        </label>
      </form>
    </div>
    <!-- ################################################################################################ -->
  </header>
</div>
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<div class="wrapper row2">
  <nav id="mainav" class="hoc clear"> 
    <!-- ################################################################################################ -->
    <ul class="clear">
      <li class="active"><a href="index.html">Home</a></li>
      <li><a class="drop" href="#">Explore</a>
        <ul>
          <li><a href=BROWSEAGENTS.php>Browse Agents</a></li>
          <li><a href=ABOUT.html>What Does this Site Do?</a></li>
          <li><a href=TUTORIAL.html>Get Started Here</a></li>
          <li><a href=CONTACT.html>Our Socia Medias</a></li>
          <li><a href=CONTACT.html>Contact Us </a></li>
        </ul>
      </li>
      <li><a class="drop" href="#">Browse Agents</a>
        <ul>
          <li><a href=BROWSEAGENTS.php>Browse Agents...</a></li>
          <li><a class="drop" href="#">Browse Agents By Filter...</a>
            <ul>
              <li><a href=BROWSEAGENTSLOCATION.html>By Location</a></li>
              <li><a href=BROWSEAGENTSRATING.html>By Rating</a></li>
              <li><a href=BROWSEAGENTSEXP.html>By Years of Experience</a></li>
            </ul>
          </li>
        </ul>
      </li>
      <li><a href="#">Get Started Here</a></li>
      <li><a href="#">Our Socia Medias</a></li>
      <li><a href="#">What Does this Site Do?</a></li>
    </ul>
    <!-- ################################################################################################ -->
  </nav>
<div class="wrapper row3">
  <main class="hoc container clear"> 
    <!-- main body -->
    <!-- ################################################################################################ -->
    <div class="content"> 
<h1><u>Profile</u></h1>
<meta charset="UTF-8">
<title><?php echo $firstname; echo" "; echo $lastname; ?></title>
<link rel="icon" href="favicon.ico" type="image/x-icon">
<link rel="stylesheet" href="style/style.css">
<style type="text/css">
img.colleaguepics{border:#000 1px solid; width:40px; height:40px; margin:2px;}
</style>
<script src="js/main.js"></script>
<script src="js/ajax.js"></script>
<script type="text/javascript">
function colleagueToggle(type,user,elem){
	var conf = confirm("Press OK to confirm the '"+type+"' action for user <?php echo $firstname; ?>.");
	if(conf != true){
		return false;
	}
	_(elem).innerHTML = 'please wait ...';
	var ajax = ajaxObj("POST", "php_parsers/COLLEAGUES_System.php");
	ajax.onreadystatechange = function() {
		if(ajaxReturn(ajax) == true) {
			if(ajax.responseText == "colleague_request_sent"){
				_(elem).innerHTML = 'OK Colleague Request Sent';
			} else if(ajax.responseText == "uncolleague_ok"){
				_(elem).innerHTML = '<button onclick="colleagueToggle(\'colleague\',\'<?php echo $firstname; ?>\',\'colleagueBtn\')">Request As Colleague</button>';
			} else {
				alert(ajax.responseText);
				_(elem).innerHTML = 'Try again later';
			}
		}
	}
	ajax.send("type="+type+"&user="+user);
}
function blockToggle(type,blockee,elem){
	var conf = confirm("Press OK to confirm the '"+type+"' action on user <?php echo $firstname; ?>.");
	if(conf != true){
		return false;
	}
	var elem = document.getElementById(elem);
	elem.innerHTML = 'please wait ...';
	var ajax = ajaxObj("POST", "php_parsers/block_system.php");
	ajax.onreadystatechange = function() {
		if(ajaxReturn(ajax) == true) {
			if(ajax.responseText == "blocked_ok"){
				elem.innerHTML = '<button onclick="blockToggle(\'unblock\',\'<?php echo $firstname; ?>\',\'blockBtn\')">Unblock User</button>';
			} else if(ajax.responseText == "unblocked_ok"){
				elem.innerHTML = '<button onclick="blockToggle(\'block\',\'<?php echo $firstname; ?>\',\'blockBtn\')">Block User</button>';
			} else {
				alert(ajax.responseText);
				elem.innerHTML = 'Try again later';
			}
		}
	}
	ajax.send("type="+type+"&blockee="+blockee);
}
</script>
</head>
<body>
<div id="pageMiddle">
  <h2><?php echo $firstname; echo" "; echo $lastname; ?></h2>
  <p>State: <?php echo $state; ?></p>
  <p>City: <?php echo $city; ?></p>
  <hr />
  <p>Colleague Button: <span id="colleagueBtn"><?php echo $colleague_button; ?></span> <?php echo $firstname." has ".$colleague_count." colleagues"; ?> <?php echo $colleagues_view_all_link; ?></p>
  <p>Block Button: <span id="blockBtn"><?php echo $block_button; ?></span></p>
  <hr />
  <p><?php echo $colleaguesHTML; ?></p>
 </div>
 
</div>
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<a id="backtotop" href="#top"><i class="fas fa-chevron-up"></i></a>
<!-- JAVASCRIPTS -->
<script src="layout/scripts/jquery.min.js"></script>
<script src="layout/scripts/jquery.backtotop.js"></script>
<script src="layout/scripts/jquery.mobilemenu.js"></script>
</body>
</html>
