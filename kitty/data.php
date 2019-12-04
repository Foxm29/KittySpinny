<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "testuser";
$password = "12345";
$dbname = "test";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
	
}


$sqlQuery = "SELECT id,revolutions,start,end,catId FROM kittyspinny ORDER BY start";

$result = mysqli_query($conn,$sqlQuery);

$data = array();
foreach ($result as $row) {
	$data[] = $row;
}

mysqli_close($conn);

echo json_encode($data);
?>