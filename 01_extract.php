<?php

echo "hello world <br>";

$url = "https://api.open-meteo.com/v1/forecast?latitude=46.9481,46.516,46.8499,46.0101&longitude=7.4474,6.6328,9.5329,8.96&current=temperature_2m,weather_code&daily=sunshine_duration&timezone=Europe%2FBerlin&forecast_days=16"; // Ersetze "https://your-new-api-url.com" durch die tatsächliche URL deiner neuen API.

// Datenabruf
$ch = curl_init(); // Curl-Handle, initialisiere cURL-Sitzung

curl_setopt($ch, CURLOPT_URL, $url);    // Setze URL zum Abrufen
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  // Setze cURL-Option, um die Ausgabe zurückzugeben, anstatt sie im Browser auszugeben

$weatherdata = curl_exec($ch);    // Führe cURL-Anfrage aus
curl_close($ch);    // Schließe cURL-Handle

// Fehlerbehandlung
if ($weatherdata === false) {
    echo "Curl error: " . curl_error($ch);  // Fehler anzeigen, wenn während der cURL-Ausführung ein Fehler auftritt
} else {
    $weatherdata = json_decode($weatherdata, true);  // JSON-Antwort decodieren
}

if ($weatherdata === null) {
    echo "JSON error: " . json_last_error();  // Fehler anzeigen, wenn beim JSON-Decodieren ein Fehler auftritt
} else {
    // Neue Datenverarbeitungsfunktion aufrufen
    processWeatherData($weatherdata);
}

// Funktion zur Verarbeitung der neuen Wetterdaten
function processWeatherData($data)
{
    foreach ($data as $item) {
        echo "Latitude: " . $item['latitude'] . "<br>";
        echo "Longitude: " . $item['longitude'] . "<br>";
        echo "Temperature: " . $item['current']['temperature_2m'] . "°C<br>";
        $sunshine_duration_hours = round(array_sum($item['daily']['sunshine_duration']) / 3600/24);
        echo "Sunshine duration: " . $sunshine_duration_hours . " hours<br>";
                echo "<br> <br>";
        // echo "Rain: " . $item['current']['rain'] . "<br>";
        // echo "Cloud Cover: " . $item['current']['cloud_cover'] . "<br><br>";
    }
}
?>
