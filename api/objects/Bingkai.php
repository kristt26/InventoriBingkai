<?php
class Bingkai
{

 // database connection and table name
 private $conn;
 private $table_name = "bingkai";

 // object properties
 public $IdBingkai;
 public $Kode;
 public $Ukuran;
 public $Warna;

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
  $query = "SELECT * from " . $this->table_name . " where IdBingkai=?";

  // prepare query statement
  $stmt = $this->conn->prepare($query);

  $this->IdBingkai = htmlspecialchars(strip_tags($this->IdBingkai));

  $stmt->bindParam(1, $this->IdBingkai);

  // execute query
  $stmt->execute();
  $row             = $stmt->fetch(PDO::FETCH_ASSOC);
  $this->IdBingkai = $row['IdBingkai'];
  $this->Kode      = $row['Kode'];
  $this->Ukuran    = $row['Ukuran'];
  $this->Warna     = $row['Warna'];

  return $stmt;
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
                   Kode=:Kode, Ukuran=:Ukuran, Warna=:Warna";

  // prepare query
  $stmt = $this->conn->prepare($query);

  // bind values
  $stmt->bindParam(":Kode", $this->Kode);
  $stmt->bindParam(":Ukuran", $this->Ukuran);
  $stmt->bindParam(":Warna", $this->Warna);

  // execute query
  if ($stmt->execute()) {
   $this->IdBingkai = $this->conn->lastInsertId();
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
                Ukuran=:Ukuran, Warna=:Warna
               WHERE
                   IdBingkai = :IdBingkai";

  // prepare query statement
  $stmt = $this->conn->prepare($query);
  // bind new values
  $stmt->bindParam(":Ukuran", $this->Ukuran);
  $stmt->bindParam(":Warna", $this->Warna);
  $stmt->bindParam(":IdBingkai", $this->IdBingkai);

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
