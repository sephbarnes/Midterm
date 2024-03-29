<?php
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Category.php';
  include_once '../../functions/isValid.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $category = new Category($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  if(!isset($data->category)) {
		echo json_encode(
			array('message' => 'Missing Required Parameters')
		);
		exit();
	}

  /* //check if the data is valid
  $valid = isValid($data->id, $category);
 
    if(!$valid) {
    
    exit();
  }*/
  
  // Set ID to UPDATE
  $category->id = $data->id;
  $category->category = $data->category;

  // Update category
  if($category->update()) {
    $json = json_encode(
      array('id' => $category->id, 'category' => $category->category)
    );
    echo $json;
  } else {
    echo json_encode(
      array('message' => 'category_id Not Found')
    );
  }
  ?>