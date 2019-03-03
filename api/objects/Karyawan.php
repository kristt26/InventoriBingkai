<?php
class Karyawan{
 
    // database connection and table name
    private $conn;
    private $table_name = "karyawan";
 
    // object properties
    public $IdKaryawan;
    public $Nama;
    public $Alamat;
    public $Kontak;
    public $Sex;
    public $Email;
    public $Password;
    public $LevelAkses;
    public $Status;
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    function CheckSession()
    {
        session_start();
        if(!isset($_SESSION['Email']))
        {
            return false;
        }else{
            return $_SESSION;
        }
    }

    function userLogin()
    {
        $query= "SELECT IdKaryawan, Nama, Alamat, Kontak, Sex, Email, LevelAkses FROM " . $this->table_name . " WHERE Email=? and Password=?";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $this->Email);
        $stmt->bindParam(2, $this->Password);

        $stmt->execute();

        return $stmt;
    }

    function Log()
    {
        session_start();
        session_unset();
        session_destroy();
        return true;
    }

    //read one product
    
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
           $query = "SELECT * from " . $this->table_name . " where IdKaryawan=?";
        
           // prepare query statement
           $stmt = $this->conn->prepare($query);

           $this->IdKaryawan=htmlspecialchars(strip_tags($this->IdKaryawan));

           $stmt->bindParam(1, $this->IdKaryawan);
        
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
                   Nama=:Nama, 
                   Sex=:Sex, 
                   Kontak=:Kontak, 
                   Alamat=:Alamat, 
                   Email=:Email, 
                   Password=:Password, 
                   LevelAkses=:LevelAkses,
                   Status=:Status";
    
       // prepare query
       $stmt = $this->conn->prepare($query);
    
       // sanitize
       $this->Nama=htmlspecialchars(strip_tags($this->Nama));
       $this->Alamat=htmlspecialchars(strip_tags($this->Alamat));
       $this->Kontak=htmlspecialchars(strip_tags($this->Kontak));
       $this->Sex=htmlspecialchars(strip_tags($this->Sex));
       $this->Email=htmlspecialchars(strip_tags($this->Email));
       $this->Password=htmlspecialchars(strip_tags($this->Password));
       $this->LevelAkses=htmlspecialchars(strip_tags($this->LevelAkses));
       $this->Status=htmlspecialchars(strip_tags($this->Status));
    
       // bind values
       $stmt->bindParam(":Nama", $this->Nama);
       $stmt->bindParam(":Alamat", $this->Alamat);
       $stmt->bindParam(":Kontak", $this->Kontak);
       $stmt->bindParam(":Sex", $this->Sex);
       $stmt->bindParam(":Email", $this->Email);
       $stmt->bindParam(":Password", $this->Password);
       $stmt->bindParam(":LevelAkses", $this->LevelAkses);
       $stmt->bindParam(":Status", $this->Status);
    
       // execute query
       if($stmt->execute()){
            $this->IdKaryawan = $this->conn->lastInsertId();
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
                    Nama=:Nama, 
                    Sex=:Sex, 
                    Kontak=:Kontak, 
                    Alamat=:Alamat, 
                    Email=:Email, 
                    LevelAkses=:LevelAkses,
                    Status=:Status
               WHERE
                   IdKaryawan = :IdKaryawan";
    
       // prepare query statement
       $stmt = $this->conn->prepare($query);
    
       // sanitize
       $this->IdKaryawan=htmlspecialchars(strip_tags($this->IdKaryawan));
       $this->Nama=htmlspecialchars(strip_tags($this->Nama));
       $this->Alamat=htmlspecialchars(strip_tags($this->Alamat));
       $this->Kontak=htmlspecialchars(strip_tags($this->Kontak));
       $this->Sex=htmlspecialchars(strip_tags($this->Sex));
       $this->Email=htmlspecialchars(strip_tags($this->Email));
       $this->LevelAkses=htmlspecialchars(strip_tags($this->LevelAkses));
       $this->Status=htmlspecialchars(strip_tags($this->Status));
    
       // bind new values
       $stmt->bindParam(":IdKaryawan", $this->IdKaryawan);
       $stmt->bindParam(":Nama", $this->Nama);
       $stmt->bindParam(":Alamat", $this->Alamat);
       $stmt->bindParam(":Kontak", $this->Kontak);
       $stmt->bindParam(":Sex", $this->Sex);
       $stmt->bindParam(":Email", $this->Email);
       $stmt->bindParam(":LevelAkses", $this->LevelAkses);
       $stmt->bindParam(":Status", $this->Status);
    
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
       $query = "DELETE FROM " . $this->table_name . " WHERE IdKaryawan = ?";
    
       // prepare query
       $stmt = $this->conn->prepare($query);
    
       // sanitize
       $this->IdKaryawan=htmlspecialchars(strip_tags($this->IdKaryawan));
    
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