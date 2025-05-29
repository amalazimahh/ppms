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
            <h1 class="card-title">Opening/Closing Tender Form</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('projects.tender.update', $project->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($project))
                    @method('PUT')
                @endif
                <div class="row mb-3">
                    <label for="confirmFund" class="col-sm-2 col-form-label">Confirmation Fund</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="confirmFund" id="confirmFund">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="costAmt" class="col-sm-2 col-form-label">Cost Estimate Amount</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="costAmt" id="costAmt" placeholder="$490,760.00">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="costDate" class="col-sm-2 col-form-label">Cost Estimate Date</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="costDate" id="costDate">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="tenderNum" class="col-sm-2 col-form-label">Tender No.</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="tenderNum" id="tenderNum" placeholder="JKR/DOD/1/2019">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="openedFirst" class="col-sm-2 col-form-label">Tender Opened First</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="openedFirst" id="openedFirst">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="openedSec" class="col-sm-2 col-form-label">Tender Opened Second</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="openedSec" id="openedSec">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="closed" class="col-sm-2 col-form-label">Tender Closed</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="closed" id="closed">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="ext" class="col-sm-2 col-form-label">Tender Extended</label>
                    <div class="col-sm-10">
                        <input type="date" name="ext" class="form-control" id="ext">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="validity" class="col-sm-2 col-form-label">Tender Validity</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="validity" id="validity">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="validity_ext" class="col-sm-2 col-form-label">Tender Validity Extended</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="validity_ext" id="validity_ext">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="cancelled" class="col-sm-2 col-form-label">Tender Cancelled</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="cancelled" id="cancelled">
                    </div>
                </div>

                <a href="{{ route('projects.design_submission', $project->id) }}" class="btn btn-primary">Back</a>
                <button type="submit" class="btn btn-primary">SAVE</button>
                <a href="{{ route('projects.tender_recommendation', $project->id) }}" class="btn btn-primary">Next</a>
            </form>
        </div>
    </div>

    <!-- handles financial year, amount user enters -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        new Cleave('#costAmt', {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand',
            prefix: '$',
            numeralDecimalScale: 2,
            numeralPositiveOnly: true,
        });
    });
</script>
@endsection
