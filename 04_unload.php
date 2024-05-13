<?php

// Include the configuration file
require_once '00_config.php';

// Check if the city parameter is provided in the request
if (!isset($_GET['city'])) {
    echo json_encode(['error' => 'City parameter is missing']);
    exit;
}

// Retrieve the city parameter from the request
$city = $_GET['city'];

try {
    // Create a new PDO instance
    $pdo = new PDO($dsn, $db_user, $db_pass, $options);

    // Prepare the SQL query with a parameter placeholder for the city
    $query = "SELECT created_at, city, temperature, weather_condition, sunshine_duration FROM Weather_API_IM4 WHERE city = :city";

    // Prepare the statement
    $stmt = $pdo->prepare($query);

    // Bind the city parameter to the prepared statement
    $stmt->bindParam(':city', $city, PDO::PARAM_STR);

    // Execute the query
    $stmt->execute();

    // Fetch all rows into an associative array
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Check if any rows are returned
    if (empty($rows)) {
        echo json_encode(['error' => 'City not found']);
        exit;
    }

    // Initialize arrays to hold the time and temperature values
    $times = [];
    $temperatures = [];

    // Populate the arrays
    foreach ($rows as $row) {
        $times[] = $row['created_at'];
        $city = $row['city'];
        $temperatures[] = $row['temperature'];
        $weatherConditions[] = $row['weather_condition'];
        $sunshineDurations[] = $row['sunshine_duration'];
    }

    // Prepare the final structure
    $result = [
        'time' => $times,
        'city' => $city,
        'temperature' => $temperatures,
        'weatherCondition' => $weatherConditions,
        'sunshineDuration' => $sunshineDurations
    ];

    // Output JSON
    header('Content-Type: application/json');
    echo json_encode($result);

} catch (PDOException $e) {
    // Handle database errors
    echo json_encode(['error' => 'Connection failed: ' . $e->getMessage()]);
}

?>