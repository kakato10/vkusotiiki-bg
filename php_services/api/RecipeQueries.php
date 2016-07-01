<?php
	require_once 'ServerConfig.php';
	require_once 'InitiateConnectionToDB.php';
	require_once 'RatingQueries.php';
	
	// Get all recipe's data
	function get_all_recipes_data(){
		global $conn;
		$table_name = "recipe";
		$rows[] = array();
		$sql = "SELECT * FROM $table_name";
		$result = $conn->query($sql);
		//echo "$stmt";
		if($result === false) {
		  echo json_encode('Wrong SQL: ' . $sql . ' Error: ' . $conn->errno . ' ' . $conn->error, E_USER_ERROR);
		  return;
		}
		else {
			//echo "Records printing" . "<br>";
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
	
    // Get recipe's data by id
	function get_recipe_data_by_id($id){
		global $conn;
		$table_name = "recipe";
		$sql = "SELECT * FROM $table_name WHERE id = $id";
		$result = $conn->query($sql);
		//echo "$stmt";
		if($result === false) {
		  echo json_encode('Wrong SQL: ' . $sql . ' Error: ' . $conn->errno . ' ' . $conn->error, E_USER_ERROR);
		  return;
		}
		else{
			//echo "Records printing" . "<br>";
			$row = $result->fetch_assoc();
			$rating = get_average_rating_by_recipe_id($conn, id);
			$row["rating"] = $rating;
		}
		echo json_encode($row);
	}
	
	// Get the most favourite recipe's id - NOT USED
	function get_the_most_favourite_recipe_id(){
		$sql = "SELECT recipe FROM (SELECT ROUND(AVG(rating),2) AS average_rating, recipe FROM rating GROUP BY recipe) AS all_ratings WHERE average_rating = (SELECT MAX(average_rating) AS max_rating FROM (SELECT ROUND(AVG(rating),2) AS average_rating FROM rating GROUP BY recipe) AS all_ratings)";
		global $conn;
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
	
	// Get the most favourite recipes' ids
	function get_the_most_favourite_recipes_ids(){
		global $conn;
		$rows[] = array();
		// SELECT MAX(average_rating) AS max_rating FROM (SELECT ROUND(AVG(rating),2) AS average_rating FROM rating GROUP BY recipe) AS all_ratings
		//SELECT ROUND(AVG(rating),2) AS average_rating, recipe  FROM rating GROUP BY recipe ORDER BY average_rating DESC LIMIT 3
    	$sql = "SELECT recipe FROM (SELECT ROUND(AVG(rating),2) AS average_rating, recipe FROM rating GROUP BY recipe) AS all_ratings INNER JOIN (SELECT ROUND(AVG(rating),2) AS average_rating FROM rating GROUP BY recipe ORDER BY average_rating DESC LIMIT 3) AS desired_ratings ON all_ratings.average_rating = desired_ratings.average_rating";
		$result = $conn->query($sql);
		if($result === false) {
		  echo json_encode('Wrong SQL: ' . $sql . ' Error: ' . $conn->errno . ' ' . $conn->error, E_USER_ERROR);
		  return;
		}
		else{
			while ($row = $result->fetch_assoc()) {
				$rows[] = $row;
			}
		}
		unset($rows[key($rows)]);
		echo json_encode(array_values($rows));
	}
	
	// Get the random recipe id for the 'Weekly recipe' section
	function get_weekly_recipe_id(){
		global $conn;
		$sql = "SELECT id FROM recipe ORDER BY RAND() LIMIT 1;";
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
		
	// Insert into recipe - insert the ingredients too with the other function!!! !!!
	function insert_into_recipe()
		// Set parameters
		global $app, $conn;
		$req = $app->request();
		$body = json_decode($req->getBody());
		$rating_value = "0"; 
		/*
		$name = "some recipe";
		$region = 3;
		$time = 60;
		$category = 2;
		$user = 42;
		$is_approved = 0;
		$dish = 1;
		$difficulty = 2;
		$ingredients = 1;
		$img = 1;
		//$rating = NULL;
		$rating_value = 0; 
		$serving = 3;
		$decription = "some";
		//$comment = NULL;
		$added_on = "26.06.16 11:45";
		$last_edited_on = "26.06.16 11:45";
		//INSERT INTO recipe (name, region, time, category, user, is_approved, dish, difficulty, 
		//ingredient, img, rating, serving, decription)
		//VALUES (:name, (SELECT id FROM region WHERE name = :region), :time, (SELECT id FROM //category WHERE name = :category), (SELECT id FROM user WHERE name = :user), //:is_approved, (SELECT id FROM dish WHERE name = :dish), :difficulty, :ingredients, //:img, :rating, :serving, :decription);
		//SELECT LAST_INSERT_ID() INTO @last_id;
		//	INSERT INTO img (id, name, url) VALUES (@last_id, ...);
		*/
		
		$sqlRecipe = "INSERT INTO recipe (name, region, time, category, user, is_approved, dish, difficulty, ingredients, img, serving, description, added_on, last_edited_on) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
		$stmt = $conn->prepare($sqlRecipe);	
		if($stmt === false) {
		  echo json_encode('Wrong SQL: ' . $sqlRecipe . ' Error: ' . $conn->errno . ' ' . $conn->error, E_USER_ERROR);
		  return;
		}
		
		$sqlRating = "INSERT INTO rating (user, recipe, rating) VALUES (?, ?, ?)";
		$stmt1 = $conn->prepare($sqlRating);
		if($stmt1 === false) {
		  echo json_encode('Wrong SQL: ' . $sqlRating . ' Error: ' . $conn->errno . ' ' . $conn->error, E_USER_ERROR);
		  return;
		}
		
		$sqlRatingToRecipe = "UPDATE recipe SET rating = ? where id = ?";
		$stmt2 = $conn->prepare($sqlRatingToRecipe);
		
		if($stmt2 === false) {
		  echo json_encode('Wrong SQL: ' . $sqlRatingToRecipe . ' Error: ' . $conn->errno . ' ' . $conn->error, E_USER_ERROR);
		  return;
		}
		else{
		    // Bind parameters.
		    $stmt->bind_param("siiiiiiiiiisss", $body->name, $body->region, $body->time, $body->category, $body->user, $body->is_approved, $body->dish, $body->difficulty, $body->ingredients, $body->img, $body->serving, $body->description, $body->added_on, $body->last_edited_on);
			$conn->query("START TRANSACTION");
		    $stmt->execute();
			
			$last_recipe_id = $conn->insert_id;
			//echo "last_recipe_id: $last_recipe_id";
			
			$stmt1->bind_param("iii", $body->user, $last_recipe_id, $rating_value);
			$stmt1->execute();
			
			$last_rating_id = $conn->insert_id;
			//echo "last_rating_id: $last_rating_id";
			
			$stmt2->bind_param("ii", $last_rating_id, $last_recipe_id);
			$stmt2->execute();
			
			$conn->query("COMMIT");
			//echo "New records created successfully\n";
		}
	}
		
	// Update recipe by id - update the ingredients too with the other function!!!
	function update_recipe_by_id ($id){ 
		// Set parameters and execute
		/*
		$id = 27;
		$name = "updated recipe";
		$region = 5;
		$time = 60;
		$category = 2;
		$user = 43;
		$is_approved = 1;
		$dish = 3;
		$difficulty = 4;
		$ingredients = 1;					
		$img = 1;
		//$rating = NULL;
		$serving = 3;
		$description = "new description";
		//$comment = NULL;
		$added_on = "27.06.16 11:45";
		$last_edited_on = "27.06.16 21:45";
		*/
		global $app, $conn;
		$req = $app->request();
		$body = json_decode($req->getBody());
		$sqlRecipe = "UPDATE recipe SET name = ?, region = ?, time = ?, category = ?, user = ?, is_approved = ?, dish = ?, difficulty = ?, ingredients = ?, img = ?, rating = ?, serving = ?, description = ?, comment = ?, added_on = ?, last_edited_on = ? WHERE id = ?";
		$stmt = $conn->prepare($sqlRecipe);	
		
		
		// $sqlRating = "INSERT INTO rating (user, recipe, rating) VALUES (?, ?, ?)";
		// $stmt1 = $conn->prepare($sqlRating);
		
		// $sqlRatingToRecipe = "UPDATE recipe SET rating = ? where id = ?";
		// $stmt2 = $conn->prepare($sqlRatingToRecipe);
		
		if($stmt === false) {
		  echo json_encode('Wrong SQL: ' . $sqlRecipe . ' Error: ' . $conn->errno . ' ' . $conn->error, E_USER_ERROR);
		  return;
		}
		else{
		    // Bind parameters.
		    $stmt->bind_param("siiiiiiiiiisssi", $body->name, $body->region, $body->time, $body->category, $body->user, $body->is_approved, $body->dish, $body->difficulty, $body->ingredients, $body->img, $body->serving, $body->description, $body->added_on, $body->last_edited_on, $id);
			// $conn->query("START TRANSACTION");
		    $stmt->execute();
			
			// $last_recipe_id = $conn->insert_id;
			// echo "last_recipe_id: $last_recipe_id";
			
			// $stmt1->bind_param("iis", $user, $last_recipe_id, $rating_value);
			// $stmt1->execute();
			
			// $last_rating_id = $conn->insert_id;
			// echo "last_rating_id: $last_rating_id";
			
			// $stmt2->bind_param("ii", $last_rating_id, $last_recipe_id);
			// $stmt2->execute();
			
			//$conn->query("COMMIT");
			//echo "Records updated successfully\n";
		}
	}
		
	// Delete from recipe by id
	function delete_recipe_by_id ($id){
		// Set parameters 
		//$id = "9";
		// $stmt = $conn->prepare("DELETE FROM user WHERE name = ?");
		global $conn;
		$sql = "DELETE FROM recipe WHERE id = ?";
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
	
	/*
		// Printing names from tables - WORKING !!!
		$table_name = "recipe";
		$result = $conn->query("SELECT * FROM $table_name");
		//echo "$stmt";
		if ($result) {
			echo "Records printing" . "<br>";
			$rows[] = array();
			while ($row = $result->fetch_assoc()) {
				$rows[] = $row;
			// for ($set = array (); $row = $result->fetch_assoc(); $set[] // = $row){
			// echo $set[1];
				echo $row["id"] . " " . $row["name"] . "<br>";
			}
			//foreach($rows as $row){
				//echo $row["name"] . "<br>";
			//}
			
		}
		else{
			echo "error";
		}	
	*/	
?>