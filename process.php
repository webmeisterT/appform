<?php
$conn = new mysqli("localhost","missions_vueCrud","missions_vueCrud","missions_vueCrud");
// $conn = new mysqli("localhost","missions_vueCrud","missions_vueCrud","missions_vueCrud");
// require "connect.php";

if($conn->connect_error){
    die("Connection Failed!".$conn->connect_error);
}

$result = array('error'=>false);
// $action = '';
$action = $_SERVER['REQUEST_METHOD'];
// echo $action;
// if (isset($_GET['action'])) {
//     $action = $_GET['action'];
// }

if ($action == 'GET') {
    $sql= $conn->query("SELECT * FROM user");
    $users = array();
    while ($row = $sql->fetch_assoc()) {
        array_push($users, $row);
    }
    $result['users'] = $users;
}

if ($action == 'POST') {
    $data = json_decode(file_get_contents("php://input"), true); // Get data as assoc array
    $name=$data['name'];
    //  $data->name; - if $data is not true
    $email=$data['email'];
    $phone=$data['phone'];
    $sql = $conn->query("INSERT INTO user (name,email,phone) VALUES('$name','$email','$phone')");
    if ($sql) {
        
        $result['message'] = "User Added success";
    }else {
        $result['error'] = true;
        $result['message'] = "User Added fail";
    }
}

if ($action == 'PUT' || $action == 'PATCH') {
    $data = json_decode(file_get_contents("php://input"), true); // Get data as assoc array
    $id=$data['id'];
    $name=$data['name'];
    $email=$data['email'];
    $phone=$data['phone'];
    $sql = $conn->query("UPDATE user SET name='$name',email='$email',phone='$phone' where id='$id'");
    if ($sql) {
        
        $result['message'] = "Update success";
    }else {
        $result['error'] = true;
        $result['message'] = "User update fail";
    }
}

if ($action == 'DELETE') {
    // $data = json_decode(file_get_contents("php://input"), true); // Get data as assoc array
    // $id=$data['id'];
    $id = $_SERVER['QUERY_STRING'];
    $sql = $conn->query("DELETE FROM user where id='$id'");
    // $users = array();
    if ($sql) {
        
        $result['message'] = "delete success";
    }else {
        $result['error'] = true;
        $result['message'] = "User deleted fail";
    }
}

$conn->close();
echo json_encode($result)
?>