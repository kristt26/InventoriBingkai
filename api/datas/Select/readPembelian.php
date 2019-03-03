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
include_once '../../../api/objects/Pembelian.php';
include_once '../../../api/objects/DetailBeli.php';
include_once '../../../api/objects/Supplier.php';

 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$barang = new Barang($db);

$pembelian = new Pembelian($db);

$detail = new DetailBeli($db);

$supplier = new Supplier($db);

$stmtpembelian = $pembelian->read();
$numpembelian = $stmtpembelian->rowCount();
if($numpembelian>0)
{
    $pembelian_arr=array();
    $pembelian_arr["records"]=array();
    while ($rowPenjualan = $stmtpembelian->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($rowPenjualan);

        $supplier->IdSupplier=$SuplierId;
        $supplier->readOne();
 
        $Pembelian_item=array(
            "IdPembelian" => $IdPembelian,
            "TglBeli" => $TglBeli,
            "TotalBayar" => $TotalBayar,
            "SupplierId" => $SuplierId,
            "NamaSupplier"=>$supplier->NamaSupplier,
            "ItemBarang"=>array()
        );

        $detail->PembelianId=$IdPembelian;
        $stmtDetail= $detail->readByPembelian();
        while ($rowDetail = $stmtDetail->fetch(PDO::FETCH_ASSOC)){
            extract($rowDetail);

            $barang->IdBarang=$BarangId;
            $barang->readOne();

            $barang_item=array(
                "IdDetail" => $IdDetail,
                "HargaBeli" => $HargaBeli,
                "Jumlah"=>$Jumlah,
                "PembelianId"=>$pembelian->IdPembelian,
                "BarangId"=>$BarangId,
                "NamaBarang"=>$barang->NamaBarang,
                "KodeBarang"=>$KodeBarang
            );
            array_push($Pembelian_item["ItemBarang"], $barang_item);

        }
        array_push($pembelian_arr["records"],$Pembelian_item) ;
    }
    
    echo json_encode($pembelian_arr);
}else
{
    echo json_encode(
        array("message" => "No bidang found.")
    );
} 
?>