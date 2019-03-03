<?php
class Penjualan{
 
    // database connection and table name
    private $conn;
    private $table_name = "penjualan";
 
    // object properties
    public $IdPenjualan;
    public $Nota;
    public $Tgl;
    public $TotalBayar;
    public $KaryawanId;
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
           $query = "SELECT * from " . $this->table_name . " where IdDetailPenjualan=?";
        
           // prepare query statement
           $stmt = $this->conn->prepare($query);

           $this->IdDetailPenjualan=htmlspecialchars(strip_tags($this->IdDetailPenjualan));

           $stmt->bindParam(1, $this->IdDetailPenjualan);
        
           // execute query
           $stmt->execute();
        
           return $stmt;
        }
    
        function readByNota(){
        
            // select all query
            $query = "SELECT * from " . $this->table_name . " ORDER BY Nota DESC LIMIT 1";
         
            // prepare query statement
            $stmt = $this->conn->prepare($query);
         
            // execute query
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->Nota=$row['Nota'];         
         }

    

   // create product
    function create(){
    
       // query to insert record
       $query = "INSERT INTO
                   " . $this->table_name . "
               SET
                   Nota=:Nota, 
                   Tgl=:Tgl, 
                   TotalBayar=:TotalBayar,
                   KaryawanId=:KaryawanId";
    
       // prepare query
       $stmt = $this->conn->prepare($query);
    
       // sanitize
       $this->Nota=htmlspecialchars(strip_tags($this->Nota));
       $this->Tgl=htmlspecialchars(strip_tags($this->Tgl));
       $this->TotalBayar=htmlspecialchars(strip_tags($this->TotalBayar));
       $this->KaryawanId=htmlspecialchars(strip_tags($this->KaryawanId));
    
       // bind values
       $stmt->bindParam(":Nota", $this->Nota);
       $stmt->bindParam(":Tgl", $this->Tgl);
       $stmt->bindParam(":TotalBayar", $this->TotalBayar);
       $stmt->bindParam(":KaryawanId", $this->KaryawanId);
    
       // execute query
       if($stmt->execute()){
            $this->IdPenjualan = $this->conn->lastInsertId();
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
                    Nota=:Nota, 
                    Tgl=:Tgl, 
                    TotalBayar=:TotalBayar,
                    KaryawanId
               WHERE
                   IdPenjualan = :IdPenjualan";
    
       // prepare query statement
       $stmt = $this->conn->prepare($query);
    
       // sanitize
      // sanitize
      $this->Nota=htmlspecialchars(strip_tags($this->Nota));
      $this->Tgl=htmlspecialchars(strip_tags($this->Tgl));
      $this->TotalBayar=htmlspecialchars(strip_tags($this->TotalBayar));
      $this->KaryawanId=htmlspecialchars(strip_tags($this->KaryawanId));
      $this->IdPenjualan=htmlspecialchars(strip_tags($this->IdPenjualan));
   
      // bind values
      $stmt->bindParam(":Nota", $this->Nota);
      $stmt->bindParam(":Tgl", $this->Tgl);
      $stmt->bindParam(":TotalBayar", $this->TotalBayar);
      $stmt->bindParam(":KaryawanId", $this->KaryawanId);
      $stmt->bindParam(":IdPenjualan", $this->IdPenjualan);
    
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
       $query = "DELETE FROM " . $this->table_name . " WHERE IdPenjualan = ?";
    
       // prepare query
       $stmt = $this->conn->prepare($query);
    
       // sanitize
       $this->IdPenjualan=htmlspecialchars(strip_tags($this->IdPenjualan));
    
       // bind id of record to delete
       $stmt->bindParam(1, $this->IdPenjualan);
    
       // execute query
       if($stmt->execute()){
           return true;
       }else
       {
            return false;
       }
   }
}