<?php 
  class Quote {
    // DB stuff
    private $conn;
    private $table = 'quotes';

    // Quote Properties
    public $id;
    public $category_id;
    public $author_id;
    public $quote;

    // Constructor with DB
    public function __construct($db) {
      $this->conn = $db;
    }

    // Get Quotes
    public function read() {
      // Create query
      $query = 'SELECT c.name as category_name, p.id, p.category_id, p.title, p.body, p.author, p.created_at
                                FROM ' . $this->table . ' p
                                LEFT JOIN
                                  categories c ON p.category_id = c.id
                                ORDER BY
                                  p.created_at DESC';
      
      // Prepare statement
      $stmt = $this->conn->prepare($query);

      // Execute query
      $stmt->execute();

      return $stmt;
    }

    // Get Single quote
    public function read_single() {
      //there are 4 options so check which one it is and do that one
      
      if($_GET['id']) {
          // Create query
          $query = 'SELECT q.id, q.quote, a.author, c.category as id, quote, author, category
                                    FROM ' . $this->table . ' q
                                    INNER JOIN
                                      authors a ON q.author_id = a.id
                                    INNER JOIN
                                      categories c ON q.category_id = c.id
                                    WHERE
                                      q.id = :id';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Bind ID
          $stmt->bindParam(':id', $this->id);

          // Execute query
          if($stmt->execute()) {
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            //test id 
            if (is_array($row)) {
              $this->quote = $row['quote'];
              $this->author_id = $row['author_id'];
              $this->category_id = $row['category_id'];
            }
          /*if(!is_array($row)) {
            echo json_encode(
              array('message' => 'author_id Not Found')
            );*/

            return false;
          }

            // Set properties
            $this->quote = $row['quote'];
            //$this->author = $row['author'];
            //$this->category_id = $row['category_id'];
            return true;

          } else {
            // Print error if something goes wrong
            printf("Error: $s.\n", $stmt->error);
          
            return false;
          }

        } 
    }

    // Create Post
    public function create() {
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
            return true;
          }

      // Print error if something goes wrong
      printf("Error: %s.\n", $stmt->error);

      return false;
    }

    // Update Post
    public function update() {
          // Create query
          $query = 'UPDATE ' . $this->table . '
                                SET title = :title, body = :body, author = :author, category_id = :category_id
                                WHERE id = :id';

          // Prepare statement
          $stmt = $this->conn->prepare($query);

          // Clean data
          $this->title = htmlspecialchars(strip_tags($this->title));
          $this->body = htmlspecialchars(strip_tags($this->body));
          $this->author = htmlspecialchars(strip_tags($this->author));
          $this->category_id = htmlspecialchars(strip_tags($this->category_id));
          $this->id = htmlspecialchars(strip_tags($this->id));

          // Bind data
          $stmt->bindParam(':title', $this->title);
          $stmt->bindParam(':body', $this->body);
          $stmt->bindParam(':author', $this->author);
          $stmt->bindParam(':category_id', $this->category_id);
          $stmt->bindParam(':id', $this->id);

          // Execute query
          if($stmt->execute()) {
            return true;
          }

          // Print error if something goes wrong
          printf("Error: %s.\n", $stmt->error);

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
    
  }