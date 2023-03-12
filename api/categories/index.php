<?php 
  //CORS HEADERS go on top of every index.php in the api folders
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  //determine HTTP request method
  $method = $_SERVER['REQUEST_METHOD'];

  if ($method === 'OPTIONS') {
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
  }
  // Headers
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Author.php';
  
  if($method === 'POST') {

    include_once 'create.php';

  } else if ($method === 'DELETE') {

    include_once 'delete.php';

  } else if ($method == 'GET') {
    $url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $url_parts = parse_url($url);
    parse_str($url_parts['query'], $params);
    if($params['id']) {

      include_once 'read_single.php';

    } else {

      include_once 'read.php';
      
    }
  } else if ($method == "PUT") {
    
    include_once 'update.php';

  }


