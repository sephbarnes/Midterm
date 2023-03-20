<?php 
  class Quote {
    // DB stuff
    private $conn;
    private $table = 'quotes';

    // Quote Properties
    public $id;
    public $category;
    public $author;
    public $quote;
    public $author_id;
    public $category_id;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get all quotes
    public function read() {
      // Create query
			$query = 'SELECT
				quotes.id, quotes.quote, authors.author, categories.category
			FROM
				' . $this->table . '
			INNER JOIN
				authors ON quotes.author_id = authors.id
			INNER JOIN
				categories ON quotes.category_id = categories.id
			ORDER BY
				id';
      
      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    // Get Single quote
    public function read_single() {
      //there are 4 options so check which one it is and do that one
      
          //get the specific quote
          if(isset($_GET['id'])) {
          // Create query
            $query = 'SELECT
              quotes.id, quotes.quote, authors.author, categories.category
            FROM
              ' . $this->table . '
            INNER JOIN
              authors ON quotes.author_id = authors.id
            INNER JOIN
              categories ON quotes.category_id = categories.id
                                        WHERE
                                          quotes.id = :id LIMIT 1';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Bind ID
            $stmt->bindParam(':id', $this->id);

             // Execute query
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            //test id 
            if (is_array($row)) {
              $this->quote = $row['quote'];
              $this->author = $row['author'];       
              $this->category = $row['category'];
            }          
          }

          //get all quotes from author_id and category_id
          if(isset($_GET['author_id']) && isset($_GET['category_id'])) {
            $query = 'SELECT
              quotes.id, quotes.quote, authors.author, categories.category
            FROM
              ' . $this->table . '
            INNER JOIN
              authors ON quotes.author_id = authors.id
            INNER JOIN
              categories ON quotes.category_id = categories.id
                                        WHERE
                                          quotes.author_id = :a_id
                                          AND 
                                          quotes.category_id = :c_id
                                          ORDER BY quotes.id';
            
           

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            $this->author_id = $_GET['author_id'];
            $this->category_id = $_GET['category_id'];
            // Bind parameters
            $stmt->bindParam(':a_id', $this->author_id);
            $stmt->bindParam(':c_id', $this->category_id);

             // Execute query
            $stmt->execute();
            
            $quote_arr = [];

            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
              extract($row);

              $quote_arr[] = ['id' => $id, 'quote' => $quote, 'author' => $author, 'category' => $category];
            }

            return $quote_arr; 
          }

          //get all quotes from author_id
          if(isset($_GET['author_id'])) {
            // Create query
            $query = 'SELECT
              quotes.id, quotes.quote, authors.author, categories.category
            FROM
              ' . $this->table . '
            INNER JOIN
              authors ON quotes.author_id = authors.id
            INNER JOIN
              categories ON quotes.category_id = categories.id
                                        WHERE
                                          quotes.author_id = :a_id
                                          ORDER BY quotes.id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Bind ID
            $stmt->bindParam(':a_id', $this->author_id);

            // Execute query
            $stmt->execute();

            $quote_arr = [];

            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
              extract($row);

              $quote_arr [] = ['id' => $id, 'quote' => $quote, 'author' => $author, 'category' => $category];
            }

            return $quote_arr;   
          }
          
          //get all quotes from category_id
          if(isset($_GET['category_id'])) {
                        // Create query
                        $query = 'SELECT
                        quotes.id, quotes.quote, authors.author, categories.category
                      FROM
                        ' . $this->table . '
                      INNER JOIN
                        authors ON quotes.author_id = authors.id
                      INNER JOIN
                        categories ON quotes.category_id = categories.id
                                                  WHERE
                                                    quotes.category_id = :c_id
                                                    ORDER BY quotes.id';
          
                      // Prepare statement
                      $stmt = $this->conn->prepare($query);
          
                      // Bind ID
                      $stmt->bindParam(':c_id', $this->category_id);
          
                      // Execute query
                      $stmt->execute();
          
                      $quote_arr = [];
          
                      
                      while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        extract($row);
          
                        $quote_arr [] = ['id' => $id, 'quote' => $quote, 'author' => $author, 'category' => $category];
                      }
           
                      return $quote_arr;  
          }

        } 

    // Create Post
    public function create() {
          //before creation check if author_id and category id are correct
          //query if author_id exists  
          $query = "SELECT quote FROM {$this->table} 
                    WHERE author_id = :a_id";
            
          $stmt = $this->conn->prepare($query);
          $stmt->bindParam(':a_id', $this->author_id);
          if($stmt->execute()){ //remove if here
            if ($stmt->rowCount() === 0){
              echo json_encode(
                array('message' => 'author_id Not Found')
              );
              exit();
            }
          }

          //query if category_id exists
          $query = "SELECT quote FROM {$this->table} 
                    WHERE category_id = :c_id";
            
          $stmt = $this->conn->prepare($query);
          $stmt->bindParam(':c_id', $this->category_id);
          if($stmt->execute()){ //remove if here
            if ($stmt->rowCount() === 0){
              echo json_encode(
                array('message' => 'category_id Not Found'));
                exit();
            }
          }

          // Create query
          $query = 'INSERT INTO ' . $this->table . 
          ' (quote, author_id, category_id) 
          VALUES
            (:quote, :author_id, :category_id)';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->quote = htmlspecialchars(strip_tags($this->quote));
          $this->author_id = htmlspecialchars(strip_tags($this->author_id));
          $this->category_id = htmlspecialchars(strip_tags($this->category_id));

          // Bind data
          $stmt->bindParam(':quote', $this->quote);
          $stmt->bindParam(':author_id', $this->author_id);
          $stmt->bindParam(':category_id', $this->category_id);

          // Execute query
          if($stmt->execute()) {
            $lastId = $this->conn->lastInsertId();
            return true;
          }

      // Print error if something goes wrong
      //printf("Error: %s.\n", $stmt->error);

      return false;
    }

    // Update Post
    public function update() {
          //before update check if id, author_id, and category id are correct

          //query if id exists  
          $query = "SELECT quote FROM {$this->table} 
                    WHERE id = :id";
            
          $stmt = $this->conn->prepare($query);
          $stmt->bindParam(':id', $this->id);
          if($stmt->execute()){ 
            if ($stmt->rowCount() === 0){
              echo json_encode(
                array('message' => 'No Quotes Found')
              );
              exit();
            }
          }

          //query if author_id exists  
          $query = "SELECT quote FROM {$this->table} 
                    WHERE author_id = :a_id";
            
          $stmt = $this->conn->prepare($query);
          $stmt->bindParam(':a_id', $this->author_id);
          if($stmt->execute()){ 
            if ($stmt->rowCount() === 0){
              echo json_encode(
                array('message' => 'author_id Not Found')
              );
              exit();
            }
          }

          //query if category_id exists
          $query = "SELECT quote FROM {$this->table} 
                    WHERE category_id = :c_id";
            
          $stmt = $this->conn->prepare($query);
          $stmt->bindParam(':c_id', $this->category_id);
          if($stmt->execute()){ 
            if ($stmt->rowCount() === 0){
              echo json_encode(
                array('message' => 'category_id Not Found'));
                exit();
            }
          }

          // Create query
          $query = 'UPDATE ' . $this->table . '
                                SET quote = :quote, author_id = :author_id, category_id = :category_id
                                WHERE id = :id';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->quote = htmlspecialchars(strip_tags($this->quote));
          $this->author_id = htmlspecialchars(strip_tags($this->author_id));
          $this->category_id = htmlspecialchars(strip_tags($this->category_id));
          $this->id = htmlspecialchars(strip_tags($this->id));

          // Bind data
          $stmt->bindParam(':quote', $this->quote);
          $stmt->bindParam(':author_id', $this->author_id);
          $stmt->bindParam(':category_id', $this->category_id);
          $stmt->bindParam(':id', $this->id);

          // Execute query
          if($stmt->execute()) {
            return true;
          }

          // Print error if something goes wrong
          //printf("Error: %s.\n", $stmt->error);

          return false;
    }

    // Delete Post
    public function delete() {
          // Create query
          $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->id = htmlspecialchars(strip_tags($this->id));

          // Bind data
          $stmt->bindParam(':id', $this->id);

          // Execute query
          if($stmt->execute()) {
            return true;
          }

          // Print error if something goes wrong
          printf("Error: %s.\n", $stmt->error);

          return false;
    }
    
  }?>