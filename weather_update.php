<?php
require_once '00_config.php';

header('Content-Type: application/json');

// List of cities to fetch data for
$cities = ['Bern', 'Lugano', 'Chur', 'Lausanne'];

try {
    $pdo = new PDO('mysql:host=' . $db_host . ';dbname=' . $db_name, $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $results = [];

    foreach ($cities as $city) {
        $stmt = $pdo->prepare("SELECT temperature, weather_condition, sunshine_duration FROM Weather_API_IM4 WHERE city = :city ORDER BY id DESC LIMIT 1");
        $stmt->execute([':city' => $city]);
        $weatherdata = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($weatherdata) {
            $results[$city] = $weatherdata;
        } else {
            $results[$city] = ['error' => 'No weather data found for ' . $city];
        }
    }

    echo json_encode($results);

} catch (\Throwable $th) {
    error_log($th->getMessage());
    echo json_encode(['error' => 'Failed to fetch weather data']);
    exit;
}
