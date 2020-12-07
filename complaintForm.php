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
//create variables
$email = $_POST["Email"];
$complaineeName = $_POST["Complainee"];
$date = $_POST["DateMade"];
$reason = $_POST["Reason"];

$sql = "INSERT INTO reports(Email,Complainee,DateMade,Reason)VALUES ('$email','$complaineeName','$date','$reason')";
if ($conn->query($sql) === TRUE) {
   echo "<script> alert('Complaint was filed successfully.');
   window.location = 'index.html';
   </script>";

}
else {
   echo "Error: " . $sql . "<br>" . $conn->error;
}
$conn->close()

?>