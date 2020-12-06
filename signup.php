<html>
<body>

<?php
//connection
$servername = "localhost";
$username = "root";
$password = "mysql";
$dbname = "reyesdb";

$conn = new mysqli($servername, $username, $password, $dbname);
if($conn->connect_error){
	die("Connection Failed : " .$conn->connect_error);
	}
//creates variables
$firstName = $_POST["fname"];
$lastName = $_POST["lname"];
$email = $_POST["email"];
$state = $_POST["state"];
$city = $_POST["city"];
$years = $_POST["years"];
$pass = $_POST["psw"];

//Hashes password
//$hashed = password_hash($pass, PASSWORD_DEFAULT);
$table = "SELECT * from users where Email= '$email'";
$result = mysqli_query($conn, $table);
$count = mysqli_num_rows($result);
if($count > 0){
	echo"
	<script> alert('Email address is taken. Enter a different one or login');
	window.location = 'SIGN-UPPAGE.html';
	</script>";
}
else{
$sql = "INSERT INTO users(FirstName,LastName,Email,Password,State,City,YearsLicensed)VALUES('$firstName','$lastName','$email','$pass','$state','$city','$years')";
if ($conn->query($sql) === TRUE) {
 echo "<script> alert('Account created successfully. Please login');
 window.location = 'LOGIN.html';
 </script>";

}
else {
 echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
}
?>

</body>
</html>