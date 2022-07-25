<?php
// header('Access-Control-Allow-Origin: *');
class Process {
    private $host='127.0.0.1';
    private $db='portfolio';
    private $user='root';
    private $pass='root';
    // private $db='missions_portfolio';
    // private $user='missions_portfolio';
    // private $pass='missions_portfolio';
    private $conn;

    public function connect()
    {
        $this->conn = null;

        $options = [
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES => false,
        ];

        $dsn= 'mysql:host='.$this->host.';dbname='.$this->db.';charset=utf8mb4';
        try {
            $this->conn = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (\PDOException $e) {
            echo "Connection Failed: ". $e->getMessage();
        }

        return $this->conn;
    }

    public function uuid() {
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
    
            // 32 bits for "time_low"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
    
            // 16 bits for "time_mid"
            mt_rand(0, 0xffff),
    
            // 16 bits for "time_hi_and_version",
            // four most significant bits holds version number 4
            mt_rand(0, 0x0fff) | 0x4000,
    
            // 16 bits, 8 bits for "clk_seq_hi_res",
            // 8 bits for "clk_seq_low",
            // two most significant bits holds zero and one for variant DCE1.1
            mt_rand(0, 0x3fff) | 0x8000,
    
            // 48 bits for "node"
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }
}

$process = new Process();
$con = $process->connect();
$result = ['error'=>false];

$action = $_SERVER['REQUEST_METHOD'];

if ($action == 'POST') {
    $data = json_decode(file_get_contents("php://input"));
    $id = $data->id = $process->uuid();
    $fullname=$data->fullname;
    $email=$data->email;
    $messg=$data->messg;

    $statement = "INSERT INTO contact (fullname, email, messg) VALUES (:fullname, :email, :messg)";

    $sql = $con->prepare($statement);

    if($sql->execute(['fullname'=>$fullname, 'email'=>$email, 'messg'=>$messg]))
        {
            echo json_encode(['ok'=>1]);
        }else{
            echo json_encode(['ok'=>0]);            
        }
        
}

