<?php

function storeSession($pdo, $user_id)
{
    $ip_address = $_SERVER["REMOTE_ADDR"];
    $timestamp = time();

    $sql = "INSERT INTO login_sessions (user_id, ip_address, timestamp) VALUES (?, ?, ?)";

    $stmt = $pdo->prepare($sql);

    $stmt->execute([$user_id, $ip_address, $timestamp]);
}
