<?php

$weatherdata = fetchDataFromAPI();

$weatherdata = mapCoordinatesToCities($weatherdata);
$weatherdata = roundTemperatures($weatherdata);
$weatherdata = addWeatherCondition($weatherdata);
print_r($weatherdata);
// print_r($weatherdata);

// Funktion zum Abrufen von Daten von der API
function fetchDataFromAPI() {
    $url = "https://api.open-meteo.com/v1/forecast?latitude=46.9481,46.516,46.8499,46.0101&longitude=7.4474,6.6328,9.5329,8.96&current=temperature_2m,weather_code&daily=sunshine_duration&timezone=Europe%2FBerlin&forecast_days=16";

    // Datenabruf
    $ch = curl_init(); // Curl-Handle, initialisiere cURL-Sitzung

    curl_setopt($ch, CURLOPT_URL, $url);    // Setze URL zum Abrufen
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  // Setze cURL-Option, um die Ausgabe zurückzugeben, anstatt sie im Browser auszugeben

    $weatherdata = curl_exec($ch);    // Führe cURL-Anfrage aus
    curl_close($ch);    // Schließe cURL-Handle

    // JSON-Antwort decodieren
    $weatherdata = json_decode($weatherdata, true);

    return $weatherdata;
}

function mapCoordinatesToCities($data)
{
    $cityMap = [
        ['latitude' => 46.94, 'longitude' => 7.44, 'city' => 'Bern'],
        ['latitude' => 46.52, 'longitude' => 6.64, 'city' => 'Lausanne'],
        ['latitude' => 46.84, 'longitude' => 9.52, 'city' => 'Chur'],
        ['latitude' => 46, 'longitude' => 8.940001, 'city' => 'Lugano']
    ];

    $result = []; // Neues Array für die modifizierten Daten

    foreach ($data as $item) {
        $found = false; // Flag, um zu überprüfen, ob eine Übereinstimmung gefunden wurde
        foreach ($cityMap as $city) {
            if ($item['latitude'] == $city['latitude'] && $item['longitude'] == $city['longitude']) {
                // Wenn eine Übereinstimmung gefunden wurde, füge die Stadt hinzu und setze das Flag
                $item['city'] = $city['city'];
                $found = true;
                break;
            }
        }
        
        // Füge das aktualisierte Element dem neuen Array hinzu
        $result[] = $item;
    }

    return $result;
}


function roundTemperatures($data)
{
    foreach ($data as &$item) {
        $item['temperature'] = round($item['current']['temperature_2m']);
    }
    return $data;
}

function addWeatherCondition($data)
{
    foreach ($data as $key => $item) {
        if ($item['current']['weather_code'] == 0) {
            if ($item['daily']['sunshine_duration'] > 36000) {
                $data[$key]['condition'] = 'sunny';
            } else {
                $data[$key]['condition'] = 'cloudy';
            }
        } else {
            $data[$key]['condition'] = 'rainy';
        }
    }
    return $data;
}







header('Content-Type: application/json');

require '00_config.php'; // Your database configuration file

try {
    $pdo = new PDO($dsn, $db_user, $db_pass, $options);
    $stmt = $pdo->query("SELECT city, temperature, weather_condition, sunshine_duration FROM Weather_API_IM4 ORDER BY created_at DESC LIMIT 1");
    $data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($data) {
        echo json_encode([
            'sunshine' => $data['sunshine_duration'] . ' hours',
            'weather' => $data['weather_condition'],
            'temperature' => $data['temperature'] . '°C'
        ]);
    } else {
        echo json_encode(['error' => 'No data available']);
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}


?>



