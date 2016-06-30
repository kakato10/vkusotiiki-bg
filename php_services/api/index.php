<!DOCTYPE html>
<html>
<head>
    <title>
    </title>
    <meta charset="utf-8">
</head>
<body>



<?php
// use \libs\Slim\Http\Request as Request;
// use \libs\Slim\Http\Response as Response;

// echo "string";
require_once '../ServerConfig.php';
require_once 'InitiateConnectionToDB.php';
require '../libs/Slim/Slim.php';
\Slim\Slim::registerAutoloader();
// $app = \Slim\Slim::getInstance();
$app = new \Slim\Slim();

// $app->get('/recipes/recipeDetails/{id}', function (Request $request, Response $response) {
//     $name = $request->getAttribute('id');
//     echo "$name";
//     $response->getBody()->write("Hello, $name");

//     return $response;
// });
// $app->run();

$app->contentType('application/json');
// $app->get('/', 'getUsers');

// function getUsers() {
//     echo "<br/>";
//     echo "getUsers";
//     echo "<br/>";
//     $conn = get_connection();
//     var_dump($conn);
//     $table_name = "user";
//     $sql = "SELECT * FROM $table_name";
//     $result = $conn->query($sql);
//     //echo "$stmt";
//     if($result === false) {
//       echo json_encode('Wrong SQL: ' . $sql . ' Error: ' . $conn->errno . ' ' . $conn->error, E_USER_ERROR);
//       return;
//     } else {
//         //echo "Records printing" . "<br>";
//         $rows[] = array();
//         while ($row = $result->fetch_assoc()) {
//             $rows[] = $row;
//         }
//         //foreach($rows as $row){
//             //echo $row["name"] . "<br>";
//         //}
//     }
//     $conn->close();
//     unset($rows[key($rows)]);
//     echo json_encode(array_values($rows));
// }

$app->put('/', 'insert_into_user');
$app->get('/:id', 'get_user_data_by_id');
$app->put('/recipe/:recipe+', 'insert_ingredient_for_recipe_by_id');

$conn = get_connection();
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
    var_dump($req->getBody());
    var_dump(json_decode($req->getBody()));
    $error = json_last_error();
    echo "$error";

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

function get_user_data_by_id($id){
    var_dump($id);
    global $conn;
    $table_name = "user";
    $result = $conn->query("SELECT * FROM $table_name WHERE id = $id");
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

function insert_ingredient_for_recipe_by_id($recipe){
    // Set parameters and execute
    // $recipe = 27;
    echo "$recipe";
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

$app->run();
$conn->close();

// $connection = initiate_connection($server_name, $username, $password, $db_name);
// echo "string";

// function get_all_users_data($conn){
//      $table_name = "user";
//      $sql = "SELECT * FROM $table_name";
//      $result = $conn->query($sql);
//      //echo "$stmt";
//      if($result === false) {
//        trigger_error('Wrong SQL: ' . $sql . ' Error: ' . $conn->errno . ' ' . $conn->error, E_USER_ERROR);
//      }
//      else {
//          echo "Records printing" . "<br>";
//          $rows[] = array();
//          while ($row = $result->fetch_assoc()) {
//              $rows[] = $row;
//          }
//          //foreach($rows as $row){
//              //echo $row["name"] . "<br>";
//          //}
//      }
//      unset($rows[key($rows)]);
//      return array_values($rows);
//  }

// echo get_all_users_data($connection);

?>


</body>
</html>