<?php
class Pembelian
{

   // database connection and table name
   private $conn;
   private $table_name = "pembelian";

   // object properties
   public $IdPembelian;
   public $IdBingkai;
   public $TanggalBeli;
   public $HargaBeli;
   public $Jumlah;

   // constructor with $db as database connection
   public function __construct($db)
   {
      $this->conn = $db;
   }

   // read products
   public function read()
   {

      // select all query
      $query = "SELECT * from " . $this->table_name . "";
      // prepare query statement
      $stmt = $this->conn->prepare($query);
      // execute query
      $stmt->execute();
      return $stmt;
   }

   public function readOne()
   {

      // select all query
      $query = "SELECT SUM(Jumlah) AS Total from " . $this->table_name . " where IdBingkai=?";

      // prepare query statement
      $stmt = $this->conn->prepare($query);

      $this->IdBingkai = htmlspecialchars(strip_tags($this->IdBingkai));

      $stmt->bindParam(1, $this->IdBingkai);
      // execute query
      $stmt->execute();
      $row = $stmt->fetch(PDO::FETCH_ASSOC);

      return $row['Total'];
   }

   public function GetUkuran()
   {
      $query = "SELECT DISTINCT Ukuran from " . $this->table_name . "";
      // prepare query statement
      $stmt = $this->conn->prepare($query);
      // execute query
      $stmt->execute();

      return $stmt;
   }

   public function GetWarna()
   {
      $query = "SELECT DISTINCT Warna from " . $this->table_name . "";
      // prepare query statement
      $stmt = $this->conn->prepare($query);
      // execute query
      $stmt->execute();

      return $stmt;
   }

   // create product
   public function create()
   {

      // query to insert record
      $query = "INSERT INTO
                   " . $this->table_name . "
               SET
                   IdBingkai=:IdBingkai, TanggalBeli=:TanggalBeli, HargaBeli=:HargaBeli, Jumlah=:Jumlah";

      // prepare query
      $stmt = $this->conn->prepare($query);

      // bind values
      $stmt->bindParam(":IdBingkai", $this->IdBingkai);
      $stmt->bindParam(":TanggalBeli", $this->TanggalBeli);
      $stmt->bindParam(":HargaBeli", $this->HargaBeli);
      $stmt->bindParam(":Jumlah", $this->Jumlah);

      // execute query
      if ($stmt->execute()) {
         $this->IdPembelian = $this->conn->lastInsertId();
         return true;
      } else {
         return false;
      }
   }

   // update the product
   public function update()
   {
      // update query
      $query = "UPDATE
                   " . $this->table_name . "
               SET
                    HargaBeli=:HargaBeli, Jumlah=:Jumlah
               WHERE
                   IdPembelian = :IdPembelian";

      // prepare query statement
      $stmt = $this->conn->prepare($query);
      // bind new values
      $stmt->bindParam(":HargaBeli", $this->HargaBeli);
      $stmt->bindParam(":Jumlah", $this->Jumlah);
      $stmt->bindParam(":IdPembelian", $this->IdPembelian);

      // execute the query
      if ($stmt->execute()) {
         return true;
      } else {
         return false;
      }
   }

   // delete the product
   public function delete()
   {

      // delete query
      $query = "DELETE FROM " . $this->table_name . " WHERE Nip = ?";

      // prepare query
      $stmt = $this->conn->prepare($query);

      // sanitize
      $this->Nip = htmlspecialchars(strip_tags($this->Nip));

      // bind id of record to delete
      $stmt->bindParam(1, $this->Nip);

      // execute query
      if ($stmt->execute()) {
         return true;
      } else {
         return false;
      }

   }
}
