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
    

  }

  //test if data received
  if(!isset($data->quote)) {
		echo json_encode(
			array('message' => 'Missing Required Parameters')
		);
		exit();
	}

  /*// Get ID
  if(isset($_GET['id'])) {
    $quote->id = $_GET['id']
  } else if(isset($_GET['author_id'])) {
    $quote->id = $_GET['author_id']
  } else if(isset($_GET['category_id'])) {
    $quote->id = $_GET['category_id']
  } else {
    die();
  }*/

  // Get quote
  $quote->read_single();

  // Create array
  $quote_arr = array(
    'id' => $quote->id,
    'quote' => $quote->quote
  );

  // Make JSON
  print_r(json_encode($quote_arr));