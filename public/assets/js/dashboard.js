(function ($) {
  'use strict';
  if ($("#visit-sale-chart").length) {
    const ctx = document.getElementById('visit-sale-chart');
    //chowdeck
    var graphGradient1 = document.getElementById('visit-sale-chart').getContext("2d");
    //glovo
    var graphGradient2 = document.getElementById('visit-sale-chart').getContext("2d");
    //eden
    var graphGradient3 = document.getElementById('visit-sale-chart').getContext("2d");

    var gradientStrokeViolet = graphGradient1.createLinearGradient(0, 0, 0, 181);
    gradientStrokeViolet.addColorStop(0, 'rgba(12, 81, 63, 1)');
    gradientStrokeViolet.addColorStop(1, 'rgba(12, 81, 63, 1)');
    var gradientLegendViolet = 'linear-gradient(to right, rgba(12, 81, 63, 1), rgba(12, 81, 63, 1))';

    var gradientStrokeBlue = graphGradient2.createLinearGradient(0, 0, 0, 360);
    gradientStrokeBlue.addColorStop(0, 'rgba(255, 194, 68, 1)');
    gradientStrokeBlue.addColorStop(1, 'rgba(255, 194, 68, 1)');
    var gradientLegendBlue = 'linear-gradient(to right, rgba(255, 194, 68, 1), rgba(255, 194, 68, 1))';

    var gradientStrokeRed = graphGradient3.createLinearGradient(0, 0, 0, 300);
    gradientStrokeRed.addColorStop(0, 'rgba(162, 153, 149, 1)');
    gradientStrokeRed.addColorStop(1, 'rgba(162, 153, 149, 1)');
    var gradientLegendRed = 'linear-gradient(to right, rgba(162, 153, 149, 1), rgba(162, 153, 149, 1))';
    const bgColor1 = ["rgba(12, 81, 63, 1)"];
    const bgColor2 = ["rgba(255, 194, 68, 1"];
    const bgColor3 = ["rgba(162, 153, 149, 1)"];

    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEPT', 'OCT', 'NOV', 'DEC'],
        datasets: [{
          label: "Chowdeck",
          borderColor: gradientStrokeViolet,
          backgroundColor: gradientStrokeViolet,
          fillColor: bgColor1,
          hoverBackgroundColor: gradientStrokeViolet,
          pointRadius: 0,
          fill: false,
          borderWidth: 1,
          fill: 'origin',
          data: [20, 40, 15, 35, 25, 50, 30, 20, 30, 45, 48, 80],
          barPercentage: 0.5,
          categoryPercentage: 0.5,
        },
        {
          label: "Glovo",
          borderColor: gradientStrokeRed,
          backgroundColor: gradientStrokeRed,
          hoverBackgroundColor: gradientStrokeRed,
          fillColor: bgColor2,
          pointRadius: 0,
          fill: false,
          borderWidth: 1,
          fill: 'origin',
          data: [40, 30, 20, 10, 50, 15, 35, 40, 35, 43, 55, 65],
          barPercentage: 0.5,
          categoryPercentage: 0.5,
        },
        {
          label: "Eden",
          borderColor: gradientStrokeBlue,
          backgroundColor: gradientStrokeBlue,
          hoverBackgroundColor: gradientStrokeBlue,
          fillColor: bgColor3,
          pointRadius: 0,
          fill: false,
          borderWidth: 1,
          fill: 'origin',
          data: [70, 10, 30, 40, 25, 50, 15, 30, 35, 41, 45, 77],
          barPercentage: 0.5,
          categoryPercentage: 0.5,
        }
        ]
      },
      options: {
        responsive: true,
        maintainAspectRatio: true,
        elements: {
          line: {
            tension: 0.4,
          },
        },
        scales: {
          y: {
            display: false,
            grid: {
              display: true,
              drawOnChartArea: true,
              drawTicks: false,
            },
          },
          x: {
            display: true,
            grid: {
              display: false,
            },
          }
        },
        plugins: {
          legend: {
            display: false,
          }
        }
      },
      plugins: [{
        afterDatasetUpdate: function (chart, args, options) {
          const chartId = chart.canvas.id;
          var i;
          const legendId = `${chartId}-legend`;
          const ul = document.createElement('ul');
          for (i = 0; i < chart.data.datasets.length; i++) {
            ul.innerHTML += `
              <li>
                <span style="background-color: ${chart.data.datasets[i].fillColor}"></span>
                ${chart.data.datasets[i].label}
              </li>
            `;
          }
          // alert(chart.data.datasets[0].backgroundColor);
          return document.getElementById(legendId).appendChild(ul);
        }
      }]
    });
  }
 
  if ($("#traffic-chart").length) {
    const ctx = document.getElementById('traffic-chart');
    //chowdeck
    var graphGradient1 = document.getElementById("traffic-chart").getContext('2d');
    //glovo
    var graphGradient2 = document.getElementById("traffic-chart").getContext('2d');
   //eden
    var graphGradient3 = document.getElementById("traffic-chart").getContext('2d');
//chowdeck
    var gradientStrokeBlue = graphGradient1.createLinearGradient(0, 0, 0, 181);
    gradientStrokeBlue.addColorStop(0, 'rgba(12, 81, 63, 1)');
    gradientStrokeBlue.addColorStop(1, 'rgba(12, 81, 63, 1)');
    var gradientLegendBlue = 'rgba(12, 81, 63, 1)';

//glovo
    var gradientStrokeRed = graphGradient2.createLinearGradient(0, 0, 0, 50);
    gradientStrokeRed.addColorStop(0, 'rgba(255, 194, 68, 1)');
    gradientStrokeRed.addColorStop(1, 'rgba(255, 194, 68, 1)');
    var gradientLegendRed = 'rgba(255, 194, 68, 1)';
//eden
    var gradientStrokeGreen = graphGradient3.createLinearGradient(0, 0, 0, 300);
    gradientStrokeGreen.addColorStop(0, 'rgba(162, 153, 149, 1)');
    gradientStrokeGreen.addColorStop(1, 'rgba(162, 153, 149, 1)');
    var gradientLegendGreen = 'rgba(162, 153, 149, 1)';

    // const bgColor1 = ["rgba(54, 215, 232, 1)"];
    // const bgColor2 = ["rgba(255, 191, 150, 1"];
    // const bgColor3 = ["rgba(6, 185, 157, 1)"];

    new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: ['Chowdeck: 0%', 'Glovo: 0%', 'Eden: 0%'],
        datasets: [{
          data: [40, 20, 10],
          backgroundColor: [gradientStrokeBlue, gradientStrokeRed, gradientStrokeGreen],
          hoverBackgroundColor: [
            gradientStrokeBlue,
            gradientStrokeRed,
            gradientStrokeGreen
           
          ],
          borderColor: [
            gradientStrokeBlue,
            gradientStrokeRed,
            gradientStrokeGreen
           
          ],
          legendColor: [
            gradientLegendBlue,
            gradientLegendRed,
            gradientLegendGreen
           
          ]
        }]
      },
      options: {
        cutout: 50,
        animationEasing: "easeOutBounce",
        animateRotate: true,
        animateScale: false,
        responsive: true,
        maintainAspectRatio: true,
        showScale: true,
        legend: false,
        plugins: {
          legend: {
            display: false,
          }
        }
      },
      plugins: [{
        afterDatasetUpdate: function (chart, args, options) {
          const chartId = chart.canvas.id;
          var i;
          const legendId = `${chartId}-legend`;
          const ul = document.createElement('ul');
          for (i = 0; i < chart.data.datasets[0].data.length; i++) {
            ul.innerHTML += `
                <li>
                  <span style="background-color: ${chart.data.datasets[0].legendColor[i]}"></span>
                  ${chart.data.labels[i]}
                </li>
              `;
          }
          return document.getElementById(legendId).appendChild(ul);
        }
      }]
    });
  }



  if ($("#inline-datepicker").length) {
    $('#inline-datepicker').datepicker({
      enableOnReadonly: true,
      todayHighlight: true,
    });
  }
  if ($.cookie('purple-pro-banner') != "true") {
    document.querySelector('#proBanner').classList.add('d-flex');
    document.querySelector('.navbar').classList.remove('fixed-top');
  } else {
    document.querySelector('#proBanner').classList.add('d-none');
    document.querySelector('.navbar').classList.add('fixed-top');
  }

  if ($(".navbar").hasClass("fixed-top")) {
    document.querySelector('.page-body-wrapper').classList.remove('pt-0');
    document.querySelector('.navbar').classList.remove('pt-5');
  } else {
    document.querySelector('.page-body-wrapper').classList.add('pt-0');
    document.querySelector('.navbar').classList.add('pt-5');
    document.querySelector('.navbar').classList.add('mt-3');

  }
  document.querySelector('#bannerClose').addEventListener('click', function () {
    document.querySelector('#proBanner').classList.add('d-none');
    document.querySelector('#proBanner').classList.remove('d-flex');
    document.querySelector('.navbar').classList.remove('pt-5');
    document.querySelector('.navbar').classList.add('fixed-top');
    document.querySelector('.page-body-wrapper').classList.add('proBanner-padding-top');
    document.querySelector('.navbar').classList.remove('mt-3');
    var date = new Date();
    date.setTime(date.getTime() + 24 * 60 * 60 * 1000);
    $.cookie('purple-pro-banner', "true", {
      expires: date
    });
  });
})(jQuery);