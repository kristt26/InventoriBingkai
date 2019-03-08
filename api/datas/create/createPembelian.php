<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
include_once '../../../api/config/database.php';
 
// instantiate product object
include_once '../../../api/objects/Pembelian.php';
 
$database = new Database();
$db = $database->getConnection();
 
$pembelian = new Pembelian($db);
 
// get posted data
$data =json_decode(file_get_contents("php://input"));
 

// set product property values
$a = new DateTime($data->TanggalBeli);
$aa=str_replace('-', '/', $a->format('Y-m-d'));
$aaa = date('Y-m-d',strtotime($aa . "+1 days"));

$pembelian->IdBingkai = $data->IdBingkai;
$pembelian->TanggalBeli = $aaa;
$pembelian->HargaBeli = $data->HargaBeli;
$pembelian->Jumlah = $data->Jumlah;
 
// create the product
if($pembelian->create()){
    http_response_code(200);
    echo json_encode(array("message" => $pembelian));
}
 
// if unable to create the product, tell the user
else{
    http_response_code(501);
    echo '{';
        echo '"message": "Unable to create bingkai."';
    echo '}';
}


?>