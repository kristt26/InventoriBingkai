<?php
class Supplier{
 
    // database connection and table name
    private $conn;
    private $table_name = "supplier";
 
    // object properties
    public $IdSupplier;
    public $NamaSupplier;
    public $Telp;
    public $Alamat;
 
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
           $query = "SELECT * from " . $this->table_name . " where IdSupplier=?";
        
           // prepare query statement
           $stmt = $this->conn->prepare($query);

           $this->IdSupplier=htmlspecialchars(strip_tags($this->IdSupplier));

           $stmt->bindParam(1, $this->IdSupplier);
        
           // execute query
           $stmt->execute();

           $row = $row = $stmt->fetch(PDO::FETCH_ASSOC);
           $this->NamaSupplier= $row['NamaSupplier'];
           $this->Telp= $row['Telp'];
           $this->Alamat= $row['Alamat'];
        
        }

    

   // create product
    function create(){
    
       // query to insert record
       $query = "INSERT INTO
                   " . $this->table_name . "
               SET
                   NamaSupplier=:NamaSupplier, 
                   Telp=:Telp, 
                   Alamat=:Alamat";
    
       // prepare query
       $stmt = $this->conn->prepare($query);
    
       // sanitize
       $this->NamaSupplier=htmlspecialchars(strip_tags($this->NamaSupplier));
       $this->Telp=htmlspecialchars(strip_tags($this->Telp));
       $this->Alamat=htmlspecialchars(strip_tags($this->Alamat));
    
       // bind values
       $stmt->bindParam(":NamaSupplier", $this->NamaSupplier);
       $stmt->bindParam(":Telp", $this->Telp);
       $stmt->bindParam(":Alamat", $this->Alamat);
    
       // execute query
       if($stmt->execute()){
            $this->IdSupplier = $this->conn->lastInsertId();
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
                    NamaSupplier=:NamaSupplier, 
                    Telp=:Telp, 
                    Alamat=:Alamat
               WHERE
                   IdSupplier = :IdSupplier";
    
       // prepare query statement
       $stmt = $this->conn->prepare($query);
    
       // sanitize
      // sanitize
      $this->NamaSupplier=htmlspecialchars(strip_tags($this->NamaSupplier));
      $this->Telp=htmlspecialchars(strip_tags($this->Telp));
      $this->Alamat=htmlspecialchars(strip_tags($this->Alamat));
      $this->IdSupplier=htmlspecialchars(strip_tags($this->IdSupplier));
   
      // bind values
      $stmt->bindParam(":NamaSupplier", $this->NamaSupplier);
      $stmt->bindParam(":Telp", $this->Telp);
      $stmt->bindParam(":Alamat", $this->Alamat);
      $stmt->bindParam(":IdSupplier", $this->IdSupplier);
    
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
       $query = "DELETE FROM " . $this->table_name . " WHERE IdSupplier = ?";
    
       // prepare query
       $stmt = $this->conn->prepare($query);
    
       // sanitize
       $this->IdSupplier=htmlspecialchars(strip_tags($this->IdSupplier));
    
       // bind id of record to delete
       $stmt->bindParam(1, $this->IdSupplier);
    
       // execute query
       if($stmt->execute()){
           return true;
       }else
       {
            return false;
       }
   }
}