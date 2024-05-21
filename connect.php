<?php
$servername = "localhost";
$username = "root";
$password = "Abdul.123456";
$dbname = "db_campusaccess";

try {
    $connect = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
CCC151(FinalRequirement)