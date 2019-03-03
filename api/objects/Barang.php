<?php
class Barang{
 
    // database connection and table name
    private $conn;
    private $table_name = "barang";
 
    // object properties
    public $IdBarang;
    public $NamaBarang;
    public $Stock;
    public $Keterangan;
    public $KategoriId;
 
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

    function readKategori(){
        
        // select all query
        $query = "SELECT * from " . $this->table_name . " where KategoriId=?";
     
        // prepare query statement
        $stmt = $this->conn->prepare($query);

        $this->KategoriId=htmlspecialchars(strip_tags($this->KategoriId));

        $stmt->bindParam(1, $this->KategoriId);
     
        // execute query
        $stmt->execute();
     
        return $stmt;
     }


    function readOne(){
        
           // select all query
           $query = "SELECT * from " . $this->table_name . " where IdBarang=?";
        
           // prepare query statement
           $stmt = $this->conn->prepare($query);

           $this->IdBarang=htmlspecialchars(strip_tags($this->IdBarang));

           $stmt->bindParam(1, $this->IdBarang);
        
           // execute query
           $stmt->execute();
           $row = $stmt->fetch(PDO::FETCH_ASSOC);
           $this->NamaBarang= $row['NamaBarang'];
           $this->Stock=$row['Stock'];
           $this->Keterangan=$row['Keterangan'];
           $this->KategoriId=$row['KategoriId'];
        }

    

   // create product
    function create(){
    
       // query to insert record
       $query = "INSERT INTO
                   " . $this->table_name . "
               SET
                   NamaBarang=:NamaBarang, Stock=:Stock, Keterangan=:Keterangan, KategoriId=:KategoriId";
    
       // prepare query
       $stmt = $this->conn->prepare($query);
    
       // sanitize
       $this->NamaBarang=htmlspecialchars(strip_tags($this->NamaBarang));
       $this->Stock=htmlspecialchars(strip_tags($this->Stock));
       $this->Keterangan=htmlspecialchars(strip_tags($this->Keterangan));
       $this->KategoriId=htmlspecialchars(strip_tags($this->KategoriId));
    
       // bind values
       $stmt->bindParam(":NamaBarang", $this->NamaBarang);
       $stmt->bindParam(":Stock", $this->Stock);
       $stmt->bindParam(":Keterangan", $this->Keterangan);
       $stmt->bindParam(":KategoriId", $this->KategoriId);
    
       // execute query
       if($stmt->execute()){
            $this->IdBarang = $this->conn->lastInsertId();
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
                    NamaBarang=:NamaBarang,
                    Keterangan=:Keterangan,
                    KategoriId=:KategoriId
               WHERE
                   IdBarang = :IdBarang";
    
       // prepare query statement
       $stmt = $this->conn->prepare($query);
    
       // sanitize
       $this->NamaBarang=htmlspecialchars(strip_tags($this->NamaBarang));
       $this->Keterangan=htmlspecialchars(strip_tags($this->Keterangan));
       $this->KategoriId=htmlspecialchars(strip_tags($this->KategoriId));
       $this->IdBarang=htmlspecialchars(strip_tags($this->IdBarang));
    
       // bind new values
       $stmt->bindParam(":NamaBarang", $this->NamaBarang);
       $stmt->bindParam(":KategoriId", $this->KategoriId);
       $stmt->bindParam(":Keterangan", $this->Keterangan);
       $stmt->bindParam(":IdBarang", $this->IdBarang);
    
       // execute the query
       if($stmt->execute()){
           return true;
       }else{
           return false;
       }
   }

   function updateStock($St){
    
    // update query
    $query = "UPDATE
                " . $this->table_name . "
            SET
                 Stock=:Stock
            WHERE
                IdBarang = :IdBarang";
 
    // prepare query statement
    $stmt = $this->conn->prepare($query);
 
    // sanitize
    $St=htmlspecialchars(strip_tags($St));
    $this->IdBarang=htmlspecialchars(strip_tags($this->IdBarang));
 
    // bind new values
    $stmt->bindParam(":Stock", $St);
    $stmt->bindParam(":IdBarang", $this->IdBarang);
 
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
       $query = "DELETE FROM " . $this->table_name . " WHERE IdBarang = ?";
    
       // prepare query
       $stmt = $this->conn->prepare($query);
    
       // sanitize
       $this->IdBarang=htmlspecialchars(strip_tags($this->IdBarang));
    
       // bind id of record to delete
       $stmt->bindParam(1, $this->IdBarang);
    
       // execute query
       if($stmt->execute()){
           return true;
       }else
       {
            return false;
       }
   }
}