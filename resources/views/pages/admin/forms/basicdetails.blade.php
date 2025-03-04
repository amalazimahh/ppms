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

    <div class="card">
        <div class="card-header mb-2">
            <h1 class="card-title">BASIC PROJECT DETAILS</h1>
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
                    <label for="oic" class="col-sm-2 col-form-label">Officer in Charge</label>
                    <div class="col-sm-10">
                        <select id="oic" name="oic" class="form-control">
                            <option disabled selected>-- Select Project Manager --</option>
                            @foreach($projectManagers as $manager)
                                <option value="{{ $manager->id }}"
                                    {{ old('oic', isset($project) ? $project->user_id : '') == $manager->id ? 'selected' : '' }}>
                                    {{ $manager->name }}
                                </option>
                            @endforeach
                        </select>
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
                    <label for="contractor_id" class="col-sm-2 col-form-label">Main Contractor</label>
                    <div class="col-sm-10">
                        <select id="contractor_id" name="contractor_id" class="form-control">
                            <option disabled selected>-- Select Main Contractor --</option>
                            @foreach($contractors as $contractor)
                                <option value="{{ $contractor->id }}"
                                {{ old('contractor', isset($project) ? $project->contractor_id : '') == $contractor->id ? 'selected' : '' }}>
                                    {{ $contractor->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="contractorNum" class="col-sm-2 col-form-label">Contractor No.</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="contractorNum" id="contractorNum" placeholder="BSB/DOD/VI.1/2021"
                        value="{{ old('contractorNum', isset($project) ? $project->contractorNum : '') }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="siteGazette" class="col-sm-2 col-form-label">Site Gazette</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="siteGazette" id="siteGazette" placeholder="Gaz Lot 4054 EDR11247"
                            value="{{ old('siteGazette', isset($project) ? $project->siteGazette : '') }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="soilInv" class="col-sm-2 col-form-label">Soil Investigation</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="soilInv" id="soilInv"
                            value="{{ old('soilInv', isset($project) ? $project->soilInv : '') }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="topoSurvey" class="col-sm-2 col-form-label">Topo Survey</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="topoSurvey" id="topoSurvey"
                            value="{{ old('topoSurvey', isset($project) ? $project->topoSurvey : '') }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="handover" class="col-sm-2 col-form-label">Handover Project</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="handover" id="handover"
                        value="{{ old('handover', isset($project) ? $project->handover : '') }}">
                    </div>
                </div>

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

                <input type="hidden" name="project_team_id" value="{{ $projectTeam ?? '' }}">
                <h3>PROJECT TEAM</h3>

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
        let voteNumField = document.getElementById('voteNum');
        let parentProjectSelect = document.getElementById('parent_project_id');

        function updateVoteNum() {
            let parentId = parentProjectSelect.value;

            if (parentId) {
                fetch(`/admin/projects/${parentId}/getVoteNum`) // ✅ Fetch voteNum from parent
                    .then(response => response.json())
                    .then(data => {
                        voteNumField.value = data.voteNum; // ✅ Set parent voteNum
                        voteNumField.setAttribute('disabled', 'disabled'); // ✅ Disable input
                    })
                    .catch(error => console.error('Error fetching voteNum:', error));
            } else {
                voteNumField.value = ''; // ✅ Clear field
                voteNumField.removeAttribute('disabled'); // ✅ Enable input for manual entry
            }
        }

        parentProjectSelect.addEventListener('change', updateVoteNum);

        // ✅ Run on page load (for edit mode)
        updateVoteNum();
    });

</script>

@endsection
