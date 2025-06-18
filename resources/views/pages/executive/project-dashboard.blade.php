@extends('layouts.app', ['page'=>__('Project Dashboard'), 'pageSlug' => 'dashboard'])

@section('content')
    <style>
        select {
            background-color: #f6f9fc;
            color: #000;
        }

        select option {
            background-color: #f6f9fc;
            color: #000;
        }

        select option:hover{
            background-color: #525f7f;
            color: #fff;
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
            <form action="{{ route('pages.project_manager.project-dashboard') }}" method="get">
                <div class="row align-items-center">
                    <div class="col-md-9">
                        <select name="project_id" id="project_id" class="form-control" onchange="this.form.submit()">
                            <option value="">Select a project...</option>
                            @foreach($projects as $proj)
                                <option value="{{ $proj->id }}">
                                    @if($proj->parent_project_id)
                                        {{ $proj->parentProject->title }} -
                                    @endif
                                    {{ $proj->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-primary btn-block" type="submit">View</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- overall progress, project summary, deadline countdown -->
    <div class="row">
        <!-- overall progress -->
        <div class="col-lg-3">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-category">Overall Progress</h5>
                    <div id="progressChart" class="mt-3"></div>
                </div>
            </div>
        </div>

        <!-- project summary -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-category">Project Summary</h5>
                    <div class="summary-details mt-3">
                        <div class="summary-item text-light">
                            <span>Project Handover (to DoD):</span>
                            <span>{{ $project ? (is_string($project->created_at) ? $project->created_at : $project->created_at->format('d/m/Y')) : 'N/A' }}</span>
                        </div>
                        <div class="summary-item text-light">
                            <span>Project Handover (to Client Ministry):</span>
                            <span>{{ $project && $project->rkn && $project->rkn->endDate ? (is_string($project->rkn->endDate) ? $project->rkn->endDate : $project->rkn->endDate->format('d/m/Y')) : 'N/A' }}</span>
                        </div>
                        <div class="summary-item text-light">
                            <span>Officer-in-Charge:</span>
                            <span>{{ $project && $project->projectTeam && $project->projectTeam->officerInCharge ? $project->projectTeam->officerInCharge->name : 'N/A' }}</span>
                        </div>
                        <div class="summary-item text-light">
                            <span>Stage:</span>
                            <span class="text-primary">{{ $project && $project->milestone ? $project->milestone->name : 'N/A' }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- countdown to deadline -->
        <div class="col-lg-3">
            <div class="card">
                <div class="card-body text-center">
                    <h5 class="card-category">Countdown to Launch</h5>
                    <div class="launch-date-card mt-3">
                        <i class="fa-solid fa-rocket" style="color: #d133e6;"></i>
                        <div id="countdown-days" class="mb-2 d-flex align-items-center justify-content-center" style="font-size: 2em; color: #00ffd0;"></div>
                        <div class="countdown-container">
                            <div id="countdown-hours" class="text-danger" style="font-size: 1.5em; margin-bottom: 5px;"></div>
                            <!-- <div class="text-muted" style="font-size: 0.8em;">Days : Hours : Minutes : Seconds</div> -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- project bar timeline -->
    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-category">Project Development Stages</h5>
                    <div class="progress-bar-container mt-3">
                        <div class="progress-bar-fill" style="width: {{ $progress }}%"></div>
                    </div>
                    <div class="row h-100 align-items-center">
                        @forelse($stages as $stage)
                            <div class="col">
                                <div class="phase-item {{ $stage['completed'] ? 'completed' : ($stage['current'] ? 'in-progress' : 'waiting') }}">
                                    @if($stage['completed'])
                                        <i class="tim-icons icon-check-2 text-success"></i>
                                    @elseif($stage['current'])
                                        <div class="progress-circle">
                                            <h4>{{ $stage['progress'] }}%</h4>
                                        </div>
                                    @else
                                        <i class="tim-icons icon-time-alarm text-muted"></i>
                                    @endif
                                    <h6>{{ $stage['name'] }}</h6>
                                    <span class="{{ $stage['completed'] ? 'text-success' : ($stage['current'] ? 'text-warning' : 'text-muted') }}">
                                        {{ $stage['completed'] ? 'Completed' : ($stage['current'] ? 'In Progress' : 'Waiting') }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="col text-center">
                                <p class="text-muted">No stages found for this project</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- bar chart - physical and financial progress status -->
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

    <!-- project updates -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-category">Recent Project Updates</h5>
                    <div class="timeline">
                        @forelse($projectUpdates as $update)
                            <div class="timeline-item">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="timeline-icon">
                                        @switch($update->type)
                                            @case('new_user')
                                                <i class="fa-solid fa-user-plus fa-2xl" style="color: #4CAF50;"></i>
                                                @break
                                            @case('reset_password')
                                                <i class="fa-solid fa-key fa-2xl" style="color: #FFC107;"></i>
                                                @break
                                            @case('new_project')
                                                <i class="fa-solid fa-folder-plus fa-2xl" style="color: #2196F3;"></i>
                                                @break
                                            @case('update_project_details')
                                                <i class="fa-solid fa-pen-to-square fa-2xl" style="color: #8f36a1;"></i>
                                                @break
                                            @case('update_project_status')
                                                <i class="fa-solid fa-arrows-rotate fa-2xl" style="color: #9d3f88;"></i>
                                                @break
                                            @case('upcoming_deadline')
                                                <i class="fa-solid fa-clock fa-2xl" style="color: #FF9800;"></i>
                                                @break
                                            @case('overbudget')
                                                <i class="fa-solid fa-money-bill-trend-up fa-2xl" style="color: #f44336;"></i>
                                                @break
                                            @case('overdue')
                                                <i class="fa-solid fa-calendar-xmark fa-2xl" style="color: #d32f2f;"></i>
                                                @break
                                            @default
                                                <i class="fa-solid fa-circle-info fa-2xl" style="color: #2f70ac;"></i>
                                        @endswitch
                                    </div>
                                    <div class="ml-3">
                                        <h6 class="mb-0">{{ ucfirst(str_replace('_', ' ', $update->type)) }}</h6>
                                        <small class="text-muted">{{ $update->created_at->diffForHumans() }}</small>
                                        <p class="mb-0 mt-2">{{ $update->message }}</p>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="text-center text-muted">
                                <p>No recent updates for this project</p>
                            </div>
                        @endforelse
                    </div>
                    @if($project && method_exists($projectUpdates, 'links'))
                        <div class="d-flex justify-content-center mt-4">
                            {{ $projectUpdates->appends(['project_name' => request('project_name')])->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // overall progress chart
            var options = {
                series: [{{ $progress ?? 0 }}],
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

            var chart = new ApexCharts(document.querySelector("#progressChart"), options);
            chart.render();

            // countdown to deadline
            function initializeCountdown() {
                @if($project && $project->rkn && $project->rkn->endDate)
                    const launchDate = new Date('{{ $project->rkn->endDate }}');
                @else
                    const launchDate = new Date(); // set to current date if no deadline
                @endif
                const daysElem = document.getElementById('countdown-days');
                const hoursElem = document.getElementById('countdown-hours');

                if (!daysElem || !hoursElem) return;

                function updateCountdown() {
                    const now = new Date();
                    let diff = launchDate - now;

                    if (diff <= 0) {
                        daysElem.textContent = "0 Days";
                        hoursElem.textContent = "00:00:00";
                        daysElem.classList.add('text-danger');
                        hoursElem.classList.add('text-danger');
                        return;
                    }

                    // calculate days, hours, minutes, seconds left
                    const days = Math.floor(diff / (1000 * 60 * 60 * 24));
                    const totalHours = Math.floor(diff / (1000 * 60 * 60));
                    const minutes = Math.floor((diff / (1000 * 60)) % 60);
                    const seconds = Math.floor((diff / 1000) % 60);

                    // update countdown display
                    daysElem.innerHTML = `<span style="margin-right: 10px;">${days}</span><span>Days</span>`;
                    hoursElem.textContent =
                        totalHours.toString().padStart(2, '0') + ':' +
                        minutes.toString().padStart(2, '0') + ':' +
                        seconds.toString().padStart(2, '0');
                }

                updateCountdown();
                return setInterval(updateCountdown, 1000);
            }

            const countdownInterval = initializeCountdown();

            window.addEventListener('beforeunload', function() {
                if (countdownInterval) clearInterval(countdownInterval);
            });
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
                        data: [{{ $project && $project->physical_status ? $project->physical_status->scheduled : 0 }}],
                        backgroundColor: 'rgba(173, 35, 207, 0.7)',
                        borderColor: 'rgba(173, 35, 207, 1)',
                        borderWidth: 2
                    },
                    {
                        label: 'Actual',
                        data: [{{ $project && $project->physical_status ? $project->physical_status->actual : 0 }}],
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
                        data: [{{ $project && $project->financial_status ? $project->financial_status->scheduled : 0 }}],
                        backgroundColor: 'rgba(52, 152, 219, 0.7)',
                        borderColor: 'rgba(52, 152, 219, 1)',
                        borderWidth: 2
                    },
                    {
                        label: 'Actual',
                        data: [{{ $project && $project->financial_status ? $project->financial_status->actual : 0 }}],
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
