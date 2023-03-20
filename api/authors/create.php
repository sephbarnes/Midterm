<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Access-Control-Allow-Origin, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Author.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate author object
  $author = new Author($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));
  
  //test if data received
  if(!isset($data->author)) {
		echo json_encode(
			array('message' => 'Missing Required Parameters')
		);
		exit();
	}
  
  $author->author = $data->author;

  // Create author
  if($author->create()) {
    $json = json_encode(
      array(
        'id' => $db->lastInsertId(),
        'author' => $author->author));
    echo $json;
  } else {
    echo json_encode(
      array('message' => 'author_id Not Found')
    );
  }

  ?>