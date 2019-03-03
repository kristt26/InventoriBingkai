<?php
class DetailBeli{
 
    // database connection and table name
    private $conn;
    private $table_name = "detailbeli";
 
    // object properties
    public $IdDetail;
    public $HargaBeli;
    public $Jumlah;
    public $KodeBarang;
    public $PembelianId;
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
           $query = "SELECT * from " . $this->table_name . " where IdDetail=?";
        
           // prepare query statement
           $stmt = $this->conn->prepare($query);

           $this->IdDetail=htmlspecialchars(strip_tags($this->IdDetail));

           $stmt->bindParam(1, $this->IdDetail);
        
           // execute query
           $stmt->execute();

           $rowRetun = $stmt->fetch(PDO::FETCH_ASSOC);
           $this->BarangId=$rowRetun['BarangId'];
           $this->PembelianId=$rowRetun['PembelianId'];
        
           return $stmt;
        }
    
        function readByPembelian(){
        
            // select all query
            $query = "SELECT * from " . $this->table_name . " where PembelianId=?";
         
            // prepare query statement
            $stmt = $this->conn->prepare($query);
 
            $this->PembelianId=htmlspecialchars(strip_tags($this->PembelianId));
 
            $stmt->bindParam(1, $this->PembelianId);
         
            // execute query
            $stmt->execute();
            /*
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->IdDetail=$row['IdDetail'];
            $this->HargaBeli=$row['HargaBeli'];
            $this->KodeBarang=$row['KodeBarang'];
            $this->Jumlah=$row['Jumlah'];
            $this->PembelianId=$row['PembelianId'];
            $this->BarangId=$row['BarangId'];
            */
         
            return $stmt;
         }
        
         function readByKodeBarang(){
        
            // select all query
            $query = "SELECT * from " . $this->table_name . " where KodeBarang=?";
         
            // prepare query statement
            $stmt = $this->conn->prepare($query);
 
            $this->KodeBarang=htmlspecialchars(strip_tags($this->KodeBarang));
 
            $stmt->bindParam(1, $this->KodeBarang);
         
            $stmt->execute();
            
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->IdDetail=$row['IdDetail'];
            $this->HargaBeli=$row['HargaBeli'];
            $this->KodeBarang=$row['KodeBarang'];
            $this->Jumlah=$row['Jumlah'];
            $this->PembelianId=$row['PembelianId'];
            $this->BarangId=$row['BarangId'];
            
         
            return $stmt;
         }

    

   // create product
    function create(){
    
       // query to insert record
       $query = "INSERT INTO
                   " . $this->table_name . "
               SET
                   HargaBeli=:HargaBeli, Jumlah=:Jumlah, KodeBarang=:KodeBarang, PembelianId=:PembelianId, BarangId=:BarangId";
    
       // prepare query
       $stmt = $this->conn->prepare($query);
    
       // sanitize
       $this->HargaBeli=htmlspecialchars(strip_tags($this->HargaBeli));
       $this->Jumlah=htmlspecialchars(strip_tags($this->Jumlah));
       $this->PembelianId=htmlspecialchars(strip_tags($this->PembelianId));
       $this->BarangId=htmlspecialchars(strip_tags($this->BarangId));
       $this->KodeBarang=htmlspecialchars(strip_tags($this->KodeBarang));
    
       // bind values
       $stmt->bindParam(":HargaBeli", $this->HargaBeli);
       $stmt->bindParam(":Jumlah", $this->Jumlah);
       $stmt->bindParam(":PembelianId", $this->PembelianId);
       $stmt->bindParam(":BarangId", $this->BarangId);
       $stmt->bindParam(":KodeBarang", $this->KodeBarang);
    
       // execute query
       if($stmt->execute()){
            $this->IdDetail = $this->conn->lastInsertId();
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
                    HargaBeli=:HargaBeli,
                    Jumlah=:Jumlah,
                    KodeBarang=:KodeBarang,
                    PembelianId=:PembelianId,
                    BarangId=:BarangId
               WHERE
                   IdDetail = :IdDetail";
    
       // prepare query statement
       $stmt = $this->conn->prepare($query);
    
       // sanitize
       // sanitize
       $this->HargaBeli=htmlspecialchars(strip_tags($this->HargaBeli));
       $this->Jumlah=htmlspecialchars(strip_tags($this->Jumlah));
       $this->KodeBarang=htmlspecialchars(strip_tags($this->KodeBarang));
       $this->PembelianId=htmlspecialchars(strip_tags($this->PembelianId));
       $this->BarangId=htmlspecialchars(strip_tags($this->BarangId));
       $this->IdDetail=htmlspecialchars(strip_tags($this->IdDetail));
    
       // bind values
       $stmt->bindParam(":HargaBeli", $this->HargaBeli);
       $stmt->bindParam(":KodeBarang", $this->KodeBarang);
       $stmt->bindParam(":Jumlah", $this->Jumlah);
       $stmt->bindParam(":PembelianId", $this->PembelianId);
       $stmt->bindParam(":BarangId", $this->BarangId);
       $stmt->bindParam(":IdDetail", $this->IdDetail);
    
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
       $query = "DELETE FROM " . $this->table_name . " WHERE IdDetail = ?";
    
       // prepare query
       $stmt = $this->conn->prepare($query);
    
       // sanitize
       $this->IdDetail=htmlspecialchars(strip_tags($this->IdDetail));
    
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