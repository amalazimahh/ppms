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

    <!-- Dropdown Navigation (for jumping between forms) -->
    <div class="row mb-3">
        <label for="formNavigation" class="col-sm-2 col-form-label">Navigate to Form: </label>
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
            <h1 class="card-title">Project Team</h1>
        </div>
        <div class="card-body">
        <!-- need to change later -->
        <form action="{{ isset($project) ? route('pages.admin.forms.basicdetails.update', $project->id) : route('pages.admin.forms.basicdetails.store') }}" method="POST" enctype="multipart/form-data">

                @csrf

                @if(isset($project))
                    @method('PUT')
                @endif

                <input type="hidden" name="project_team_id" value="{{ $projectTeam ?? '' }}">

                <div class="row mb-3">
                    <label for="oic" class="col-sm-2 col-form-label">Officer-in-Charge</label>
                    <div class="col-sm-10">
                        <select name="officer_in_charge" id="officer_in_charge" class="form-control">
                            <option disabled selected>-- Select Officer in Charge --</option>
                            @foreach($projectManagers as $projectManager)
                                <option value="{{ $projectManager->id }}">{{ $projectManager->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="architect_id" class="col-sm-2 col-form-label">Architect</label>
                    <div class="col-sm-10">
                        <select id="architect_id" name="architect_id" class="form-control">
                            <option disabled selected>-- Select Architect --</option>
                            @foreach($architects as $architect)
                                <option value="{{ $architect->id }}"
                                {{ old('architect', isset($project) ? $project->architect_id : '') == $architect->id ? 'selected' : '' }}>
                                    {{ $architect->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="mechanical_electrical_id" class="col-sm-2 col-form-label">Mechanical & Electrical</label>
                    <div class="col-sm-10">
                        <select id="mechanical_electrical_id" name="mechanical_electrical_id" class="form-control">
                            <option disabled selected>-- Select Mechanical & Electrical --</option>
                            @foreach($mechanicalElectricals as $mechanicalElectrical)
                                <option value="{{ $mechanicalElectrical->id }}"
                                {{ old('mechanicalElectrical', isset($project) ? $project->mechanicalElectrical_id : '') == $mechanicalElectrical->id ? 'selected' : '' }}>
                                    {{ $mechanicalElectrical->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="civil_structural_id" class="col-sm-2 col-form-label">Civil & Structural</label>
                    <div class="col-sm-10">
                        <select id="civil_structural_id" name="civil_structural_id" class="form-control">
                            <option disabled selected>-- Select Civil & Structural --</option>
                            @foreach($civilStructurals as $civilStructural)
                                <option value="{{ $civilStructural->id }}"
                                {{ old('civilStructural', isset($project) ? $project->civilStructural_id : '') == $civilStructural->id ? 'selected' : '' }}>
                                    {{ $civilStructural->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="quantity_surveyor_id" class="col-sm-2 col-form-label">Quantity Surveyor</label>
                    <div class="col-sm-10">
                        <select id="quantity_surveyor_id" name="quantity_surveyor_id" class="form-control">
                            <option disabled selected>-- Select Quantity Surveyor --</option>
                            @foreach($quantitySurveyors as $quantitySurveyor)
                                <option value="{{ $quantitySurveyor->id }}"
                                {{ old('quantitySurveyor', isset($project) ? $project->quantitySurveyor_id : '') == $quantitySurveyor->id ? 'selected' : '' }}>
                                    {{ $quantitySurveyor->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="others_id" class="col-sm-2 col-form-label">Others (Specialist)</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="others_id" id="others_id">
                    </div>
                </div>

                <a href="{{ route('projects.pre_tender', $project->id) }}" class="btn btn-primary">Back</a>
                <button type="submit" class="btn btn-primary">SAVE</button>
                <a href="{{ route('projects.design_submission', $project->id) }}" class="btn btn-primary">Next</a>
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
