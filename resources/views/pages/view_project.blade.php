@extends('layouts.app', ['pageSlug' => 'basicdetails'])

@section('content')
<style>
    /* Vertical Tabs Styling */
    .vertical-tabs {
        display: flex;
        align-items: flex-start;
    }

    .nav-tabs {
        flex-direction: column;
        border-bottom: none;
        width: 330px; /* Fixed width for tabs */
        flex-shrink: 0; /* Prevent tabs from shrinking */
    }

    .nav-tabs .nav-link {
        color: #000;
        border: 1px solid transparent;
        border-radius: 0.25rem 0 0 0.25rem;
        padding: 0.75rem 1rem;
        margin-bottom: 0.25rem;
        text-align: left;
        white-space: nowrap; /* Prevent text wrapping */
        width: 100%; /* Ensure all tabs have the same width */
        box-sizing: border-box; /* Include padding and border in the width */
    }

    .nav-tabs .nav-link.active {
        color: #000;
        background-color: #f6f9fc;
        border-color: #dee2e6 #f6f9fc #dee2e6 #dee2e6;
    }

    .nav-tabs .nav-link:hover {
        border-color: #e9ecef #e9ecef #e9ecef #dee2e6;
    }

    .tab-content {
        flex-grow: 1;
        width: calc(100% - 250px); /* Adjust according to nav-tabs width */
        padding: 5px 20px 20px 20px;
        border: 1px solid #dee2e6;
        min-height: 400px; /* Prevent collapsing */
        box-sizing: border-box;
    }
</style>

<div class="card">
    <div class="card-header mb-2">
        <h1 class="card-title">Project: {{ $project->title }}</h1>
    </div>
    <div class="card-body">
        <!-- Vertical Tabs Container -->
        <div class="vertical-tabs">
            <!-- Tab Navigation -->
            <ul class="nav nav-tabs" id="projectTabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="basic-details-tab" data-toggle="tab" href="#basic-details" role="tab" aria-controls="basic-details" aria-selected="true">
                        i. Basic Details
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="pre-tender-tab" data-toggle="tab" href="#pre-tender" role="tab" aria-controls="pre-tender" aria-selected="false">
                        ii. Pre-Tender
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="project-team-tab" data-toggle="tab" href="#project-team" role="tab" aria-controls="project-team" aria-selected="false">
                        iii. Project Team
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="design-submission-tab" data-toggle="tab" href="#design-submission" role="tab" aria-controls="design-submission" aria-selected="false">
                        iv. Design Submission
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tender-tab" data-toggle="tab" href="#tender" role="tab" aria-controls="tender" aria-selected="false">
                       v.  Opening/Closing Tender
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tender-recomm-tab" data-toggle="tab" href="#tender-recomm" role="tab" aria-controls="tender-recomm" aria-selected="false">
                        vi. Evaluation/Recommendation of Tender
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="award-tab" data-toggle="tab" href="#award" role="tab" aria-controls="award" aria-selected="false">
                        vii. Approval of Award
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="contract-tab" data-toggle="tab" href="#contract" role="tab" aria-controls="contract" aria-selected="false">
                        viii. Contract
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="bankers-tab" data-toggle="tab" href="#bankers" role="tab" aria-controls="bankers" aria-selected="false">
                        ix. Banker's Guarantee Form
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="insurance-tab" data-toggle="tab" href="#insurance" role="tab" aria-controls="insurance" aria-selected="false">
                        x. Insurance Form
                    </a>
                </li>
            </ul>

            <!-- Tab Content -->
            <div class="tab-content" id="projectTabsContent">
                <!-- Basic Details Tab -->
                <div class="tab-pane fade show active" id="basic-details" role="tabpanel" aria-labelledby="basic-details-tab">
                    @include('pages.form_details.view_basicdetails', ['project' => $project])
                    <a href="{{ route('projects.edit', ['id' => $project->id, 'form' => 'basicdetails' ]) }}" class="btn btn-primary">Edit</a>
                </div>

                <!-- Pre-Tender Tab -->
                <div class="tab-pane fade" id="pre-tender" role="tabpanel" aria-labelledby="pre-tender-tab">
                    @include('pages.form_details.view_predesign', ['project' => $project])
                </div>

                <!-- Project Team Tab -->
                <div class="tab-pane fade" id="project-team" role="tabpanel" aria-labelledby="project-team-tab">
                    @include('pages.form_details.view_projectteam', ['project' => $project])
                </div>

                <!-- Design Submission Tab -->
                <div class="tab-pane fade" id="design-submission" role="tabpanel" aria-labelledby="design-submission-tab">
                    @include('pages.form_details.view_design', ['project' => $project])
                </div>

                <!-- Tender Tab -->
                <div class="tab-pane fade" id="tender" role="tabpanel" aria-labelledby="tender-tab">
                    @include('pages.form_details.view_tender', ['project' => $project])
                </div>

                <!-- Tender Recommendation Tab -->
                <div class="tab-pane fade" id="tender-recomm" role="tabpanel" aria-labelledby="tender-recomm-tab">
                    @include('pages.form_details.view_tender_recomm', ['project' => $project])
                </div>

                <!-- Approval of Award Tab -->
                <div class="tab-pane fade" id="award" role="tabpanel" aria-labelledby="award-tab">
                    @include('pages.form_details.view_award', ['project' => $project])
                </div>

                <!-- Contract Tab -->
                <div class="tab-pane fade" id="contract" role="tabpanel" aria-labelledby="contract-tab">
                    @include('pages.form_details.view_contract', ['project' => $project])
                </div>

                <!-- Banker's Guarantee Tab -->
                <div class="tab-pane fade" id="bankers" role="tabpanel" aria-labelledby="bankers-tab">
                    @include('pages.form_details.view_bankers_details', ['project' => $project])
                </div>

                <!-- Insurance Tab -->
                <div class="tab-pane fade" id="insurance" role="tabpanel" aria-labelledby="insurance-tab">
                    @include('pages.form_details.view_insurance_details', ['project' => $project])
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Bootstrap JS for tabs functionality -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
