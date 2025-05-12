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
            <h1 class="card-title">Design Form</h1>
        </div>
        <div class="card-body">
            <form action="" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- first row -->
                <!-- <div class="form-row"> -->
                    <!-- financial year -->
                    <div class="row mb-3">
                    <label for="kom" class="col-sm-2 col-form-label">Kick Off Meeting</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="kom" id="kom">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="conAppr" class="col-sm-2 col-form-label">Concept Approval</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="conAppr" id="conAppr">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="designRev" class="col-sm-2 col-form-label">Design Review</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="designRev" id="designRev">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="detailedRev" class="col-sm-2 col-form-label">Detailed Design Review</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="detailedRev" id="detailedRev">
                    </div>
                </div>

                <a href="{{ route('projects.project_team', $project->id) }}" class="btn btn-primary">Back</a>
                <button type="submit" class="btn btn-primary">SAVE</button>
                <a href="{{ route('projects.tender', $project->id) }}" class="btn btn-primary">Next</a>
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
