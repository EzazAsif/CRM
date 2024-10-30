<?php?
/**
 * 
 * This file contains the HTML and JavaScript code to render various charts for analytics and reporting
 * using the Chart.js library. The charts included are:
 * 
 * 1. Sales Performance (Bar Chart)
 * 2. Customer Engagement (Line Chart)
 * 3. Campaign Performance (Pie Chart)
 * 4. Support Response Times (Doughnut Chart)
 * 
 * The charts are displayed within Bootstrap cards for a responsive and organized layout.
 * 
 * Dependencies:
 * - Chart.js
 * - Bootstrap 4
 * - jQuery
 * 
 * JavaScript Code:
 * - Initializes and configures each chart with sample data and options.
 * 
 * HTML Structure:
 * - A container with multiple rows and columns to hold the charts.
 * - Each chart is placed inside a Bootstrap card for better presentation.
 * 
 * External Scripts:
 * - jQuery (https://code.jquery.com/jquery-3.5.1.slim.min.js)
 * - Popper.js (https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js)
 * - Bootstrap JS (https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js)
 */

>
<div class="container mt-5">
    <h2 class="text-center">Analytics and Reporting</h2>
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Sales Performance</h5>
                    <canvas id="salesChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Customer Engagement</h5>
                    <canvas id="engagementChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Campaign Performance</h5>
                    <canvas id="campaignChart"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Support Response Times</h5>
                    <canvas id="supportChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- JavaScript to generate Charts using Chart.js -->
<script>
    // Sales Chart
    var salesChartCtx = document.getElementById('salesChart').getContext('2d');
    var salesChart = new Chart(salesChartCtx, {
        type: 'bar',
        data: {
            labels: ['Q1', 'Q2', 'Q3', 'Q4'],
            datasets: [{
                label: 'Sales ($)',
                data: [15000, 20000, 18000, 22000],
                backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545']
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Customer Engagement Chart
    var engagementChartCtx = document.getElementById('engagementChart').getContext('2d');
    var engagementChart = new Chart(engagementChartCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'Engagement Rate (%)',
                data: [20, 25, 22, 30, 27, 35],
                backgroundColor: 'rgba(40, 167, 69, 0.2)',
                borderColor: '#28a745',
                borderWidth: 2,
                fill: true
            }]
        },
        options: {
            responsive: true
        }
    });

    // Campaign Performance Chart
    var campaignChartCtx = document.getElementById('campaignChart').getContext('2d');
    var campaignChart = new Chart(campaignChartCtx, {
        type: 'pie',
        data: {
            labels: ['Email Campaign', 'Social Media', 'PPC', 'SEO'],
            datasets: [{
                data: [40, 30, 20, 10],
                backgroundColor: ['#007bff', '#ffc107', '#28a745', '#dc3545']
            }]
        },
        options: {
            responsive: true
        }
    });

    // Support Response Times Chart
    var supportChartCtx = document.getElementById('supportChart').getContext('2d');
    var supportChart = new Chart(supportChartCtx, {
        type: 'doughnut',
        data: {
            labels: ['<1 hour', '1-4 hours', '4-24 hours', '24+ hours'],
            datasets: [{
                data: [50, 30, 15, 5],
                backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545']
            }]
        },
        options: {
            responsive: true
        }
    });
</script>

<!-- Bootstrap JS and jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>