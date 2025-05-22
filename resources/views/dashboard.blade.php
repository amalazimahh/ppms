@extends('layouts.app', ['pageSlug' => 'dashboard'])
<style>
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
</style>

@section('content')
    <div class="row">
        <div class="col-lg-3">
            <div class="card card-stats">
                <div class="card-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="numbers">
                                <p class="card-category text-primary">TOTAL PROJECTS</p>
                                <h2 class="card-title">12</h2>
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
                                <h2 class="card-title">9</h2>
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
                                <h2 class="card-title">3</h2>
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
                                <h2 class="card-title">2</h2>
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
                                <h2 class="card-title">$64,000.00</h2>
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
                                <h2 class="card-title">$32,000.00</h2>
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
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-category">Ministry Distribution</h5>
                    <h2 class="card-title">Project Allocation</h2>
                </div>
                <div class="card-body d-flex justify-content-center align-items-center">
                    <div id="sunburst-chart" style="height: 400px; width: 400px;"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-category">Project Stages</h5>
                    <h2 class="card-title">Current Status</h2>
                </div>
                 <div class="card-body d-flex justify-content-center align-items-cente">
                    <canvas id="projectStagesDonut" style="height: 400px; width: 500px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Bar chart for physical and financial status in its own row -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-category">Budget vs Timeline</h5>
                    <h2 class="card-title">Project Progress</h2>
                </div>
                <div class="card-body">
                    <canvas id="projectProgressChart" height="50"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Upcoming Deadlines table in its own row -->
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
                                    <th>Project</th>
                                    <th>Officer-in-Charge</th>
                                    <th>Countdown</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Pembinaan Semula Sekolah Menengah Sultan Hassan Bangar Temburong</td>
                                    <td>Afiqah</td>
                                    <td>
                                        <span class="status-dot red animation"></span>
                                        1 month
                                    </td>
                                </tr>
                                <tr>
                                    <td>Masjid Baru RPN Kg. Mengkubau</td>
                                    <td>Zulmajdi</td>
                                    <td>
                                        <span class="status-dot yellow"></span>
                                        2 months
                                    </td>
                                </tr>
                                <tr>
                                    <td>UTB Phase 4 - School of Applied Sciences and Mathematics</td>
                                    <td>Mohd</td>
                                    <td>
                                        <span class="status-dot green"></span>
                                        12 months
                                    </td>
                                </tr>
                                <tr>
                                    <td>Pelan Induk Akademi Pasukan Polis Diraja Brunei</td>
                                    <td>Pg Ayatol</td>
                                    <td>
                                        <span class="status-dot green"></span>
                                        6 months
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
<script src="https://d3js.org/d3.v7.min.js"></script>
    <script>
        $(document).ready(function() {

            // Donut Chart for Project Stages
            const stageLabels = ['Pre-Design', 'Design', 'Tender', 'Ongoing', 'Post-Completion'];
            const stageData = [3, 5, 2, 1, 4];
            const ctxDonut = document.getElementById('projectStagesDonut').getContext('2d');
            const projectStagesDonut = new Chart(ctxDonut, {
                type: 'doughnut',
                data: {
                    labels: stageLabels,
                    datasets: [{
                        data: stageData,
                        backgroundColor: [
                            '#36A2EB',
                            '#FFCE56',
                            '#4BC0C0',
                            '#FF6384',
                            '#9966FF'
                        ],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'right'
                        }
                    }
                }
            });

            // Bar Chart for Project Progress
            const barLabels = [
                'UTB Phase 4 - School of Applied Sciences and Mathematics',
                'Masjid Baru RPN Kg. Mengkubau',
                'Pembinaan Semula Sekolah Menengah Sultan Hassan Bangar Temburong',
                'Pelan Induk Akademi Pasukan Polis Diraja Brunei'
            ];
            const physicalProgress = [80, 60, 90, 70];
            const financialProgress = [70, 55, 85, 65];
            const ctxBar = document.getElementById('projectProgressChart').getContext('2d');
            const projectProgressChart = new Chart(ctxBar, {
                type: 'bar',
                data: {
                    labels: barLabels,
                    datasets: [
                        {
                            label: 'Physical Progress (%)',
                            data: physicalProgress,
                            backgroundColor: '#36A2EB'
                        },
                        {
                            label: 'Financial Progress (%)',
                            data: financialProgress,
                            backgroundColor: '#FFCE56'
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top'
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                callback: function(value, index, ticks) {
                                    const label = this.getLabelForValue(value);
                                    return label.match(/.{1,18}(\s|$)/g);
                                },
                                font: {
                                    size: 12
                                }
                            }
                        },
                        y: {
                            beginAtZero: true,
                            max: 100
                        }
                    }
                }
            });

        // sunburst chart
        const data = {
            name: "flare",
            children: [
                { name: "PMO", children: [{ name: "project 1", value: 3938 }, { name: "project 2", value: 3938 }] },
                { name: "MCYS", children: [{ name: "project 1", value: 17010 }, { name: "project 2", value: 5842 }] },
                { name: "MinDef", children: [{ name: "project 1", value: 7213 }, { name: "project 2", value: 3322 }] },
                { name: "MoD", children: [{ name: "project 1", value: 8833 }, { name: "project 2", value: 1732 }] },
                { name: "MoE", children: [{ name: "project 1", value: 4116 }] },
                { name: "MoFE", children: [{ name: "project 1", value: 1082 }, { name: "project 2", value: 1336 }] },
                { name: "MoFA", children: [{ name: "project 1", value: 1616 }, { name: "project 2", value: 1027 }] },
                { name: "MoH", children: [{ name: "project 1", value: 2105 }, { name: "project 2", value: 1316 }] },
                { name: "MoHA", children: [{ name: "project 1", value: 3938 }, { name: "project 2", value: 8258 }, {name: "project 3", value: 1001}] },
                { name: "MPRT", children: [{ name: "project 1", value: 24593 }, { name: "project 2", value: 13598 }] },
                { name: "MoRA", children: [{ name: "project 1", value: 24593 }, { name: "project 2", value: 13598 }] },
                { name: "MTIC", children: [{ name: "project 1", value: 24593 }, { name: "project 2", value: 13598 }] }
            ]
        };

        // Container styling
        const container = d3.select("#sunburst-chart")
            .style("height", "400px")
            .style("width", "100%")
            .style("display", "flex")
            .style("align-items", "center")
            .style("justify-content", "center");

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

        // Legend
        const legend = svg.append("g")
            .attr("class", "legend")
            .attr("transform", `translate(${width/1.6}, ${-height/3.8})`);

        const legendItems = legend.selectAll("g")
            .data(data.children)
            .enter()
            .append("g")
            .attr("transform", (d, i) => `translate(0, ${i * 20})`);

        legendItems.append("rect")
            .attr("width", 18)
            .attr("height", 18)
            .attr("rx", 4)
            .attr("fill", d => color(d.name))
            .attr("fill-opacity", 0.8);

        legendItems.append("text")
            .attr("x", 28)
            .attr("y", 12)
            .attr("dy", "0.35em")
            .attr("fill", "#ffffff")
            .style("font-size", "16px") // larger font
            .text(d => d.name);

        const path = svg.append("g")
            .selectAll("path")
            .data(root.descendants().slice(1))
            .join("path")
            .attr("fill", d => { while (d.depth > 1) d = d.parent; return color(d.data.name); })
            .attr("fill-opacity", d => arcVisible(d.current) ? (d.children ? 0.6 : 0.4) : 0)
            .attr("pointer-events", d => arcVisible(d.current) ? "auto" : "none")
            .attr("d", d => arc(d.current));

        path.filter(d => d.children)
            .style("cursor", "pointer")
            .on("click", clicked);

        const format = d3.format(",d");
        path.append("title")
            .text(d => `${d.ancestors().map(d => d.data.name).reverse().join("/")}\n${format(d.value)}`);

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
            .style("font-size", "10px")
            .each(function(d) {
                d3.select(this).selectAll("tspan").remove();
                const maxWidth = 60;
                const words = d.data.name.split(/\s+/);
                let line = [];
                let lineNumber = 0;
                let lineHeight = 1.1;
                let tspan = d3.select(this)
                    .append("tspan")
                    .attr("x", 0)
                    .attr("y", 0)
                    .attr("dy", "0em");
                for (let i = 0; i < words.length; i++) {
                    line.push(words[i]);
                    tspan.text(line.join(" "));
                    if (this.getComputedTextLength && this.getComputedTextLength() > maxWidth) {
                        line.pop();
                        tspan.text(line.join(" "));
                        line = [words[i]];
                        tspan = d3.select(this)
                            .append("tspan")
                            .attr("x", 0)
                            .attr("y", 0)
                            .attr("dy", ++lineNumber * lineHeight + "em")
                            .text(words[i]);
                    }
                }
            })
            .append("title")
            .text(d => d.data.name);

        const parent = svg.append("circle")
            .datum(root)
            .attr("r", radius)
            .attr("fill", "none")
            .attr("pointer-events", "all")
            .on("click", clicked);

        function clicked(event, p) {
            parent.datum(p.parent || root);

            root.each(d => d.target = {
                x0: Math.max(0, Math.min(1, (d.x0 - p.x0) / (p.x1 - p.x0))) * 2 * Math.PI,
                x1: Math.max(0, Math.min(1, (d.x1 - p.x0) / (p.x1 - p.x0))) * 2 * Math.PI,
                y0: Math.max(0, d.y0 - p.depth),
                y1: Math.max(0, d.y1 - p.depth)
            });

            const t = svg.transition().duration(event.altKey ? 7500 : 750);

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

    });
    </script>
@endpush
