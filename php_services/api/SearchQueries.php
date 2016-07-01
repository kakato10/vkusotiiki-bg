<?php
    //session_start();
    require_once 'ServerConfig.php';
	require_once 'InitiateConnectionToDB.php';
	
	// Gets some search data
	function get_search_data_by_type(){
		// $search_type = "dish || category || region";
		global $app, $conn;
		$req = $app->request();
		$body = json_decode($req->getBody());
		$search_type = $body->search_type;
		$rows[] = array();
		$result = $conn->query("SELECT name FROM $search_type");
		//echo "$stmt";
		if($result === false) {
		  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->errno . ' ' . $conn->error, E_USER_ERROR);
		}
		else {
			//echo "Records printing" . "<br>";
			while ($row = $result->fetch_assoc()) {
				$rows[] = $row;
			}
		}
		unset($rows[key($rows)]);
		echo json_encode(array_values($rows));
	}
	
	// Gets ingredients by it's type
    function get_ingredients_by_type($conn, $type){
		$table_name = "ingredient";
		// $type = 'vegetable','fruit','nut','diary','meat','seafood','seasoning','other'
		$rows[] = array();
		$sql = "SELECT name FROM $table_name WHERE type = '$type'";
		$result = $conn->query($sql);
		if($result === false) {
		    echo json_encode('Wrong SQL: ' . $sql . ' Error: ' . $conn->errno . ' ' . $conn->error, E_USER_ERROR);
		    return; 
		}
		else{
			//echo "Records printing" . "<br>";
			while ($row = $result->fetch_assoc()) {
				$rows[] = $row;
			}
		}
		unset($rows[key($rows)]);
		return array_values($rows);
	}
	
	/*
	// Gets ingredient types
	function get_ingredients_types($conn){
		$rows[] = array();
		$result = $conn->query("SELECT type FROM ingredient");
		//echo "$stmt";
		if($result === false) {
		  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->errno . ' ' . $conn->error, E_USER_ERROR);
		}
		else {
			$row = $result->fetch_assoc()) {
			}
		}
		//unset($rows[key($rows)]);
		//return array_values($rows);
		return $row;
	}
	*/
	
	// Gets get recipe id by search data (dish, category, region or difficulty)
    function get_recipe_id_by_search_data($search_type, $search_data){
	    // $search_type = "dish || category || region || difficulty";
		global $conn;
		if($search_data == NULL){
			return NULL;
		}
		$rows[] = array();
		$sql = "SELECT id FROM recipe WHERE $search_type = '$search_data'";
		$result = $conn->query($sql);
		//echo "$stmt";
		if($result === false) {
		   echo json_encode('Wrong SQL: ' . $sql . ' Error: ' . $conn->errno . ' ' . $conn->error, E_USER_ERROR);
		   return;
		}
		else {
			//echo "Records printing" . "<br>";
			while ($row = $result->fetch_assoc()) {
				$rows[] = $row["id"];
			}
		}
		unset($rows[key($rows)]);
		return array_values($rows);
	}
	
	// Gets get recipe id by time to prepare
    function get_recipe_id_by_time($from, $to){
	    // $search_type = "dish || category || region || difficulty";
		global $conn;
		if($from == NULL || $to == NULL){
			return NULL;
		}
		$rows[] = array();
		$result = $conn->query("SELECT id FROM recipe WHERE time BETWEEN '$from' AND '$to'");
		//echo "$stmt";
		if($result === false) {
		   echo json_encode('Wrong SQL: ' . $sql . ' Error: ' . $conn->errno . ' ' . $conn->error, E_USER_ERROR);
		   return;
		}
		else {
			//echo "Records printing" . "<br>";
			while ($row = $result->fetch_assoc()) {
				$rows[] = $row["id"];
			}
		}
		unset($rows[key($rows)]);
		return array_values($rows);
	}
	
	// Get get recipe id by search data
    function get_recipe_id_by_ingredient_type($ingredients, $ingredient_type){
		global $conn;
	    //$ingredients = array(20);
		//$ingredient_type = "fruit";
		if($ingredients == NULL){
			return NULL;
		}
		$rows[] = array();
		// $index = 0;
		$results[] = array();
		foreach($ingredients as $ingredient){
			//echo "$ingredient" . "<br><br>";
			$result = $conn->query("SELECT recipe FROM ingredient_recipe WHERE ingredient = '$ingredient'");
			// $index += 1;
			//echo "$stmt";
			if($result === false) {
			   echo json_encode('Wrong SQL: ' . $sql . ' Error: ' . $conn->errno . ' ' . $conn->error, E_USER_ERROR);
		       return;
			}
			else {
				 echo "Records printing" . "<br>";
				 while ($row = $result->fetch_assoc()) {
					$rows[] = $row["recipe"];
					//echo "row: " . var_dump($row["recipe"]);
					//echo "<br><br>";
				}
			}
		}
		unset($rows[key($rows)]);
		if(count($ingredients) == 1){
			return array_values($rows);
		}else{
			return array_values(array_unique(array_diff_assoc($rows, array_unique($rows))));
		}	
	}
	
	// Gets the ids of the search queries that are given
	function get_search_result_ids($search_ids){
		// echo "parameters" . var_dump($parameters);
		// echo "<br><br>";
		global $conn;
		$result = "";
		foreach($search_ids as $row){
			if($row != NULL){
				$result = $row;
		    }
			if($row === array()){
				return array();
			}
		}
		if($result == NULL){
				return array();
			}
		$rows[] = array();	
		foreach($search_ids as $row){
			// echo "row" . var_dump($row);
		    // echo "<br><br>";
			if($row != NULL){
			$result = array_intersect($result, $row);
			}
		}
		return array_values($result);
	}
	
	/*
    // Get rating's data by id
	function get_rating_data_by_id($conn, $id){
		$table_name = "rating";
		$result = $conn->query("SELECT * FROM $table_name WHERE id = $id");
		//echo "$stmt";
		if ($result) {
			echo "Records printing" . "<br>";
			$row = $result->fetch_assoc();
		}
		else{
			echo "error";
		}
		return $row;
	}
	*/
?>