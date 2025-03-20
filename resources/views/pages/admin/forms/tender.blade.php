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
            <h1 class="card-title">Opening/Closing Tender Form</h1>
        </div>
        <div class="card-body">
            <form action="" method="POST" enctype="multipart/form-data">
                @csrf
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
