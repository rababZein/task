<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once 'AnalysisClass.php';

$s = $_POST['s'];
$lines = $_POST['lines'];

$analysis = new Analysis($s, $lines);

$outputArray = $analysis->generateOutPut();

foreach ($outputArray as $output) {
    echo $output.'</br>';
}
