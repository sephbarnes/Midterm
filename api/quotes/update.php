<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/quote.php';
  include_once '../../functions/isValid.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate quote object
  $quote = new Quote($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  //test if data received
  if((!isset($data->id)) || (!isset($data->quote)) || (!isset($data->author_id)) || (!isset($data->category_id))) {
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
  }`

  // Set ID to update
  $quote->id = $data->id;
  $quote->quote = $data->quote;
  $quote->author_id = $data->author_id;
  $quote->category_id = $data->category_id;

  // Update quote
  if($quote->update()) {
    echo json_encode(array('id' => $quote->id,
    'quote' => $quote->quote,
    'author_id' => $quote->author_id,
    'category_id' => $quote->category_id));
} else {
echo json_encode(
  array('message' => 'No Quotes Found')
);
}

