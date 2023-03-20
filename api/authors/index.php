<?php 
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    $method = $_SERVER['REQUEST_METHOD'];

    $uri = $_SERVER['REQUEST_URI'];

    if ($method === 'OPTIONS') {
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
        header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
        exit();
    }

  include_once '../../config/Database.php';
  include_once '../../models/Author.php';
  
  if($method === 'POST') {
    //console.log("Lets create a post!");
    include_once 'create.php';

  } else if ($method === 'DELETE') {

    include_once 'delete.php';

  } else if ($method === 'GET') {
    
    if (parse_url($uri, PHP_URL_QUERY)){
            require('read_single.php');
        } else {
            require('read.php');
        }

     
  } else if ($method === "PUT") {
    
    include_once 'update.php';

  }?>