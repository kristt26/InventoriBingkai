<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../../../api/config/database.php';
include_once '../../../api/objects/Pembelian.php';
include_once '../../../api/objects/DetailBeli.php';
include_once '../../../api/objects/Barang.php';

 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$pembelian = new Pembelian($db);

$detailbeli = new DetailBeli($db);
$barang = new Barang($db);
 

$data =json_decode(file_get_contents("php://input"));

$pembelian->SuplierId = $data->SupplierId;
$pembelian->TotalBayar = $data->TotalBayar;
$pembelian->ItemBarang = $data->ItemBarang;
$a = new DateTime($data->TglBeli);
$aa=str_replace('-', '/', $a->format('Y-m-d'));
$aaa = date('Y-m-d',strtotime($aa . "+1 days"));
$pembelian->TglBeli=$aaa;


// query products

try{
    $database->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $database->conn->beginTransaction();
    $stmtpembelian = $pembelian->create();    
    $detailbeli->PembelianId=$pembelian->IdPembelian;
    $itemPembelian=array(
        "IdPembelian"=>$pembelian->IdPembelian,
        "TglBeli"=>$pembelian->TglBeli,
        "TotalBayar"=>$pembelian->TotalBayar,
        "SupplierId"=>$pembelian->SuplierId,
        "NamaSupplier"=>$data->NamaSupplier,
        "ItemBarang"=>array()
    );
    foreach($pembelian->ItemBarang as &$Value)
    {
        $detailbeli->HargaBeli=$Value->HargaBeli;
        $detailbeli->Jumlah=$Value->Jumlah;
        $detailbeli->BarangId=$Value->BarangId;

        $a=str_replace("-","",$pembelian->TglBeli);
        $detailbeli->KodeBarang=$a.$pembelian->SuplierId.$Value->BarangId;
        $stmtDetail = $detailbeli->create();
        $barang->IdBarang=$Value->BarangId;
        $barang->readOne();
        $StockTemporary=$barang->Stock + $Value->Jumlah;
        $barang->updateStock($StockTemporary);
        $itemDetail = array(
            "IdDetail"=>$detailbeli->IdDetail,
            "HargaBeli"=>$detailbeli->HargaBeli,
            "Jumlah"=>$detailbeli->Jumlah,
            "PembelianId"=>$detailbeli->PembelianId,
            "BarangId"=>$detailbeli->BarangId,
            "NamaBarang"=>$barang->NamaBarang,
            "KodeBarang"=>$detailbeli->KodeBarang
        );
        
        array_push($itemPembelian['ItemBarang'],$itemDetail);

    }
    $database->conn->commit();
    
    
    echo json_encode($itemPembelian);
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
// check if more than 0 record found

?>