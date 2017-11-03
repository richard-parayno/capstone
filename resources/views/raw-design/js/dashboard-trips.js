Chart.defaults.global.defaultFontFamily = "Lato";
Chart.defaults.global.defaultColor = "#FBFBFB";
var ctx = document.getElementById('trips-overview').getContext('2d');
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'line',

    // The data for our dataset
    data: {
        labels: ["January", "February", "March", "April", "May", "June", "July"],
        datasets: [{
            label: "In-house Trips",
            backgroundColor: 'rgb(1, 151, 246)',              
            borderColor: 'rgb(1, 151, 246)',
            fill: false,
            data: [0, 20, 30, 40, 50, 30, 60],
        }, {
            label: "Outsourced Trips",
            backgroundColor: 'rgb(255, 90, 95)',
            borderColor: 'rgb(255, 90, 95)',
            fill: false,
            data: [0, 70, 50, 25, 80, 90, 25],
        }]
    },

    // Configuration options go here
    options: {
      responsive: true,
      legend: {
        labels: {
          fontColor: "#FBFBFB",
        }
      },
      title: {
        display: true,
        text: "Trips",
        fontColor: "#FBFBFB"
      },
      layout: {
        padding: {
          left: 30,
          right: 40,
          top: 30,
          bottom: 30
        },
      },
      scales: {
        xAxes: [{
          display: true,
          ticks: {
            fontColor: "#FBFBFB",
          },
          scaleLabel: {
            display: true,
            labelString: 'Month',
            fontColor: "#FBFBFB",
          }
        }],
        yAxes: [{
          display: true,
          ticks: {
            fontColor: "#FBFBFB",
          },
          scaleLabel: {
            display: true,
            labelString: 'Number of Trips',
            fontColor: "#FBFBFB",
          }
        }]
      }
    }
});