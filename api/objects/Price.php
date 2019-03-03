<?php
class Price{
 
    // database connection and table name
    private $conn;
    private $table_name = "price";
 
    // object properties
    public $IdPrice;
    public $Price;
    public $CreateDate;
    public $Status;
    public $BarangId;
 
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

    function readByStatus(){
        
        // select all query
        $query = "SELECT * from " . $this->table_name . " where Status=?";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);

        $this->Status=htmlspecialchars(strip_tags($this->Status));

        $stmt->bindParam(1, $this->Status);
     
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


        function readByBarang(){
        
            // select all query
            $query = "SELECT * from " . $this->table_name . " where BarangId=? and Status=?";
         
            // prepare query statement
            $stmt = $this->conn->prepare($query);
 
            $this->BarangId=htmlspecialchars(strip_tags($this->BarangId));
            $this->Status=htmlspecialchars(strip_tags($this->Status));
 
            $stmt->bindParam(1, $this->BarangId);
            $stmt->bindParam(2, $this->Status);
         
            // execute query
            $stmt->execute();
            return $stmt;
         }

         function readByTgl($Tgl){
        
            // select all query
            $query = "SELECT * from " . $this->table_name . " where BarangId=? and CreateDate<=? and CreateDate>=?";
         
            // prepare query statement
            $stmt = $this->conn->prepare($query);
 
            $this->BarangId=htmlspecialchars(strip_tags($this->BarangId));
            $Tgl=htmlspecialchars(strip_tags($Tgl));
 
            $stmt->bindParam(1, $this->BarangId);
            $stmt->bindParam(2, $Tgl);
            $stmt->bindParam(3, $Tgl);
         
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
                   Price=:Price, 
                   CreateDate=:CreateDate, 
                   Status=:Status,
                   BarangId=:BarangId";
    
       // prepare query
       $stmt = $this->conn->prepare($query);
    
       // sanitize
       $this->Price=htmlspecialchars(strip_tags($this->Price));
       $this->CreateDate=htmlspecialchars(strip_tags($this->CreateDate));
       $this->Status=htmlspecialchars(strip_tags($this->Status));
       $this->BarangId=htmlspecialchars(strip_tags($this->BarangId));
    
       // bind values
       $stmt->bindParam(":Price", $this->Price);
       $stmt->bindParam(":CreateDate", $this->CreateDate);
       $stmt->bindParam(":Status", $this->Status);
       $stmt->bindParam(":BarangId", $this->BarangId);
    
       // execute query
       if($stmt->execute()){
            $this->IdPrice = $this->conn->lastInsertId();
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
                    Price=:Price, 
                    CreateDate=:CreateDate, 
                    BarangId=:BarangId
               WHERE
                   IdPrice = :IdPrice";
    
       // prepare query statement
       $stmt = $this->conn->prepare($query);
    
       // sanitize
      // sanitize
      $this->Price=htmlspecialchars(strip_tags($this->Price));
       $this->CreateDate=htmlspecialchars(strip_tags($this->CreateDate));
       $this->BarangId=htmlspecialchars(strip_tags($this->BarangId));
       $this->IdPrice=htmlspecialchars(strip_tags($this->IdPrice));
    
       // bind values
       $stmt->bindParam(":Price", $this->Price);
       $stmt->bindParam(":CreateDate", $this->CreateDate);
       $stmt->bindParam(":BarangId", $this->BarangId);
       $stmt->bindParam(":IdPrice", $this->IdPrice);
    
       // execute the query
       if($stmt->execute()){
           return true;
       }else{
           return false;
       }
   }

   function updateStatus($DataStatus){
    
    // update query
        $query = "UPDATE
                    " . $this->table_name . "
                SET
                    Status=:Status
                WHERE
                    BarangId = :BarangId";
    
        // prepare query statement
        $stmt = $this->conn->prepare($query);
    
        // sanitize
    // sanitize
        $DataStatus=htmlspecialchars(strip_tags($DataStatus));
        $this->BarangId=htmlspecialchars(strip_tags($this->BarangId));
    
        // bind values
        $stmt->bindParam(":Status", $DataStatus);
        $stmt->bindParam(":BarangId", $this->BarangId);
    
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
       $query = "DELETE FROM " . $this->table_name . " WHERE IdPrice = ?";
    
       // prepare query
       $stmt = $this->conn->prepare($query);
    
       // sanitize
       $this->IdPrice=htmlspecialchars(strip_tags($this->IdPrice));
    
       // bind id of record to delete
       $stmt->bindParam(1, $this->IdPrice);
    
       // execute query
       if($stmt->execute()){
           return true;
       }else
       {
            return false;
       }
   }
}