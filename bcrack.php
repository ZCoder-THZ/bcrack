<?php 
require './bcrack.php';
require_once './dbConnection.php';
$bcrack=new PasswordTester(new Dbconnection('172.17.0.1', 'myjobs', 'root', 'secret'));
// $bcrack->singleComparison('testerthz@gmail.com','thz123456');

$bcrack->multipleComparison('thz123456');

