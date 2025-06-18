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

    @php
        $milestones = $project->milestones;
        $totalMilestones = $milestones->unique('id')->count();
        $completedMilestones = $milestones->where('pivot.completed', true)->unique('id')->count();
        $progress = $totalMilestones > 0 ? round(($completedMilestones / $totalMilestones) * 100) : 0;
    @endphp
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
                <option disabled {{ Route::currentRouteName() === null ? 'selected' : '' }}>-- Select Form --</option>
                <option value="{{ route('projects.status', $project->id) }}" {{ Route::currentRouteName() === 'projects.status' ? 'selected' : '' }}>1. Project Status</option>
                <option value="{{ route('pages.admin.forms.basicdetails', $project->id) }}" {{ Route::currentRouteName() === 'pages.admin.forms.basicdetails' ? 'selected' : '' }}>2. Project Terms of Reference Form</option>
                <option value="{{ route('projects.pre_tender', $project->id) }}" {{ Route::currentRouteName() === 'projects.pre_tender' ? 'selected' : '' }}>3. Pre-Design Form</option>
                <option value="{{ route('projects.project_team', $project->id) }}" {{ Route::currentRouteName() === 'projects.project_team' ? 'selected' : '' }}>4. Project Team Form</option>
                <option value="{{ route('projects.design_submission', $project->id) }}" {{ Route::currentRouteName() === 'projects.design_submission' ? 'selected' : '' }}>5. Design Submission Form</option>
                <option value="{{ route('projects.tender', $project->id) }}" {{ Route::currentRouteName() === 'projects.tender' ? 'selected' : '' }}>6. Opening/Closing Tender Form</option>
                <option value="{{ route('projects.tender_recommendation', $project->id) }}" {{ Route::currentRouteName() === 'projects.tender_recommendation' ? 'selected' : '' }}>6.1 Evaluation/Recommendation of Tender Form</option>
                <option value="{{ route('projects.approval_award', $project->id) }}" {{ Route::currentRouteName() === 'projects.approval_award' ? 'selected' : '' }}>6.2 Approval of Award Form</option>
                <option value="{{ route('projects.contract', $project->id) }}" {{ Route::currentRouteName() === 'projects.contract' ? 'selected' : '' }}>7. Contract Form</option>
                <option value="{{ route('projects.bankers_guarantee', $project->id) }}" {{ Route::currentRouteName() === 'projects.bankers_guarantee' ? 'selected' : '' }}>7.1 Banker's Guarantee Form</option>
                <option value="{{ route('projects.insurance', $project->id) }}" {{ Route::currentRouteName() === 'projects.insurance' ? 'selected' : '' }}>7.2 Insurance Form</option>
                <option value="{{ route('projects.project_health', $project->id) }}" {{ Route::currentRouteName() === 'projects.project_health' ? 'selected' : '' }}>8. Project Progress Status</option>
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

                <div class="row mb-3">
                    <label for="rkn_id" class="col-sm-2 col-form-label">RKN No. </label>
                    <div class="col-sm-10">
                        <select id="rkn_id" name="rkn_id" class="form-control">
                            <option disabled selected>-- Select RKN No. --</option>
                            @foreach($rkns as $rkn)
                                <option value="{{ $rkn->id }}"
                                    {{ old('rkn_id', isset($project) ? $project->rkn_id : '') == $rkn->id ? 'selected' : '' }}>
                                    {{ $rkn->rknNum }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

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
                    <label for="handoverDate" class="col-sm-2 col-form-label">Project Handover (to DOD)</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="handoverDate" id="handoverDate">
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

                <button type="submit" class="btn btn-primary">{{ isset($project) ? 'Update' : 'Submit' }}</button>

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
