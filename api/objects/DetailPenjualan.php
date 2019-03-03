<?php
class DetailPenjualan{
 
    // database connection and table name
    private $conn;
    private $table_name = "detailpenjualan";
 
    // object properties
    public $IdDetailPenjualan;
    public $Jumlah;
    public $KodeBarang;
    public $PenjualanId;
    public $DetailId;
    public $TotalPembelian;
    public $TotalJumlah;
 
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


        function readByPenjualanId(){
        
            // select all query
            $query = "SELECT * from " . $this->table_name . " where PenjualanId=?";
         
            // prepare query statement
            $stmt = $this->conn->prepare($query);
 
            $this->PenjualanId=htmlspecialchars(strip_tags($this->PenjualanId));
 
            $stmt->bindParam(1, $this->PenjualanId);
         
            // execute query
            $stmt->execute();
         
            return $stmt;
         }
    
        function readTotalPenjualan(){
        
            // select all query
            $query = "SELECT sum(Jumlah) as TotalJumlah from " . $this->table_name . " where DetailId=?";
         
            // prepare query statement
            $stmt = $this->conn->prepare($query);
 
            $this->DetailId=htmlspecialchars(strip_tags($this->DetailId));
 
            $stmt->bindParam(1, $this->DetailId);
         
            // execute query
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->TotalJumlah=$row['TotalJumlah'];
         
            return $stmt;
         }
    
         

    

   // create product
    function create(){
    
       // query to insert record
       $query = "INSERT INTO
                   " . $this->table_name . "
               SET
                   KodeBarang=:KodeBarang, 
                   Jumlah=:Jumlah, 
                   PenjualanId=:PenjualanId, 
                   DetailId=:DetailId";
    
       // prepare query
       $stmt = $this->conn->prepare($query);
    
       // sanitize
       $this->KodeBarang=htmlspecialchars(strip_tags($this->KodeBarang));
       $this->Jumlah=htmlspecialchars(strip_tags($this->Jumlah));
       $this->PenjualanId=htmlspecialchars(strip_tags($this->PenjualanId));
       $this->DetailId=htmlspecialchars(strip_tags($this->DetailId));
    
       // bind values
       $stmt->bindParam(":KodeBarang", $this->KodeBarang);
       $stmt->bindParam(":Jumlah", $this->Jumlah);
       $stmt->bindParam(":PenjualanId", $this->PenjualanId);
       $stmt->bindParam(":DetailId", $this->DetailId);
    
       // execute query
       if($stmt->execute()){
            $this->IdDetailPenjualan = $this->conn->lastInsertId();
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
                    KodeBarang=:KodeBarang,
                    Jumlah=:Jumlah,
                    PenjualanId=:PenjualanId,
                    DetailId=:DetailId
               WHERE
                   IdDetailPenjualan = :IdDetailPenjualan";
    
       // prepare query statement
       $stmt = $this->conn->prepare($query);
    
       // sanitize
      // sanitize
      $this->KodeBarang=htmlspecialchars(strip_tags($this->KodeBarang));
      $this->Jumlah=htmlspecialchars(strip_tags($this->Jumlah));
      $this->PenjualanId=htmlspecialchars(strip_tags($this->PenjualanId));
      $this->DetailId=htmlspecialchars(strip_tags($this->DetailId));
      $this->IdDetailPenjualan=htmlspecialchars(strip_tags($this->IdDetailPenjualan));
   
      // bind values
      $stmt->bindParam(":KodeBarang", $this->KodeBarang);
      $stmt->bindParam(":Jumlah", $this->Jumlah);
      $stmt->bindParam(":PenjualanId", $this->PenjualanId);
      $stmt->bindParam(":DetailId", $this->DetailId);
      $stmt->bindParam(":IdDetailPenjualan", $this->IdDetailPenjualan);
    
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
       $query = "DELETE FROM " . $this->table_name . " WHERE IdDetailPenjualan = ?";
    
       // prepare query
       $stmt = $this->conn->prepare($query);
    
       // sanitize
       $this->IdDetail=htmlspecialchars(strip_tags($this->IdDetailPenjualan));
    
       // bind id of record to delete
       $stmt->bindParam(1, $this->IdDetail);
    
       // execute query
       if($stmt->execute()){
           return true;
       }else
       {
            return false;
       }
   }
}