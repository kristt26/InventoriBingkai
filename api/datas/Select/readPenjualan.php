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
include_once '../../../api/objects/Discount.php';
include_once '../../../api/objects/DetailBeli.php';
include_once '../../../api/objects/Returnn.php';
include_once '../../../api/objects/DetailPenjualan.php';
include_once '../../../api/objects/Penjualan.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$barang = new Barang($db);

$price = new Price($db);

$discount = new Discount($db);

$detail = new DetailBeli($db);

$returnn = new Returnn($db);

$detailPenjualan = new DetailPenjualan($db);

$penjualan = new Penjualan($db);
 
// query products

$penjualan->read();
$stmtpenjualan = $penjualan->read();   
$numpenjualan = $stmtpenjualan->rowCount();
 
// check if more than 0 record found
if($numpenjualan>0){
 
    // products array
   $dataread = array(
    "message"=>"Penjualan is Found",
    "records"=>array()
   );
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($rowPenjualan = $stmtpenjualan->fetch(PDO::FETCH_ASSOC)){

        extract($rowPenjualan);
        $products_arr=array(
            "IdPenjualan"=>$IdPenjualan,
            "Nota"=>$Nota,
            "Tgl"=>$Tgl,
            "TotalBayar"=>$TotalBayar,
            "KaryawanId"=>$KaryawanId,
            "ItemBarang"=>array()
        );
        // extract row
        // this will make $row['name'] to
        // just $name only
        
        $detailPenjualan->PenjualanId=$IdPenjualan;
        $stmtDetailPenjualan=$detailPenjualan->readByPenjualanId();
        $numDetailPenjualan = $stmtDetailPenjualan->rowCount();
        if($numDetailPenjualan>0)
        {
            while ($rowDet = $stmtDetailPenjualan->fetch(PDO::FETCH_ASSOC)){
                // extract row
                // this will make $row['name'] to
                // just $name only
                extract($rowDet);
                $detail->IdDetail=$DetailId;
                $detail->readOne();
                $barang->IdBarang=$detail->BarangId;
                $barang->readOne();
                $price->BarangId=$barang->IdBarang;
                $c= $price->readByTgl($Tgl);
                $discount->BarangId=$barang->IdBarang;
                $b= $discount->readByTgl($Tgl);
                $numDisc = $c->rowCount();
                if($numDisc!=0)
                {
                    $rowdisc = $c->fetch(PDO::FETCH_ASSOC);
                    $discount->Discount= $rowdisc['Discount'];
                }else
                    $discount->Discount= 0;
                $b = $price->readByBarang();

                $numprice= $b->rowCount();
                if($numprice!=0)
                {
                    $rowprice = $b->fetch(PDO::FETCH_ASSOC);
                    $price->Price=$rowprice['Price'];
                }else
                {
                    $price->Price=0;
                }

                $product_item=array(
                    "BarangId" => $barang->IdBarang,
                    "KodeBarang"=>$KodeBarang,
                    "DetailId"=>$detail->IdDetail,
                    "NamaBarang" => $barang->NamaBarang,
                    "Keterangan" => $barang->Keterangan,
                    "Jumlah"=>$Jumlah,
                    "Discount"=>$discount->Discount,
                    "Price"=>$price->Price,                
                );
            }
            array_push($products_arr["ItemBarang"], $product_item);
        }
        array_push($dataread['records'],$products_arr);
        
    }
 
    echo json_encode($dataread);
}
 
else{
    echo json_encode(
        array("message" => "No Penjualan found")
    );
}
?>