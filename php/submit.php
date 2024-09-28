<?php
include "db/db.php";
include "config/config.php";

$jsonData = file_get_contents("php://input");
$data = json_decode($jsonData, true);
if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode(['error' => 'Invalid JSON']);
    exit;
}

$username = $data["username"] ?? "anonymous";
$score = $data["score"] ?? 0;

$stmt = $pdo->prepare("INSERT INTO point_game(nama_user, total_point) VALUES (:username, :totalPoint)");
$stmt->bindParam(":username", $username);
$stmt->bindParam(":totalPoint", $score);
$stmt->execute();

echo json_encode(['redirectUrl' => $baseUrl . "?username=" . $username . "&score=" . $score]);
exit();
