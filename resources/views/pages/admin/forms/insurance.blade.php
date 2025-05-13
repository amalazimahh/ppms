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
    <div id="progressLabel" class="mt-2" style="text-align: center;">Project Title: </div>

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
            <h1 class="card-title">Insurance Form</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('projects.insurance.update', $project->id) }}" method="POST" enctype="multipart/form-data">
                @csrf

                @if(isset($project))
                    @method('PUT')
                @endif

                <div class="row mb-3">
                    <label for="insType" class="col-sm-2 col-form-label">Insurance Type</label>
                    <div class="col-sm-10">
                        <!-- dropdown selection here -->
                        <input type="text" class="form-control" name="insType" id="insType">
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

                <a href="{{ route('projects.bankers_guarantee', $project->id) }}" class="btn btn-primary">Back</a>
                <button type="submit" class="btn btn-primary">SAVE</button>
            </form>
        </div>
    </div>
@endsection
