<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: GET');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Author.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate author object
  $author = new Author($db);

  // Get ID
  $author->id = isset($_GET['id']) ? $_GET['id'] : die();
  //echo json_encode($author->id);
  // Get author
  $author->read_single();

  // Create array
  $author_arr = array(
    'id' => $author->id,
    'author' => $author->author
  );

  // Make JSON
  print_r(json_encode($author_arr));