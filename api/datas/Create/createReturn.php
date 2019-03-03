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
include_once '../../../api/objects/Returnn.php';

include_once '../../../api/objects/Barang.php';

include_once '../../../api/objects/DetailBeli.php';
 
$database = new Database();
$db = $database->getConnection();
 
$return = new Returnn($db);

$barang = new Barang($db);
$detail = new DetailBeli($db);
 
// get posted data
$data =json_decode(file_get_contents("php://input"));

try{
    $database->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $database->conn->beginTransaction();
    $a = new DateTime($data->TglReturn);
    $aa=str_replace('-', '/', $a->format('Y-m-d'));
    $aaa = date('Y-m-d',strtotime($aa . "+1 days"));

    // set product property values
    $return->TglReturn=$aaa;
    $return->IdSupplier = $data->IdSupplier;
    $return->Jumlah = $data->Jumlah;
    $return->DetailId = $data->DetailId;
    $return->create();
    $detail->IdDetail=$return->DetailId;
    $detail->readOne();
    $barang->IdBarang=$detail->BarangId;
    $barang->readOne();
    $StockTemporary=$barang->Stock - $return->Jumlah;
    $barang->updateStock($StockTemporary);
    
    $database->conn->commit();
    echo '{';
        echo '"message": "'.$return->IdReturn.'"';
    echo '}';
    
    
    /*
    echo '{';
        echo '"message": "Sukses"';
    echo '}';
    */

}catch(Exception $e)
{
    $database->conn->rollBack();
    echo "Failed: " . $e->getMessage();
}
?>