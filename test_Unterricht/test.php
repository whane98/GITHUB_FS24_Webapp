<?php
// Beispiele für verschiedene Variablentypen in PHP (Integer, Float, String, Boolean, Array, Array mit Strings, Array mit gemischten Werten, assoziatives Array)
$integer = 42;
$float = 3.14;
$string = "Hallo Welt!";
$boolean = true;
$array = array(1, 2, 3, 4, 5);
$arrayStrings = array("Apfel", "Birne", "Banane");
$arrayMixed = array(1, "Apfel", 3.14, true);
$associativeArray = array("Vorname" => "Alina", "Nachname" => "Weisser", "Grösse" => 1.64);

// Ausgabe der Variablen
echo "Integer: " . $integer . "<br>";
echo "Float: " . $float . "<br>";
echo "String: " . $string . "<br>";
echo "Boolean: " . $boolean . "<br>";
echo "Array: ";
print_r($array);
echo "<br>";
echo "Array mit Strings: ";
print_r($arrayStrings);
echo "<br>";
echo "Array mit gemischten Werten: ";
print_r($arrayMixed);
echo "<br>";
echo "Assoziatives Array: ";
print_r($associativeArray);
echo "<br><br>";

// Ausgabe einzelner Werte aus dem assoziativen Array
echo "Vorname: " . $associativeArray["Vorname"] . "<br>";
echo "Nachname: " . $associativeArray["Nachname"] . "<br>";
echo "Grösse: " . $associativeArray["Grösse"] . "<br>";

// Bedingungen

if ($integer > 40) {
    echo "Die Zahl ist grösser als 40.<br>";
} else if ($integer == 40) {
    echo "Die Zahl ist gleich 40.<br>";
} else {
    echo "Die Zahl ist kleiner als 40.<br>";
}


// Schleifen

// Zahlen von 1 bis 10 mit for-Schleife ausgeben
for ($i = 1; $i <= 10; $i++) {
    echo $i . "<br>";
}

// Array mit Schleife ausgeben
foreach ($array as $wert) {
    echo $wert . "<br>";
}

// Assoziatives Array mit Schleife ausgeben
foreach ($associativeArray as $key => $value) {
    echo $key . ": " . $value . "<br>";
}


// Array mit Schleifen ausgeben
echo "Array mit Schleife ausgeben:<br>";
for ($i = 0; $i < count($array); $i++) {
    echo $array[$i] . "<br>";
}


// Assoziatives Array mit Schleifen ausgeben

// Funktionen

?>
<!-- erstelle eine einfache HTML-Struktur und gebe alle oben erzeugten Werte in der Struktur aus -->