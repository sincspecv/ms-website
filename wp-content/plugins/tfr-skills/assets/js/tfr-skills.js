// Chart element
var canvas = document.getElementById('tfr-skills-chart');

// Get the chart data and build the chart
var xhr = new XMLHttpRequest();
xhr.open('GET', '/wp-json/skills/v1/chart');
xhr.onload = function() {
  if (xhr.status === 200) {
    // if the chart element is already in view, build the chart
    if (isInView(canvas)) {
      buildChart(JSON.parse(xhr.responseText));
    } else {
      // else watch for scroll event and build the chart when the element is in view
      var chartIsBuilt = false
      window.addEventListener('scroll', function() {
        if (isInView(canvas) && chartIsBuilt === false) {
          buildChart(JSON.parse(xhr.responseText));
          chartIsBuilt = true;
        }
      });
    }
  }
  else {
    console.debug('Request failed.  Returned status of ' + xhr.status);
  }
};
xhr.send();

function buildChart(chartData) {
  // Make sure chart goes to 100
  chartData.data[chartData.data.length] = 100;

  // Build colors array
  var colors = [];

  chartData.labels.forEach(function() {
    colors.push(chartColor);
  })

  // Create the chart
  var chart = new Chart(canvas, {
    type: 'horizontalBar',
    data: {
      labels: chartData.labels,
      datasets: [{
        label: '',
        data: chartData.data,
        backgroundColor: colors,
        borderColor: colors,
        borderWidth: .6
      }]
    },
    options: {
      legend: {
        display: false
      },
      label: {
        display: false
      },
      barThickness: 10,
      scales: {
        xAxes: [{
          ticks: {
            beginAtZero: true,
            display: false,
          },
          gridLines: {
            display: false
          }
        }],
        yAxes: [{
          gridLines: {
            display: false
          }
        }]
      }
    }
  });
}

function isInView(el) {
  var rect = el.getBoundingClientRect();
  return rect.top <= window.innerHeight - 100;
};

