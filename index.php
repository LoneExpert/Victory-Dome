<?php
error_reporting(E_ALL);
ini_set('display_error',1);
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

include 'DbConnect.php';
$objDb = new DbConnect;
$conn = $objDb->connect();


$method = $_SERVER['REQUEST_METHOD'];
switch($method){
    case "POST":
        $user = json_decode( file_get_contents('php://input') );
        $sql = "INSERT INTO users(id,name,email,query,date) VALUES(null,:name,:email,:query,:date)";
        $stmt = $conn->prepare($sql);
        $date = date('Y-m-d');
        $stmt->bindParam(':name',$user->name);
        $stmt->bindParam(':email',$user->email);
        $stmt->bindParam(':query',$user->query);
        $stmt->bindParam(':date',$user->date);  

        if($stmt->execute()){
            $response = ['status' => 1, 'message' => 'Record Succesfully data.'];
            
        }
        else{
            $response  = ['status' => 0, 'message' => 'Data failed.'];
        }
        return json_encode($response);
        
        break;

}


?>