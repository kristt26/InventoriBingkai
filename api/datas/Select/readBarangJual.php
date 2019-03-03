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
session_start();
$a = date("Ymd");
$TdlBaru= str_replace("-","",$a);
$penjualan->readByNota();
            $len=strlen($penjualan->Nota);
            $nPotong = $len-8;            
            $nhPotong = substr($penjualan->Nota,$nPotong)+1;
            $NotaBaru = $a.$nhPotong;
$stmtdetail = $detail->read();   
$num = $stmtdetail->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // products array
    $products_arr=array(
        "message"=>"Barang is Found",
        "KaryawanId"=>$_SESSION['IdKaryawan'],
        "Nota"=>$NotaBaru,
        "records"=>array()
    );
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmtdetail->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
        $jumtemporary = $Jumlah;
        $returnn->DetailId=$IdDetail;
        $returnn->readTotalPenjualan();
        $detailPenjualan->DetailId=$IdDetail;
        $detailPenjualan->readTotalPenjualan();
        $jum = $jumtemporary-$detailPenjualan->TotalJumlah-$returnn->TotalRetun;
        if($jum>0)
        {
            $barang->IdBarang=$BarangId;
            $barang->readOne();
            $discount->BarangId=$barang->IdBarang;
            $c=$discount->readByBarang($a);
            $numDisc = $c->rowCount();
            if($numDisc!=0)
            {
                $rowdisc = $c->fetch(PDO::FETCH_ASSOC);
                $discount->Discount= $rowdisc['Discount'];
            }else
                $discount->Discount= 0;
            $price->BarangId=$barang->IdBarang;
            $price->Status="true";
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
                "BarangId" => $BarangId,
                "KodeBarang"=>$KodeBarang,
                "DetailId"=>$IdDetail,
                "NamaBarang" => $barang->NamaBarang,
                "Stock" => $jum,
                "Keterangan" => $barang->Keterangan,
                "Discount"=>$discount->Discount,
                "Price"=>$price->Price,                
            );
            array_push($products_arr["records"], $product_item);
        }
        
    }
 
    echo json_encode($products_arr);
}
 
else{
    echo json_encode(
        array("message" => "No bidang found.")
    );
}
?>