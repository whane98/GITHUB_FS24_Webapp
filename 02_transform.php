<?php

$weatherdata = fetchDataFromAPI();

$weatherdata = mapCoordinatesToCities($weatherdata);
$weatherdata = roundTemperatures($weatherdata);
$weatherdata = addWeatherCondition($weatherdata);
print_r($weatherdata);
// print_r($weatherdata);

// function to fetch data from the API ---------------------------------------------------------------------------------------------
function fetchDataFromAPI() {
    $url = "https://api.open-meteo.com/v1/forecast?latitude=46.9481,46.516,46.8499,46.0101&longitude=7.4474,6.6328,9.5329,8.96&current=temperature_2m,weather_code&daily=sunshine_duration&timezone=Europe%2FBerlin&forecast_days=16";

    // data retrieval
    $ch = curl_init(); // curl handle, initialize curl session

    curl_setopt($ch, CURLOPT_URL, $url);    // set URL to fetch
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  // set curl option to return the output as a string instead of outputting it in the browser

    $weatherdata = curl_exec($ch);    // execute curl request
    curl_close($ch);    // close curl handle

    // decode json response
    $weatherdata = json_decode($weatherdata, true);

    return $weatherdata;
}

// function to map coordinates to cities ---------------------------------------------------------------------------------------------

function mapCoordinatesToCities($data)
{
    $cityMap = [
        ['latitude' => 46.94, 'longitude' => 7.44, 'city' => 'bern'],
        ['latitude' => 46.52, 'longitude' => 6.64, 'city' => 'lausanne'],
        ['latitude' => 46.84, 'longitude' => 9.52, 'city' => 'chur'],
        ['latitude' => 46, 'longitude' => 8.940001, 'city' => 'lugano']
    ];

    $result = []; // new array for the modified data

    foreach ($data as $item) {
        $found = false; // flag to check if a match was found
        foreach ($cityMap as $city) {
            if ($item['latitude'] == $city['latitude'] && $item['longitude'] == $city['longitude']) {
                // if a match was found, add the city and set the flag
                $item['city'] = $city['city'];
                $found = true;
                break;
            }
        }
        
        // add the updated item to the new array
        $result[] = $item;
    }

    return $result;
}

// function to round temperatures ---------------------------------------------------------------------------------------------

function roundTemperatures($data)
{
    foreach ($data as &$item) {
        $item['temperature'] = round($item['current']['temperature_2m']);
    }
    return $data;
}

// function to determine weather conditions ---------------------------------------------------------------------------------------------

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

?>
