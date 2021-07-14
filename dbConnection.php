<?php

function setupConnection(array $config): ?\PDO
{
    try {
        if (!isset($config)) {
            echo "No config" . PHP_EOL;
            return null;
        }
        $conn = new PDO('mysql:host=' . $config['serverName'] . ';' . "dbname=" . $config['dbName'], $config['userName'], $config['password']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        echo "Connection failed " . $e->getMessage() . PHP_EOL;
        exit();
    }
}
