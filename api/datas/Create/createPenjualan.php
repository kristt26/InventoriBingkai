<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
 
// include database and object files
include_once '../../../api/config/database.php';
include_once '../../../api/objects/Penjualan.php';
include_once '../../../api/objects/DetailPenjualan.php';
include_once '../../../api/objects/Barang.php';

 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$penjualan = new Penjualan($db);

$barang = new Barang($db);

$detailpenjualan = new DetailPenjualan($db);
 

$data =json_decode(file_get_contents("php://input"));


$penjualan->Nota = $data->Nota;
$penjualan->TotalBayar = $data->TotalBayar;
$penjualan->KaryawanId = $data->KaryawanId;
$penjualan->Tgl=date("Y-m-d");
$penjualan->ItemBarang=$data->ItemBarang;


// query products

try{
    $database->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $database->conn->beginTransaction();
    $stmtpenjualan = $penjualan->create();    
    $detailpenjualan->PenjualanId=$penjualan->IdPenjualan;
    $itemPenjualan=array(
        "IdPenjualan"=>$penjualan->IdPenjualan,
        "Nota"=>$penjualan->Nota,
        "Tgl"=>$penjualan->Nota,
        "TotalBayar"=>$penjualan->TotalBayar,
        "KaryawanId"=>$penjualan->KaryawanId,
        "ItemBarang"=>array()
    );
    foreach($penjualan->ItemBarang as &$value)
    {
        $detailpenjualan->KodeBarang=$value->KodeBarang;
        $detailpenjualan->Jumlah=$value->Jumlah;
        $detailpenjualan->PenjualanId=$penjualan->IdPenjualan;
        $detailpenjualan->DetailId=$value->DetailId;
        $stmtDetail = $detailpenjualan->create();
        $barang->IdBarang=$value->BarangId;
        $barang->readOne();
        $StockTemporary=$barang->Stock - $value->Jumlah;
        $barang->updateStock($StockTemporary);
        $itemDetail = array(
            "BarangId" => $barang->IdBarang,
            "KodeBarang"=>$detailpenjualan->KodeBarang,
            "DetailId"=>$detailpenjualan->DetailId,
            "NamaBarang" => $barang->NamaBarang,
            "Stock" => $barang->NamaBarang,
            "Keterangan" => $barang->Keterangan,
            "Discount"=>$value->Discount,
            "Price"=>$value->Price,
        );
        
        array_push($itemPenjualan['ItemBarang'],$itemDetail);

    }
    $database->conn->commit();
    
    
    echo json_encode($itemPenjualan);
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