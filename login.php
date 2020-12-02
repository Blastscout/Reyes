
<html>
<body>
<?php
$servername = "127.0.0.1";
$username = "root";
$password = "mysql";
$dbname = "reyesdb";

$email = $_POST['email'];
$pass = $_POST['psw'];

$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if (!$conn) {
 die("Connection failed: " . mysqli_connect_error());
}
$sql = "SELECT * FROM users WHERE email = '$email' and
password = '$pass'";
$result = $conn->query($sql);
if ($result->num_rows === 1) {
 session_start();
 $row = $result->fetch_assoc();
unset($_SESSION['row']);

if (!isset($_SESSION['row'])) {
 $_SESSION['row'] = $row;
 header('location:home.php');
}
} else {
    echo"
	<script> alert('Incorrect email or password. Try again');
	window.location = 'LOGIN.html';
	</script>";
 }
$conn->close();
?>
</body>
</html>