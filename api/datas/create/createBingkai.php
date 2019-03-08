<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
include_once '../../../api/config/database.php';
 
// instantiate product object
include_once '../../../api/objects/Bingkai.php';
 
$database = new Database();
$db = $database->getConnection();
 
$bingkai = new Bingkai($db);
 
// get posted data
$data =json_decode(file_get_contents("php://input"));
 

// set product property values
$bingkai->Kode = $data->Kode;
$bingkai->Ukuran = $data->Ukuran;
$bingkai->Warna = $data->Warna;
 
// create the product
if($bingkai->create()){
    http_response_code(200);
    echo json_encode(array("message" => $bingkai->IdBingkai));
}
 
// if unable to create the product, tell the user
else{
    http_response_code(501);
    echo '{';
        echo '"message": "Unable to create bingkai."';
    echo '}';
}


?>