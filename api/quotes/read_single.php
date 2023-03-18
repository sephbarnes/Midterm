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
    echo json_encode(array('message' => 'read single test'));

    //cannot call isValid() in this block
    //This block is always called by isValid() to validate ids
    
    // Get quote
    $quote->read_single(); //member function / method

    // Create array
    $quote_arr = array(
      'id' => $quote->id,
      'quote' => $quote->quote,
      'author_id' => $quote->author,
      'category_id' => $quote->category
    );

    //the real error testing for isValid()
    if($quote->quote !== null) {
      // Make JSON
      print_r(json_encode($quote_arr));         
    } else {
      echo json_encode(array('message' => 'No Quotes Found'));
    }

  } else if (isset($_GET['author_id']) && isset($_GET['category_id'])) {
		$quote->author_id = isset($_GET['author_id']) ? $_GET['author_id'] : die();
    //get quotes
    $quote_arr = $quote->read_single();
    if(!empty($quote_arr)) {
      // Make JSON
      print_r(json_encode($quote_arr));         
    } else {
      echo json_encode(array('message' => 'No Quotes Found'));
    }
	}	else if(isset($_GET['author_id'])) {
    $quote->author_id = isset($_GET['author_id']) ? $_GET['author_id'] : die();

    //get quotes
    $quote_arr = $quote->read_single();

    //test if array of quotes is empty
    if(!empty($quote_arr)) {
      // Make JSON
      print_r(json_encode($quote_arr));         
    } else {
      echo json_encode(array('message' => 'No Quotes Found'));
    }
  } else if (isset($_GET['category_id'])) {
		$quote->category_id = isset($_GET['category_id']) ? $_GET['category_id'] : die();
    //get quotes
    $quote_arr = $quote->read_single();
    if(!empty($quote_arr)) {
      // Make JSON
      print_r(json_encode($quote_arr));         
    } else {
      echo json_encode(array('message' => 'No Quotes Found'));
    }
	}
	
?>

