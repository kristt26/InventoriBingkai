<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 
// get database connection
include_once '../../../api/config/database.php';
 
// instantiate product object
include_once '../../../api/objects/Karyawan.php';
 
$database = new Database();
$db = $database->getConnection();
 
$karyawan = new Karyawan($db);
 
// get posted data
$data =json_decode(file_get_contents("php://input"));
 

// set product property values
$karyawan->Nama = $data->Nama;
$karyawan->Sex = $data->Sex;
$karyawan->Kontak = $data->Kontak;
$karyawan->Alamat = $data->Alamat;
$karyawan->Email = $data->Email;
$karyawan->Password = md5("12345678");
$karyawan->LevelAkses = $data->LevelAkses;
$karyawan->Status = "true";


 
// create the product
if($karyawan->create()){
    echo '{';
        echo '"message": "'.$karyawan->IdKaryawan.'"';
    echo '}';
}
 
// if unable to create the product, tell the user
else{
    echo '{';
        echo '"message": "Unable to create Karyawan"';
    echo '}';
}


?>