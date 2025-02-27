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
            <form action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- first row -->
                <!-- <div class="form-row"> -->
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
                    <label for="status" class="col-sm-2 col-form-label">Status</label>
                    <div class="col-sm-10">
                        <select id="status" name="status" class="form-control">
                            <option disabled selected>-- Select status stage --</option>
                            @foreach($statuses as $status)
                                <option value="{{ $status->id }}"
                                    {{ old('status', isset($project) ? $project->status_id : '') == $status->id ? 'selected' : '' }}>
                                    {{ $status->name }}
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
                    <label for="cm" class="col-sm-2 col-form-label">Client Ministry</label>
                    <div class="col-sm-10">
                        <select id="cm" name="cm" class="form-control">
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
                    <label for="contractor" class="col-sm-2 col-form-label">Main Contractor</label>
                    <div class="col-sm-10">
                        <select id="contractor" name="contractor" class="form-control">
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

                <h3>PROJECT TEAM</h3>

                <div class="row mb-3">
                    <label for="architect" class="col-sm-2 col-form-label">Architect</label>
                    <div class="col-sm-10">
                        <select id="architect" name="architect" class="form-control">
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
                    <label for="me" class="col-sm-2 col-form-label">Mechanical & Electrical</label>
                    <div class="col-sm-10">
                        <select id="me" name="me" class="form-control">
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
                    <label for="cs" class="col-sm-2 col-form-label">Civil & Structural</label>
                    <div class="col-sm-10">
                        <select id="cs" name="cs" class="form-control">
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
                    <label for="qs" class="col-sm-2 col-form-label">Quantity Surveyor</label>
                    <div class="col-sm-10">
                        <select id="qs" name="qs" class="form-control">
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
                    <label for="others" class="col-sm-2 col-form-label">Others (Specialist)</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="others" id="others">
                    </div>
                </div>

                @if(isset($project))
                <a href="{{ route('pages.admin.projectsList') }}" class="btn btn-primary">Cancel</a>
                @endif

                <button type="submit" class="btn btn-primary">SAVE</button>

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
</script>

@endsection
