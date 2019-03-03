<?php
class Pembelian{
 
    // database connection and table name
    private $conn;
    private $table_name = "pembelian";
 
    // object properties
    public $IdPembelian;
    public $TglBeli;
    public $TotalBayar;
    public $SuplierId;
    public $ItemBarang;
 
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
           $query = "SELECT * from " . $this->table_name . " where IdPembelian=?";
        
           // prepare query statement
           $stmt = $this->conn->prepare($query);

           $this->IdPembelian=htmlspecialchars(strip_tags($this->IdPembelian));

           $stmt->bindParam(1, $this->IdPembelian);
        
           // execute query
           $stmt->execute();
           $rowPembelian = $stmt->fetch(PDO::FETCH_ASSOC);
           $this->TglBeli=$rowPembelian['TglBeli'];
        
           return $stmt;
        }

        function readBySupplier(){
        
            // select all query
            $query = "SELECT * from " . $this->table_name . " where SuplierId=?";
         
            // prepare query statement
            $stmt = $this->conn->prepare($query);
 
            $this->SuplierId=htmlspecialchars(strip_tags($this->SuplierId));
 
            $stmt->bindParam(1, $this->SuplierId);
         
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
                   TglBeli=:TglBeli, TotalBayar=:TotalBayar, SuplierId=:SuplierId";
    
       // prepare query
       $stmt = $this->conn->prepare($query);
    
       // sanitize
       $this->TglBeli=htmlspecialchars(strip_tags($this->TglBeli));
       $this->TotalBayar=htmlspecialchars(strip_tags($this->TotalBayar));
       $this->SuplierId=htmlspecialchars(strip_tags($this->SuplierId));
    
       // bind values
       $stmt->bindParam(":TglBeli", $this->TglBeli);
       $stmt->bindParam(":TotalBayar", $this->TotalBayar);
       $stmt->bindParam(":SuplierId", $this->SuplierId);
    
       // execute query
       if($stmt->execute()){
            $this->IdPembelian = $this->conn->lastInsertId();
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
                    TglBeli=:TglBeli, 
                    TotalBayar=:TotalBayar, 
                    SuplierId=:SuplierId
               WHERE
                   IdPembelian = :IdPembelian";
    
       // prepare query statement
       $stmt = $this->conn->prepare($query);
    
       // sanitize
      // sanitize
      $this->TglBeli=htmlspecialchars(strip_tags($this->TglBeli));
      $this->TotalBayar=htmlspecialchars(strip_tags($this->TotalBayar));
      $this->SuplierId=htmlspecialchars(strip_tags($this->SuplierId));
      $this->IdPembelian=htmlspecialchars(strip_tags($this->IdPembelian));
   
      // bind values
      $stmt->bindParam(":TglBeli", $this->TglBeli);
      $stmt->bindParam(":TotalBayar", $this->TotalBayar);
      $stmt->bindParam(":SuplierId", $this->SuplierId);
      $stmt->bindParam(":IdPembelian", $this->IdPembelian);
    
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
       $query = "DELETE FROM " . $this->table_name . " WHERE IdPembelian = ?";
    
       // prepare query
       $stmt = $this->conn->prepare($query);
    
       // sanitize
       $this->IdPembelian=htmlspecialchars(strip_tags($this->IdPembelian));
    
       // bind id of record to delete
       $stmt->bindParam(1, $this->IdPembelian);
    
       // execute query
       if($stmt->execute()){
           return true;
       }else
       {
            return false;
       }
   }
}