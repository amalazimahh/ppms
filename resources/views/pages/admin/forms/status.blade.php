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

    <!-- progress bar -->
    <div class="progress" style="height: 20px;">
        <div id="formProgressBar" class="progress-bar" role="progressbar"
             style="width: {{ $progress }}%;" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
            {{ $progress }}%
        </div>
    </div>

    <hr>

    <!-- project title -->
    <div class="row mb-2">
        <label for="projectTitle" class="col-sm-2 col-form-label">Project Title: </label>
        <div class="col-sm-10">
            <input type="text" name="projectTitle" id="projectTitle" value="{{ $project->title }}" class="form-control text-white" disabled>
        </div>
     </div>

    <!-- dropdown navigation -->
    <div class="row mb-3">
        <label for="formNavigation" class="col-sm-2 col-form-label">Navigate to Form: </label>
        <div class="col-sm-10">
            <select id="formNavigation" class="form-control" onchange="window.location.href=this.value">
                <option disabled selected>-- Select Form --</option>
                <option value="{{ route('projects.status', $project->id) }}">1. Project Status</option>
                <option value="{{ route('pages.admin.forms.basicdetails', $project->id) }}">2. Project Terms of Reference Form</option>
                <option value="{{ route('projects.pre_tender', $project->id) }}">3. Pre-Design Form</option>
                <option value="{{ route('projects.project_team', $project->id) }}">4. Project Team Form</option>
                <option value="{{ route('projects.design_submission', $project->id) }}">5. Design Submission Form</option>
                <option value="{{ route('projects.tender', $project->id) }}">6. Opening/Closing Tender Form</option>
                <option value="{{ route('projects.tender_recommendation', $project->id) }}">6.1 Evaluation/Recommendation of Tender Form</option>
                <option value="{{ route('projects.approval_award', $project->id) }}">6.2 Approval of Award Form</option>
                <option value="{{ route('projects.contract', $project->id) }}">7. Contract Form</option>
                <option value="{{ route('projects.bankers_guarantee', $project->id) }}">7.1 Banker's Guarantee Form</option>
                <option value="{{ route('projects.insurance', $project->id) }}">7.2 Insurance Form</option>
                <option value="{{ route('projects.project_health', $project->id) }}">8. Project Progress Status</option>
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
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="tim-icons icon-simple-remove"></i>
                    </button>
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
                            <!-- <th>Status</th> -->
                    </thead>
                    <tbody>
                        @foreach ($statuses as $status)
                            <tr class="status-row" data-status-id="{{ $status->id }}">
                                <td>{{ $status->name }}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary toggle-milestones">Show Milestones</button>
                                </td>
                                <!-- <td>N/A</td> -->
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
                                            @php
                                                $projectMilestone = $milestones->firstWhere('id', $milestone->id);
                                            @endphp
                                            <tr>
                                                <td>{{ $milestone->name }}</td>
                                                <td>
                                                    <div class="form-check">
                                                        <label class="form-check-label">
                                                            <input type="checkbox"
                                                                name="completed"
                                                                class="form-check-input milestone-checkbox"
                                                                data-milestone-id="{{ $milestone->id }}"
                                                                {{ $projectMilestone && $projectMilestone->pivot && $projectMilestone->pivot->completed ? 'checked' : '' }}>
                                                            <span class="form-check-sign">
                                                                <span class="check"></span>
                                                            </span>
                                                        </label>
                                                    </div>
                                                </td>
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // toggle milestones visibility
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

        // progress bar update logic
        function updateProgressBar(){
            // Use a Set to store unique milestone IDs
            const checkboxes = document.querySelectorAll('.milestone-checkbox');
            const checked = document.querySelectorAll('.milestone-checkbox:checked');
            const uniqueIds = new Set();
            const checkedIds = new Set();

            checkboxes.forEach(cb => uniqueIds.add(cb.dataset.milestoneId));
            checked.forEach(cb => checkedIds.add(cb.dataset.milestoneId));

            const total = uniqueIds.size;
            const checkedCount = checkedIds.size;

            let percent = 0;
            if(total > 0){
                percent = (checkedCount / total) * 100;
            }

            percent = Math.ceil(percent);

            console.log('Total:', total, 'Checked:', checkedCount, 'Percent:', percent);

            const progressBar = document.getElementById('formProgressBar');
            if (progressBar) {
                progressBar.style.width = percent + '%';
                progressBar.setAttribute('aria-valuenow', percent);
                progressBar.textContent = percent + '%';
            }
        }

        // attach event listener to milestone checkboxes
        $('.milestone-checkbox').on('change', function() {
            var milestoneId = $(this).data('milestone-id');
            var completed = $(this).is(':checked') ? 1 : 0;
            $.ajax({
                url: '/projects/{{ $project->id }}/milestones/' + milestoneId + '/toggle',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    completed: completed
                },
                success: function(response) {
                    updateProgressBar();
                }
            });
        });

        updateProgressBar();
    });
</script>
