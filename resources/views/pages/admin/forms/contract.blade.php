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
            <h1 class="card-title">CONTRACT DETAILS</h1>
        </div>
        <div class="card-body">
            <form action="" method="POST" enctype="multipart/form-data">
                @csrf

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

                <a href="{{ route('projects.approval_award', $project->id) }}" class="btn btn-primary">Back</a>
                <button type="submit" class="btn btn-primary">SAVE</button>
                <a href="{{ route('projects.bankers_guarantee', $project->id) }}" class="btn btn-primary">Next</a>
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
