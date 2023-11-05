import "./styles/analytics.css"

console.log('Weekly Data:', weeklyData);
const ctx = document.getElementById("myChart").getContext("2d");
const ctx2 = document.getElementById("myChart2").getContext("2d");

new Chart(ctx, {
  type: "doughnut",
  data: {
    labels: collegeCodes,
    datasets: [
      {
        label: "Reservations by College",
        data: userCounts,
        backgroundColor: [
          'rgba(255, 99, 132, 0.7)',
          'rgba(54, 162, 235, 0.7)',
          'rgba(255, 206, 86, 0.7)',
          'rgba(75, 192, 192, 0.7)',
          'rgba(153, 102, 255, 0.7)',
          'rgba(255, 159, 64, 0.7)',
          'rgba(100, 100, 100, 0.7)',
          'rgba(100, 200, 150, 0.7)',
          'rgba(255, 120, 100, 0.7)',
          'rgba(60, 100, 80, 0.7)',
          'rgba(70, 100, 255, 0.7)',
        ],
      },
    ],
  },
  options: {
    responsive: true,
  },
});

new Chart(ctx2, {
  type: "bar",
  data: {
    labels: daysOfWeek,
    datasets: [
      {
        label: "Successful Reservations",
        data: reservationCounts2,
        borderWidth: 1,
      },
    ],
  },
  options: {
    responsive: true,
  },
});

var chartConfig = {
  type: "line",
  data: {
    labels: monthLabels,
    datasets: [
      {
        label: "Monthly",
        data: finalData,
        borderWidth: 1,
      },
    ],
  },
  options: {
    responsive: true,
  },
};

var ctx3 = document.getElementById('myChart3').getContext('2d');
var myChart = new Chart(ctx3, chartConfig);

document.getElementById('yearSelect').addEventListener('change', function() {
  updateChart();
});

function updateChart() {
  var selectedYear = document.getElementById('yearSelect').value;
  var xhr = new XMLHttpRequest();
  xhr.open('GET', 'get_monthly_data.php?year=' + selectedYear, true);

  xhr.onload = function() {
    if (xhr.status === 200) {
      var responseData = JSON.parse(xhr.responseText);
      myChart.data.datasets[0].data = responseData.finalData;
      myChart.update();
    }
  };

  xhr.send();
}
