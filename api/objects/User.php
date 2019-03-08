<?php
class User{
 
    // database connection and table name
    private $conn;
    private $table_name = "user";
 
    // object properties
    public $IdUser;
    public $Nama;
    public $Username;
    public $Password;
    public $Level;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    //read one product
    function readByBidang()
    {
        $query = "SELECT p.Nip, p.Nama, p.Alamat, p.Kontak, p.Sex, b.IdBidang,b.NamaBidang, p.Jabatan, p.Email from pegawai p, bidang b where p.IdBidang=b.IdBidang and p.IdBidang=?";
        $stmtByBidang = $this->conn->prepare($query);

        $this->IdBidang=htmlspecialchars(strip_tags($this->IdBidang));

        $stmtByBidang->bindParam(1, $this->IdBidang);
        $stmtByBidang->execute();

        return $stmtByBidang;

    }

    // read products
    function read(){
    
       // select all query
       $query = "SELECT IdUser, Username, Nama, Level from User";
       // prepare query statement
       $stmt = $this->conn->prepare($query);
       // execute query
       $stmt->execute();
       return $stmt;
    }


    function readOne(){
        
           // select all query
           $query = "SELECT Nip, Nama, Alamat, Kontak, Sex, Jabatan, IdBidang, Pangkat, Email from pegawai where Nip=?";
        
           // prepare query statement
           $stmt = $this->conn->prepare($query);

           $this->Nip=htmlspecialchars(strip_tags($this->Nip));

           $stmt->bindParam(1, $this->Nip);
        
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
                   Username=:Username, Password=:Password, Nama=:Nama, Level=:Level";
    
       // prepare query
       $stmt = $this->conn->prepare($query);
    
       // bind values
       $stmt->bindParam(":Username", $this->Username);
       $stmt->bindParam(":Password", $this->Password);
       $stmt->bindParam(":Nama", $this->Nama);
       $stmt->bindParam(":Level", $this->Level);
    
       // execute query
       if($stmt->execute()){
           $this->IdUser= $this->conn->lastInsertId();
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
                Username=:Username, Nama=:Nama, Level=:Level
               WHERE
                   IdUser = :IdUser";
    
       // prepare query statement
       $stmt = $this->conn->prepare($query);
       // bind new values
       $stmt->bindParam(":Username", $this->Username);
       $stmt->bindParam(":Nama", $this->Nama);
       $stmt->bindParam(":Level", $this->Level);
       $stmt->bindParam(":IdUser", $this->IdUser);
    
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
       $query = "DELETE FROM " . $this->table_name . " WHERE Nip = ?";
    
       // prepare query
       $stmt = $this->conn->prepare($query);
    
       // sanitize
       $this->Nip=htmlspecialchars(strip_tags($this->Nip));
    
       // bind id of record to delete
       $stmt->bindParam(1, $this->Nip);
    
       // execute query
       if($stmt->execute()){
           return true;
       }else
       {
            return false;
       }
    
       
        
   }
}