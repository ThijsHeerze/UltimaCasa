<?php
function ConnectDB()
{
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=ultima_casa_db;charset=utf8', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}
?>