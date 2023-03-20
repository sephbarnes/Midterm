<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Access-Control-Allow-Origin, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Quote.php';
  include_once '../../functions/isValid.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate quote object
  $quote = new Quote($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));
  
  //test if data received
  if((!isset($data->quote)) || (!isset($data->author_id) || (!isset($data->category_id)))) {
		echo json_encode(
			array('message' => 'Missing Required Parameters')
		);
		exit();
	}
  
  $quote->quote = $data->quote;
  $quote->author_id = $data->author_id;
  $quote->category_id = $data->category_id;

  // Create quote
  if($quote->create()) {
  echo json_encode(array('id' => $db->lastInsertId(),
        'quote' => $quote->quote,
        'author_id' => $quote->author_id,
        'category_id' => $quote->category_id));
  } else {
    echo json_encode(
      array('message' => 'Quote Not Created')
    );
  }
  ?>