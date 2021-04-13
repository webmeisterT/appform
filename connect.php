<?php
// $host = '127.0.0.1';
// $db   = 'missions_vueCrud';
// $user = 'missions_vueCrud';
// $pass = 'missions_vueCrud';
// $port = "3306";
// $charset = 'utf8mb4';
$host = '127.0.0.1';
$db   = 'crud_vue';
$user = 'root';
$pass = 'root';
$port = "3306";
$charset = 'utf8mb4';

$options = [
    \PDO::ATTR_ERRMODE            => \PDO::ERRMODE_EXCEPTION,
    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
    \PDO::ATTR_EMULATE_PREPARES   => false,
];
$dsn = "mysql:host=$host;dbname=$db;charset=$charset;port=$port";
try {
     $con = new \PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
     throw new \PDOException($e->getMessage(), (int)$e->getCode());
}