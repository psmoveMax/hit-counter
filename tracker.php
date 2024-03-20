<?php
$db = new PDO('sqlite:visits.db');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$db->exec("CREATE TABLE IF NOT EXISTS visits (
    id INTEGER PRIMARY KEY,
    ip TEXT,
    user_agent TEXT,
    visited_at DATETIME DEFAULT CURRENT_TIMESTAMP
)");

// Получение IP-адреса пользователя
$ip = $_SERVER['REMOTE_ADDR'];
$userAgent = $_SERVER['HTTP_USER_AGENT'];

$stmt = $db->prepare("INSERT INTO visits (ip, user_agent) VALUES (?, ?)");
$stmt->execute([$ip, $userAgent]);
?>