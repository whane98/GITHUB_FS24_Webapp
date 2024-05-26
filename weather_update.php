<?php
require_once '00_config.php';

header('content-type: application/json');

// list of cities to fetch data for
$cities = ['bern', 'lugano', 'chur', 'lausanne'];

try {
    $pdo = new PDO('mysql:host=' . $db_host . ';dbname=' . $db_name, $db_user, $db_pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $results = [];

    foreach ($cities as $city) {
        $stmt = $pdo->prepare("select temperature, weather_condition, sunshine_duration from weather_api_im4 where city = :city order by id desc limit 1");
        $stmt->execute([':city' => $city]);
        $weatherdata = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($weatherdata) {
            $results[$city] = $weatherdata;
        } else {
            $results[$city] = ['error' => 'no weather data found for ' . $city];
        }
    }

    echo json_encode($results);

} catch (\Throwable $th) {
    error_log($th->getMessage());
    echo json_encode(['error' => 'failed to fetch weather data']);
    exit;
}
?>
