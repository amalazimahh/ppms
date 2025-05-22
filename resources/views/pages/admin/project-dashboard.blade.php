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
                background: rgba(152, 76, 175, 0.1);
                border: 3px solid #823a97;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .launch-date-card {
                height: 100%;
                border-radius: 8px;
                padding: 20px;
                display: flex;
                flex-direction: column;
                justify-content: center;
                align-items: center;
            }
            .launch-date-card i {
                font-size: 64px;
                margin-bottom: 15px;
            }
            .row {
                margin-bottom: 20px;
            }
            /* Add progress bar styles */
            .progress-bar-container {
                width: 100%;
                background: rgba(255, 255, 255, 0.1);
                height: 20px;
                border-radius: 4px;
                margin-bottom: 20px;
            }
            .progress-bar-fill {
                height: 100%;
                background: #ad23cf;
                border-radius: 10px;
                width: 72%;
            }

        /* budget card styles */
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
            border-bottom: 1px solid rgba(255,255,255,0.08);
            background: transparent;
        }

        .summary-item:last-child{
            border-bottom: none;
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

        .progress-circle h4 {
            margin: 0;
            font-size: 18px;
            color:rgb(166, 141, 182);
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

    /* timeline styles */
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

    /* cost analysis styles */
    .cost-item {
        background: rgba(255, 255, 255, 0.05);
        padding: 15px;
        border-radius: 8px;
    }

    /* timeline & milestones styles */
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

    /* health indicators styles */
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
                <form action="{{ route('pages.admin.project-dashboard') }}" method="get">
                    <div class="row align-items-center">
                        <div class="col-md-9">
                            <input type="text" name="project_name" id="project_name" class="form-control" placeholder="Enter a project name...">
                        </div>
                        <div class="col-md-3">
                            <button class="btn btn-primary btn-block">Search</button>
                        </div>
                    </div>
                </form>
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
                        <div class="summary-item text-light">
                            <span>Project Handover (to DoD):</span>
                            <span>22-05-2023</span>
                        </div>
                        <div class="summary-item text-light">
                            <span>Project Handover (to Client Ministry):</span>
                            <span>N/A</span>
                        </div>
                        <div class="summary-item text-light">
                            <span>Officer-in-Charge:</span>
                            <span>Mohd</span>
                        </div>
                        <div class="summary-item text-light">
                            <span>Stage:</span>
                            <span class="text-primary">Ongoing (Construction)</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Projected Launch Date -->
        <div class="col-lg-3">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-category">Countdown to Launch</h5>
                    <div class="launch-date-card mt-3">
                        <i class="fa-solid fa-rocket" style="color: #d133e6;"></i>
                        <div id="countdown-days" class="mb-2" style="font-size: 2em; color: #ffff;">-- Days</div>
                        <h2 id="countdown-hours" class="text-danger" style="font-size: 1.5em; margin-bottom: 0;">--:--:--:--</h2>
                        <h5 class="text-muted" style="margin-top: 0;">DD : HH : MM : SS</h5>
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
                            <div class="phase-item completed">
                                <i class="tim-icons icon-check-2 text-success"></i>
                                <h6>Tender</h6>
                                <span class="text-success">Completed</span>
                            </div>
                        </div>
                        <div class="col">
                            <div class="phase-item in-progress">
                                <div class="progress-circle">
                                    <h4>72%</h4>
                                </div>
                                <h6>Ongoing</h6>
                                <span class="text-warning">In Progress</span>
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
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-category">Physical Progress</h5>
                    <div style="height:200px;">
                        <canvas id="physicalProgressChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-category">Financial Progress</h5>
                    <div style="height:200px;">
                        <canvas id="financialProgressChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

        <!-- fouth row: project updates -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-category">Recent Project Updates</h5>
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="d-flex align-items-center mb-3">
                                <div class="timeline-icon">
                                    <!-- <i class="tim-icons icon-notes text-info"></i> -->
                                    <i class="fa-solid fa-user-pen fa-2xl" style="color: #8f36a1;"></i>
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
                                <div class="timeline-icon">
                                    <!-- <i class="tim-icons icon-check-2 text-success"></i> -->
                                    <i class="fa-solid fa-user-pen fa-2xl" style="color: #2f70ac;"></i>
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
                                <div class="timeline-icon">
                                    <!-- <i class="tim-icons icon-alert-circle-exc text-warning"></i> -->
                                    <i class="fa-solid fa-user-pen fa-2xl" style="color: #9d3f88;"></i>
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
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Overall Progress Chart
            var options = {
                series: [72],
                chart: {
                    height: 200,
                    type: 'radialBar',
                },
                plotOptions: {
                    radialBar: {
                        hollow: {
                            size: '72%',
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
                colors: ['#ad23cf'],
            };

            // Progress Bar Chart
            var chart = new ApexCharts(document.querySelector("#progressChart"), options);
            chart.render();

                const launchDate = new Date('2026-03-31T00:00:00');
                const daysElem = document.getElementById('countdown-days');
                const hoursElem = document.getElementById('countdown-hours');

                function updateCountdown() {
                    const now = new Date();
                    let diff = launchDate - now;
                    if (diff <= 0) {
                        daysElem.textContent = "0 Days";
                        hoursElem.textContent = "00:00:00";
                        return;
                    }

                    // Calculate days, hours, minutes, seconds left
                    const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((diff / (1000 * 60 * 60)) % 24);
                    const minutes = Math.floor((diff / (1000 * 60)) % 60);
                    const seconds = Math.floor((diff / 1000) % 60);

                    daysElem.textContent = days + (days === 1 ? " Day" : " Days");
                    hoursElem.textContent =
                        days.toString().padStart(2, '0') + ':'+
                        hours.toString().padStart(2, '0') + ':' +
                        minutes.toString().padStart(2, '0') + ':' +
                        seconds.toString().padStart(2, '0');
                }

                updateCountdown();
                setInterval(updateCountdown, 1000);
            });

            // physical progress chart
            var ctx = document.getElementById('physicalProgressChart').getContext('2d');
            var physicalProgressChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Physical Progress'],
                    datasets: [
                        {
                            label: 'Expected',
                            data: [65],
                            backgroundColor: 'rgba(173, 35, 207, 0.7)',
                            borderColor: 'rgba(173, 35, 207, 1)',
                            borderWidth: 2
                        },
                        {
                            label: 'Actual',
                            data: [50],
                            backgroundColor: 'rgba(218, 136, 28, 0.7)',
                            borderColor: 'rgba(218, 136, 28, 1)',
                            borderWidth: 2
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: true },
                        title: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100,
                            grid: {
                                color: 'rgba(255,255,255,0.1)'
                            },
                            title: {
                                display: true,
                                text: 'Percentage (%)'
                            }
                        }
                    }
                }
            });

            var ctx = document.getElementById('financialProgressChart').getContext('2d');
            var financialProgressChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Financial Progress'],
                    datasets: [
                        {
                            label: 'Expected',
                            data: [75],
                            backgroundColor: 'rgba(52, 152, 219, 0.7)',
                            borderColor: 'rgba(52, 152, 219, 1)',
                            borderWidth: 2
                        },
                        {
                            label: 'Actual',
                            data: [65],
                            backgroundColor: 'rgba(46, 204, 113, 0.7)',
                            borderColor: 'rgba(46, 204, 113, 1)',
                            borderWidth: 2
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: true },
                        title: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100,
                            title: {
                                display: true,
                                text: 'Percentage (%)'
                            }
                        }
                    }
                }
            });

    </script>

@endpush
