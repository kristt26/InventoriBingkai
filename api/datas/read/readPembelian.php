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
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$bingkai = new Bingkai($db);
$pembelian = new Pembelian($db);
 
// query products
$stmtPembelian = $pembelian->read();
$num = $stmtPembelian->rowCount();
// check if more than 0 record found
if($num>0){
    // products array
    $DatasPembelian=array(
        "Pembelian" => array()
    );
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmtPembelian->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
 
        $PembelianItem=array(
            "IdPembelian" => $IdPembelian,
            "Bingkai" => array(),
            "TanggalBeli" => $TanggalBeli,
            "HargaBeli" => $HargaBeli,
            "Jumlah" => $Jumlah
        );
        $bingkai->IdBingkai=$IdBingkai;
        $stmtBingkai = $bingkai->readOne();
        $BingkaiItem = array(
            'IdBingkai' => $bingkai->IdBingkai,
            'Kode'=> $bingkai->Kode,
            'Ukuran' => $bingkai->Ukuran,
            'Warna' => $bingkai->Warna
        );
        array_push($PembelianItem['Bingkai'], $BingkaiItem);
 
        array_push($DatasPembelian["Pembelian"], $PembelianItem);
    }
    http_response_code(200);
    echo json_encode($DatasPembelian);
}
 
else{
    http_response_code(501);
    echo json_encode(
        array("message" => "No Pembelian found.")
    );
}
?>