<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object files
include_once '../../../api/config/database.php';
include_once '../../../api/objects/Bingkai.php';
include_once '../../../api/objects/Pembelian.php';
include_once '../../../api/objects/Transaksi.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$bingkai = new Bingkai($db);
$pembelian = new Pembelian($db);
$transaksi = new Transaksi($db);
$Data = array(
    'Ukuran' => array(), 
    'Warna' => array(),
    'Bingkai' => array()
);
 
// query products
$stmt = $bingkai->GetUkuran();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    $UkuranItem = array(
        'Ukuran' => $Ukuran, 
    );
    array_push($Data['Ukuran'], $UkuranItem);
}
$stmt=null;
$stmt = $bingkai->GetWarna();
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    extract($row);
    $WarnaItem = array(
        'Warna' => $Warna, 
    );
    array_push($Data['Warna'], $WarnaItem);
}
$stmt=null;
$stmt=$bingkai->read();
$num = $stmt->rowCount();
// check if more than 0 record found
if($num>0){
    // products array
    $DatasPembelian=array(
        "Pembelian" => array()
    );
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        
        $pembelian->IdBingkai=$IdBingkai;
        $transaksi->IdBingkai=$IdBingkai;
        $TotalPembelian = $pembelian->readOne();
        $TotalPenjualan = $transaksi->readOne();
        $Stock = $TotalPembelian-$TotalPenjualan;

        $BingkaiItem=array(
            "IdBingkai" => $IdBingkai,
            "Kode" => $Kode,
            "Ukuran" => $Ukuran,
            "Warna" => $Warna,
            "Stock" => $Stock
        );
        array_push($Data["Bingkai"], $BingkaiItem);
    }
    http_response_code(200);
    echo json_encode($Data);
}
 
else{
    http_response_code(501);
    echo json_encode(
        array("message" => "No Pembelian found.")
    );
}
?>