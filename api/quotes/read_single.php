<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: GET');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

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
  
  if(isset($_GET['id'])) {
    $quote->id = isset($_GET['id']) ? $_GET['id'] : die();
    // Get quote
    $quote->read_single();

    // Create array
    $quote_arr = array(
      'id' => $quote->id,
      'quote' => $quote->quote,
      'author_id' => $quote->author,
      'category_id' => $quote->category
    );

    if($quote->quote !== null) {
      // Make JSON
      print_r(json_encode($quote_arr));         ///dif
    } else {
      echo json_encode(array('message' => 'No quotes Found'));
    }

  }

  /*//test if data received
  if(!isset($data->id)) {
		echo json_encode(
			array('message' => 'Missing Required Parameters')
		);
		exit();
	}


  // Get quote
  $quote->read_single();

  // Create array
  $quote_arr = array(
    'id' => $quote->id,
    'quote' => $quote->quote
  );

  // Make JSON
  print_r(json_encode($quote_arr));*/