<?php
require_once '../includes/config.php';
require_once '../includes/functions.php';

header('Content-Type: application/json');

if (isset($_GET['id'])) {
    $car_id = (int) $_GET['id'];
    $car = getCarById($car_id);
    
    if ($car) {
        echo json_encode(['price_per_day' => $car['price_per_day']]);
    } else {
        echo json_encode(['error' => 'Car not found']);
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}
?>