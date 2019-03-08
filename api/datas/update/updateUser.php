<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object files
include_once '../../../api/config/database.php';
include_once '../../../api/objects/User.php';
 
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare product object
$user = new User($db);
 
// get id of product to be edited
$data = json_decode(file_get_contents("php://input"));
 
// set ID property of product to be edited
$user->IdUser = $data->IdUser;
$user->Nama = $data->Nama;
$user->Username = $data->Username;
$user->Level = $data->Level;
 
// update the product
if($user->update()){
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