<!DOCTYPE html>
<?php
session_start();
$ret = $_SESSION['row'];
if(!isset($ret['UserID'])){
	header('location:login.html');
	}
?>

<html lang="">
<head>
<title>REYES REAL ESTATE NETWORK</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<link href="layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
</head>
<body id="top">
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<div class="wrapper row0">
  <div id="topbar" class="hoc clear"> 
    <!-- ################################################################################################ -->
    <div class="fl_left">
      <ul class="nospace">
        <li><a href="home.php"><i class="fas fa-home fa-lg"></i></a></li>
        <li><a href="#">About</a></li>
        <li><a href="mailto:ogorzalm@go.stockton.edu">Contact</a></li>
        <li><a href="#">Login</a></li>
        <li><a href=SIGN-UPPAGE.html>Register</a></li>
		<li><a href="#">File Complaint</a></li>
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
      <li class="active"><a href="home.php">Home</a></li>
      <li><a class="drop" href="#">Explore</a>
        <ul>
          <li><a href="pages/gallery.html">Agent Gallery</a></li>
          <li><a href="pages/full-width.html">full-width</a></li>
          <li><a href="pages/sidebar-left.html">leftsidebar</a></li>
          <li><a href="pages/sidebar-right.html">Sidebar Right</a></li>
          <li><a href="pages/basic-grid.html">Basic Grid</a></li>
          <li><a href="pages/font-icons.html">Font Icons</a></li>
        </ul>
      </li>
      <li><a class="drop" href="#">Browse Agents</a>
        <ul>
          <li><a href=BROWSEAGENTS.html>Browse Agents...</a></li>
          <li><a class="drop" href="#">Browse Agents By Filter...</a>
            <ul>
              <li><a href=BROWSEAGENTSLOCATION.html>By Location</a></li>
              <li><a href=BROWSEAGENTSRATING.html>By Rating</a></li>
              <li><a href=BROWSEAGENTSEXP.html>By Years of Experience</a></li>
            </ul>
          </li>
        </ul>
      </li>
      <li><a href="#">Link Text</a></li>
      <li><a href="#">Link Text</a></li>
      <li><a href="#">Link Text</a></li>
      <li><a href="#">Long Link Text</a></li>
    </ul>
    <!-- ################################################################################################ -->
  </nav>
</div>
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<!-- ################################################################################################ -->
<div class="wrapper row3">
  <main class="hoc container clear"> 
    <!-- main body -->
    <!-- ################################################################################################ -->
    <div class="content"> 
<h1><u>Browse Agents</u></h1>
      <div class="scrollable">
        <table>
          <thead>
            <tr>
            <th>Name</th>
              <th>Location</th>
   			  <th>Years with Real Estate License</th>
			  <th>E-mail</th>
            </tr>
            <?php
			$servername = "127.0.0.1";
			$username = "root";
			$password = "mysql";
			$dbname = "reyesdb";
      $conn = new mysqli($servername, $username, $password, $dbname);
      $ID = $ret['UserID'];
			$sql = "Select FirstName,LastName, YearsLicensed,City,State,Email from users where UserID != $ID";
			$result = $conn->query($sql);
			if ($result->num_rows>0){
				while ($row = $result-> fetch_assoc()){
					echo"<tr><td>".$row['FirstName']." ". $row['LastName']."</td><td>".$row['City'].", ".$row['State']."</td><td>".$row['YearsLicensed']."</td><td>".$row['Email']."</td></tr>";
					}
				echo "</table>";
				}
			else{
				echo "No results";
				}
			$conn->close();
			?>

        </table>
      </div>
	 </div>
	 </div>
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
    <p class="fl_left">Copyright &copy; 2021 - All Rights Reserved - <a href="#">Mogorzalek</a></p>
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