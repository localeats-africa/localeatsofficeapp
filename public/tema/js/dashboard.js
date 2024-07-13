


$(function () {

  'use strict';
	
		  function generateData(count, yrange) {
			var i = 0;
			var series = [];
			while (i < count) {
			  var x = 'w' + (i + 1).toString();
			  var y = Math.floor(Math.random() * (yrange.max - yrange.min + 1)) + yrange.min;

			  series.push({
				x: x,
				y: y
			  });
			  i++;
			}
			return series;
		  }
  
  var line_options = {
    series: [
      {
        name: "Chowdeck",
        data: [12, 42, 14, 28, 13, 40, 21],
      },
      {
        name: "Glovo",
        data: [28, 10, 23, 40, 25, 15, 41],
      },
    ],
    chart: {
      height: 350,
      type: "bar",
      dropShadow: {
        enabled: true,
        color: "#1b0a01",
        top: 18,
        left: 7,
        blur: 10,
        opacity: 0.2,
      },
      toolbar: {
        show: false,
      },
    },
    colors: ["#0C513F", "#FFC244"],
    dataLabels: {
      enabled: false,
    },
    stroke: {
      curve: "smooth",
      width: 1,
      lineCap: 'butt',
    },
    // grid: {
    //   borderColor: "#e7e7e7",
    // },
    grid: {
      show: true,
      borderColor: '#e7e7e7',
      strokeDashArray: 0,
      position: 'back',
      xaxis: {
          lines: {
              show: true
          }
      },   
      yaxis: {
          lines: {
              show: true
        },
      },  
      row: {
          colors: undefined,
          opacity: 0.9
      },  
      column: {
          colors: undefined,
          opacity: 0.9
      },  
      padding: {
          top: 0,
          right: 0,
          bottom: 0,
          left: 10
      },  
    },
    xaxis: {
      categories: ["Day 1", "Day 2", "Day 3", "Day 4", "Day 5", "Day 6", "Day 7"],
    },
    legend: {
      show: false,
    },

    tooltip: {
      y: {
        formatter: function (val) {
          return "Total " + val + " Orders";
        },
      },
      marker: {
        show: true,
      },
    },
  };

  var chart = new ApexCharts(
    document.querySelector("#overview_trend"),
    line_options
  );
  chart.render();
		
  $(".donut").peity("donut");
	
	
}); // End of use strict
