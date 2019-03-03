<?php
class Kembali{
    // database connection and table name
    private $conn;
    private $table_name = "return";
 
    // object properties
    public $IdReturn;
    public $IdSupplier;
    public $TglReturn;
    public $Jumlah;
    public $DetailId;
    public $TotalRetun;
 
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
    
        function readTotalPenjualan(){
        
            // select all query
            $query = "SELECT sum(Jumlah) as TotalReturn from " . $this->table_name . " where DetailId=?";
         
            // prepare query statement
            $stmt = $this->conn->prepare($query);
 
            $this->DetailId=htmlspecialchars(strip_tags($this->DetailId));
 
            $stmt->bindParam(1, $this->DetailId);
         
            // execute query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->TotalRetun=$row['TotalReturn'];
         
            return $stmt;
         }

    

   // create product
    function create(){
    
       // query to insert record
       $query = "INSERT INTO
                   " . $this->table_name . "
               SET
                   IdSupplier=:IdSupplier, 
                   TglReturn=:TglReturn, 
                   Jumlah=:Jumlah,
                   DetailId=:DetailId";
    
       // prepare query
       $stmt = $this->conn->prepare($query);
    
       // sanitize
       $this->IdSupplier=htmlspecialchars(strip_tags($this->IdSupplier));
       $this->TglReturn=htmlspecialchars(strip_tags($this->TglReturn));
       $this->Jumlah=htmlspecialchars(strip_tags($this->Jumlah));
       $this->DetailId=htmlspecialchars(strip_tags($this->DetailId));
    
       // bind values
       $stmt->bindParam(":IdSupplier", $this->IdSupplier);
       $stmt->bindParam(":TglReturn", $this->TglReturn);
       $stmt->bindParam(":Jumlah", $this->Jumlah);
       $stmt->bindParam(":DetailId", $this->DetailId);
    
       // execute query
       if($stmt->execute()){
            $this->IdReturn = $this->conn->lastInsertId();
           return true;
       }else{
           return false;
       }
   }

   function insert(){
    
    // query to insert record
    $query = "INSERT INTO
                " . $this->table_name . "
            SET
                IdSupplier=:IdSupplier, 
                TglReturn=:TglReturn, 
                Jumlah=:Jumlah,
                DetailId=:DetailId";
 
    // prepare query
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $this->IdSupplier=htmlspecialchars(strip_tags($this->IdSupplier));
    $this->TglReturn=htmlspecialchars(strip_tags($this->TglReturn));
    $this->Jumlah=htmlspecialchars(strip_tags($this->Jumlah));
    $this->DetailId=htmlspecialchars(strip_tags($this->DetailId));
 
    // bind values
    $stmt->bindParam(":IdSupplier", $this->IdSupplier);
    $stmt->bindParam(":TglReturn", $this->TglReturn);
    $stmt->bindParam(":Jumlah", $this->Jumlah);
    $stmt->bindParam(":DetailId", $this->DetailId);
 
    // execute query
    if($stmt->execute()){
         $this->IdReturn = $this->conn->lastInsertId();
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
                    IdSupplier=:IdSupplier, 
                    TglReturn=:TglReturn, 
                    Jumlah=:Jumlah,
                    DetailId=:DetailId
               WHERE
                   IdPrice = :IdPrice";
    
       // prepare query statement
       $stmt = $this->conn->prepare($query);
    
       // sanitize
      // sanitize
      $this->IdSupplier=htmlspecialchars(strip_tags($this->IdSupplier));
       $this->TglReturn=htmlspecialchars(strip_tags($this->TglReturn));
       $this->Jumlah=htmlspecialchars(strip_tags($this->Jumlah));
       $this->DetailId=htmlspecialchars(strip_tags($this->DetailId));
       $this->IdReturn=htmlspecialchars(strip_tags($this->IdReturn));
    
       // bind values
       $stmt->bindParam(":IdSupplier", $this->IdSupplier);
       $stmt->bindParam(":TglReturn", $this->TglReturn);
       $stmt->bindParam(":Jumlah", $this->Jumlah);
       $stmt->bindParam(":DetailId", $this->DetailId);
       $stmt->bindParam(":IdReturn", $this->IdReturn);
    
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
       $query = "DELETE FROM " . $this->table_name . " WHERE IdRerutn = ?";
    
       // prepare query
       $stmt = $this->conn->prepare($query);
    
       // sanitize
       $this->IdReturn=htmlspecialchars(strip_tags($this->IdReturn));
    
       // bind id of record to delete
       $stmt->bindParam(1, $this->IdReturn);
    
       // execute query
       if($stmt->execute()){
           return true;
       }else
       {
            return false;
       }
   }
}
?>