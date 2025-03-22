@extends('layouts.app')

@section('content')
 <!-- apply styling for dropdown -->
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
    </style>

    <!-- Progress Bar -->
    <div class="progress" style="height: 20px;">
        <div id="formProgressBar" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
    </div>
    <div id="progressLabel" class="mt-2" style="text-align: center;">Progress: 0%</div>

    <!-- Dropdown Navigation (for jumping between forms) -->
    <div class="row mb-3">
        <label for="formNavigation" class="col-sm-2 col-form-label">Navigate to: </label>
        <div class="col-sm-10">
            <select id="formNavigation" class="form-control" onchange="window.location.href=this.value">
                <option disabled selected>-- Select Form --</option>
                <option value="{{ route('projects.status', $project->id) }}">Project Status</option>
                <option value="{{ route('pages.admin.forms.basicdetails', $project->id) }}">Project Terms of Reference Form</option>
                <option value="{{ route('projects.pre_tender', $project->id) }}">Pre-Design Form</option>
                <option value="{{ route('projects.project_team', $project->id) }}">Project Team Form</option>
                <option value="{{ route('projects.design_submission', $project->id) }}">Design Submission Form</option>
                <option value="{{ route('projects.tender', $project->id) }}">Opening/Closing Tender Form</option>
                <option value="{{ route('projects.tender_recommendation', $project->id) }}">Evaluation/Recommendation of Tender Form</option>
                <option value="{{ route('projects.approval_award', $project->id) }}">Approval of Award Form</option>
                <option value="{{ route('projects.contract', $project->id) }}">Contract Form</option>
                <option value="{{ route('projects.bankers_guarantee', $project->id) }}">Banker's Guarantee Form</option>
                <option value="{{ route('projects.insurance', $project->id) }}">Insurance Form</option>
            </select>
        </div>
    </div>

    <div class="card">
        <div class="card-header mb-2">
            <h1 class="card-title">Project Status/Milestones</h1>
        </div>
        <div class="card-body">
            @if (!$project->status)
                <div class="alert alert-info">
                    This project has not been assigned a status yet. Please assign a status to view milestones.
                </div>
            @elseif ($milestones->isEmpty())
                <div class="alert alert-warning">
                    No milestones found for this project.
                </div>
            @endif
                <table class="table">
                    <thead>
                        <tr>
                            <th>Stage</th>
                            <th>Actions</th>
                    </thead>
                    <tbody>
                        @foreach ($statuses as $status)
                            <tr class="status-row" data-status-id="{{ $status->id }}">
                                <td>{{ $status->name }}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary toggle-milestones">Show Milestones</button>
                                </td>
                            </tr>
                            <tr class="milestones-row" data-status-id="{{ $status->id }}" style="display:none;">
                                <td colspan="2">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Milestone</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($status->milestones as $milestone)
                                                <tr>
                                                    <td>{{ $milestone->name }}</td>
                                                    <td><input type="checkbox" name="completed" class="milestone-checkbox" data-milestone-id="{{ $milestone->id }}"></td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
        </div>
    </div>
@endsection

<!-- Add this at the end of your view or in a separate JS file -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Toggle milestones visibility
        document.querySelectorAll('.toggle-milestones').forEach(button => {
            button.addEventListener('click', function () {
                const statusId = this.closest('tr').getAttribute('data-status-id');
                const milestonesRow = document.querySelector(`.milestones-row[data-status-id="${statusId}"]`);

                if (milestonesRow.style.display === 'none') {
                    milestonesRow.style.display = 'table-row';
                    this.textContent = 'Hide Milestones';
                } else {
                    milestonesRow.style.display = 'none';
                    this.textContent = 'Show Milestones';
                }
            });
        });

        // Handle milestone checkbox clicks
        document.querySelectorAll('.milestone-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                const milestoneId = this.getAttribute('data-milestone-id');
                const isCompleted = this.checked;

                // Send an AJAX request to update the milestone status
                fetch(`/milestones/${milestoneId}/update-status`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({ completed: isCompleted }),
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Milestone status updated successfully!');
                    } else {
                        alert('Failed to update milestone status.');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            });
        });
    });
</script>
