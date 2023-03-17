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
      print_r(json_encode($quote_arr));         
    } else {
      echo json_encode(array('message' => 'No Quotes Found'));
    }

  } 
  
  if(isset($_GET['author_id'])) {
  echo json_encode(array('message' => 'Here we go TEST 1'));

    $quote->id = isset($_GET['author_id']) ? $_GET['author_id'] : die();
    
    //get quotes
    $quotes_arr = $quote->read_single();

    // Make JSON
    echo json_encode($quotes_arr);

    /*if($quote->quote !== null) {
      // Make JSON
      print_r(json_encode($quote_arr));         ///dif
    } else {
      echo json_encode(array('message' => 'No Quotes Found'));
    }*/
  



  }
  
  if(isset($_GET['category_id'])) {
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
      echo json_encode(array('message' => 'No Quotes Found'));
    }
      // Make JSON
      echo json_encode($quotes_arr);
  }

  if(isset($_GET['author_id']) && isset($_GET['category_id'])) {
    echo json_encode(array('message' => 'Here we go TEST 2!'));
     
      $quote->id = isset($_GET['author_id']) ? $_GET['author_id'] : die();
      //get quotes
      $quotes_arr = $quote->read_single();
  
      // Make JSON
      echo json_encode($quotes_arr);
  
  
  
  }

?>
