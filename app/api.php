<?php
require_once __DIR__ . '/../config/config.php';
$sql = 'SELECT * FROM learning';
$stmt = $pdo->query($sql);
$data = $stmt->fetch(PDO::FETCH_ASSOC);