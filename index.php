<?php

require_once "/var/www/evozon2021/Lab7/dbConnection.php";
require_once "/var/www/evozon2021/Lab7/config.php";

\session_start();

$conn = setupConnection($config);
if ($conn === null) {
    echo "DB connection issues" . PHP_EOL;
    header("HTTP/1.1 500 Internal Server Error");
    exit();
}

if (isset($_SESSION['admin']) === false) {
    $token = bin2hex(random_bytes(10));
    $queryString = "INSERT INTO admins (passkey) VALUES (:token);";
    $query = $conn->prepare($queryString);
    $query->bindParam(':token', $token);

    $result = $query->execute();

    if (!$result) {
        echo "Token insertion failed" . PHP_EOL;
        header("HTTP/1.1 500 Internal Server Error");
        exit();
    }
    echo "Insertion successfull!" . PHP_EOL;
    $_SESSION['admin'] = $token;
}
$conn = null;
header("HTTP/1.1 201 Created");


