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
include_once '../../../api/objects/Supplier.php';
 
$database = new Database();
$db = $database->getConnection();
 
$supplier = new Supplier($db);
 
// get posted data
$data =json_decode(file_get_contents("php://input"));
 

// set product property values
$supplier->NamaSupplier = $data->NamaSupplier;
$supplier->Telp = $data->Telp;
$supplier->Alamat = $data->Alamat;
 
// create the product
if($supplier->create()){
    echo '{';
        echo '"message": "'.$supplier->IdSupplier.'"';
    echo '}';
}
 
// if unable to create the product, tell the user
else{
    echo '{';
        echo '"message": "Unable to create Supplier"';
    echo '}';
}


?>