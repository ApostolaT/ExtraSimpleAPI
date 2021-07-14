<?php

require_once "/var/www/evozon2021/Lab7/dbConnection.php";
require_once "/var/www/evozon2021/Lab7/config.php";

\session_start();

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo "wrong method" . PHP_EOL;;
    exit();
}

$conn = setupConnection($config);
if ($conn === null) {
    echo "DB connection issues" . PHP_EOL;
    exit();
}

if (isset($_GET['word'])) {
    $word        = $_GET['word'];
    $queryString = "SELECT * FROM words WHERE word = :word;";
    $query       = $conn->prepare($queryString);

    $query->bindParam(':word', $word);
    $query->execute();

    $result      = $query->fetch();

    if (!$result) {
        echo "No result was found". PHP_EOL;
        exit();
    }
    $conn = null;

    $data = [$result['word'], $result['translation']];
    header('Content-Type: application/json');
    echo json_encode($data);
}