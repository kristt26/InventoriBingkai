<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object files
include_once '../../api/config/database.php';
include_once '../../api/objects/Karyawan.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$karyawan = new Karyawan($db);
 
// query products
//$stmt = $bidang->read();   
//$num = $stmt->rowCount();
 
// check if more than 0 record found
echo json_encode(array("Session" => $karyawan->CheckSession()));
?>