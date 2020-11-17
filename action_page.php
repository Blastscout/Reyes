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

$sql = "INSERT INTO users(FirstName,LastName,Email,Password,State,City,YearsLicensed)VALUES('$firstName','$lastName','$email','$pass','$state','$city','$years')";
if ($conn->query($sql) === TRUE) {
 echo "Sign up successfully!";
 header("location: index.html");
}
else {
 echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close();
?>

</body>
</html>