<?php
    //session_start();
    require_once 'ServerConfig.php';
	require_once 'InitiateConnectionToDB.php';
	
	// Get all business user's data
	function get_all_business_users_data($conn){
		$table_name = "user";
		$sql = "SELECT * FROM user AS U INNER JOIN business_user AS B ON U.id = B.user";
		$result = $conn->query($sql);
		//echo "$stmt";
		if($result === false) {
		 echo json_encode('Wrong SQL: ' . $sql . ' Error: ' . $conn->errno . ' ' . $conn->error, E_USER_ERROR);
		 return;
		}
		else {
			echo "Records printing" . "<br>";
			$rows[] = array();
			while ($row = $result->fetch_assoc()) {
				$rows[] = $row;
			}
			//foreach($rows as $row){
				//echo $row["name"] . "<br>";
			//}
		}
		unset($rows[key($rows)]);
		echo json_encode(array_values($rows));
	}
	
    // Get business user's data by id
	function get_business_user_data_by_id($conn, $id){
		$sql = "SELECT * FROM user AS U INNER JOIN business_user AS B ON U.id = B.user WHERE U.id = '$id'";
		$result = $conn->query($sql);
		if($result === false) {
		  echo json_encode('Wrong SQL: ' . $sql . ' Error: ' . $conn->errno . ' ' . $conn->error, E_USER_ERROR);
		  return;
		}
		else {
			echo "Records printing" . "<br>";
			$row = $result->fetch_assoc();
		}
		echo json_encode($row);
	}
	
    // Insert into business user
	function insert_into_business_user($conn){
		// Set parameters and execute
		/*
		$first_name = "Michael";
		$last_name = "Thiessen";
		$location = 1;
		$password = "1234567";
		$email = "michael@demo.com";
		$image = 1;
		$address = "ул. Черно Море 43";
		$telephone_num = 0898346423;
		*/
		global $app;
		$req = $app->request();
		$body = json_decode($req->getBody());
		
		$sql = "INSERT INTO user (first_name, last_name, location, password, email, image) VALUES (?, ?, ?, ?, ?, ?)";
		$stmt = $conn->prepare($sql);
		if($stmt === false) {
		  echo json_encode('Wrong SQL: ' . $sql . ' Error: ' . $conn->errno . ' ' . $conn->error, E_USER_ERROR);
		  return;
		}
		$sql1 = "INSERT INTO business_user (address, telephone_num, user) VALUES (?, ?, ?)";
		$stmt1 = $conn->prepare($sql1);
		if($stmt1 === false) {
		   echo json_encode('Wrong SQL: ' . $sql . ' Error: ' . $conn->errno . ' ' . $conn->error, E_USER_ERROR);
		   return;
		}
		else {
			$conn->query("START TRANSACTION");
			
		    // Bind parameters. Types: s = string, i = integer, d = double,  b = blob 
		    $stmt->bind_param("ssissi", $body->first_name, $body->last_name, $body->location, $body->password, $body->email, $body->image);
		    $stmt->execute();
			
			$last_user_id = $conn->insert_id;
			echo "last_user_id: $last_user_id";
			
			 // Bind parameters. Types: s = string, i = integer, d = double,  b = blob 
		    $stmt1->bind_param("ssi", $body->address, $body->telephone_num, $last_user_id);
		    $stmt1->execute();
			
			$conn->query("COMMIT");
			echo "New records created successfully\n";
		}
	}
		
	// Update a business business_user with an id
	function update_business_user_by_user_id($conn, $user_id){
		// Set parameters and execute
		/*
		$user_id = 37;
		$first_name = "Michael";
		$last_name = "Tompson";
		$location = 1;
		$password = "987654321";
		$email = "michael@demo.bg";
		$image = 1;
		$address = "ул. Черно Море 46";
		$telephone_num = 087883223;
		*/
		
		$sql = "UPDATE user SET first_name = ?, last_name = ?, location = ?, password = ?, email = ?, image = ? WHERE id = ?";
		$stmt = $conn->prepare($sql);
		if($stmt === false) {
		  echo json_encode('Wrong SQL: ' . $sql . ' Error: ' . $conn->errno . ' ' . $conn->error, E_USER_ERROR);
		  return;
		}
		
		$sql1 = "UPDATE business_user SET address = ?, telephone_num = ? WHERE user = ?";
		$stmt1 = $conn->prepare($sql1);
		if($stmt === false) {
		  trigger_error('Wrong SQL: ' . $sql1 . ' Error: ' . $conn->errno . ' ' . $conn->error, E_USER_ERROR);
		  return;
		}
		else {
		   $conn->query("START TRANSACTION");
			
		    // Bind parameters. Types: s = string, i = integer, d = double,  b = blob 
		    $stmt->bind_param("ssissii", $body->first_name, $body->last_name, $body->location, $body->password, $body->email, $body->image, $user_id);
		    $stmt->execute();
			
			 // Bind parameters. Types: s = string, i = integer, d = double,  b = blob 
		    $stmt1->bind_param("ssi", $body->$address, $body->telephone_num, $user_id);
		    $stmt1->execute();
			
			$conn->query("COMMIT");
			//echo "Records updated successfully\n";
		}
	}
		
    // Delete a business user with an user id
	function delete_business_user_by_user_id($conn, $user_id){
		// Set parameters and execute
		// $id = "37";
		// $stmt = $conn->prepare("DELETE FROM user WHERE name = ?");
		$stmt = $conn->prepare("DELETE FROM user WHERE id = ?");
		if($stmt === false) {
		  echo json_encode('Wrong SQL: ' . $sql . ' Error: ' . $conn->errno . ' ' . $conn->error, E_USER_ERROR);
		  return;
		}
		else {		
		    // Bind parameters. Types: s = string, i = integer, d = double,  b = blob 
		    $stmt->bind_param("i", $user_id);
		    $stmt->execute();
			//echo "Record deleted successfully\n";
		}
	}
?>