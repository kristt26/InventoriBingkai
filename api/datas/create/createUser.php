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
include_once '../../../api/objects/User.php';
 
$database = new Database();
$db = $database->getConnection();
 
$user = new User($db);
 
// get posted data
$data =json_decode(file_get_contents("php://input"));
 

// set product property values
$user->Nama = $data->Nama;
$user->Username = $data->Username;
$user->Level = $data->Level;
$user->Password = md5($data->Password);
 
// create the product
if($user->create()){
    http_response_code(200);
    echo json_encode(array("message" => $user->IdUser));
}
 
// if unable to create the product, tell the user
else{
    http_response_code(501);
    echo '{';
        echo '"message": "Unable to create user."';
    echo '}';
}


?>