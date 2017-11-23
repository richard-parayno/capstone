Chart.defaults.global.defaultFontFamily = "Lato";
Chart.defaults.global.defaultColor = "#FBFBFB";
var ctx = document.getElementById('trips-overview').getContext('2d');
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'line',

    // The data for our dataset
    data: {
        labels: ["Dec 16", "Jan 17", "Feb 17", "Mar 17", "Apr 17", "May 17", "Jun 17", "Jul 17", "Aug 17", "Sep 17", "Oct 17", "Nov 17", "Dec 17"],
        datasets: [{
            label: "Carbon Emissions in Tonnes",
            backgroundColor: 'rgb(1, 151, 246)',              
            borderColor: 'rgb(1, 151, 246)',
            fill: false,
            data: [1.5504, 1.1371, 1.2101, 1.701, 1.3407, 1.2123, 1.5433, 1.4343, 1.4566, 1.6876, 1.834, 1.79, 1.3208],
        }, {
            label: "Analytics Values",
            backgroundColor: 'rgb(255, 165, 0)',
            borderColor: 'rgb(255, 165, 0)',
            fill: false,
            data: [101.22, 2.66, 11.62, 20.58, 29.54, 38.50, 47.46, 56.42, 65.38, 74.34, 83.30, 92.26, 101.22],
        }, {
            label: "Carbon Sequestrated in Tonnes",
            backgroundColor: 'rgb(211, 211, 211)',
            borderColor: 'rgb(211, 211, 211)',
            fill: false,
            data: [120.958873, 120.958873, 120.958873, 120.958873, 120.958873, 120.958873, 120.958873, 120.958873, 120.958873, 120.958873, 120.958873, 120.958873, 120.958873],
        }, {
            label: "25% Threshold",
            backgroundColor: 'rgb(255, 255, 0)',
            borderColor: 'rgb(255, 255, 0)',
            fill: false,
            data: [4.8, 4.8, 4.8, 4.8, 4.8, 4.8, 4.8, 4.8, 4.8, 4.8, 4.8, 4.8, 4.8],
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
        text: "Analytics",
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