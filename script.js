let city = '?city=Bern&city=Lugano&city=Lausanne&city=Chur';


// temperatur-dauer ---------------------------------------------------------------------------------------------

// Fetch data from the URL
fetch(`https://164933-4.web.fhgr.ch/IM4_Meteo/04_unload.php${city}`)
  .then(response => {
    // Check if the response is successful (status code 200)
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }
    // Parse the JSON response
    return response.json();
  })
  .then(data => {
    // Extract time and temperature data from the JSON response
    const timeData = data.time;
    const temperatureData = data.temperature;

    // Create a new Chart instance
    const ctx = document.getElementById('temperatureChart').getContext('2d');
    const temperatureChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: timeData, // Time data for x-axis
        datasets: [{
          label: 'Temperatur (°C)',
          data: temperatureData, // Temperature data for y-axis
          borderColor: '#259ED2',
          borderWidth: 2,
          fill: false,
          pointRadius: 0 // Applies rounded points on the line chart
        }]
      },
      options: {
        responsive: true,
        scales: {
          xAxes: [{
            type: 'time',
            time: {
              parser: 'MM-DD HH:mm',
              tooltipFormat: 'MM-DD HH:mm:ss',
              unit: 'hour',
              displayFormats: {
                hour: 'HH:mm'
              },
              stepSize: 1
            },
            scaleLabel: {
              display: true,
              labelString: 'Time'
            }
          }],
          yAxes: [{
            scaleLabel: {
              display: true,
              labelString: 'Temperatur (°C)'
            }
          }]
        },
        title: {
          display: true,
          text: 'Temperatur'
        }
      }
    });
  })
  .catch(error => {
    // Log any errors that occur during the fetch request
    console.error('There was a problem with the fetch operation:', error);
  });

  
// sonnenschein-dauer ---------------------------------------------------------------------------------------------

// Fetch data from the URL
fetch(`https://164933-4.web.fhgr.ch/IM4_Meteo/04_unload.php${city}`)
  .then(response => {
    // Check if the response is successful (status code 200)
    if (!response.ok) {
      throw new Error('Network response was not ok');
    }
    // Parse the JSON response
    return response.json();
  })
  .then(data => {
    // Extract time and sunshine duration data from the JSON response
    const timeData = data.time;
    const sunshineDurationData = data.sunshineDuration;  // Adjust this according to your JSON structure

    // Create a new Chart instance for Sunshine Duration
    const ctxSunshine = document.getElementById('sonnenscheindauer').getContext('2d');
    const sunshineChart = new Chart(ctxSunshine, {
      type: 'line',
      data: {
        labels: timeData, // Time data for x-axis
        datasets: [{
          label: 'Sonnenscheindauer (Stunden)',
          data: sunshineDurationData, // Sunshine Duration data for y-axis
          borderColor: '#259ED2',
          borderWidth: 2,
          fill: false,
          pointRadius: 0 // Applies rounded points on the line chart
        }]
      },
      options: {
        responsive: true,
        scales: {
          xAxes: [{
            type: 'time',
            time: {
              parser: 'MM-DD HH:mm',
              tooltipFormat: 'MM-DD HH:mm:ss',
              unit: 'hour',
              displayFormats: {
                hour: 'HH:mm'
              },
              stepSize: 1
            },
            scaleLabel: {
              display: true,
              labelString: 'Time'
            }
          }],
          yAxes: [{
            scaleLabel: {
              display: true,
              labelString: 'Sonnenscheindauer (Stunden)'
            }
          }]
        },
        title: {
          display: true,
          text: 'Sonnenschein Dauer Chart'
        }
      }
    });
  })
  .catch(error => {
    // Log any errors that occur during the fetch operation
    console.error('There was a problem with the fetch operation:', error);
  });







  // wetterkonditionen ---------------------------------------------------------------------------------------------
  // Fetch data for weather conditions
fetch(`https://164933-4.web.fhgr.ch/IM4_Meteo/04_unload.php${city}`)
.then(response => {
  if (!response.ok) {
    throw new Error('Network response was not ok');
  }
  return response.json();
})
.then(data => {
  let weatherConditionCounts = { sunny: 0, cloudy: 0, rainy: 0 };

  console.log(data);

  // Count each weather condition
  data.weatherCondition.forEach(item => {
    if (item === 'sunny') {
      weatherConditionCounts.sunny += 1;
    } else if (item === 'cloudy') {
      weatherConditionCounts.cloudy += 1;
    } else if (item === 'rainy') {
      weatherConditionCounts.rainy += 1;
    }
  });

  console.log(weatherConditionCounts);

  // Doughnut Chart for Weather Conditions
  const ctxWeather = document.getElementById('wetterkonditionen').getContext('2d');
  const weatherChart = new Chart(ctxWeather, {
    type: 'doughnut',
    data: {
      labels: ['Sonnig', 'Bewölkt', 'Regnerisch'],
      datasets: [{
        label: 'Wetterverhältnisse',
        data: [weatherConditionCounts.sunny, weatherConditionCounts.cloudy, weatherConditionCounts.rainy],
        backgroundColor: ['#9CDCF0', '#C6C6C6', '#30748A'],
        hoverOffset: 4
      }]
    },
    options: {
      responsive: true,
      title: {
        display: true,
        text: 'Wetterverhältnisse'
      }
    }
  });
})
.catch(error => {
  console.error('There was a problem with the fetch operation:', error);
});



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


