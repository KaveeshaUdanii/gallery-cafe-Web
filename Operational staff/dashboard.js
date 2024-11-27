// Reservations Bar Chart (Indoor vs Outdoor)
const reservationsBarCtx = document.getElementById('reservationsBarChart').getContext('2d');
const reservationsBarChart = new Chart(reservationsBarCtx, {
    type: 'bar',
    data: reservationsData,
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Parking Bookings Pie Chart (Confirmed vs Pending)
const parkingPieCtx = document.getElementById('parkingPieChart').getContext('2d');
const parkingPieChart = new Chart(parkingPieCtx, {
    type: 'pie',
    data: parkingData
});

// Food Sales by Category Bar Chart
const foodSalesBarCtx = document.getElementById('foodSalesBarChart').getContext('2d');
const foodSalesBarChart = new Chart(foodSalesBarCtx, {
    type: 'bar',
    data: foodSalesData,
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Tables Availability Bar Chart
const tablesAvailabilityCtx = document.getElementById('tablesAvailabilityChart').getContext('2d');
const tablesAvailabilityChart = new Chart(tablesAvailabilityCtx, {
    type: 'bar',
    data: tablesAvailabilityData,
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Recent Food Orders Line Chart
const recentOrdersCtx = document.getElementById('recentOrdersChart').getContext('2d');
const recentOrdersChart = new Chart(recentOrdersCtx, {
    type: 'line',
    data: recentOrdersData,
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
