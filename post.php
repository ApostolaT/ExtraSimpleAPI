<?php

require_once "/var/www/evozon2021/Lab7/dbConnection.php";
require_once "/var/www/evozon2021/Lab7/config.php";

\session_start();
$token = $_SESSION['admin'];

if (!isset($_SESSION['admin'])) {
    echo "You must login as an admin" . PHP_EOL;
    exit();
}

$conn = setupConnection($config);
if ($conn === null) {
    echo "DB connection issues" . PHP_EOL;
    exit();
}

if (userIsAdminToken($_SESSION['admin'], $conn) === false) {
    echo "You do not have access to this feature!" . PHP_EOL;
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "wrong method" . PHP_EOL;
    exit();
}

if (isset($_POST['word']) && isset($_POST['translation'])) {

    $word        = $_POST['word'];
    $translation = $_POST['translation'];
    $queryString = "INSERT INTO words (word, translation) VALUES (:word, :translation)";
    $query       = $conn->prepare($queryString);

    $query->bindParam(':word', $word);
    $query->bindParam(':translation', $translation);
    $result = $query->execute();

    if (!$result) {
        echo "Insertion failed" . PHP_EOL;
        exit();
    }
    echo "Insertion successfull!" . PHP_EOL;
    $conn = null;
}

function userIsAdminToken(string $token, PDO $conn): bool
{

    $queryString = "SELECT * FROM admins WHERE passkey = :token";
    $query       = $conn->prepare($queryString);

    $query->bindParam(':token', $token);
    $query->execute();
    $result = $query->fetch();

    if (!$result) {
        echo "No such token" . PHP_EOL;
        return false;
    }

    return true;
}