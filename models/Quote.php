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

    // Get all quotes
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
      
          //get the specific quote
          if(isset($_GET['id'])) {
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
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            //test id 
            if (is_array($row)) {
              $this->quote = $row['quote'];
              $this->author_id = $row['author_id'];
              $this->category_id = $row['category_id'];
            }          
          }

          //get all quotes from author_id and category_id
          if(isset($_GET['author_id']) && isset($_GET['category_id'])) {
            $query = 'SELECT q.id, q.quote, a.author, c.category as id, quote, author, category
            FROM ' . $this->table . ' q
            INNER JOIN
              authors a ON q.author_id = a.id
            INNER JOIN
              categories c ON q.category_id = c.id
            WHERE
              a.id = :a_id
              AND
              c.id = :c_id';

            // Prepare statement
            $stmt = $this->conn->prepare($query);

            // Bind ID
            $stmt->bindParam(':a_id', $this->author_id);
            $stmt->bindParam(':c_id', $this->category_id);

             // Execute query
            $stmt->execute();
            
            $quote_arr = [];

            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
              extract($row);
              $quote_arr[] = ['id' => $id, 'quote' => $quote, 'author_id' => $author_id, 'category_id' => $category_id];
            }

            return $quotes; 
          }

          //get all quotes from author_id
          if(isset($_GET['author_id'])) {

          }
          
          //get all quotes from category_id
          if(isset($_GET['category_id'])) {
            
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