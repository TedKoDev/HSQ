<?php

class Meta{


  //db stuff
  private $conn;
  private $table1 ='User';
  private $table2 ='User_Meta';

  //post properties
  public $id;
  public $category_id;
  public $title;
  public $body;
  public $author;
  public $create_at;

  //constructor with db connection 
  public function __construct($db) // __construct 생성자 
  {
    $this ->conn = $db;
    
  }


  //getting posts from our database
  public function read(){
      //create query
      $query = 'SELECT c.name as category_name,p.id,p.category_id,p.title,p.body,p.author,p.created_at FROM '.$this->table.' p  LEFT JOIN categories c ON p.category_id = c.id ORDER BY p.created_at DESC';

        //prepare statement
        $stmt = $this -> conn -> prepare($query);
        //execute query
        $stmt -> execute();
        // echo json_encode( $stmt);
        return $stmt;
    
  }

  public function read_single(){
    $query = 'SELECT c.name as category_name,p.id,p.category_id,p.title,p.body,p.author,p.created_at
     FROM '.$this->table.' p 
    LEFT JOIN categories c ON p.category_id = c.id WHERE p.id = ? LIMIT 1';


    //prepare statement
    $stmt = $this -> conn -> prepare($query);
    //binding param
    $stmt ->bindParam(1, $this->id);
    //execute the query
    $stmt ->execute();
    
    $row = $stmt ->fetch(PDO::FETCH_ASSOC);

    $this->id = $row['id'];
    $this->title = $row['title'];
    $this->body = $row['body'];
    $this->author = $row['author'];
    $this->category_id = $row['category_id'];
    $this->category_name = $row['category_name'];

    //execute query
    $stmt -> execute();
    echo json_encode( $stmt);
    return $stmt;


  }

  public function create(){
 
    //create query
    $query = 'INSERT INTO '.$this -> table . ' SET title = :title, body = :body, author = :author, category_id = :category_id';
    //prepare statement
    $stmt = $this->conn->prepare($query);
    //clean data
    $this -> title          = htmlspecialchars(strip_tags($this->title));
    $this -> body           = htmlspecialchars(strip_tags($this->body));
    $this -> author         = htmlspecialchars(strip_tags($this->author));
    $this -> category_id    = htmlspecialchars(strip_tags($this->category_id));
    //binding of parameters
    $stmt ->bindParam(':title', $this->title);
    $stmt ->bindParam(':body', $this->body);
    $stmt ->bindParam(':author', $this->author);
    $stmt ->bindParam(':category_id', $this->category_id);
    //execute the query  쿼리를 실행하다. 
    if($stmt->execute()){

      echo 2;
      return true;
    }


    //print error if something goes wrong
    printf("Error %s. \n", $stmt->error);
    return false;

  }
  
  public function update(){
  
    //create query
   echo  $query = 'UPDATE '.$this -> table . '
     SET title = :title, body = :body, author = :author, category_id = :category_id
     WHERE id = :id';
    //prepare statement
    $stmt = $this->conn->prepare($query);
    //clean data
    $this -> title          = htmlspecialchars(strip_tags($this->title));
    $this -> body           = htmlspecialchars(strip_tags($this->body));
    $this -> author         = htmlspecialchars(strip_tags($this->author));
    $this -> category_id    = htmlspecialchars(strip_tags($this->category_id));
    $this -> id             = htmlspecialchars(strip_tags($this->id));

    //binding of parameters
    $stmt ->bindParam(':title', $this->title);
    $stmt ->bindParam(':body', $this->body);
    $stmt ->bindParam(':author', $this->author);
    $stmt ->bindParam(':category_id', $this->category_id);
    $stmt ->bindParam(':id', $this->id);
    //execute the query  쿼리를 실행하다. 
    if($stmt->execute()){
      return true;
    }


    //print error if something goes wrong
    printf("Error %s. \n", $stmt->error);
    return false;

  }


  public function delete(){
  
    //create query
   echo  $query = 'DELETE FROM '.$this -> table . '   WHERE id = :id';
    //prepare statement
    $stmt = $this->conn->prepare($query);
    //clean data
    $this -> id             = htmlspecialchars(strip_tags($this->id));

    //binding of parameters
    $stmt ->bindParam(':id', $this->id);
    //execute the query  쿼리를 실행하다. 
    if($stmt->execute()){
      return true;
    }


    //print error if something goes wrong
    printf("Error %s. \n", $stmt->error);
    return false;

  }



}