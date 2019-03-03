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
include_once '../../../api/objects/Discount.php';
 
$database = new Database();
$db = $database->getConnection();
 
$discount = new Discount($db);

 
// get posted data
$data =json_decode(file_get_contents("php://input"));
 

// set product property values
$discount->Discount = $data->Discount;
$discount->MasaBerlaku = $data->MasaBerlaku;
$discount->BarangId = $data->BarangId;
$discount->Keterangan=$data->Keterangan;

if($discount->create()){
    echo '{';
        echo '"message": "'.$discount->IdDiscount.'"';
    echo '}';
}else{
    echo '{';
        echo '"message": "Unable to Create Discount"';
    echo '}';
}


?>