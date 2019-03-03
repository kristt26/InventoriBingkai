<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// include database and object files
include_once '../../../api/config/database.php';
include_once '../../../api/objects/Karyawan.php';
 
// instantiate database and product object
$database = new Database();
$db = $database->getConnection();
 
// initialize object
$karyawan = new Karyawan($db);
 
// query products
$stmt = $karyawan->read();   
$num = $stmt->rowCount();
 
// check if more than 0 record found
if($num>0){
 
    // products array
    $karyawan_arr=array(
        "message"=>"Karyawan Found",
        "records"=>array()
    );
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
        // extract row
        // this will make $row['name'] to
        // just $name only
        extract($row);
        if($Status=="true")
            $KetStatus="Aktif";
        else
            $KetStatus="Tidak Aktif";
 
        $karyawan_item=array(
            "IdKaryawan" => $IdKaryawan,
            "Nama" => $Nama,
            "Sex"=>$Sex,
            "Kontak"=>$Kontak,
            "Alamat"=>$Alamat,
            "Email"=>$Email,
            "Password"=>$Password,
            "LevelAkses"=>$LevelAkses,
            "Status"=>$Status,
            "KetStatus"=>$KetStatus
        );
 
        array_push($karyawan_arr["records"], $karyawan_item);
    }
 
    echo json_encode($karyawan_arr);
}
 
else{
    echo json_encode(
        array("message" => "No bidang found.")
    );
}
?>