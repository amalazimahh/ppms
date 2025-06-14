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
            background-color: #f6f9fc,
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
            <h1 class="card-title">Insurance Form</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('projects.insurance.update', $project->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                @if(isset($project))
                    @method('PUT')
                @endif

                <div class="row mb-3">
                    <label for="insurance_type_id" class="col-sm-2 col-form-label">Insurance Type</label>
                    <div class="col-sm-10">
                        <select id="insurance_type_id" name="insurance_type_id" class="form-control">
                            <option disabled {{ empty($insurance->insurance_type_id) ? 'selected' : '' }}>-- Select Insurance Type --</option>
                            @foreach($insuranceType as $types)
                                <option value="{{ $types->id }}"
                                {{ (old('insurance_type_id', isset($insurance) ? $insurance->insurance_type_id : '') == $types->id) ? 'selected' : '' }}>
                                    {{ $types->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="insIssued" class="col-sm-2 col-form-label">Insurance Issued</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="insIssued" id="insIssued">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="insExpiry" class="col-sm-2 col-form-label">Insurance Expiry</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="insExpiry" id="insExpiry">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="insExt" class="col-sm-2 col-form-label">Insurance Extended</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="insExt" id="insExt">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">SAVE</button>

            </form>
        </div>
    </div>
@endsection
