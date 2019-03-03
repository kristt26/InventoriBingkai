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

$data = json_decode(file_get_contents("php://input"));


// set product property values

$karyawan->Email = $data->Email;
$karyawan->Password = md5($data->Password);



// query products
$stmt = $karyawan->userLogin();
$num = $stmt->rowCount();
 
// check if more than 0 record found
try {
    if ($num > 0) {
        session_start();
    // products array
        $products_arr = array();
        $products_arr["records"] = array();
 
    // retrieve our table contents
    // fetch() is faster than fetchAll()
    // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        // extract row
        // this will make $row['name'] to
        // just $name only
            extract($row);
            $_SESSION['IdKaryawan'] = $IdKaryawan;
            $_SESSION['Nama'] = $Nama;
            $_SESSION['Sex'] = $Sex;
            $_SESSION['Kontak'] = $Kontak;
            $_SESSION['Alamat'] = $Alamat;
            $_SESSION['Email'] = $Email;


            $product_item = array(
                "Session" => $_SESSION,
                "Level" =>$LevelAkses,
                "Message" => true
            );

            array_push($products_arr["records"], $product_item);
        }

        echo json_encode($products_arr);
    } else {
        throw new Exception('You Not Have Access');
    }
} catch (Exception $ex) {
    header("HTTP/1.1 500 Internal Server Error");
    echo '{"message": "Exception occurred: '.$ex->getMessage().'"}';
}


?>