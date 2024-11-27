document.addEventListener('DOMContentLoaded', function () {
    fetch('fetch_statistics.php')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok: ' + response.statusText);
            }
            return response.json();
        })
        .then(data => {
            createLineChart(data);
            createStatisticalChart(data);
        })
        .catch(error => {
            console.error('Error fetching statistics:', error);
        });
});

// Function to create the multiple lines chart
function createLineChart(data) {
    const ctxLine = document.getElementById('lineChart').getContext('2d');

    const lineChart = new Chart(ctxLine, {
        type: 'line',
        data: {
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
            datasets: [
                {
                    label: 'Food Orders',
                    data: data.foodOrdersMonthly, // Example data array for monthly food orders
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: true,
                    tension: 0.3,
                },
                {
                    label: 'Table Reservations',
                    data: data.tableReservationsMonthly, // Example data array for monthly table reservations
                    borderColor: 'rgba(255, 99, 132, 1)',
                    backgroundColor: 'rgba(255, 99, 132, 0.2)',
                    fill: true,
                    tension: 0.3,
                },
                {
                    label: 'Parking Bookings',
                    data: data.parkingBookingsMonthly, // Example data array for monthly parking bookings
                    borderColor: 'rgba(54, 162, 235, 1)',
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    fill: true,
                    tension: 0.3,
                },
            ],
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function (tooltipItem) {
                            return `${tooltipItem.dataset.label}: ${tooltipItem.raw}`;
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false,
                    },
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(200, 200, 200, 0.3)',
                    },
                }
            }
        }
    });
}

// Function to create the bar chart for statistics
function createStatisticalChart(data) {
    const ctxBar = document.getElementById('statisticalChart').getContext('2d');

    const statisticalChart = new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: ['Total Users', 'Total Foods', 'Total Orders', 'Total Reservations', 'Total Parking Bookings', 'Total Customers', 'Total Operational Staff', 'Total Admins'],
            datasets: [{
                label: 'Statistics',
                data: [data.total_users, data.total_food, data.total_orders, data.total_reservations, data.total_parking_bookings, data.customers, data.operational_staff, data.admins],
                backgroundColor: 'rgba(54, 162, 235, 0.8)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 2,
                borderRadius: 5,
                hoverBackgroundColor: 'rgba(75, 192, 192, 0.6)',
                hoverBorderColor: 'rgba(255, 206, 86, 1)',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                },
                tooltip: {
                    callbacks: {
                        label: function (tooltipItem) {
                            return `${tooltipItem.dataset.label}: ${tooltipItem.raw}`;
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false,
                    },
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(200, 200, 200, 0.3)',
                    },
                }
            }
        }
    });
}
