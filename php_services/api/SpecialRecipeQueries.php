<?php
    //session_start();
    require_once 'ServerConfig.php';
	require_once 'InitiateConnectionToDB.php';
	
	// Get all special_recipe's data
	function get_all_special_recipe_data(){
		global $conn;
		$rows[] = array();
		$table_name = "special_recipe";
		$sql = "SELECT * FROM $table_name";
		$result = $conn->query($sql);
		//echo "$stmt";
		if($result === false) {
		   echo json_encode('Wrong SQL: ' . $sql . ' Error: ' . $conn->errno . ' ' . $conn->error, E_USER_ERROR);
		  return;
		}
		else {
			echo "Records printing" . "<br>";
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
	
    // Get special_recipe's data by user id
	function get_special_recipe_data_by_user_id($user_id){
		global $conn;
		$rows[] = array();
		$table_name = "special_recipe";
		$sql = "SELECT * FROM $table_name WHERE id = $user_id";
		$result = $conn->query($sql);
		//echo "$stmt";
		if($result === false) {
		    echo json_encode('Wrong SQL: ' . $sql . ' Error: ' . $conn->errno . ' ' . $conn->error, E_USER_ERROR);
		  return;
		}
		else {
			echo "Records printing" . "<br>";
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
	
    // Insert into special recipe
	function insert_into_special_recipe(){
		// Set parameters and execute
		/*
		$user = 42;
		$recipe = 33;
		*/
		global $app, $conn;
		$req = $app->request();
		$body = json_decode($req->getBody());
		$sql = "INSERT INTO special_recipe (user, recipe) VALUES (?, ?)";
		$stmt = $conn->prepare($sql);
		if($stmt === false) {
		   echo json_encode('Wrong SQL: ' . $sql . ' Error: ' . $conn->errno . ' ' . $conn->error, E_USER_ERROR);
		  return;
		}
		else {
		    // Bind parameters. Types: s = string, i = integer, d = double,  b = blob 
		    $stmt->bind_param("ii",  $body->user,  $body->recipe);
		    $stmt->execute();
			//echo "New records created successfully\n";
		}
	}
		
    // Delete a special recipe with a user id
	function delete_special_recipe_by_user_id($user_id){
		// Set parameters and execute
		// $id = "37";
		// $stmt = $conn->prepare("DELETE FROM user WHERE name = ?");
		global $conn;
		$sql = "DELETE FROM special_recipe WHERE id = ?";
		$stmt = $conn->prepare($sql);
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