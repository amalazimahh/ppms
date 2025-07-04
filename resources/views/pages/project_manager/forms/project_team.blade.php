@extends('layouts.app', ['pageSlug' => 'basicdetails'])

@if(session('success') || session('error'))
<div style="position: fixed; top: 80px; right: 20px; z-index: 9999; min-width: 300px;">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
            <i class="tim-icons icon-simple-remove"></i>
        </button>
        <span><b>Success - </b> {!! session('success') !!}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
            <i class="tim-icons icon-simple-remove"></i>
        </button>
        <span><b>Error - </b> {{ session('error') }}</span>
    </div>
    @endif
</div>
@endif

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


    <div class="row mb-3">
        <label for="formNavigation" class="col-sm-2 col-form-label">Navigate to Form: </label>
        <div class="col-sm-10">
            <select id="formNavigation" class="form-control" onchange="window.location.href=this.value">
                <option disabled selected>-- Select Form --</option>
                <option value="{{ route('projects.status', $project->id) }}">1. Project Status</option>
                <option value="{{ route('pages.project_manager.forms.basicdetails', $project->id) }}">2. Project Terms of Reference Form</option>
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
            <h1 class="card-title">Project Team</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('projects.project_team.update', $project->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <input type="hidden" name="officer_in_charge" value="{{ auth()->id() }}">

                <div class="row mb-3">
                    <label for="oic" class="col-sm-2 col-form-label">Officer-in-Charge</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control text-white" value="{{ auth()->user()->name }}" readonly>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="architect_id" class="col-sm-2 col-form-label">Architect</label>
                    <div class="col-sm-10">
                        <select id="architect_id" name="architect_id" class="form-control">
                            <option disabled {{ empty($project->projectTeam?->architect_id) ? 'selected' : '' }}>-- Select Architect --</option>
                            @foreach($architects as $architect)
                                <option value="{{ $architect->id }}"
                                {{ (old('architect_id', $project->projectTeam?->architect_id) == $architect->id) ? 'selected' : '' }}>
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
                            <option disabled {{ empty($project->projectTeam?->mechanical_electrical_id) ? 'selected' : '' }}>-- Select Mechanical & Electrical --</option>
                            @foreach($mechanicalElectricals as $mechanicalElectrical)
                                <option value="{{ $mechanicalElectrical->id }}"
                                {{ (old('mechanical_electrical_id', $project->projectTeam?->mechanical_electrical_id) == $mechanicalElectrical->id) ? 'selected' : '' }}>
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
                            <option disabled {{ empty($project->projectTeam?->civil_structural_id) ? 'selected' : '' }}>-- Select Civil & Structural --</option>
                            @foreach($civilStructurals as $civilStructural)
                                <option value="{{ $civilStructural->id }}"
                                {{ (old('civil_structural_id', $project->projectTeam?->civil_structural_id) == $civilStructural->id) ? 'selected' : '' }}>
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
                            <option disabled {{ empty($project->projectTeam?->quantity_surveyor_id) ? 'selected' : '' }}>-- Select Quantity Surveyor --</option>
                            @foreach($quantitySurveyors as $quantitySurveyor)
                                <option value="{{ $quantitySurveyor->id }}"
                                {{ (old('quantity_surveyor_id', $project->projectTeam?->quantity_surveyor_id) == $quantitySurveyor->id) ? 'selected' : '' }}>
                                    {{ $quantitySurveyor->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">SAVE</button>

            </form>
        </div>
    </div>

@endsection
