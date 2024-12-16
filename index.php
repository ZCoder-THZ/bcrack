
<?php
require 'vendor/autoload.php';

use Illuminate\Hashing\BcryptHasher;
require_once './dbConnection.php';
require_once './crack.php';
// Create an instance of the Dbconnection class
// if ($argc > 1) {
//     $email = $argv[1];  // $argv[1] contains the first argument passed
// } else {
//     die("Please provide an email as an argument.\n");
// }

$host = '172.17.0.1';
$dbname = 'yourdb';
$username = 'root';
$password = 'secret';
$db = new Dbconnection($host, $dbname, $username, $password);


$crack=new PasswordTester($db);
// $crack->singleComparison('testerthz@gmail.com','thz123456');
$crack->multipleComparison('thz123456');




