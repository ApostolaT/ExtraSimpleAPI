<?php


require_once "/var/www/evozon2021/Lab7/dbConnection.php";
require_once "/var/www/evozon2021/Lab7/config.php";

\session_start();
echo "Destroying session now" . PHP_EOL;

$conn = setupConnection($config);
if ($conn === null) {
    echo "DB connection issues" . PHP_EOL;
    exit();
}

if (isset($_SESSION['admin'])) {
    $token = $_SESSION['admin'];
    $queryString = "DELETE FROM admins WHERE passkey = :token;";
    $query = $conn->prepare($queryString);
    $query->bindParam(':token', $token);

    $result = $query->execute();

    if (!$result) {
        echo "Token deletion failed" . PHP_EOL;
        exit();
    }
    echo "Deletion successful!" . PHP_EOL;
}

$conn = null;

\session_destroy();