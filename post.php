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

if (!isset($_SESSION['admin'])) {
    echo "You must login as an admin" . PHP_EOL;
    header("HTTP/1.1 401 Unauthorized");
    exit();
}

$token = $_SESSION['admin'];
$conn = setupConnection($config);
if ($conn === null) {
    echo "DB connection issues" . PHP_EOL;
    header("HTTP/1.1 500 Internal Server Error");
    exit();
}

if (userIsAdminToken($_SESSION['admin'], $conn) === false) {
    echo "You do not have access to this feature!" . PHP_EOL;
    $conn = null;
    header("HTTP/1.1 401 Unauthorized");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "wrong method" . PHP_EOL;
    $conn = null;
    header("HTTP/1.1 405 Method Not Allowed");
    exit();
}

if ((isset($_POST['word']) && isset($_POST['translation'])) === false) {
    $conn = null;
    header("HTTP/1.1 422 Unprocessable Entity");
    exit();
}

$word = $_POST['word'];
$translation = $_POST['translation'];

if (mb_strlen($translation) > 100) {
    echo "Translation too long";
    $conn = null;
    header("HTTP/1.1 422 Unprocessable Entity");
    exit();
}

$queryString = "INSERT INTO words (word, translation) VALUES (:word, :translation)";
$query = $conn->prepare($queryString);

$query->bindParam(':word', $word);
$query->bindParam(':translation', $translation);
$result = $query->execute();

if (!$result) {
    echo "Insertion failed" . PHP_EOL;
    $conn = null;
    header("HTTP/1.1 500 Internal Server Error");
    exit();
}

echo "Insertion successfull!" . PHP_EOL;
$conn = null;
header("HTTP/1.1 201 Created");
