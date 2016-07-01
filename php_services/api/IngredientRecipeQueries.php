<?php
	require_once 'ServerConfig.php';
	require_once 'InitiateConnectionToDB.php';
	
	// Insert into ingredient_recipe
	function insert_ingredient_for_recipe_by_id($recipe){
		// Set parameters and execute
		// $recipe = 27;
		// $ingredients = array("ingredient" => 2, "unit" => "?.?.", "quantity" => 7)
		global $app, $conn;
		$req = $app->request();
		$body = json_decode($req->getBody());
		$ingredients = json_decode($body->ingredients); 
		$ingredient = $ingredients->ingredient;
		$quantity = $ingredients->quantity;
		$unit = $ingredients->unit;
		$sql = "INSERT INTO ingredient_recipe (recipe, ingredient, quantity, unit) VALUES (?, ?, ?, ?)";
		$stmt = $conn->prepare($sql);
		if($stmt === false) {
		  echo json_encode('Wrong SQL: ' . $sql . ' Error: ' . $conn->errno . ' ' . $conn->error, E_USER_ERROR);
		  return;
		}
		else {
		    // Bind parameters. Types: s = string, i = integer, d = double,  b = blob 
				$stmt->bind_param("iiis", $recipe, $ingredient, $quantity, $unit);
				$stmt->execute();
		   // echo "New records created successfully\n";
		}
	}
	
	// Update a ingredient in a recipe with an id
	function update_ingredient_for_recipe_by_id($id){
	    // Set parameters and execute
		// $recipe = 27;
		// $ingredients = array("ingredient" => 2, "unit" => "?.?.", "quantity" => 7)

		//$ingredient = $ingredients["ingredient"];
		//$quantity = $ingredients["quantity"];
		//$unit = $ingredients["unit"];
		global $app, $conn;
		$req = $app->request();
		$body = json_decode($req->getBody());
		$ingredients = json_decode($body->ingredients); 
		$ingredient = $ingredients->ingredient;
		$quantity = $ingredients->quantity;
		$unit = $ingredients->unit;
		$sql = "UPDATE ingredient_recipe SET ingredient = ?, quantity = ? , unit = ? WHERE id = ?";
		$stmt = $conn->prepare($sql);
		if($stmt === false) {
		   echo json_encode('Wrong SQL: ' . $sql . ' Error: ' . $conn->errno . ' ' . $conn->error, E_USER_ERROR);
		}
		else {		
		    // Bind parameters. Types: s = string, i = integer, d = double,  b = blob 
		    $stmt->bind_param("iisi", $ingredient, $quantity, $unit, $id);
		    $stmt->execute();
			//echo "Records updated successfully\n";
		}
	}
	
	// Get a recipe's ingredients by recipe id
	function get_recipe_ingredients_by_id($recipe_id){
		//$recipe_id = 24;
		global $conn;
		$rows[] = array();
		$sql = "SELECT ingredient, quantity, unit FROM ingredient_recipe WHERE recipe = '$recipe_id'";
		$result = $conn->query($sql);
		//echo "$stmt";
		if($result === false) {
		  echo json_encode('Wrong SQL: ' . $sql . ' Error: ' . $conn->errno . ' ' . $conn->error, E_USER_ERROR);
		}
		else {
			echo "Records printing" . "<br>";
			while ($row = $result->fetch_assoc()) {
				//$rows[$row["ingredient"]] = array($row["unit"], $row["quantity"]);
				$rows[] = array("ingredient" => $row["ingredient"],"unit" => $row["unit"], "quantity" => $row["quantity"]);
			}
		}
		unset($rows[key($rows)]);
		echo json_encode(array_values($rows));
	}
	
	// Delete from ingredient for recipe by id
	function delete_ingredient_for_recipe_by_id ($id){
		// Set parameters 
		global $conn;
		//$id = "31";
		$sql = "DELETE FROM ingredient_recipe WHERE id = ?";
		$stmt = $conn->prepare($sql);
		if($stmt === false) {
		  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->errno . ' ' . $conn->error, E_USER_ERROR);
		}
		else{		
		    // Bind parameters. Types: s = string, i = integer, d = double,  b = blob 
		    $stmt->bind_param("i", $id);
		    $stmt->execute();
			//echo "Record deleted successfully\n";
		}
	}
?>