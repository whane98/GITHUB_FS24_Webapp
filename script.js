let city = '?city=Bern&city=Lugano&city=Lausanne&city=Chur';

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
          label: 'Temperature (°C)',
          data: temperatureData, // Temperature data for y-axis
          borderColor: 'red',
          borderWidth: 5,
          fill: false
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
              labelString: 'Temperature (°C)'
            }
          }]
        },
        title: {
          display: true,
          text: 'Temperature Chart'
        }
      }
    });
  })
  .catch(error => {
    // Log any errors that occur during the fetch request
    console.error('There was a problem with the fetch operation:', error);
  });
