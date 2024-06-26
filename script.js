// Ensure that the DOM is fully loaded before running the script
document.addEventListener('DOMContentLoaded', initializePage);

function initializePage() {
  // Your initialization code here
  console.log("Page is fully loaded and initialized.");
}














// Stadt-Liste
const cities = ['Bern', 'Lugano', 'Lausanne', 'Chur'];

// Globale Speicherung der Daten und Chart-Instanzen
const cityData = {};
const charts = {};

// Funktion zum Erstellen eines Temperaturdiagramms -------------------------------------------------------------------------------------------------------
function createChart(city, timeData, temperatureData) {
    const canvasId = `temperatureChart-${city}`;
    const canvas = document.getElementById(canvasId);
    if (canvas) {
        const ctx = canvas.getContext('2d');
        
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
                    label: `Temperatur`,
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
                            display: true
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
                    legend: {
                        labels: {
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    title: {
                        display: true
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('de-DE', { style: 'decimal' }).format(context.parsed.y);
                                }
                                return label + ' °C';
                            }
                        }
                    }
                }
            }
        });
    }
}

// Funktion zum Erstellen eines Sonnenscheindauer-Diagramms -------------------------------------------------------------------------------------------------------
function createSunshineChart(city, timeData, sunshineDurationData) {
    const canvasId = `sunshineChart-${city}`;
    const canvas = document.getElementById(canvasId);
    if (canvas) {
        const ctx = canvas.getContext('2d');
        
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
                    label: `Sonnenscheindauer`,
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
                    legend: {
                        labels: {
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    title: {
                        display: true
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.dataset.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.parsed.y !== null) {
                                    label += new Intl.NumberFormat('de-DE', { style: 'decimal' }).format(context.parsed.y);
                                }
                                return label + ' h';
                            }
                        }
                    }
                }
            }
        });
    }
}

// Funktion zum Erstellen eines Wetterkonditionen-Diagramms -------------------------------------------------------------------------------------------------------
function createWeatherChart(city, weatherConditionCounts) {
    const canvasId = `weatherChart-${city}`;
    const canvas = document.getElementById(canvasId);
    if (canvas) {
        const ctx = canvas.getContext('2d');
        
        // Zerstöre bestehende Chart-Instanz, falls vorhanden
        if (charts[canvasId]) {
            charts[canvasId].destroy();
        }

        // Neue Chart-Instanz erstellen
        charts[canvasId] = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Sonnig', 'Bewölkt', 'Regnerisch'],
                datasets: [{
                    data: [weatherConditionCounts.sunny, weatherConditionCounts.cloudy, weatherConditionCounts.rainy],
                    backgroundColor: ['#9CDCF0', '#C6C6C6', '#30748A'],
                    borderColor: ['#ffffff', '#ffffff', '#ffffff'],
                    borderWidth: 0.5,
                    hoverBorderColor: ['#ffffff', '#ffffff', '#ffffff'],
                    hoverBorderWidth: 2,
                    hoverOffset: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                aspectRatio: 1.5,
                layout: {
                    padding: {
                        top: 10,
                        bottom: 10
                    }
                },
                plugins: {
                    legend: {
                        labels: {
                            usePointStyle: true,
                            pointStyle: 'circle'
                        }
                    },
                    title: {
                        display: true
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                let label = context.label || '';
                                if (label) {
                                    label += ': ';
                                }
                                if (context.raw !== null) {
                                    label += new Intl.NumberFormat('de-DE', { style: 'decimal' }).format(context.raw);
                                }
                                return label;
                            }
                        }
                    }
                }
            }
        });
    }
}

// Daten für jede Stadt einzeln abrufen und ein Diagramm erstellen -------------------------------------------------------------------------------------------------------
cities.forEach(city => {
    const temperatureChartId = `temperatureChart-${city}`;
    const sunshineChartId = `sunshineChart-${city}`;
    const weatherChartId = `weatherChart-${city}`;

    if (document.getElementById(temperatureChartId) || 
        document.getElementById(sunshineChartId) || 
        document.getElementById(weatherChartId)) {
        
        fetch(`https://164933-4.web.fhgr.ch/IM4_Meteo/04_unload.php?city=${city}`)
            .then(response => response.json())
            .then(data => {
                cityData[city] = data;
                if (document.getElementById(temperatureChartId)) {
                    createChart(city, data.time, data.temperature);
                }
                if (document.getElementById(sunshineChartId)) {
                    createSunshineChart(city, data.time, data.sunshineDuration);
                }

                if (document.getElementById(weatherChartId)) {
                    // Wetterbedingungen zählen und Diagramm erstellen
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
                    createWeatherChart(city, weatherConditionCounts);
                }
            })
            .catch(error => {
                console.error(`Es gab ein Problem mit der Fetch-Operation für ${city}:`, error);
            });
    }
});

// Funktion zum Filtern und Neuzeichnen der Diagramme -------------------------------------------------------------------------------------------------------
function filterCharts(duration) {
    const days = duration === '3 Tage' ? 3 : duration === '1 Woche' ? 7 : 14;
    const now = new Date();
    const pastDate = new Date(now.setDate(now.getDate() - days));
    const city = document.querySelector('.filter-statistik-button').getAttribute('data-city');

    const filteredTimeData = cityData[city].time.filter(time => new Date(time) >= pastDate);
    const filteredTemperatureData = cityData[city].temperature.slice(-filteredTimeData.length);
    const filteredSunshineData = cityData[city].sunshineDuration.slice(-filteredTimeData.length);

    // Diagramme neu erstellen mit gefilterten Daten
    createChart(city, filteredTimeData, filteredTemperatureData);
    createSunshineChart(city, filteredTimeData, filteredSunshineData);

    // Wetterbedingungen zählen und Diagramm erstellen
    let weatherConditionCounts = { sunny: 0, cloudy: 0, rainy: 0 };
    cityData[city].weatherCondition.forEach((item, index) => {
        if (new Date(cityData[city].time[index]) >= pastDate) {
            if (item === 'sunny') {
                weatherConditionCounts.sunny += 1;
            } else if (item === 'cloudy') {
                weatherConditionCounts.cloudy += 1;
            } else if (item === 'rainy') {
                weatherConditionCounts.rainy += 1;
            }
        }
    });
    createWeatherChart(city, weatherConditionCounts);
}

// Event Listener für die Buttons -------------------------------------------------------------------------------------------------------
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.filter-statistik-button').forEach(button => {
        button.addEventListener('click', function() {
            const city = this.getAttribute('data-city');
            const duration = this.textContent; // 3 Tage, 1 Woche, 2 Wochen
            filterCharts(duration, city);
        });
    });
});

