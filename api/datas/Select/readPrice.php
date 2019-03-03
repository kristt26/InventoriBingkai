<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object files
include_once '../../../api/config/database.php';
include_once '../../../api/objects/Barang.php';
include_once '../../../api/objects/Price.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$barang = new Barang($db);

$price = new Price($db);
 
// query products
$price->Status="true";
$stmtprice = $price->readByStatus();   
$num = $stmtprice->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // products array
    $price_arr=array(
        "message"=>"Price Was Create",
        "records"=>array()
    );
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmtprice->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
        $barang->IdBarang=$BarangId;
        $barang->readOne(); 
        $price_item=array(
            "IdPrice"=>$IdPrice,
            "BarangId" => $BarangId,
            "NamaBarang" => $barang->NamaBarang,
            "Price"=>$Price,
            "CreateDate" => $CreateDate,
            "Status" => $Status
        );
 
        array_push($price_arr["records"], $price_item);
    }
 
    echo json_encode($price_arr);
}
 
else{
    echo json_encode(
        array("message" => "No price found.")
    );
}
?>