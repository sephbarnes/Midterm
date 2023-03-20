<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: DELETE');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Quote.php';
  include_once '../../functions/isValid.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate author object
  $quote = new Quote($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  if(!isset($data->id)) {
		echo json_encode(
			array('message' => 'Missing Required Parameters')
		);
		exit();
	}

  //check if the data is valid
  $valid = isValid($data->id, $quote);

  if(!$valid) {
    echo json_encode(
      array('message' => 'No Quotes Found')
    );
    exit();
  }

  // Set ID to delete
  $quote->id = $data->id;

  // Delete post
  if($quote->delete()) {
    echo json_encode(
      array('id' => $data->id)
    );
  } else {
    echo json_encode(
      array('message' => 'No Quotes Found')
    );
  }

  ?>