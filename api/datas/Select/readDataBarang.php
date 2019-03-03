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
include_once '../../../api/objects/DetailPenjualan.php';
include_once '../../../api/objects/Supplier.php';
include_once '../../../api/objects/Pembelian.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$barang = new Barang($db);

$return = new Returnn($db);

$detailbeli = new DetailBeli($db);

$detailpenjualan = new DetailPenjualan($db);

$supplier =new Supplier($db);

$pembelian = new Pembelian($db);
 
// query products

$data =json_decode(file_get_contents("php://input"));

$pembelian->SuplierId=$data->IdSupplier;
$stmtpembelian= $pembelian->readBySupplier();
$numpembelian=$stmtpembelian->rowCount();

$ItemData=array();
$ItemData['Barang']=array();
if($numpembelian>0)
{
    while ($rowpembelian = $stmtpembelian->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($rowpembelian);
        $detailbeli->PembelianId=$IdPembelian;
        $stmtDetailBeli = $detailbeli->readByPembelian();
        $numDetailBeli = $stmtDetailBeli->rowCount();
        if($numDetailBeli>0)
        {
            while ($rowDetailBeli = $stmtDetailBeli->fetch(PDO::FETCH_ASSOC)){
                // extract row
                // this will make $row['name'] to
                // just $name only
                extract($rowDetailBeli);
                $barang->IdBarang=$BarangId;
                $barang->readOne();
                $detailpenjualan->DetailId=$IdDetail;
                $detailpenjualan->readTotalPenjualan();
                $return->DetailId=$IdDetail;
                $return->readTotalPenjualan();
                $supplier->IdSupplier=$SuplierId;
                $supplier->readOne();
                if($Jumlah-$return->Jumlah-$detailbeli->Jumlah>0)
                $DataItemBarang=array(
                    "IdDetail"=>$IdDetail,
                    "NamaBarang"=>$barang->NamaBarang,
                    "KodeBarang"=>$KodeBarang,
                    "TglBeli"=>$TglBeli
                );
                array_push($ItemData["Barang"], $DataItemBarang);
            }
        }

    }
    echo json_encode($ItemData);
}else
{
    echo '{';
        echo '"message": "'.$pembelian->SuplierId.'"';
    echo '}';
}

?>