<?php
	//session_start();
    require_once 'ServerConfig.php';
	require_once 'InitiateConnectionToDB.php';
	
	// Upload the file to directory and file size limit
	function upload_file(){
		global $app;
		$req = $app->request();
		$body = json_decode($req->getBody());
		$input_file_form_name = body->input_file_form_name;
		$target_dir = body->target_dir;
		$size_limit = body->size_limit;
		$target_file = $target_dir . basename($_FILES[$input_file_form_name]["name"]);
		//$uploadOk = 1;
		$result = array();
		$result["uploadOk"] = 1;
		$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
		// Check if image file is a actual image or fake image
		if(isset($_POST["image"])) {
			$check = getimagesize($_FILES[$input_file_form_name]["tmp_name"]);
			if($check !== false) {
				$result["file_image"] = "File is an image - " . $check["mime"] . ".";
				$result["uploadOk"] = 1;
			} else {
				$result["file_not_image"] =  "File is not an image.";
				$result["uploadOk"] = 0;
				return;
			}
		}
		// Check if file already exists
		if (file_exists($target_file)) {
			$result["file_already_exists"] = "Sorry, file already exists.";
			$result["uploadOk"] = 0;
			return;
		}
		// Check file size
		if ($_FILES[$input_file_form_name]["size"] > $size_limit) {
			$result["too_large_file"] = "Sorry, your file is too large.";
			$result["uploadOk"] = 0;
			return;
		}
		// Allow certain file formats
		if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
		&& $imageFileType != "gif" ) {
			echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
			$result["uploadOk"] = 0;
			return;
		}
		// Check if $uploadOk is set to 0 by an error
		if ($uploadOk == 0) {
			$result["result"] = "Sorry, your file was not uploaded.";
			$result["uploadOk"] = 0;
			return;
		// if everything is ok, try to upload file
		} else {
			if (move_uploaded_file($_FILES[$input_file_form_name]["tmp_name"], $target_file)) {
				$result["uploadOk"] = 1;
				$result["file_name"] = $_FILES[$input_file_form_name]["name"]);
				$result["result"] = "The file ". basename( $_FILES[$input_file_form_name]["name"]). " has been uploaded.";
			} else {
				$result["uploadOk"] = 0;
				$result["result"] = "Sorry, there was an error uploading your file.";
			}
		}
	}

	// Insert into image - NOT TESTED
	function insert_file_into_image(){
		// Set parameters and execute
		/*
		$name = "demo_img_1";
		$url = "/images/$name";
		$location = 1;
		*/
		global $app, $conn;
		$req = $app->request();
		$body = json_decode($req->getBody());
		$sql = "INSERT INTO image (name, url) VALUES (?, ?)";
		$stmt = $conn->prepare($sql);
		if($stmt === false) {
		  echo json_encode('Wrong SQL: ' . $sql . ' Error: ' . $conn->errno . ' ' . $conn->error, E_USER_ERROR);
		  return;
		}
		else {
		    // Bind parameters. Types: s = string, i = integer, d = double,  b = blob 
		    $stmt->bind_param("ss", $body->name, $body->url);
		    $stmt->execute();
			//echo "New records created successfully\n";
		}
	}
?>