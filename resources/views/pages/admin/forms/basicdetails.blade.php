@if(session('success'))
    <script>
        window.onload = function() {
            demo.showNotification('top', 'right', "{{ session('success') }}");
        };
    </script>
@endif

@extends('layouts.app', ['pageSlug' => 'basicdetails'])

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

    <!-- Project Status & Milestone Selection -->
    <div class="row mb-3">
        <label for="status" class="col-sm-2 col-form-label">Project Stage:</label>
        <div class="col-sm-4">
            <select id="status" name="status_id" class="form-control" onchange="updateMilestones(this.value)">
                @foreach($statuses as $status)
                    <option value="{{ $status->id }}" {{ $project->status_id == $status->id ? 'selected' : '' }}>
                        {{ $status->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <label for="milestone" class="col-sm-2 col-form-label">Milestone:</label>
        <div class="col-sm-4">
            <select id="milestone" name="milestone_id" class="form-control">
                @foreach($milestones as $milestone)
                    <option value="{{ $milestone->id }}" {{ $project->milestone_id == $milestone->id ? 'selected' : '' }}>
                        {{ $milestone->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>


    <!-- Dropdown Navigation (for jumping between forms) -->
    <div class="row mb-3">
        <label for="formNavigation" class="col-sm-2 col-form-label">Navigate to Form: </label>
        <div class="col-sm-10">
            <select id="formNavigation" class="form-control" onchange="window.location.href=this.value">
                <option disabled selected>-- Select Form --</option>
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
            <h1 class="card-title">Project Terms of Reference</h1>
        </div>
        <div class="card-body">
        <form action="{{ isset($project) ? route('pages.admin.forms.basicdetails.update', $project->id) : route('pages.admin.forms.basicdetails.store') }}" method="POST" enctype="multipart/form-data">

                @csrf

                @if(isset($project))
                    @method('PUT')
                @endif

                <!-- financial year -->
                <div class="row mb-3">
                    <label for="fy" class="col-sm-2 col-form-label">Financial Year</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="fy" id="fy" placeholder="2020/2021"
                            maxlength="9" oninput="formatFinancialYear(this)"
                            value="{{ old('fy', isset($project) ? $project->fy : '') }}">
                        </div>
                </div>

                <div class="row mb-3">
                    <label for="sv" class="col-sm-2 col-form-label">Scheme Value</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="sv" id="sv"
                            placeholder="$20,000,000.00"
                            value="{{ old('sv', isset($project) ? $project->sv : '') }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="av" class="col-sm-2 col-form-label">Allocation Value</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="av" id="av"
                            placeholder="$3,901,420.00"
                            value="{{ old('av', isset($project) ? $project->av : '') }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="statuses_id" class="col-sm-2 col-form-label">Status</label>
                    <div class="col-sm-10">
                        <select id="statuses_id" name="statuses_id" class="form-control">
                            <option disabled selected>-- Select status stage --</option>
                            @foreach($statuses as $status)
                                <option value="{{ $status->id }}"
                                    {{ ($project->status_id ?? old('status')) == $status->id ? 'selected' : '' }}>
                                    {{ $status->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <input type="hidden" name="parent_project_id" value="{{ old('parent_project_id', isset($project) ? $project->parent_project_id : '') }}">

                <div class="row mb-3">
                    <label for="parent_project_id" class="col-sm-2 col-form-label">Parent Project (Optional)</label>
                    <div class="col-sm-10">
                        <select id="parent_project_id" name="parent_project_id" class="form-control">
                            <option value="">No Parent (New Main Project)</option>
                            @foreach($mainProjects as $parentProject)
                                <option value="{{ $parentProject->id }}"
                                    {{ old('parent_project_id', isset($project) ? $project->parent_project_id : '') == $parentProject->id ? 'selected' : '' }}>
                                    {{ $parentProject->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>


                <div class="row mb-3">
                    <label for="voteNum" class="col-sm-2 col-form-label">Vote No.</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="voteNum" id="voteNum" placeholder="1105-005"
                            value="{{ old('voteNum', isset($project) ? $project->voteNum : '') }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="title" class="col-sm-2 col-form-label">Project Title</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="title" id="title" placeholder="Pembinaan Semula Sekolah Menengah Sultan Hassan Bangar Temburong"
                            value="{{ old('title', isset($project) ? $project->title : '') }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="client_ministry_id" class="col-sm-2 col-form-label">Client Ministry</label>
                    <div class="col-sm-10">
                        <select id="client_ministry_id" name="client_ministry_id" class="form-control">
                            <option disabled selected>-- Select Client Ministry --</option>
                                @foreach($clientMinistries as $clientMinistry)
                                    <option value="{{ $clientMinistry->id }}"
                                        {{ old('cm', isset($project) ? $project->client_ministry_id : '') == $clientMinistry->id ? 'selected' : '' }}>
                                        {{ $clientMinistry->ministryName }}
                                    </option>
                                @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="siteGazette" class="col-sm-2 col-form-label">Site Gazette</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="siteGazette" id="siteGazette" placeholder="Gaz Lot 4054 EDR11247"
                            value="{{ old('siteGazette', isset($project) ? $project->siteGazette : '') }}">
                    </div>
                </div>

                <!-- <div class="row mb-3">
                    <label for="handover" class="col-sm-2 col-form-label">Handover Project</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="handover" id="handover"
                        value="{{ old('handover', isset($project) ? $project->handover : '') }}">
                    </div>
                </div> -->

                <div class="row mb-3">
                    <label for="scope" class="col-sm-2 col-form-label">Scope</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="scope" id="scope" rows="4" placeholder="Construction of school campus including MPH, cafeteria, academic and admin blocks."
                            value="{{ old('scope', isset($project) ? $project->scope : '') }}"></textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="location" class="col-sm-2 col-form-label">Location</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="location" id="location" placeholder="https://goo.gl/maps/Qktu9RDd3hKWc8Av8"
                            value="{{ old('location', isset($project) ? $project->location : '') }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="img" class="col-sm-2 col-form-label">Upload Image</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control-file" name="img" id="img">
                    </div>
                </div>

                @if(isset($project))
                <a href="{{ route('pages.admin.projectsList') }}" class="btn btn-primary">Cancel</a>
                @endif

                <button type="submit" class="btn btn-primary">{{ isset($project) ? 'Update' : 'Submit' }}</button>
                @if(isset($project))
                 <a href="{{ route('projects.pre_tender', $project->id) }}" class="btn btn-primary">
                     Next
                 </a>
                 @endif
            </form>
        </div>
    </div>

<!-- handles financial year, amount user enters -->
<script>
    function formatFinancialYear(input)
    {
        //remove non-digit input
        let value = input.value.replace(/\D/g, '');

        // if length > 4, insert /
        if(value.length > 4)
        {
            value = value.slice(0,4) + '/' + value.slice(4,8);
        }

        input.value = value;
    }

    document.addEventListener('DOMContentLoaded', function () {
        new Cleave('#sv', {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand',
            prefix: '$',
            numeralDecimalScale: 2,
            numeralPositiveOnly: true,
        });

        new Cleave('#av', {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand',
            prefix: '$',
            numeralDecimalScale: 2,
            numeralPositiveOnly: true,
        });
    });


    // javascript to load the voteNum dynamically
    document.addEventListener('DOMContentLoaded', function () {
        let voteNum = document.getElementById('voteNum');
        let parentProjectSelect = document.getElementById('parent_project_id');

        function updateVoteNum() {
            let parentId = parentProjectSelect.value;

            if (parentId) {
                fetch(`/admin/projects/${parentId}/getVoteNum`) // fetch voteNum from parent
                    .then(response => response.json())
                    .then(data => {
                        voteNum.value = data.voteNum; // set parent voteNum
                        voteNum.setAttribute('readonly', 'readonly'); // disable input
                    })
                    .catch(error => console.error('Error fetching voteNum:', error));
            } else {
                voteNumField.value = ''; // clear field
                voteNumField.removeAttribute('readonly'); // enable input for manual entry
            }
        }

        parentProjectSelect.addEventListener('change', updateVoteNum);

        updateVoteNum();
    });

</script>

@endsection
