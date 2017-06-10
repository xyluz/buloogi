<?php session_start();
require_once('../admin/_autoload.php');
require_once '../lib/function.php';



$data = new upload();

$test = $data->collectFile();

echo $test;
