<?php

require_once '02_transform.php';
require_once '00_config.php';

try {
    // create a new pdo instance ---------------------------------------------------------------------------------------------
    $pdo = new PDO($dsn, $db_user, $db_pass, $options);

    // prepare sql statement for inserting data into the database ---------------------------------------------------------------------------------------------
    $stmt = $pdo->prepare("INSERT INTO Weather_API_IM4 (city, temperature, weather_condition, sunshine_duration) VALUES (?, ?, ?, ?)");

    // iterate over each item in $weather_data array ---------------------------------------------------------------------------------------------
    
    foreach ($weatherdata as $item) {
        // bind parameters and execute the statement for each item
        $sunshine_duration_hours = round(array_sum($item['daily']['sunshine_duration']) / 3600/24);
        $stmt->execute([$item['city'], $item['temperature'], $item['condition'], $sunshine_duration_hours]);
    }

    // output success message
    echo "weather data loaded successfully into the database.";
} catch (PDOException $e) {
    // handle database connection errors
    echo "error: " . $e->getMessage();
}

?>
