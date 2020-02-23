let url = window.location;
let protocol = url.protocol;
let hostname = url.hostname;
let port = url.port;
const baseUrl =
  hostname == "localhost"
    ? `${protocol}//${hostname}:${port}/`
    : `${protocol}//${hostname}/`;
$(".table").DataTable();
let dataAntrian;
let chart;
$(document).ready(async function() {
  dataAntrian = (await $.ajax(`${baseUrl}api/v1/queue/admin/date`)).message;
  console.log(dataAntrian);
  chart = await initChart();
});

async function updateData(obj) {
  dataAntrian = (await $.ajax(`${baseUrl}api/v1/queue/admin/date/${obj.value}`))
    .message;
  console.log(dataAntrian);
  let label = generateLabels();
  let data = generateData();
  console.log(chart.data.datasets[0].data.length);
  chart.data.labels = label;
  chart.data.datasets[0].data = data
  chart.update();
}

function generateLabels() {
  let chartLabels = [];
  dataAntrian.forEach(e => {
    chartLabels.push(e.tanggal_pembuatan);
  });
  return chartLabels;
}

function generateData() {
  let chartData = [];
  dataAntrian.forEach(e => {
    chartData.push(e.jumlah);
  });
  return chartData;
}

function initChart() {
  let ctx = $("#myAreaChart");
  var myLineChart = new Chart(ctx, {
    type: "line",
    data: {
      labels: generateLabels(),
      datasets: [
        {
          label: "Jumlah Antrian",
          lineTension: 0.3,
          backgroundColor: "rgba(78, 115, 223, 0.05)",
          borderColor: "rgba(78, 115, 223, 1)",
          pointRadius: 3,
          pointBackgroundColor: "rgba(78, 115, 223, 1)",
          pointBorderColor: "rgba(78, 115, 223, 1)",
          pointHoverRadius: 3,
          pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
          pointHoverBorderColor: "rgba(78, 115, 223, 1)",
          pointHitRadius: 10,
          pointBorderWidth: 2,
          data: generateData()
        }
      ]
    },
    options: {
      maintainAspectRatio: false,
      layout: {
        padding: {
          left: 10,
          right: 25,
          top: 25,
          bottom: 0
        }
      },
      scales: {
        xAxes: [
          {
            time: {
              unit: "date"
            },
            gridLines: {
              display: false,
              drawBorder: false
            },
            ticks: {
              maxTicksLimit: 7
            }
          }
        ],
        yAxes: [
          {
            ticks: {
              maxTicksLimit: 5,
              padding: 10
            },
            gridLines: {
              color: "rgb(234, 236, 244)",
              zeroLineColor: "rgb(234, 236, 244)",
              drawBorder: false,
              borderDash: [2],
              zeroLineBorderDash: [2]
            }
          }
        ]
      },
      legend: {
        display: false
      },
      tooltips: {
        backgroundColor: "rgb(255,255,255)",
        bodyFontColor: "#858796",
        titleMarginBottom: 10,
        titleFontColor: "#6e707e",
        titleFontSize: 14,
        borderColor: "#dddfeb",
        borderWidth: 1,
        xPadding: 15,
        yPadding: 15,
        displayColors: false,
        intersect: false,
        mode: "index",
        caretPadding: 10
      },
      plugins: {
        zoom: {
          pan: {
            enabled: true,
            mode: "x"
          },
          zoom: {
            enabled: true,
            drag: true,
            mode: "x",
            speed: 10
          }
        }
      }
    }
  });
  return myLineChart;
}
