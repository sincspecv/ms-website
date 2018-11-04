// Chart element
var canvas = document.getElementById('tfr-skills-chart');
// canvas.parentNode.height = 385;

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
  // Build colors array
  var colors = chartData.labels.map(function() {
    // chartColor variable is defined in the shortcode php function
    return chartColor
  });

  // Create the chart
  var chart = new Chart(canvas, {
    type: 'horizontalBar',
    data: {
      labels: chartData.labels,
      datasets: [{
        label: '',
        data: chartData.data,
        fill: false,
        backgroundColor: colors,
        borderColor: colors,
        borderWidth: 0,
        lineWidth: .1
      }]
    },
    options: {
      maintainAspectRatio: false,
      legend: {
        display: false
      },
      label: {
        display: false
      },
      scales: {
        xAxes: [{
          display: false,
          ticks: {
            beginAtZero: true,
            display: false,
            max: 100
          },
          gridLines: {
            display: false
          }
        }],
        yAxes: [{
          categoryPercentage: 1,
          barPercentage: .5,
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

