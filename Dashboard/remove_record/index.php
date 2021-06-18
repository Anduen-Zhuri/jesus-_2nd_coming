<?php

session_start();

require_once("../../DB_CFG/index.php");

if (isset($_SESSION["uuid"]) && isset($_GET["id"]) && !empty($_GET["id"])) {
    $stmt = $conn->prepare("SELECT id FROM jobs WHERE id=? AND user=?");
        
        
    $stmt->bind_param("ss", $_GET["id"], $_SESSION["uuid"]);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows <= 0) {
        header("location: ../works");
    } else {
        $stmt = $conn->prepare("DELETE FROM jobs WHERE id = ?");
        $stmt->bind_param("i", $_GET["id"]);
        $stmt->execute();
        $stmt->close();
        header("location: ../works");
    }

} else {
    header("location: ../works");
}