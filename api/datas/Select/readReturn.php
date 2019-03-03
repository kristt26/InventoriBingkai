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
include_once '../../../api/objects/Returnn.php';
include_once '../../../api/objects/DetailBeli.php';
include_once '../../../api/objects/Supplier.php';
include_once '../../../api/objects/Pembelian.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$barang = new Barang($db);
$return =  new Returnn($db);
$detail = new DetailBeli($db);
$supplier = new Supplier($db);
$pembelian = new Pembelian($db);
 
// query products
$stmtreturn = $return->read();   
$num = $stmtreturn->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // products array
    $products_arr=array();
    $products_arr["records"]=array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($rowRetun = $stmtreturn->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($rowRetun);
        $supplier->IdSupplier=$IdSupplier;
        $supplier->readOne();
        $detail->IdDetail=$DetailId;
        $detail->readOne();
        $barang->IdBarang=$detail->BarangId;
        $barang->readOne();
        $pembelian->IdPembelian=$detail->PembelianId;
        $pembelian->readOne();
         
        $product_item=array(
            "IdReturn" => $IdReturn,
            "IdSupplier" => $IdSupplier,
            "TglReturn" => $TglReturn,
            "Jumlah" => $Jumlah,
            "DetailId"=> $DetailId,
            "NamaSupplier"=>$supplier->NamaSupplier,
            "NamaBarang"=>$barang->NamaBarang,
            "TglBeli"=>$pembelian->TglBeli
        );
 
        array_push($products_arr["records"], $product_item);
    }
 
    echo json_encode($products_arr);
}
 
else{
    echo json_encode(
        array("message" => "No bidang found.")
    );
}
?>