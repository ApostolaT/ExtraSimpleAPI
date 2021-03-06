<?php


require_once "/var/www/evozon2021/Lab7/dbConnection.php";
require_once "/var/www/evozon2021/Lab7/config.php";

\session_start();
echo "Destroying session now" . PHP_EOL;

$conn = setupConnection($config);
if ($conn === null) {
    echo "DB connection issues" . PHP_EOL;
    header("HTTP/1.1 500 Internal Server Error");
    exit();
}

if (isset($_SESSION['admin']) === false) {
    header("HTTP/1.1 200 OK");
    session_destroy();
    exit();

}

$token = $_SESSION['admin'];
$queryString = "DELETE FROM admins WHERE passkey = :token;";
$query = $conn->prepare($queryString);
$query->bindParam(':token', $token);

$result = $query->execute();

if (!$result) {
    echo "Token deletion failed" . PHP_EOL;
    header("HTTP/1.1 500 Internal Server Error");
    exit();
}
echo "Deletion successful!" . PHP_EOL;
$conn = null;
\session_destroy();