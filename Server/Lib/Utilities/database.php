<?php

require_once($_SERVER['DOCUMENT_ROOT'].'/Config/database.php');

function connectBD() {
    try {
        $db = "mysql:host=" . DB_SERVER . ";dbname=" . DB_NAME . ";charset=utf8";
        $link = new PDO($db, DB_USERNAME, DB_PASSWORD);
        $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $link;
    } catch (PDOException $e) {
        die("ERRO: Connection was not possible. " . $e->getMessage());
    }
}