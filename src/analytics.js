import "./styles/analytics.css"

const ctx = document.getElementById("myChart");
const ctx2 = document.getElementById("myChart2");
const ctx3 = document.getElementById("myChart3");


new Chart(ctx, {
  type: "doughnut",
  data: {
    labels: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
    datasets: [
      {
        label: "Reserved Seats",
        data: [201, 365, 387, 403, 352, 321, 204],
        borderWidth: 1,
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
    labels: ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"],
    datasets: [
      {
        label: "This Weeks No. of Reserved Seat",
        data: [201, 365, 387, 403, 352, 321, 204],
        borderWidth: 1,
      },
    ],
  },
  
  options: {
    responsive: true,
  },
});

new Chart(ctx3, {
    type: "line",
    data: {
      labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
      datasets: [
        {
          label: "Monthly",
          data: [5684, 8764, 9912, 11984, 11256, 10276, 10136, 11200, 9072, 12656, 11872, 11592],
          borderWidth: 1,
        },{
            label: "Weekly",
            data: [1421, 2191, 2478, 2996, 2814, 2569, 2534, 2800, 2268, 3164, 2968, 2898],
            borderWidth: 1,
        },{
            label: "Daily",
            data: [203, 313, 354, 428, 402, 367, 362, 400, 324, 452, 424, 414 ],
            borderWidth: 1,
        },
      ],
    },
    
    options: {
      responsive: true,
    },
  });
  