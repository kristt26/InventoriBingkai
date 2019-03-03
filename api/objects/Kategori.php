<?php
class Kategori{
 
    // database connection and table name
    private $conn;
    private $table_name = "kategori";
 
    // object properties
    public $IdKategori;
    public $NamaKategori;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    
    // read products
    function read(){
    
       // select all query
       $query = "SELECT * from " . $this->table_name . "";
    
       // prepare query statement
       $stmt = $this->conn->prepare($query);
    
       // execute query
       $stmt->execute();
    
       return $stmt;
    }


    function readOne(){
        
           // select all query
           $query = "SELECT * from " . $this->table_name . " where IdKategori=?";
        
           // prepare query statement
           $stmt = $this->conn->prepare($query);

           $this->IdKategori=htmlspecialchars(strip_tags($this->IdKategori));

           $stmt->bindParam(1, $this->IdKategori);
        
           // execute query
           $stmt->execute();
        
           return $stmt;
        }

    

   // create product
    function create(){
    
       // query to insert record
       $query = "INSERT INTO
                   " . $this->table_name . "
               SET
                   NamaKategori=:NamaKategori";
    
       // prepare query
       $stmt = $this->conn->prepare($query);
    
       // sanitize
       $this->NamaKategori=htmlspecialchars(strip_tags($this->NamaKategori));
    
       // bind values
       $stmt->bindParam(":NamaKategori", $this->NamaKategori);
    
       // execute query
       if($stmt->execute()){
            $this->IdKategori = $this->conn->lastInsertId();
           return true;
       }else{
           return false;
       }
   }

   // update the product
    function update(){
    
       // update query
       $query = "UPDATE
                   " . $this->table_name . "
               SET
                    NamaKategori=:NamaKategori 
               WHERE
                   IdKategori = :IdKategori";
    
       // prepare query statement
       $stmt = $this->conn->prepare($query);
    
       // sanitize
       $this->NamaKategori=htmlspecialchars(strip_tags($this->NamaKategori));
       $this->IdKategori=htmlspecialchars(strip_tags($this->IdKategori));
    
       // bind new values
       $stmt->bindParam(":NamaKategori", $this->NamaKategori);
       $stmt->bindParam(":IdKategori", $this->IdKategori);
    
       // execute the query
       if($stmt->execute()){
           return true;
       }else{
           return false;
       }
   }

   // delete the product
    function delete(){
    
       // delete query
       $query = "DELETE FROM " . $this->table_name . " WHERE IdKategori = ?";
    
       // prepare query
       $stmt = $this->conn->prepare($query);
    
       // sanitize
       $this->IdKategori=htmlspecialchars(strip_tags($this->IdKategori));
    
       // bind id of record to delete
       $stmt->bindParam(1, $this->IdKategori);
    
       // execute query
       if($stmt->execute()){
           return true;
       }else
       {
            return false;
       }
   }
}