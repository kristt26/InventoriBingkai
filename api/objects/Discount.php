<?php
class Discount{
 
    // database connection and table name
    private $conn;
    private $table_name = "discount";
 
    // object properties
    public $IdDiscount;
    public $MasaBerlaku;
    public $Discount;
    public $Keterangan;
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

         function readByBarang($dttgl){
        
            // select all query
            $query = "SELECT * from " . $this->table_name . " where BarangId=? and MasaBerlaku>=?";
         
            // prepare query statement
            $stmt = $this->conn->prepare($query);
 
            $this->BarangId=htmlspecialchars(strip_tags($this->BarangId));
            $dttgl=htmlspecialchars(strip_tags($dttgl));
 
            $stmt->bindParam(1, $this->BarangId);
            $stmt->bindParam(2, $dttgl);
         
            // execute query
            $stmt->execute();
            return $stmt;
         }

         function readByTgl($Tgl){
        
            // select all query
            $query = "SELECT * from " . $this->table_name . " where BarangId=? and MasaBerlaku<=? and MasaBerlaku>=?";
         
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
                   MasaBerlaku=:MasaBerlaku, 
                   Discount=:Discount, 
                   Keterangan=:Keterangan, 
                   BarangId=:BarangId";
    
       // prepare query
       $stmt = $this->conn->prepare($query);
    
       // sanitize
       $this->MasaBerlaku=htmlspecialchars(strip_tags($this->MasaBerlaku));
       $this->Discount=htmlspecialchars(strip_tags($this->Discount));
       $this->Keterangan=htmlspecialchars(strip_tags($this->Keterangan));
       $this->BarangId=htmlspecialchars(strip_tags($this->BarangId));
    
       // bind values
       $stmt->bindParam(":MasaBerlaku", $this->MasaBerlaku);
       $stmt->bindParam(":Discount", $this->Discount);
       $stmt->bindParam(":Keterangan", $this->Keterangan);
       $stmt->bindParam(":BarangId", $this->BarangId);
    
       // execute query
       if($stmt->execute()){
            $this->IdDiscount = $this->conn->lastInsertId();
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
                    MasaBerlaku=:MasaBerlaku, 
                    Discount=:Discount, 
                    Keterangan=:Keterangan,
                    BarangId=:BarangId
               WHERE
                   IdDiscount = :IdDiscount";
    
       // prepare query statement
       $stmt = $this->conn->prepare($query);
    
       // sanitize
      // sanitize
      $this->MasaBerlaku=htmlspecialchars(strip_tags($this->MasaBerlaku));
       $this->Discount=htmlspecialchars(strip_tags($this->Discount));
       $this->Keterangan=htmlspecialchars(strip_tags($this->Keterangan));
       $this->BarangId=htmlspecialchars(strip_tags($this->BarangId));
       $this->IdDiscount=htmlspecialchars(strip_tags($this->IdDiscount));
    
       // bind values
       $stmt->bindParam(":MasaBerlaku", $this->MasaBerlaku);
       $stmt->bindParam(":Discount", $this->Discount);
       $stmt->bindParam(":Keterangan", $this->Keterangan);
       $stmt->bindParam(":BarangId", $this->BarangId);
       $stmt->bindParam(":IdDiscount", $this->IdDiscount);
    
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
       $query = "DELETE FROM " . $this->table_name . " WHERE IdDiscount = ?";
    
       // prepare query
       $stmt = $this->conn->prepare($query);
    
       // sanitize
       $this->IdDiscount=htmlspecialchars(strip_tags($this->IdDiscount));
    
       // bind id of record to delete
       $stmt->bindParam(1, $this->IdDiscount);
    
       // execute query
       if($stmt->execute()){
           return true;
       }else
       {
            return false;
       }
   }
}