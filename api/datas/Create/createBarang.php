<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../../../api/config/database.php';
 
// instantiate product object
include_once '../../../api/objects/Barang.php';
 
$database = new Database();
$db = $database->getConnection();
 
$barang = new Barang($db);
 
// get posted data
$data =json_decode(file_get_contents("php://input"));
 

// set product property values
$barang->NamaBarang = $data->NamaBarang;
$barang->Keterangan = $data->Keterangan;
$barang->KategoriId = $data->KategoriId;
$barang->Stock=0;
 
// create the product
if($barang->create()){
    echo '{';
        echo '"message": "'.$barang->IdBarang.'"';
    echo '}';
}
 
// if unable to create the product, tell the user
else{
    echo '{';
        echo '"message": "Unable to create product."';
    echo '}';
}


?>