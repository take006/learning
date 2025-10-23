<?php
include_once './database.php';
$sql = 'SELECT * FROM learning';
$stmt = $pdo->query($sql);
$data = $stmt->fetch(PDO::FETCH_ASSOC);