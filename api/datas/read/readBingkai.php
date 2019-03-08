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
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$bingkai = new Bingkai($db);
 
// query products
$stmt = $bingkai->read();   
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
    // products array
    $DatasBingkai=array(
        "Bingkai" => array()
    );
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $BingkaiItem=array(
            "IdBingkai" => $IdBingkai,
            "Kode" => $Kode,
            "Ukuran" => $Ukuran,
            "Warna" => $Warna
        );
 
        array_push($DatasBingkai["Bingkai"], $BingkaiItem);
    }
    http_response_code(200);
    echo json_encode($DatasBingkai);
}
 
else{
    http_response_code(501);
    echo json_encode(
        array("message" => "No User found.")
    );
}
?>