<?php
// use \libs\Slim\Http\Request as Request;
// use \libs\Slim\Http\Response as Response;

// echo "string";
require_once 'ServerConfig.php';
require_once 'InitiateConnectionToDB.php';
// require 'libs/Slim/Slim.php';

// $app = new \Slim\Slim();

// $app->get('/recipes/recipeDetails/{id}', function (Request $request, Response $response) {
//     $name = $request->getAttribute('id');
//     echo "$name";
//     $response->getBody()->write("Hello, $name");

//     return $response;
// });
// $app->run();


$connection = initiate_connection($server_name, $username, $password, $db_name);
echo "string";

function get_all_users_data($conn){
		$table_name = "user";
		$sql = "SELECT * FROM $table_name";
		$result = $conn->query($sql);
		//echo "$stmt";
		if($result === false) {
		  trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->errno . ' ' . $conn->error, E_USER_ERROR);
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
		return array_values($rows);
	}

echo get_all_users_data($connection);

?>
