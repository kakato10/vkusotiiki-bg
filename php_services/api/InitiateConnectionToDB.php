<?php
    //session_start();
    require_once '../ServerConfig.php';

    function initiate_connection($server_name, $username, $password, $db_name){
        // Create connection
        $conn = new mysqli($server_name, $username, $password, $db_name);

        // Change character set to utf8
        if (!$conn->set_charset("utf8")) {
            printf("Error loading character set utf8: %s" ."<br>", $conn->error);
        } else {
            printf("Current character set: %s" . "<br>", $conn->character_set_name());
        }

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error . "<br>");
        }
        return $conn;
    }

    function get_connection()
    {
        global $server_name, $username, $password, $db_name;
        return initiate_connection($server_name, $username, $password, $db_name);
    }
?>