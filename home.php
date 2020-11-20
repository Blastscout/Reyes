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
        <li><a href="index.html"><i class="fas fa-home fa-lg"></i></a></li>
        <li><a href="#">About</a></li>
        <li><a href="mailto:ogorzalm@go.stockton.edu">Contact</a></li>
        <li><a href=LOGIN.html>Login</a></li>
        <li><a href=SIGN-UPPAGE.html>Register</a></li>
		<li><a href="logout.php">LOGOUT</a></li>
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
	<div class="one_quarter"><strong><i class="far fa-clock rgtspace-5"></i><?php echo $ret['FirstName']; echo $ret['LastName'];?></div>
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
          <li><a href=BROWSEAGENTS.html>Browse Agents</a></li>
          <li><a href=ABOUT.html>What Does this Site Do?</a></li>
          <li><a href=TUTORIAL.html>Get Started Here</a></li>
          <li><a href=CONTACT.html>Our Socia Medias</a></li>
          <li><a href=CONTACT.html>Contact Us </a></li>
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
      <li><a href="#">Get Started Here</a></li>
      <li><a href="#">Our Socia Medias</a></li>
      <li><a href="#">What Does this Site Do?</a></li>
    </ul>
    <!-- ################################################################################################ -->
  </nav>
</div>
</head>
<body>
<div class="wrapper row3">
  <main class="hoc container clear"> 
    <!-- main body -->
    <!-- ################################################################################################ -->
    <div class="content"> 
<div class="container">


<h1> Welcome <?php echo $ret['FirstName']; echo $ret['LastName'];?> </h1>
<a class="float-right" href="logout.php">Logout</a>
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
          Street Name &amp; Number, Town, Postcode/Zip
          </address>
        </li>
        <li><i class="fas fa-phone"></i> +00 (123) 456 7890</li>
        <li><i class="far fa-envelope"></i> info@domain.com</li>
      </ul>
      <ul class="faico clear">
        <li><a class="faicon-facebook" href="#"><i class="fab fa-facebook"></i></a></li>
        <li><a class="faicon-twitter" href="#"><i class="fab fa-twitter"></i></a></li>
        <li><a class="faicon-dribble" href="#"><i class="fab fa-dribbble"></i></a></li>
        <li><a class="faicon-linkedin" href="#"><i class="fab fa-linkedin"></i></a></li>
      </ul>
    </div>
    <div class="one_quarter">
      <h6 class="heading">Dignissim nibh ut</h6>
      <ul class="nospace linklist">
        <li><a href="#">Natoque penatibus et magnis</a></li>
        <li><a href="#">Dis parturient montes</a></li>
        <li><a href="#">Nascetur ridiculus mus</a></li>
        <li><a href="#">Vestibulum tincidunt nisi</a></li>
        <li><a href="#">Sed eleifend scelerisque</a></li>
      </ul>
    </div>
    <div class="one_quarter">
      <h6 class="heading">Vestibulum cras placerat</h6>
      <ul class="nospace linklist">
        <li><a href="#">Maecenas vestibulum molestie</a></li>
        <li><a href="#">Arcu cras sed tincidunt</a></li>
        <li><a href="#">Enim maecenas sed mi dictum</a></li>
        <li><a href="#">Dolor laoreet fringilla</a></li>
        <li><a href="#">Augue curabitur lobortis</a></li>
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
