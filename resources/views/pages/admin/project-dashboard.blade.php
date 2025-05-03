@extends('layouts.app', ['pageSlug' => 'dashboard'])

@section('content')
    <style>
        .card {
            height: 100%;
            margin-bottom: 20px;
        }
            .card-body {
                height: 100%;
                min-height: 250px;
                padding: 20px;
                display: flex;
                flex-direction: column;
            }
            .phase-item {
                height: 100%;
                padding: 20px;
                border-radius: 8px;
                background: rgba(255, 255, 255, 0.05);
                margin-bottom: 0;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
            }
            .phase-item i {
                font-size: 24px;
                margin-bottom: 15px;
            }
            .progress-circle {
                width: 60px;
                height: 60px;
                margin: 0 auto 15px;
                border-radius: 50%;
                background: rgba(76, 175, 80, 0.1);
                border: 3px solid #4CAF50;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .launch-date-card {
                height: 100%;
                background: rgba(76, 175, 80, 0.1);
                border-radius: 8px;
                padding: 20px;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
            }
            .launch-date-card i {
                font-size: 32px;
                margin-bottom: 15px;
            }
            .row {
                margin-bottom: 20px;
            }
            /* Add progress bar styles */
            .progress-bar-container {
                width: 100%;
                background: rgba(255, 255, 255, 0.1);
                height: 8px;
                border-radius: 4px;
                margin-bottom: 20px;
            }
            .progress-bar-fill {
                height: 100%;
                background: #4CAF50;
                border-radius: 4px;
                width: 54%;
            }

        /* Budget styles */
        /* Update the budget card styles */
        .budget-card {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            padding: 15px;
            height: 300px; /* Increased height */
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Add this to ensure the canvas takes full space */
        .budget-card canvas {
            width: 100% !important;
            height: 100% !important;
        }
        .budget-info {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .budget-stat {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
            padding: 15px;
            display: flex;
            align-items: center;
            gap: 15px;
        }
        .budget-icon {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .budget-warning {
            background: rgba(255, 82, 82, 0.1);
            border-radius: 8px;
            padding: 10px;
            text-align: center;
        }

        /* Add any missing styles for risk-item and summary-details if needed */
        .risk-item {
            margin-bottom: 20px;
        }
        .summary-details {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .summary-item {
            display: flex;
            justify-content: space-between;
            padding: 10px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 8px;
        }
        .card {
            height: 100%;
            margin-bottom: 20px;
        }
        .card-body {
            height: 100%;
            min-height: 250px;
            padding: 20px;
            display: flex;
            flex-direction: column;
        }
        .phase-item {
            height: 100%;
            padding: 20px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.05);
            margin-bottom: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            min-height: 160px;
        }

        .progress-circle {
            width: 60px;
            height: 60px;
            margin: 0 auto 15px;
            border-radius: 50%;
            background: rgba(76, 175, 80, 0.1);
            border: 3px solid #4CAF50;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        .progress-circle h4 {
            margin: 0;
            font-size: 18px;
            color: #4CAF50;
        }

        .phase-item::after {
            content: '';
            position: absolute;
            right: -50%;
            top: 45px;
            width: 100%;
            height: 2px;
            background: rgba(255, 255, 255, 0.1);
            z-index: 0;
        }

        .phase-item:last-child::after {
            display: none;
        }

            /* Timeline styles */
    .timeline-item {
        padding-left: 15px;
        border-left: 2px solid rgba(255, 255, 255, 0.1);
        margin-bottom: 20px;
    }
    .timeline-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Cost Analysis styles */
    .cost-item {
        background: rgba(255, 255, 255, 0.05);
        padding: 15px;
        border-radius: 8px;
    }

    /* Timeline & Milestones styles */
    .timeline-horizontal {
        display: flex;
        justify-content: space-between;
        position: relative;
        padding: 20px 0;
    }
    .timeline-horizontal::before {
        content: '';
        position: absolute;
        top: 50%;
        left: 0;
        right: 0;
        height: 2px;
        background: rgba(255, 255, 255, 0.1);
    }
    .milestone {
        text-align: center;
        position: relative;
        z-index: 1;
    }
    .milestone-marker {
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #2c2c2c;
        border: 2px solid #4CAF50;
        margin: 0 auto 10px;
    }
    .milestone.completed .milestone-marker {
        background: #4CAF50;
    }
    .milestone.current .milestone-marker {
        background: #2196F3;
        border-color: #2196F3;
    }

    /* Health Indicators styles */
    .health-item .progress {
        height: 8px;
        background: rgba(255, 255, 255, 0.1);
    }

    .milestone-table .status-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            display: inline-block;
            margin-right: 8px;
        }
    .status-dot.green { background: #4CAF50; }
    .status-dot.yellow { background: #FFC107; }
    .status-dot.red { background: #f44336; }

    .overdue-badge {
            background: rgba(244, 67, 54, 0.1);
            color: #f44336;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
    }
    </style>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="row">
                    <div class="col-md-9">
                        <form action="{{ route('pages.admin.project-dashboard') }}" method="get">
                            <input type="text" name="project_name" id="project_name" class="form-control" placeholder="Enter a project name...">
                        </form>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-primary btn-block">Search</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Overall Progress, Project Summary, Launch Date -->
    <div class="row">
        <!-- Overall Progress -->
        <div class="col-lg-3">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-category">Overall Progress</h5>
                    <div id="progressChart" class="mt-3"></div>
                </div>
            </div>
        </div>

        <!-- Project Summary -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-category">Project Summary</h5>
                    <div class="summary-details mt-3">
                        <div class="summary-item text-light bg-dark">
                            <span>Start Date:</span>
                            <span>2017-05-01</span>
                        </div>
                        <div class="summary-item text-light bg-dark">
                            <span>End Date:</span>
                            <span>2017-12-15</span>
                        </div>
                        <div class="summary-item text-light bg-dark">
                            <span>Officer-in-Charge:</span>
                            <span>Pg Ayatol</span>
                        </div>
                        <div class="summary-item text-light bg-dark">
                            <span>Overall Status:</span>
                            <span class="text-success">In Time</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Projected Launch Date -->
        <div class="col-lg-3">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-category">Projected Launch Date</h5>
                    <div class="launch-date-card mt-3">
                        <i class="tim-icons icon-calendar-60 text-success"></i>
                        <h4>Friday, December 15</h4>
                        <h3 class="text-success mt-2">121 Days</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Second row Project Phases -->
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-category">Project Development Stages</h5>
                    <div class="progress-bar-container mt-3">
                        <div class="progress-bar-fill"></div>
                    </div>
                    <div class="row h-100 align-items-center">
                        <div class="col">
                            <div class="phase-item completed">
                                <i class="tim-icons icon-check-2 text-success"></i>
                                <h6>Pre-Design</h6>
                                <span class="text-success">Completed</span>
                            </div>
                        </div>
                        <div class="col">
                            <div class="phase-item completed">
                                <i class="tim-icons icon-check-2 text-success"></i>
                                <h6>Design</h6>
                                <span class="text-success">Completed</span>
                            </div>
                        </div>
                        <div class="col">
                            <div class="phase-item in-progress">
                                <div class="progress-circle">
                                    <h4>67%</h4>
                                </div>
                                <h6>Tender</h6>
                                <span class="text-info">In Progress</span>
                            </div>
                        </div>
                        <div class="col">
                            <div class="phase-item waiting">
                                <i class="tim-icons icon-time-alarm text-muted"></i>
                                <h6>Construction</h6>
                                <span class="text-muted">Waiting</span>
                            </div>
                        </div>
                        <div class="col">
                            <div class="phase-item waiting">
                                <i class="tim-icons icon-time-alarm text-muted"></i>
                                <h6>Post-Completion</h6>
                                <span class="text-muted">Waiting</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Third row: Budget, Milestones, and Project Updates -->
    <div class="row mt-4">
        <!-- Left Column: Budget and Milestones -->
        <div class="col-lg-8">
            <!-- Upcoming Milestones -->
            <div class="row mb-4">
                <div class="col-lg-7">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-category">Upcoming Milestones</h5>
                            <div class="table-responsive">
                                <table class="table milestone-table">
                                    <thead>
                                        <tr>
                                            <th>Task</th>
                                            <th>Due Date</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Tender Documentation</td>
                                            <td>2017-09-15</td>
                                            <td>
                                                <span class="status-dot green"></span>
                                                On Track
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Contractor Selection</td>
                                            <td>2017-09-30</td>
                                            <td>
                                                <span class="status-dot yellow"></span>
                                                At Risk
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Construction Planning</td>
                                            <td>2017-10-15</td>
                                            <td>
                                                <span class="status-dot green"></span>
                                                On Track
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-category">Overdue Milestones</h5>
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <td>
                                                <span class="overdue-badge">5 days</span>
                                                Budget Review Meeting
                                            </td>
                                            <td>2017-08-15</td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <span class="overdue-badge">3 days</span>
                                                Tender Documents Review
                                            </td>
                                            <td>2017-08-17</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Project Budget -->
            <div class="row">
                <div class="col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-category">Project Budget</h5>
                            <div class="row">
                                <div class="col-md-8">
                                    <div class="budget-card">
                                        <canvas id="budgetChart"></canvas>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="budget-info">
                                        <div class="budget-stat">
                                            <div class="budget-icon bg-info">
                                                <i class="tim-icons icon-coins text-info"></i>
                                            </div>
                                            <div>
                                                <h6 class="text-muted">Total Budget</h6>
                                                <h3>$52,000</h3>
                                            </div>
                                        </div>
                                        <div class="budget-stat">
                                            <div class="budget-icon bg-success">
                                                <i class="tim-icons icon-wallet-43 text-success"></i>
                                            </div>
                                            <div>
                                                <h6 class="text-muted">Remaining</h6>
                                                <h3>$8,770</h3>
                                            </div>
                                        </div>
                                        <div class="budget-warning">
                                            <i class="tim-icons icon-alert-circle-exc"></i>
                                            <h5 class="text-danger mb-0">8.1% Over Target</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-category">Project Health</h5>
                            <div class="health-indicators mt-3">
                                <div class="health-item mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Schedule Performance</span>
                                        <span class="text-success">92%</span>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-success" role="progressbar" style="width: 92%"></div>
                                    </div>
                                </div>
                                <div class="health-item mb-3">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Quality Metrics</span>
                                        <span class="text-info">87%</span>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-info" role="progressbar" style="width: 87%"></div>
                                    </div>
                                </div>
                                <div class="health-item">
                                    <div class="d-flex justify-content-between mb-1">
                                        <span>Team Velocity</span>
                                        <span class="text-warning">76%</span>
                                    </div>
                                    <div class="progress">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: 76%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Project Updates -->
        <div class="col-lg-4">
            <div class="card" style="height: calc(100% - 20px);">
                <div class="card-body">
                    <h5 class="card-category">Recent Project Updates</h5>
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="d-flex align-items-center mb-3">
                                <div class="timeline-icon bg-info">
                                    <i class="tim-icons icon-notes text-info"></i>
                                </div>
                                <div class="ml-3">
                                    <h6 class="mb-0">Design Documentation Updated</h6>
                                    <small class="text-muted">2 hours ago by Amal</small>
                                    <p class="mb-0 mt-2">Updated UI/UX specifications for mobile view</p>
                                </div>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="d-flex align-items-center mb-3">
                                <div class="timeline-icon bg-success">
                                    <i class="tim-icons icon-check-2 text-success"></i>
                                </div>
                                <div class="ml-3">
                                    <h6 class="mb-0">Mobile View Configuration Completed</h6>
                                    <small class="text-muted">Yesterday by Amal</small>
                                    <p class="mb-0 mt-2">Responsive design implementation finished</p>
                                </div>
                            </div>
                        </div>
                        <div class="timeline-item">
                            <div class="d-flex align-items-center">
                                <div class="timeline-icon bg-warning">
                                    <i class="tim-icons icon-alert-circle-exc text-warning"></i>
                                </div>
                                <div class="ml-3">
                                    <h6 class="mb-0">Budget Adjustment Required</h6>
                                    <small class="text-muted">2 days ago by Amal</small>
                                    <p class="mb-0 mt-2">Additional resources needed for testing phase</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('black') }}/js/plugins/chartjs.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        $(document).ready(function() {
            // Overall Progress Chart
            var options = {
                series: [78],
                chart: {
                    height: 200,
                    type: 'radialBar',
                },
                plotOptions: {
                    radialBar: {
                        hollow: {
                            size: '70%',
                        },
                        track: {
                            background: '#2c2c2c',
                        },
                        dataLabels: {
                            name: {
                                show: false
                            },
                            value: {
                                fontSize: '24px',
                                color: '#fff',
                                formatter: function (val) {
                                    return val + '%'
                                }
                            }
                        }
                    },
                },
                colors: ['#4CAF50'],
            };

            var chart = new ApexCharts(document.querySelector("#progressChart"), options);
            chart.render();

            // Project Budget Chart
            const budgetCtx = document.getElementById('budgetChart').getContext('2d');
            // In your JavaScript, update the Chart options
            new Chart(budgetCtx, {
                type: 'bar',
                data: {
                    labels: ['Total Budget', 'Amount Used', 'Target Amount'],
                    datasets: [{
                        data: [52000, 44230, 46000],
                        backgroundColor: ['#2196F3', '#4CAF50', '#FFC107'],
                        barThickness: 20
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    layout: {
                        padding: {
                            left: 20,
                            right: 30,
                            top: 10,
                            bottom: 10
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        x: {
                            grid: {
                                color: 'rgba(255, 255, 255, 0.1)'
                            },
                            ticks: {
                                color: '#fff',
                                font: {
                                    size: 12
                                }
                            }
                        },
                        y: {
                            grid: {
                                display: false
                            },
                            ticks: {
                                color: '#fff',
                                font: {
                                    size: 12
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush
