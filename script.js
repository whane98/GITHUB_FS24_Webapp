// Stadt-Liste
const cities = ['Bern', 'Lugano', 'Lausanne', 'Chur'];

// Globale Speicherung der Daten und Chart-Instanzen
const cityData = {};
const charts = {};

// Funktion zum Erstellen eines Temperaturdiagramms
function createChart(city, timeData, temperatureData) {
    const canvasId = `temperatureChart-${city}`;
    const ctx = document.getElementById(canvasId).getContext('2d');
    
    // Zerstöre bestehende Chart-Instanz, falls vorhanden
    if (charts[canvasId]) {
        charts[canvasId].destroy();
    }

    // Neue Chart-Instanz erstellen
    charts[canvasId] = new Chart(ctx, {
        type: 'line',
        data: {
            labels: timeData,
            datasets: [{
                label: `Temperatur in ${city}`,
                data: temperatureData,
                borderColor: '#259ED2',
                borderWidth: 2,
                fill: false,
                pointRadius: 0
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    type: 'time',
                    time: {
                        unit: 'hour',
                        displayFormats: {
                            hour: 'HH:mm'
                        }
                    },
                    title: {
                        display: true,
                       // text: 'Uhrzeit'
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Temperatur (°C)'
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    // text: `Temperaturverlauf in ${city}`
                }
            }
        }
    });
}

// Funktion zum Erstellen eines Sonnenscheindauer-Diagramms
function createSunshineChart(city, timeData, sunshineDurationData) {
    const canvasId = `sunshineChart-${city}`;
    const ctx = document.getElementById(canvasId).getContext('2d');
    
    // Zerstöre bestehende Chart-Instanz, falls vorhanden
    if (charts[canvasId]) {
        charts[canvasId].destroy();
    }

    // Neue Chart-Instanz erstellen
    charts[canvasId] = new Chart(ctx, {
        type: 'line',
        data: {
            labels: timeData,
            datasets: [{
                label: `Sonnenscheindauer in ${city}`,
                data: sunshineDurationData,
                borderColor: '#FFA500',
                borderWidth: 2,
                fill: false,
                pointRadius: 0
            }]
        },
        options: {
            responsive: true,
            scales: {
                x: {
                    type: 'time',
                    time: {
                        unit: 'hour',
                        displayFormats: {
                            hour: 'HH:mm'
                        }
                    }
                },
                y: {
                    beginAtZero: true,
                    title: {
                        display: true,
                        text: 'Sonnenscheindauer (h)'
                    }
                }
            },
            plugins: {
                title: {
                    display: true,
                    //text: `Sonnenscheindauer in ${city}`
                }
            }
        }
    });
}

// Daten für jede Stadt einzeln abrufen und ein Diagramm erstellen
cities.forEach(city => {
    fetch(`https://164933-4.web.fhgr.ch/IM4_Meteo/04_unload.php?city=${city}`)
        .then(response => response.json())
        .then(data => {
            cityData[city] = data;
            createChart(city, data.time, data.temperature);
            createSunshineChart(city, data.time, data.sunshineDuration);
        })
        .catch(error => {
            console.error(`There was a problem with the fetch operation for ${city}:`, error);
        });
});

// Funktion zum Filtern und Neuzeichnen der Diagramme
function filterCharts(duration) {
    const days = duration === '3 Tage' ? 3 : duration === '1 Woche' ? 7 : 14;
    const now = new Date();
    const pastDate = new Date(now.setDate(now.getDate() - days));

    cities.forEach(city => {
        const filteredTimeData = cityData[city].time.filter(time => new Date(time) >= pastDate);
        const filteredTemperatureData = cityData[city].temperature.slice(-filteredTimeData.length);
        const filteredSunshineData = cityData[city].sunshineDuration.slice(-filteredTimeData.length);

        // Diagramme neu erstellen mit gefilterten Daten
        createChart(city, filteredTimeData, filteredTemperatureData);
        createSunshineChart(city, filteredTimeData, filteredSunshineData);
    });
}

// Event Listener für die Buttons
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.filter-statistik-button').forEach(button => {
        button.addEventListener('click', function() {
            filterCharts(this.textContent); // 3 Tage, 1 Woche, 2 Wochen
        });
    });
});

// Funktion zum Abrufen und Darstellen von Wetterbedingungen
function fetchAndDisplayWeatherConditions() {
    fetch(`https://164933-4.web.fhgr.ch/IM4_Meteo/04_unload.php?city=Bern&city=Lugano&city=Lausanne&city=Chur`)
        .then(response => response.json())
        .then(data => {
            let weatherConditionCounts = { sunny: 0, cloudy: 0, rainy: 0 };
            data.weatherCondition.forEach(item => {
                if (item === 'sunny') {
                    weatherConditionCounts.sunny += 1;
                } else if (item === 'cloudy') {
                    weatherConditionCounts.cloudy += 1;
                } else if (item === 'rainy') {
                    weatherConditionCounts.rainy += 1;
                }
            });

            const ctxWeather = document.getElementById('wetterkonditionen').getContext('2d');
            const weatherChart = new Chart(ctxWeather, {
                type: 'doughnut',
                data: {
                    labels: ['Sonnig', 'Bewölkt', 'Regnerisch'],
                    datasets: [{
                        data: [weatherConditionCounts.sunny, weatherConditionCounts.cloudy, weatherConditionCounts.rainy],
                        backgroundColor: ['#9CDCF0', '#C6C6C6', '#30748A'],
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    aspectRatio: 1.5, // Doughnut Größe
                    plugins: {
                        title: {
                            display: true,
                            //text: 'Wetterverhältnisse'
                        }
                    }
                }
            });
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
        });
}

// Aufruf der Funktion zum Abrufen der Wetterbedingungen
fetchAndDisplayWeatherConditions();




//test-doughnut
// document.addEventListener('DOMContentLoaded', function() {
//   var ctx = document.getElementById('wetterkonditionen').getContext('2d');
//   var testChart = new Chart(ctx, {
//     type: 'doughnut',
//     data: {
//       labels: ['Test1', 'Test2', 'Test3'],
//       datasets: [{
//         data: [10, 20, 30],
//         backgroundColor: ['red', 'blue', 'green']
//       }]
//     }
//   });
// });


