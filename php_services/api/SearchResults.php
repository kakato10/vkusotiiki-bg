<?php
    //session_start();
    require_once 'SearchQueries.php';
	
	//$conn = initiate_connection($server_name, $username, $password, $db_name);
	
	function get_search_results_data(){
		global $app, $conn;
		$req = $app->request();
		$body = json_decode($req->getBody());
		$search_data_by_dish = body->search_data_by_dish;
		$search_data_by_category = body->search_data_by_category;
		$search_data_by_region = body->search_data_by_region;
		$search_data_by_difficulty = body->search_data_by_difficulty;
		$search_data_by_time = body->search_data_by_time;
		$search_data_by_ingredient body->search_data_by_ingredient;
		/*
		$search_data_by_dish = NULL;
		$search_data_by_category = NULL;
		$search_data_by_region = NULL;
		$search_data_by_difficulty = NULL;
		$search_data_by_time = array("from" => NULL, "to" => NULL);
		$search_data_by_ingredient = array("vegetable" => NULL, "fruit" => array(20), "nut" => NULL, "diary" => array(12, 17), "meat" => NULL, "seafood" =>NULL, "seasoning" => NULL, "other" =>array(2));
		*/
		
		/*
		$search_data_by_ingredient_vegetable = NULL;
		$search_data_by_ingredient_fruit = NULL;
		$search_data_by_ingredient_nut = NULL;
		$search_data_by_ingredient_diary = NULL;
		$search_data_by_ingredient_meat = NULL;
		$search_data_by_ingredient_seafood = NULL;
		$search_data_by_ingredient_seasoning = NULL;
		$search_data_by_ingredient_other = array(2);
		*/
		
		$all_recipe_ids = array();
		$recipe_ids_by_dish = get_recipe_id_by_search_data("dish", $search_data_by_dish);
		$recipe_ids_by_category = get_recipe_id_by_search_data("category", $search_data_by_category);
		$recipe_ids_by_region = get_recipe_id_by_search_data("region", $search_data_by_region);
		$recipe_ids_by_difficulty = get_recipe_id_by_search_data("difficulty", $search_data_by_difficulty);
		if($search_data_by_time == NULL){
			$recipe_ids_by_time = NULL;
		}
		else{
			$recipe_ids_by_time = get_recipe_id_by_time($search_data_by_time["from"], $search_data_by_time["to"]);
		}
		
		array_push($all_recipe_ids, $recipe_ids_by_dish);
		array_push($all_recipe_ids, $recipe_ids_by_category);
		array_push($all_recipe_ids, $recipe_ids_by_region);
		array_push($all_recipe_ids, $recipe_ids_by_difficulty);
		array_push($all_recipe_ids, $recipe_ids_by_time);
		
		/*
		$types = get_ingredients_types($conn);
		echo "types: " . var_dump($types);
		echo "<br><br>";
		*/
		
		//'vegetable','fruit','nut','diary','meat','seafood','seasoning','other'
		foreach($search_data_by_ingredient as $ingredient_type => $ingredient_data){
			$recipe_ids_by_ingredient = get_recipe_id_by_ingredient_type($ingredient_data, $ingredient_type);
			array_push($all_recipe_ids, $recipe_ids_by_ingredient);
		}
		/*
		$recipe_ids_by_ingredient_vegetable = get_recipe_id_by_ingredient_type($conn, $search_data_by_ingredient_vegetable, "vegetable");
		$recipe_ids_by_ingredient_fruit = get_recipe_id_by_ingredient_type($conn, $search_data_by_ingredient_fruit, "fruit");
		$recipe_ids_by_ingredient_nut = get_recipe_id_by_ingredient_type($conn, $search_data_by_ingredient_nut, "nut");
		$recipe_ids_by_ingredient_diary = get_recipe_id_by_ingredient_type($conn, $search_data_by_ingredient_diary, "diary");
		$recipe_ids_by_ingredient_meat = get_recipe_id_by_ingredient_type($conn, $search_data_by_ingredient_meat, "meat");
		$recipe_ids_by_ingredient_seafood = get_recipe_id_by_ingredient_type($conn, $search_data_by_ingredient_seafood, "seafood");
		$recipe_ids_by_ingredient_seasoning = get_recipe_id_by_ingredient_type($conn, $search_data_by_ingredient_seasoning, "seasoning");
		$recipe_ids_by_ingredient_other = get_recipe_id_by_ingredient_type($conn, $search_data_by_ingredient_other, "other");
		*/
		
		
		/*
		$search_result = get_search_result_ids($recipe_ids_by_dish, $recipe_ids_by_category, $recipe_ids_by_region, $recipe_ids_by_difficulty, $recipe_ids_by_ingredient_vegetable, $recipe_ids_by_ingredient_fruit, $recipe_ids_by_ingredient_nut, $recipe_ids_by_ingredient_diary, $recipe_ids_by_ingredient_meat, $recipe_ids_by_ingredient_seafood, $recipe_ids_by_ingredient_seasoning, $recipe_ids_by_ingredient_other);
		*/
		
		$search_result = get_search_result_ids($all_recipe_ids);
		echo json_encode($search_result);
	}
	
?>
	
	