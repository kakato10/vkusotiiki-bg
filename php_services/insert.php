<?php

require_once 'InitiateConnectionToDB.php';

$name = $_POST['id'];
$email = $_POST['email'];

$sql = "INSERT INTO `service`.`user` (`id`, `email`) VALUES (NULL, '$email');";

if ($connection->query($sql)) {
$msg = array("status" =>1 , "msg" => "Your record inserted successfully");
} else {
echo "Error: " . $sql . "<br>" . mysqli_error($connection);
}
 
$json = $msg;
 
header('content-type: application/json');
echo json_encode($json);
 
 
@mysqli_close($conn);

?>