<?php
    //session_start();
    require_once 'ServerConfig.php';
	require_once 'InitiateConnectionToDB.php';
	
	// Get all rating's data
	function get_all_ratings_data(){
		global $conn;
		$table_name = "rating";
		$rows[] = array();
		$sql = "SELECT * FROM $table_name";
		$result = $conn->query($sql);
		//echo "$stmt";
		if($result === false) {
		  echo json_encode('Wrong SQL: ' . $sql . ' Error: ' . $conn->errno . ' ' . $conn->error, E_USER_ERROR);
		  return;
		}else {
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
	
    // Get rating's data by id
	function get_rating_data_by_id($id){
		global $conn;
		$table_name = "rating";
		$sql = "SELECT * FROM $table_name WHERE id = $id";
		$result = $conn->query($sql);
		if($result === false) {
		  echo json_encode('Wrong SQL: ' . $sql . ' Error: ' . $conn->errno . ' ' . $conn->error, E_USER_ERROR);
		  return;
		}else {
			//echo "Records printing" . "<br>";
			$row = $result->fetch_assoc();
		}
		else{
			echo "error";
		}
		echo json_encode($row);
	}
	
	// Get the average rating by recipe id
	function get_average_rating_by_recipe_id($recipe_id){
		// Set parameters and execute
		// $recipe_id = 27;
		$sql = "SELECT ROUND(AVG(rating),2) AS average_rating FROM rating WHERE recipe = $recipe_id GROUP BY recipe";
		$result = $conn->query($sql);
		if($result === false) {
		    echo json_encode('Wrong SQL: ' . $sql . ' Error: ' . $conn->errno . ' ' . $conn->error, E_USER_ERROR);
		    return;
		}
		else{
			$row = $result->fetch_assoc();
		}
		echo json_encode($row);
	}
	
    // Insert into rating
	function insert_into_rating(){
		// Set parameters and execute
		/*
        $user = 42;
		$recipe = 27;
		$rating = 1;
		*/
		global $app, $conn;
		$req = $app->request();
		$body = json_decode($req->getBody());
		$sql = "INSERT INTO rating (user, recipe, rating) VALUES (?, ?, ?)";
		$stmt = $conn->prepare($sql);
		if($stmt === false) {
		    echo json_encode('Wrong SQL: ' . $sql . ' Error: ' . $conn->errno . ' ' . $conn->error, E_USER_ERROR);
		    return;
		}
		else {
		    // Bind parameters. Types: s = string, i = integer, d = double,  b = blob 
		    $stmt->bind_param("iii",  $body->user,  $body->recipe,  $body->rating);
		    $stmt->execute();
			//echo "New records created successfully\n";
		}
	}
		
	// Update a rating with an id
	function update_rating_by_id($user, $recipe){
		// Set parameters and execute
		/*
	    $id = 12;
		$rating = 2;
		*/
		global $app, $conn;
		$req = $app->request();
		$body = json_decode($req->getBody());
		$sql = "UPDATE rating SET rating = ? WHERE user = ? and recipe = ?";
		$stmt = $conn->prepare($sql);
		if($stmt === false) {
		    echo json_encode('Wrong SQL: ' . $sql . ' Error: ' . $conn->errno . ' ' . $conn->error, E_USER_ERROR);
		    return;
		}
		else {		
		    // Bind parameters. Types: s = string, i = integer, d = double,  b = blob 
		    $stmt->bind_param("iii",  $body->rating, $user, $recipe);
		    $stmt->execute();
			//echo "Records updated successfully\n";
		}
	}
		
    // Delete a rating with an id
	function delete_rating_by_id($id){
		// Set parameters and execute
		// $id = "13";
		global $conn;
		// $stmt = $conn->prepare("DELETE FROM user WHERE name = ?");
		$sql = "DELETE FROM rating WHERE id = ?";
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