<?php
$servername = "127.0.0.1";
$username = "root";
$password = "mysql";
$dbname = "reyesdb";
$db_conx = new mysqli($servername, $username, $password, $dbname);
session_start();
$ret = $_SESSION['row'];



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
        <li><a href=complaintForm.html>File Complaint</a></li>
		    <li><a href="logout.php">LOGOUT</a></li>

      </ul>
    </div>
    <div class="fl_right">
      <ul class="nospace">
        <li>Signed in as: </li>
        <li><?php echo $ret['FirstName']; echo " "; echo $ret['LastName'];?></li>
        <li> <a href="notifications.php"> Notifications</a> </li>

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
              <li><a href=BROWSEAGENTSLOCATION.php>By Location</a></li>
              <li><a href=BROWSEAGENTSRATING.php>By Rating</a></li>
              <li><a href=BROWSEAGENTSEXP.php>By Years of Experience</a></li>
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
<h1><u>NOTIFACTION CENTER</u></h1>
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
</div>
</div>
</div>
<div class="wrapper row2">
  <figure class="hoc container clear clients"> 
    <!-- ################################################################################################ -->
    
    <!-- ################################################################################################ -->
  </figure>
</div>
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<div class="wrapper row4">
  <footer id="footer" class="hoc clear"> 
    <!-- ################################################################################################ -->
    <div class="one_quarter first">
      <h6 class="heading">Contact Us</h6>
      <ul class="nospace btmspace-30 linklist contact">
        <li><i class="fas fa-map-marker-alt"></i>
          <address>
          TBD
          </address>
        </li>
        <li><i class="fas fa-phone"></i> 1-(690)-REYES-00</li>
        <li><i class="far fa-envelope"></i> reyescompany@domain.com</li>
      </ul>
      <ul class="faico clear">
        <li><a class="faicon-facebook" href="#"><i class="fab fa-facebook"></i></a></li>
        <li><a class="faicon-twitter" href="#"><i class="fab fa-twitter"></i></a></li>
        <li><a class="faicon-dribble" href="#"><i class="fab fa-dribbble"></i></a></li>
        <li><a class="faicon-linkedin" href="#"><i class="fab fa-linkedin"></i></a></li>
      </ul>
    </div>
    <div class="one_quarter">
      <h6 class="heading">About Reyes</h6>
      <ul class="nospace linklist">
        <li><a href="#">Company Information</a></li>
        <li><a href="#">Careers</a></li>
        <li><a href="#">Sitemap</a></li>
      </ul>
    </div>
    <div class="one_quarter">
      <h6 class="heading">Privacy</h6>
      <ul class="nospace linklist">
        <li><a href="#">Private Policy</a></li>
        <li><a href="#">Documens & Policies</a></li>
        <li><a href="#">Terms of Use</a></li>
      </ul>
    </div>
    <div class="one_quarter">
      <h6 class="heading">Sign-Up for our newsletter!</h6>
      <p class="nospace btmspace-15">Enter your name and e-mail here to get weekly notifactations for articles on agents.</p>
      <form method="post" action="#">
        <fieldset>
          <legend>Newsletter:</legend>
          <input class="btmspace-15" type="text" value="" placeholder="Name">
          <input class="btmspace-15" type="text" value="" placeholder="Email">
          <button type="submit" value="submit">Submit</button>
        </fieldset>
      </form>
    </div>
    <!-- ################################################################################################ -->
  </footer>
</div>
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<div class="wrapper row5">
  <div id="copyright" class="hoc clear"> 
    <!-- ################################################################################################ -->
    <p class="fl_left">Copyright &copy; 2021 - All Rights Reserved - <a href="#">Reyes</a></p>
    <!-- ################################################################################################ -->
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
