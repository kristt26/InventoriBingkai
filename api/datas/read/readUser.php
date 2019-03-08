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
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$user = new User($db);
 
// query products
$stmt = $user->read();   
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
    // products array
    $DatasUser=array(
        "User" => array()
    );
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $UserItem=array(
            "IdUser" => $IdUser,
            "Username" => $Username,
            "Nama" => $Nama,
            "Level" => $Level
        );
 
        array_push($DatasUser["User"], $UserItem);
    }
    http_response_code(200);
    echo json_encode($DatasUser);
}
 
else{
    http_response_code(501);
    echo json_encode(
        array("message" => "No User found.")
    );
}
?>