<?php
    //session_start();
    require_once 'ServerConfig.php';
	require_once 'InitiateConnectionToDB.php';
	
	// Get all user's data
	function get_all_users_data(){
		global $conn;
		$table_name = "user";
		$sql = "SELECT * FROM $table_name";
		$result = $conn->query($sql);
		//echo "$stmt";
		if($result === false) {
		  echo json_encode('Wrong SQL: ' . $sql . ' Error: ' . $conn->errno . ' ' . $conn->error, E_USER_ERROR);
		  return;
		} else {
			//echo "Records printing" . "<br>";
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
	
    // Get user's data by id
	function get_user_data_by_id($id){
		global $conn;
		$table_name = "user";
		$sql = "SELECT * FROM $table_name WHERE id = $id";
		$result = $conn->query($sql);
		//echo "$stmt";
		if($result === false) {
		  echo json_encode('Wrong SQL: ' . $sql . ' Error: ' . $conn->errno . ' ' . $conn->error, E_USER_ERROR);
		  return;
		} else {
			//echo "Records printing" . "<br>";
			$row = $result->fetch_assoc();
		}
		echo json_encode($row);
	}
	
    // Insert into user
	function insert_into_user(){
		// Set parameters and execute
		/*
		$first_name = "Michael";
		$last_name = "Thiessen";
		$location = 1;
		$password = "1234567";
		$email = "michael@demo.com";
		$image = 1;
		*/
		global $app, $conn;
		$req = $app->request();
		$body = json_decode($req->getBody());
		$sql = "INSERT INTO user (first_name, last_name, location, password, email, image) VALUES (?, ?, ?, ?, ?, ?)";
		$stmt = $conn->prepare($sql);
		if($stmt === false) {
		  echo json_encode('Wrong SQL: ' . $sql . ' Error: ' . $conn->errno . ' ' . $conn->error, E_USER_ERROR);
		  return;
		}
		else {
		    // Bind parameters. Types: s = string, i = integer, d = double,  b = blob 
		    $stmt->bind_param("ssissi", $body->first_name, $body->last_name, $body->location, $body->password, $body->email, $body->image);
		    $stmt->execute();
			//echo "New records created successfully\n";
		}
	}
		
	// Update a user with an id
	function update_user_by_id($id){
		// Set parameters and execute
		/*
		$id = 37;
		$first_name = "Michael";
		$last_name = "Tompson";
		$location = 1;
		$password = "987654321";
		$email = "michael@demo.bg";
		$image = 1;
		*/
		global $app, $conn;
		$req = $app->request();
		$body = json_decode($req->getBody());
		$sql = "UPDATE user SET first_name = ?, last_name = ?, location = ?, password = ?, email = ?, image = ?
		WHERE id = ?";
		$stmt = $conn->prepare($sql);
		if($stmt === false) {
		   echo json_encode('Wrong SQL: ' . $sql . ' Error: ' . $conn->errno . ' ' . $conn->error, E_USER_ERROR);
		   return;
		}
		else {
		    // Bind parameters. Types: s = string, i = integer, d = double,  b = blob 
		    $stmt->bind_param("ssissii", $body->first_name, $body->last_name, $body->location, $body->password, $body->email, $body->image, $id);
		    $stmt->execute();
			//echo "Records updated successfully\n";
		}
	}
		
    // Delete a user with an id
	function delete_user_by_id($id){
		// Set parameters and execute
		// $id = "37";
		global $conn;
		$sql = "DELETE FROM user WHERE id = ?";
		// $stmt = $conn->prepare("DELETE FROM user WHERE name = ?");
		$stmt = $conn->prepare($sql);
		if($stmt === false) {
		  echo json_encode('Wrong SQL: ' . $sql . ' Error: ' . $conn->errno . ' ' . $conn->error, E_USER_ERROR);
		  return;
		}
		else {		
		    // Bind parameters. Types: s = string, i = integer, d = double,  b = blob 
		    $stmt->bind_param("i", $id);
		    $stmt->execute();
			//echo "Record deleted successfully\n";
		}
	}
?>