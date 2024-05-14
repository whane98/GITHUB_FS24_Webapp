<?php

// Definition der Verbindungsparameter für die Datenbank
$db_host     = 'localhost';     // Hostserver, auf dem die DB läuft.
// «localhost» bedeutet: die selbe Serveradresse, auf dem auch die Seiten gespeichert sind

$db_name = '164933_4_1';   // Name der Datenbank (stimmt im Beispiel nur zufällig mit username überein)
$db_user = '164933_4_1';   // Name des DB-Users (stimmt im Beispiel nur zufällig mit Datenbankname überein)
$db_pass = '4cnt0r1M8xjf';  // Passwort des DB-Users*/


$db_charset  = 'utf8mb4';       // siehe https://www.hydroxi.de/utf8-vs-utf8mb4/

$dsn = "mysql:host=$db_host;dbname=$db_name;charset=$db_charset"; // siehe https://en.wikipedia.org/wiki/Data_source_name
$options = [
  PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::ATTR_EMULATE_PREPARES   => false
];






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
