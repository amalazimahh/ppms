@extends('layouts.app', ['pageSlug' => 'dashboard'])

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

    .status-dot {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        display: inline-block;
        margin-right: 8px;
    }

    .animation{
        animation: status-fade 0.5s infinite alternate;
    }

    .status-dot.green {
        background: #4CAF50;
    }
    .status-dot.yellow {
        background: #FFC107;
    }
    .status-dot.red {
        background: #f44336;
    }
    @keyframes status-fade{
        from{ opacity: 1; }
        to { opacity: 0.4; }
    }

    /* scrollbar styles blend with the card */
    #chartContainer {
    background: #23263a; /* Match your card/chart background */
    scrollbar-color: #444 #23263a; /* thumb color, track color for Firefox */
    scrollbar-width: thin;
    }

    /* Webkit browsers */
    #chartContainer::-webkit-scrollbar {
        height: 10px;
        background: #23263a; /* track color */
    }
    #chartContainer::-webkit-scrollbar-thumb {
        background: #444; /* thumb color */
        border-radius: 5px;
    }
</style>


@section('content')

<div class="row mt-3">
    <div class="col-lg-3">
        <div class="card card-stats">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="numbers">
                            <p class="card-category text-primary">TOTAL PROJECTS</p>
                            <h2 class="card-title">{{ $totalProjects }}</h2>
                        </div>
                    </div>
                </div>
                <div class="icon-big text-center text-primary" style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); opacity: 0.3;">
                    <i class="tim-icons icon-chart-pie-36" style="font-size: 3em;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card card-stats">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="numbers">
                            <p class="card-category text-info">ONGOING</p>
                            <h2 class="card-title">{{ $ongoingCount }}</h2>
                        </div>
                    </div>
                </div>
                <div class="icon-big text-center text-info" style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); opacity: 0.3;">
                    <i class="tim-icons icon-refresh-02" style="font-size: 3em;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card card-stats">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="numbers">
                            <p class="card-category text-success">COMPLETED</p>
                            <h2 class="card-title">{{ $completedCount }}</h2>
                        </div>
                    </div>
                </div>
                <div class="icon-big text-center text-success" style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); opacity: 0.3;">
                    <i class="tim-icons icon-check-2" style="font-size: 3em;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-3">
        <div class="card card-stats">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="numbers">
                            <p class="card-category text-danger">OVERDUE</p>
                            <h2 class="card-title">{{ $overdueCount }}</h2>
                        </div>
                    </div>
                </div>
                <div class="icon-big text-center text-danger" style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); opacity: 0.3;">
                    <i class="tim-icons icon-alert-circle-exc" style="font-size: 3em;"></i>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row mt-2">
    <div class="col-lg-6">
        <div class="card card-stats">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="numbers">
                            <p class="card-category text-warning">SCHEME VALUE</p>
                            <h2 class="card-title">$ {{ number_format($schemeValue, 2) }}</h2>
                        </div>
                    </div>
                </div>
                <div class="icon-big text-center text-warning" style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); opacity: 0.3;">
                    <i class="tim-icons icon-coins" style="font-size: 3em;"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="card card-stats">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <div class="numbers">
                            <p class="card-category text-info">ALLOCATION VALUE</p>
                            <h2 class="card-title">$ {{ number_format($allocationValue, 2) }}</h2>
                        </div>
                    </div>
                </div>
                <div class="icon-big text-center text-info" style="position: absolute; right: 20px; top: 50%; transform: translateY(-50%); opacity: 0.3;">
                    <i class="tim-icons icon-credit-card" style="font-size: 3em;"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Section -->
<div class="row">
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header">
                <h5 class="card-category">Ministry Distribution</h5>
                <h2 class="card-title">Project Allocation</h2>
            </div>
            <div class="card-body">
                <div id="sunburst-chart" style="height: 400px; display: flex; justify-content: center;"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header">
                <h5 class="card-category">Project Stages</h5>
                <h2 class="card-title">Current Status</h2>
            </div>
            <div class="card-body">
                <canvas id="projectStagesDonut" style="height: 360px;"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- upcoming deadlines table -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-category">Timeline Overview</h5>
                <h2 class="card-title">Upcoming Deadlines</h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 60%">Project</th>
                                <th style="width: 15%">Officer-in-Charge</th>
                                <th style="width: 5%">Status</th>
                                <th style="width: 15%">Due/Overdue</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($paginatedDeadlines as $project)
                                <tr>
                                    <td>
                                        @if($project['main_project'])
                                            {{ $project['main_project'] }} -
                                        @endif
                                        {{ $project['name'] }}
                                    </td>
                                    <td>{{ $project['officer_in_charge'] ?? 'N/A' }}</td>
                                    <td>
                                        @if($project['status'] === 'danger')
                                            <span class="status-dot red animation"></span>
                                        @elseif($project['status'] === 'success')
                                            <span class="status-dot green"></span>
                                        @elseif($project['status'] === 'warning')
                                            <span class="status-dot yellow"></span>
                                        @else
                                            <span class="status-dot green"></span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($project['status'] === 'danger')
                                            Overdue by
                                            @if($project['months_left'] < 0)
                                                {{ abs($project['months_left']) }} month{{ abs($project['months_left']) == 1 ? '' : 's' }}
                                            @endif
                                        @elseif($project['status'] === 'warning')
                                            {{ $project['months_left'] }} month{{ $project['months_left'] == 1 ? '' : 's' }} left
                                        @elseif($project['status'] === 'success')
                                            On track
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-3 d-flex flex-column align-items-center">
                        {{ $paginatedDeadlines->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- bar chart for physical and financial status in its own row -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header d-flex flex-column flex-md-row align-items-md-center justify-content-between">
                <div>
                    <h5 class="card-category">Physical vs Financial Progress</h5>
                    <h2 class="card-title">Project Progress</h2>
                </div>
                <div style="min-width:220px;">
                    <label for="ministryFilter" class="form-label">Filter by Ministry:</label>
                    <select id="ministryFilter" class="form-control">
                        <option value="">-- Select Ministry --</option>
                        @foreach($ministries as $ministry)
                            <option value="{{ $ministry->id }}">{{ $ministry->ministryName }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="card-body">
                <div id="noProjectsMsg" class="text-center text-danger" style="display:none;">No projects available under this ministry.</div>
                <div id="chartContainer" style="overflow-x: auto; width: 100%;">
                    <canvas id="projectProgressChart" height="300" style="min-width:900px;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const projectsByMinistry = @json($projectsByMinistry);
    let defaultLabels = @json($projectNames);
    let defaultPhysical = @json($physicalProgress);
    let defaultFinancial = @json($financialProgress);

    let progressChart;
    function renderBarChart(labels, physical, financial) {
        const canvas = document.getElementById('projectProgressChart');
        if (labels.length > 5) {
            canvas.width = labels.length * 150;
        } else {
            canvas.width = 0;
        }

        const ctx = canvas.getContext('2d');
        if (window.progressChart) {
            window.progressChart.destroy();
            window.progressChart = null;
        }
        window.progressChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Physical Progress (%)',
                    data: physical,
                    backgroundColor: '#1d8cf8',
                    barPercentage: 0.7,
                    categoryPercentage: 0.7
                }, {
                    label: 'Financial Progress (%)',
                    data: financial,
                    backgroundColor: '#00f2c3',
                    barPercentage: 0.7,
                    categoryPercentage: 0.7
                }]
            },
            options: {
                responsive: labels.length <= 5,
                maintainAspectRatio: false,
                layout: {
                    padding: { top: 20, right: 20, bottom: 20, left: 20 }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        grid: { color: 'rgba(255,255,255,0.1)' },
                        ticks: {
                            color: '#ffffff',
                            font: { size: 12 },
                            callback: function(value) { return value + '%'; }
                        }
                    },
                    x: {
                        grid: { color: 'rgba(255,255,255,0.1)' },
                        ticks: {
                            color: '#ffffff',
                            autoSkip: false,
                            maxRotation: 0,
                            minRotation: 0,
                            font: { size: 12 },
                            callback: function(value, index) {
                                const label = this.getLabelForValue(value);
                                return label.match(/.{1,15}(\s|$)/g);
                            }
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            color: '#ffffff',
                            font: { size: 12 },
                            padding: 20
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return context.dataset.label + ': ' + context.parsed.y + '%';
                            }
                        }
                    }
                }
            }
        });
    }
    function hideChart() {
        document.getElementById('chartContainer').style.display = 'none';
        if (window.progressChart) {
            window.progressChart.destroy();
            window.progressChart = null;
        }
    }

    function showChart() {
        document.getElementById('chartContainer').style.display = '';
    }

    // initial render
    renderBarChart(defaultLabels, defaultPhysical, defaultFinancial);

    // ministry filter event
    document.getElementById('ministryFilter').addEventListener('change', function() {
        const ministryId = this.value;
        if (ministryId && projectsByMinistry[ministryId] && projectsByMinistry[ministryId].length > 0) {
            const labels = projectsByMinistry[ministryId].map(p => p.title);
            const physical = projectsByMinistry[ministryId].map(p => p.physical);
            const financial = projectsByMinistry[ministryId].map(p => p.financial);
            document.getElementById('noProjectsMsg').style.display = 'none';
            showChart();
            renderBarChart(labels, physical, financial);
        } else if (ministryId) {
            // no projects for selected ministry
            document.getElementById('noProjectsMsg').style.display = 'block';
            hideChart();
        } else {
            document.getElementById('noProjectsMsg').style.display = 'none';
            showChart();
            renderBarChart(defaultLabels, defaultPhysical, defaultFinancial);
        }
    });

    // on initial load, show or hide chart based on data
    if (defaultLabels.length === 0) {
        document.getElementById('noProjectsMsg').style.display = 'block';
        hideChart();
    } else {
        document.getElementById('noProjectsMsg').style.display = 'none';
        showChart();
        renderBarChart(defaultLabels, defaultPhysical, defaultFinancial);
    }

    // SUNBURST CHART - PROJECT MINISTRIES
    const data = @json($sunburstData);
    console.log(data);

    // D3 Sunburst Chart
    const container = d3.select("#sunburst-chart")
        .style("height", "360px")
        .style("width", "100%")
        .style("display", "flex")
        .style("align-items", "center")
        .style("justify-content", "center");

        // adjust chart dimensions
        const width = 550;
        const height = 450;
        const radius = Math.min(width, height) / 6;

        const color = d3.scaleOrdinal(d3.quantize(d3.interpolateRainbow, data.children.length + 1));

        const hierarchy = d3.hierarchy(data)
            .sum(d => d.value)
            .sort((a, b) => b.value - a.value);
        const root = d3.partition()
            .size([2 * Math.PI, hierarchy.height + 1])
            (hierarchy);
        root.each(d => d.current = d);

        const arc = d3.arc()
            .startAngle(d => d.x0)
            .endAngle(d => d.x1)
            .padAngle(d => Math.min((d.x1 - d.x0) / 2, 0.005))
            .padRadius(radius * 1.5)
            .innerRadius(d => d.y0 * radius)
            .outerRadius(d => Math.max(d.y0 * radius, d.y1 * radius - 1));

        const svg = container
            .append("svg")
            .attr("width", "100%")
            .attr("height", "100%")
            .attr("preserveAspectRatio", "xMidYMid meet")
            .attr("viewBox", [-width / 4, -height / 2, width, height])
            .style("font", "11px sans-serif");

        // legend for sunburst chart
        const legend = svg.append("g")
            .attr("class", "legend")
            .attr("transform", `translate(${width/2.2}, ${-height/2.5})`);

        // prepare legend data with line count
        const legendLineHeight = 12;
        const legendMaxChars = 45;   // chars per line

        // Calculate lines for each legend item
        const legendData = data.children.map(d => {
            const lines = (d.name.match(new RegExp(`.{1,${legendMaxChars}}(\\s|$)|\\S+`, 'g')) || [d.name]);
            return { ...d, lines, lineCount: lines.length };
        });

        // 2. Calculate y-offsets for each legend item
        let yOffset = 0;
        legendData.forEach((d, i) => {
            d.y = yOffset;
            yOffset += d.lineCount * legendLineHeight + 4; // 4px gap between items
        });

        // 3. Bind legendData instead of data.children
        const legendItems = legend.selectAll("g")
            .data(legendData)
            .enter()
            .append("g")
            .attr("transform", d => `translate(0,${d.y})`);

        // 4. Draw rect, set height to fit all lines
        legendItems.append("rect")
            .attr("width", 12)
            .attr("height", d => d.lineCount * legendLineHeight)
            .attr("rx", 2)
            .attr("fill", d => color(d.name))
            .attr("fill-opacity", 0.8);

        // 5. Draw wrapped text
        legendItems.append("text")
            .attr("x", 16)
            .attr("y", 0)
            .attr("fill", "#ffffff")
            .style("font-size", "10px")
            .selectAll("tspan")
            .data(d => d.lines)
            .join("tspan")
            .attr("x", 16)
            .attr("dy", (d, i) => i === 0 ? legendLineHeight - 4 : legendLineHeight) // align first line with rect
            .text(d => d.trim());

        const path = svg.append("g")
            .selectAll("path")
            .data(root.descendants().slice(1))
            .join("path")
            .attr("fill", d => { while (d.depth > 1) d = d.parent; return color(d.data.name); })
            .attr("fill-opacity", d => arcVisible(d.current) ? (d.children ? 0.6 : 0.4) : 0)
            .attr("pointer-events", d => arcVisible(d.current) ? "auto" : "none")
            .attr("d", d => arc(d.current));

        // Make them clickable if they have children.
        path.filter(d => d.children)
            .style("cursor", "pointer")
            .on("click", clicked);

        const format = d3.format(",d");
        path.append("title")
        .text(d => d.data.name);

        const label = svg.append("g")
            .attr("pointer-events", "none")
            .attr("text-anchor", "middle")
            .style("user-select", "none")
            .selectAll("text")
            .data(root.descendants().slice(1))
            .join("text")
            .attr("dy", "0.35em")
            .attr("fill-opacity", d => +labelVisible(d.current))
            .attr("transform", d => labelTransform(d.current))
            .each(function(d) {
                // Split label every 12 characters or at spaces
                let words = d.data.name.match(/.{1,12}(\s|$)|\S+/g) || [d.data.name];
                const maxLines = 2;
                if (words.length > maxLines) {
                    words = words.slice(0, maxLines);
                    // Add ellipsis to the last line
                    words[maxLines - 1] = words[maxLines - 1].replace(/\s*$/, '') + '...';
                }
                d3.select(this).selectAll("tspan")
                    .data(words)
                    .join("tspan")
                    .attr("x", 0)
                    .attr("dy", (w, i) => i === 0 ? 0 : "1.1em")
                    .text(w => w.trim());
            });

        const parent = svg.append("circle")
            .datum(root)
            .attr("r", radius)
            .attr("fill", "none")
            .attr("pointer-events", "all")
            .on("click", clicked);

        // Handle zoom on click.
        function clicked(event, p) {
            parent.datum(p.parent || root);

            root.each(d => d.target = {
            x0: Math.max(0, Math.min(1, (d.x0 - p.x0) / (p.x1 - p.x0))) * 2 * Math.PI,
            x1: Math.max(0, Math.min(1, (d.x1 - p.x0) / (p.x1 - p.x0))) * 2 * Math.PI,
            y0: Math.max(0, d.y0 - p.depth),
            y1: Math.max(0, d.y1 - p.depth)
            });

        const t = svg.transition().duration(event.altKey ? 7500 : 750);

        // Transition the data on all arcs, even the ones that aren’t visible,
        // so that if this transition is interrupted, entering arcs will start
        // the next transition from the desired position.
        path.transition(t)
            .tween("data", d => {
            const i = d3.interpolate(d.current, d.target);
            return t => d.current = i(t);
            })
        .filter(function(d) {
            return +this.getAttribute("fill-opacity") || arcVisible(d.target);
        })
            .attr("fill-opacity", d => arcVisible(d.target) ? (d.children ? 0.6 : 0.4) : 0)
            .attr("pointer-events", d => arcVisible(d.target) ? "auto" : "none")

            .attrTween("d", d => () => arc(d.current));

        label.filter(function(d) {
            return +this.getAttribute("fill-opacity") || labelVisible(d.target);
        }).transition(t)
            .attr("fill-opacity", d => +labelVisible(d.target))
            .attrTween("transform", d => () => labelTransform(d.current));
        label.append("title")
            .text(d => d.data.name);
    }

    function arcVisible(d) {
        return d.y1 <= 3 && d.y0 >= 1 && d.x1 > d.x0;
    }

    function labelVisible(d) {
        return d.y1 <= 3 && d.y0 >= 1 && (d.y1 - d.y0) * (d.x1 - d.x0) > 0.03;
    }

    function labelTransform(d) {
        const x = (d.x0 + d.x1) / 2 * 180 / Math.PI;
        const y = (d.y0 + d.y1) / 2 * radius;
        return `rotate(${x - 90}) translate(${y},0) rotate(${x < 180 ? 0 : 180})`;
    }

    // END OF SUNBURST CHART

    // DONUT CHART - PROJECT STAGES
    const projectStagesData = {
        labels: @json($stageLabels),
        datasets: [{
            data: @json($stageData),
            backgroundColor: ['#e14eca', '#00f2c3', '#ff8d72', '#1d8cf8', '#fd5d93'],
            borderWidth: 0
        }]
    };

    const projectStagesConfig = {
        type: 'doughnut',
        data: projectStagesData,
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '60%',
            plugins: {
                legend: {
                    position: 'top',
                    align: 'center',
                    labels: {
                        color: '#ffffff',
                        padding: 10,
                        font: {
                            size: 12
                        },
                        boxWidth: 10
                    }
                }
            },
            layout: {
                padding: {
                    right: 10
                }
            }
        }
    };

    // DONUT CHART - PROJECT STAGES
    const projectStagesCtx = document.getElementById('projectStagesDonut').getContext('2d');
    new Chart(projectStagesCtx, projectStagesConfig);

    const progressCtx = document.getElementById('projectProgressChart').getContext('2d');
    new Chart(progressCtx, {
        type: 'bar',
        data: {
            labels: @json($projectNames),
            datasets: [{
                label: 'Physical Progress (%)',
                data: @json($physicalProgress),
                backgroundColor: '#1d8cf8',
                barPercentage: 0.8,
                categoryPercentage: 0.8
            }, {
                label: 'Financial Progress (%)',
                data: @json($financialProgress),
                backgroundColor: '#00f2c3',
                barPercentage: 0.8,
                categoryPercentage: 0.8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            layout: {
                padding: {
                    top: 20,
                    right: 20,
                    bottom: 20,
                    left: 20
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    grid: {
                        color: 'rgba(255,255,255,0.1)'
                    },
                    ticks: {
                        color: '#ffffff',
                        font: {
                            size: 12
                        },
                        callback: function(value) {
                            return value + '%';
                        }
                    }
                },
                x: {
                    grid: {
                        color: 'rgba(255,255,255,0.1)'
                    },
                    ticks: {
                        color: '#ffffff',
                        autoSkip: false,
                        maxRotation: 0,
                        minRotation: 0,
                        font: {
                            size: 12
                        },
                        callback: function(value, index) {
                            const label = this.getLabelForValue(value);
                            // Split label every 15 characters (or at spaces)
                            return label.match(/.{1,15}(\s|$)/g);
                        }
                    }
                }
            },
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                    labels: {
                        color: '#ffffff',
                        font: {
                            size: 12
                        },
                        padding: 20
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': ' + context.parsed.y + '%';
                        }
                    }
                }
            }
        }
    });

    });
</script>
@endpush
