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
            <h1 class="card-title">Approval of Award</h1>
        </div>
        <div class="card-body">
            <form action="" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row mb-3">
                    <label for="loaIssued" class="col-sm-2 col-form-label">Letter of Award Issued</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="loaIssued" id="loaIssued">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="loa" class="col-sm-2 col-form-label">Letter of Award (LOA)</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="loa" id="loa">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="ladDay" class="col-sm-2 col-form-label">Liquidated Ascertained Damages (LAD)</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="ladDay" id="ladDay">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="docPrep" class="col-sm-2 col-form-label">Document Preparation</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="docPrep" id="docPrep">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="conSigned" class="col-sm-2 col-form-label">Contract Signed Date</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="conSigned" id="conSigned">
                    </div>
                </div>

                <a href="{{ route('projects.tender_recommendation', $project->id) }}" class="btn btn-primary">Back</a>
                <button type="submit" class="btn btn-primary">SAVE</button>
                <a href="{{ route('projects.contract', $project->id) }}" class="btn btn-primary">Next</a>
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
