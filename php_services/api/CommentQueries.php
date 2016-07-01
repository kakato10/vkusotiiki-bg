<?php
    //session_start();
    require_once 'ServerConfig.php';
	require_once 'InitiateConnectionToDB.php';
	
	// Get all comments's data
	function get_all_comment_data(){
		global $conn;
		$table_name = "comment";
		$sql = "SELECT * FROM $table_name";
		$result = $conn->query($sql);
		//echo "$stmt";
		if($result === false) {
		   echo json_encode('Wrong SQL: ' . $sql . ' Error: ' . $conn->errno . ' ' . $conn->error, E_USER_ERROR);
		   return;
		}
		else {
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
	
    // Get comment's data by id
	function get_comment_data_by_id($id){
		global $conn;
		$table_name = "comment";
		$sql = "SELECT * FROM $table_name WHERE id = $id";
		$result = $conn->query($sql);
		//echo "$stmt";
		if($result === false) {
		   echo json_encode('Wrong SQL: ' . $sql . ' Error: ' . $conn->errno . ' ' . $conn->error, E_USER_ERROR);
		   return;
		}
		else {
			//echo "Records printing" . "<br>";
			$row = $result->fetch_assoc();
		}
		echo json_encode($row);
	}
	
    // Insert into commment
	function insert_into_comment(){
		// Set parameters and execute
		/*
	    $user = 42;
		$recipe = 27;
		$date = "26.06.16";
		$comment = "hi";
		*/
		global $app, $conn;
		$req = $app->request();
		$body = json_decode($req->getBody());
		$sql = "INSERT INTO comment (user, recipe, date, comment) VALUES (?, ?, ?, ?)";
		$stmt = $conn->prepare($sql);
		if($stmt === false) {
		  echo json_encode('Wrong SQL: ' . $sql . ' Error: ' . $conn->errno . ' ' . $conn->error, E_USER_ERROR);
		   return;
		}
		else {
		    // Bind parameters. Types: s = string, i = integer, d = double,  b = blob 
		    $stmt->bind_param("iiss", $body->user, $body->recipe, $body->date, $body->comment);
		    $stmt->execute();
			//echo "New records created successfully\n";
		}
	}
		
	// Update a comment with an id
	function update_comment_by_id($id){
		// Set parameters and execute
		/*
		$id = 12;
		$date = "24.06.16";
		$comment = "hiiiii";
		*/
		global $app, $conn;
		$req = $app->request();
		$body = json_decode($req->getBody());
		$sql = "UPDATE comment SET date = ?, comment = ? WHERE id = ?";
		$stmt = $conn->prepare($sql);
		if($stmt === false) {
		  echo json_encode('Wrong SQL: ' . $sql . ' Error: ' . $conn->errno . ' ' . $conn->error, E_USER_ERROR);
		   return;
		}
		else {		
		    // Bind parameters. Types: s = string, i = integer, d = double,  b = blob 
		    $stmt->bind_param("ssi", $body->date, $body->comment, $id);
		    $stmt->execute();
			//echo "Records updated successfully\n";
		}
	}
		
    // Delete a comment with an id
	function delete_comment_by_id($id){
		// Set parameters and execute
		// $id = "37";
		// $stmt = $conn->prepare("DELETE FROM user WHERE name = ?");
		global $conn;
		$sql = "DELETE FROM comment WHERE id = ?";
		$stmt = $conn->prepare($sql);
		if($stmt === false) {
		  echo json_encode('Wrong SQL: ' . $sql . ' Error: ' . $conn->errno . ' ' . $conn->error, E_USER_ERROR);
		   return;
		}
		else{		
		    // Bind parameters. Types: s = string, i = integer, d = double,  b = blob 
		    $stmt->bind_param("i", $id);
		    $stmt->execute();
			//echo "Record deleted successfully\n";
		}
	}
?>