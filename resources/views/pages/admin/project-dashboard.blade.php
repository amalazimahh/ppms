@extends('layouts.app', ['pageSlug' => 'project-dashboard'])

@section('content')
    <div class="row">
        <!-- Overall Progress -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-category">Overall Progress</h5>
                    <h2 class="card-title">78%</h2>
                </div>
                <div class="card-body">
                    <div class="progress-section">
                        <div class="progress-item">
                            <span>Planning</span>
                            <span>Completed</span>
                        </div>
                        <div class="progress-item">
                            <span>Design</span>
                            <span>Completed</span>
                        </div>
                        <div class="progress-item">
                            <span>Development</span>
                            <span>67%</span>
                        </div>
                        <div class="progress-item">
                            <span>Testing</span>
                            <span>Waiting</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Projected Launch Date -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-category">Projected Launch Date</h5>
                    <h2 class="card-title">Friday, December 15</h2>
                    <p class="card-category">121 Days</p>
                </div>
            </div>
        </div>

        <!-- Risks -->
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-category">Risks</h5>
                    <h2 class="card-title text-danger">8.1%</h2>
                    <p class="card-category">Currently Over Target Budget</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Overdue Tasks -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-category">Overdue Tasks</h5>
                </div>
                <div class="card-body">
                    <div class="overdue-tasks">
                        <div class="task-item high-risk">
                            <h6>High Risk</h6>
                            <p>Task Status Update for board is overdue.</p>
                        </div>
                        <div class="task-item medium-risk">
                            <h6>Medium Risk</h6>
                            <p>View all project logs</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Project Budget -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-category">Project Budget</h5>
                </div>
                <div class="card-body">
                    <div class="budget-details">
                        <div class="budget-item">
                            <span>Total Budget</span>
                            <span>$80K</span>
                        </div>
                        <div class="budget-item">
                            <span>Target Amount Used</span>
                            <span>$52,000</span>
                        </div>
                        <div class="budget-item">
                            <span>Remaining</span>
                            <span>$8,770</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Project Summary -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-category">Project Summary</h5>
                </div>
                <div class="card-body">
                    <div class="summary-details">
                        <div class="summary-item">
                            <span>Start Date</span>
                            <span>2017-05-01</span>
                        </div>
                        <div class="summary-item">
                            <span>End Date</span>
                            <span>2017-12-15</span>
                        </div>
                        <div class="summary-item">
                            <span>Project Leader</span>
                            <span>Georg Darwilli</span>
                        </div>
                        <div class="summary-item">
                            <span>Overall Status</span>
                            <span class="text-success">In Time</span>
                        </div>
                        <div class="summary-item">
                            <span>Avg Handle Time (in Days) For Project-Task</span>
                            <span>6.3</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Upcoming Deadlines -->
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-category">Upcoming Deadlines</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Task</th>
                                <th>Deadline</th>
                                <th>Workload</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Catherine</td>
                                <td>Interactive Dashboard Features</td>
                                <td>2017-08-21</td>
                                <td>34%</td>
                            </tr>
                            <tr>
                                <td>George</td>
                                <td>Facebook API Connector</td>
                                <td>2017-09-30</td>
                                <td>56%</td>
                            </tr>
                            <tr>
                                <td>Nancy</td>
                                <td>Set Up Test Environment</td>
                                <td>2017-10-12</td>
                                <td>11%</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{ asset('black') }}/js/plugins/chartjs.min.js"></script>
    <script>
        $(document).ready(function() {
          demo.initDashboardPageCharts();
        });
    </script>
@endpush
