<?php

echo "hello world <br>";

$url = "https://api.open-meteo.com/v1/forecast?latitude=46.9481,46.516,46.8499,46.0101&longitude=7.4474,6.6328,9.5329,8.96&current=temperature_2m,weather_code&daily=sunshine_duration&timezone=Europe%2FBerlin&forecast_days=16"; // replace "https://your-new-api-url.com" with the actual URL of your new API.

// data retrieval ---------------------------------------------------------------------------------------------
$ch = curl_init(); // curl handle, initialize curl session

curl_setopt($ch, CURLOPT_URL, $url);    // set URL to fetch
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  // set curl option to return the output as a string instead of outputting it in the browser

$weatherdata = curl_exec($ch);    // execute curl request
curl_close($ch);    // close curl handle

// error handling ---------------------------------------------------------------------------------------------
if ($weatherdata === false) {
    echo "curl error: " . curl_error($ch);  // display error if an error occurs during curl execution
} else {
    $weatherdata = json_decode($weatherdata, true);  // decode json response
}

if ($weatherdata === null) {
    echo "json error: " . json_last_error();  // display error if an error occurs during json decoding
} else {
    // call new data processing function
    processWeatherData($weatherdata);
}

// function to process the new weather data ---------------------------------------------------------------------------------------------
function processWeatherData($data)
{
    foreach ($data as $item) {
        echo "latitude: " . $item['latitude'] . "<br>";
        echo "longitude: " . $item['longitude'] . "<br>";
        echo "temperature: " . $item['current']['temperature_2m'] . "°c<br>";
        $sunshine_duration_hours = round(array_sum($item['daily']['sunshine_duration']) / 3600/24);
        echo "sunshine duration: " . $sunshine_duration_hours . " hours<br>";
                echo "<br> <br>";
        // echo "rain: " . $item['current']['rain'] . "<br>";
        // echo "cloud cover: " . $item['current']['cloud_cover'] . "<br><br>";
    }
}

// function to fetch latest weather data from the database
function fetchLatestWeatherData($pdo) {
    $stmt = $pdo->prepare("select temperature, weather_condition, sunshine_duration from weather_api_im4 order by entry_id desc limit 1");
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

// decide what action to take based on a query parameter or specific condition
if (isset($_GET['updateWeather'])) {
    // assuming the pdo connection setup is similar to what's in your `00_config.php`
    try {
        $pdo = new PDO($dsn, $db_user, $db_pass, $options);
        $latestWeather = fetchLatestWeatherData($pdo);

        // output javascript to update html content
        header("content-type: application/javascript");
        echo "document.getElementById('temperature').textContent = '{$latestWeather['temperature']} °c';";
        echo "document.getElementById('weather').textContent = '{$latestWeather['weather_condition']}';";
        echo "document.getElementById('sunshine').textContent = '{$latestWeather['sunshine_duration']} hours';";
    } catch (PDOException $e) {
        echo "console.error('connection failed: " . addslashes($e->getMessage()) . "');";
    }
} else {
    // existing api data handling code
    // existing code to handle api data extraction goes here
}
?>
