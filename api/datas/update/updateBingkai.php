<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object files
include_once '../../../api/config/database.php';
include_once '../../../api/objects/Bingkai.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$bingkai = new Bingkai($db);
 
// get id of product to be edited
$data = json_decode(file_get_contents("php://input"));
 
// set ID property of product to be edited
$bingkai->IdBingkai = $data->IdBingkai;
$bingkai->Kode = $data->Kode;
$bingkai->Ukuran = $data->Ukuran;
$bingkai->Warna = $data->Warna;
 
// update the product
if($bingkai->update()){
    http_response_code(200);
    echo '{';
        echo '"message": "User was Update"';
    echo '}';
}
 
// if unable to update the product, tell the user
else{
    http_response_code(501);
    echo '{';
        echo '"message": "Unable to update User"';
    echo '}';
}
?>