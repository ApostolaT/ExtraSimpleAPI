<?php

require_once "/var/www/evozon2021/Lab7/dbConnection.php";
require_once "/var/www/evozon2021/Lab7/config.php";

function userIsAdminToken(string $token, PDO $conn): bool
{

    $queryString = "SELECT * FROM admins WHERE passkey = :token";
    $query = $conn->prepare($queryString);

    $query->bindParam(':token', $token);
    $query->execute();
    $result = $query->fetch();

    if (!$result) {
        echo "No such token" . PHP_EOL;
        return false;
    }

    return true;
}

\session_start();

if (isset($_SESSION['admin']) === false) {
    echo "You must login as an admin" . PHP_EOL;
    header("HTTP/1.1 401 Unauthorized");
    exit();
}

$conn = setupConnection($config);
if ($conn === null) {
    echo "DB connection issues" . PHP_EOL;
    header("HTTP/1.1 500 Internal Server Error");
    exit();
}

if (userIsAdminToken($_SESSION['admin'], $conn) === false) {
    echo "You do not have access to this feature!" . PHP_EOL;
    header("HTTP/1.1 401 Unauthorized");
    exit();
}

//Nu merge in browser :)
if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
    echo "Wrong method" . PHP_EOL;
    header("HTTP/1.1 405 Method Not Allowed");
    exit();
}

if (!isset($_GET['word'])) {
    $conn = null;
    header("422 Unprocessable Entity");
    exit();
}

$word = $_GET['word'];
$queryString = "DELETE FROM words WHERE word = :word;";
$query = $conn->prepare($queryString);

$query->bindParam(':word', $word);
$result = $query->execute();

if (!$result) {
    echo "Deletion failed" . PHP_EOL;
    header("HTTP/1.1 500 Internal Server Error");
    exit();
}

echo "Deletion successfull!" . PHP_EOL;
$conn = null;
header("HTTP/1.1 200 Ok");
