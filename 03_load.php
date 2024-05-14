<?php

require_once '02_transform.php';
require_once '00_config.php';

try {
    // Create a new PDO instance ---------------------------------------------------------------------------------------------
    $pdo = new PDO($dsn, $db_user, $db_pass, $options);

    // Prepare SQL statement for inserting data into the database ---------------------------------------------------------------------------------------------
    $stmt = $pdo->prepare("INSERT INTO Weather_API_IM4 (city, temperature, weather_condition, sunshine_duration) VALUES (?, ?, ?, ?)");

    // Iterate over each item in $weather_data array ---------------------------------------------------------------------------------------------
    
    foreach ($weatherdata as $item) {
        // Bind parameters and execute the statement for each item
        $sunshine_duration_hours = round(array_sum($item['daily']['sunshine_duration']) / 3600/24);
        $stmt->execute([$item['city'], $item['temperature'], $item['condition'], $sunshine_duration_hours]);
    }

    // Output success message
    echo "Weather data loaded successfully into the database.";
} catch (PDOException $e) {
    // Handle database connection errors
    echo "Error: " . $e->getMessage();
}
