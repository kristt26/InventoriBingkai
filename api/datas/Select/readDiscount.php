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
include_once '../../../api/objects/Discount.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$barang = new Barang($db);

$discount = new Discount($db);
 
// query products
$stmtdiscount = $discount->read();   
$num = $stmtdiscount->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // products array
    $discount_arr=array(
        "message"=>"Discount is Found",
        "records"=>array()
    );
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmtdiscount->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
        $barang->IdBarang=$BarangId;
        $barang->readOne(); 
        $discount_item=array(
            "IdDiscount"=>$IdDiscount,
            "BarangId" => $BarangId,
            "NamaBarang" => $barang->NamaBarang,
            "MasaBerlaku"=> $MasaBerlaku,
            "Discount"=>$Discount,
            "Keterangan" => $Keterangan
        );
 
        array_push($discount_arr["records"], $discount_item);
    }
 
    echo json_encode($discount_arr);
}
 
else{
    echo json_encode(
        array("message" => "No Discount found.")
    );
}
?>