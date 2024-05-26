<?php

// include the configuration file ---------------------------------------------------------------------------------------------
require_once '00_config.php';

// check if the city parameter is provided in the request ---------------------------------------------------------------------------------------------
if (!isset($_GET['city'])) {
    echo json_encode(['error' => 'city parameter is missing']);
    exit;
}

// retrieve the city parameter from the request ---------------------------------------------------------------------------------------------
$city = $_GET['city'];

try {
    // create a new pdo instance 
    $pdo = new PDO($dsn, $db_user, $db_pass, $options);

    // prepare the sql query with a parameter placeholder for the city
    $query = "select created_at, city, temperature, weather_condition, sunshine_duration from weather_api_im4 where city = :city";

    // prepare the statement
    $stmt = $pdo->prepare($query);

    // bind the city parameter to the prepared statement
    $stmt->bindParam(':city', $city, PDO::PARAM_STR);

    // execute the query
    $stmt->execute();

    // fetch all rows into an associative array
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // check if any rows are returned
    if (empty($rows)) {
        echo json_encode(['error' => 'city not found']);
        exit;
    }

    // initialize arrays to hold the time and temperature values
    $times = [];
    $temperatures = [];
    $weatherConditions = [];
    $sunshineDurations = [];

    // populate the arrays
    foreach ($rows as $row) {
        $times[] = $row['created_at'];
        $city = $row['city'];
        $temperatures[] = $row['temperature'];
        $weatherConditions[] = $row['weather_condition'];
        $sunshineDurations[] = $row['sunshine_duration'];
    }

    // prepare the final structure
    $result = [
        'time' => $times,
        'city' => $city,
        'temperature' => $temperatures,
        'weatherCondition' => $weatherConditions,
        'sunshineDuration' => $sunshineDurations
    ]; 

    // output json
    header('content-type: application/json');
    echo json_encode($result);

} catch (PDOException $e) {
    // handle database errors
    echo json_encode(['error' => 'connection failed: ' . $e->getMessage()]);
}

?>
