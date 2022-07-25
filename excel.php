<?php
require "connect.php";

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

// $spreadsheet = new Spreadsheet();
// $sheet = $spreadsheet->getActiveSheet();
// $sheet->setCellValue('A1', 'Hello World !');

// $writer = new Xlsx($spreadsheet);
// $writer->save('hello world.xlsx');
// echo $writer;
$sql = "SELECT * FROM `user` ORDER BY id DESC";
$stm = $con->prepare($sql);
$stm->execute();
$res = $stm->fetchAll();


$file = new Spreadsheet();
$active_sheet = $file->getActiveSheet();
$active_sheet->setCellValue('A1','Name'); 
$active_sheet->setCellValue('B1','Email'); 
$active_sheet->setCellValue('C1','Phone'); 

$count = 2;

foreach ($res as $row) {
    $active_sheet->setCellValue('A'.$count, $row['name']);
    $active_sheet->setCellValue('B'.$count, $row['email']);
    $active_sheet->setCellValue('C'.$count, $row['phone']);
    $count = $count + 1;

}

// $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($file, $_POST['file_type']);

// $file_name = time().'.'. strtolower($_POST['file_type']);
$file_name = time().'.'. 'xlsx';

$writer = new Xlsx($file);
$writer->save($file_name);

header('Content-Type: application/x-www-form-urlencoded');

header('Content-Transfer-Encoding: Binary');

header("Content-disposition: attachment; filename=\"".$file_name."\"");

readfile($file_name);

unlink($file_name);

exit;


?>