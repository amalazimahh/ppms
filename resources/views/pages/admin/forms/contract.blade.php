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
            <h1 class="card-title">CONTRACT DETAILS</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('projects.contract.update', $project->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($project))
                    @method('PUT')
                @endif

                <div class="row mb-3">
                    <label for="contractor_id" class="col-sm-2 col-form-label">Main Contractor</label>
                    <div class="col-sm-10">
                        <select id="contractor_id" name="contractor_id" class="form-control">
                            <option value="" disabled selected>-- Select Main Contractor --</option>
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
                    <label for="contractorNum" class="col-sm-2 col-form-label">Contract No.</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="contractorNum" id="contractorNum" placeholder="BSB/DOD/VI.1/2021"
                        value="{{ old('contractorNum', isset($project) ? $project->contractorNum : '') }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="start" class="col-sm-2 col-form-label">Contract Start Date</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="start" id="start">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="end" class="col-sm-2 col-form-label">Contract End Date</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="end" id="end">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="period" class="col-sm-2 col-form-label">Contract Period</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="period" id="period">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="sum" class="col-sm-2 col-form-label">Contract Sum</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="sum" id="sum">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="revSum" class="col-sm-2 col-form-label">Revised Contract Sum</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="revSum" id="revSum">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="lad" class="col-sm-2 col-form-label">Liquidated Ascertained Damages</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="lad" id="lad">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="totalLad" class="col-sm-2 col-form-label">Total Liquidated Ascertained Damages</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="totalLad" id="totalLad">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="cnc" class="col-sm-2 col-form-label">Certificate of Non-Completion (CNC)</label>
                    <div class="col-sm-10">
                        <input type="date" name="cnc" class="form-control" id="cnc">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="revComp" class="col-sm-2 col-form-label">Revised Completion</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="revComp" id="revComp">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="actualComp" class="col-sm-2 col-form-label">Actual Completion</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="actualComp" id="actualComp">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="cpc" class="col-sm-2 col-form-label">Certificate of Practical Completion (CPC)</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="cpc" id="cpc">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="edlp" class="col-sm-2 col-form-label">End of Defects Liability Period</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="edlp" id="edlp">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="cmgd" class="col-sm-2 col-form-label">Certificate of Making Good Defects</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="cmgd" id="cmgd">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="lsk" class="col-sm-2 col-form-label">Laporan Siap Kerja</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="lsk" id="lsk">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="penAmt" class="col-sm-2 col-form-label">Penultimate Amount</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="penAmt" id="penAmt">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="retAmt" class="col-sm-2 col-form-label">Retention Amount</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="retAmt" id="retAmt">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="statDec" class="col-sm-2 col-form-label">Statutory Declaration</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="statDec" id="statDec">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">SAVE</button>

            </form>
        </div>
    </div>

    <!-- handles financial year, amount user enters -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        new Cleave('#sum', {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand',
            prefix: '$',
            numeralDecimalScale: 2,
            numeralPositiveOnly: true,
        });

        new Cleave('#revSum', {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand',
            prefix: '$',
            numeralDecimalScale: 2,
            numeralPositiveOnly: true,
        });

        new Cleave('#lad', {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand',
            prefix: '$',
            numeralDecimalScale: 2,
            numeralPositiveOnly: true,
        });

        new Cleave('#totalLad', {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand',
            prefix: '$',
            numeralDecimalScale: 2,
            numeralPositiveOnly: true,
        });

        new Cleave('#penAmt', {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand',
            prefix: '$',
            numeralDecimalScale: 2,
            numeralPositiveOnly: true,
        });

        new Cleave('#retAmt', {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand',
            prefix: '$',
            numeralDecimalScale: 2,
            numeralPositiveOnly: true,
        });

        new Cleave('#bgAmt', {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand',
            prefix: '$',
            numeralDecimalScale: 2,
            numeralPositiveOnly: true,
        });
    });
</script>
@endsection
