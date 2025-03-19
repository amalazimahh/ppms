@extends('layouts.app', ['pageSlug' => 'basicdetails'])

@section('content')
<style>
    .nav-tabs .nav-link {
        color: #000;
    }

    .nav-tabs .nav-link.active {
        color: #000;
        background-color: #f6f9fc;
        border-color: #dee2e6 #dee2e6 #f6f9fc;
    }
</style>

<div class="card">
    <div class="card-header mb-2">
        <h1 class="card-title">Project: {{ $project->title }}</h1>
    </div>
    <div class="card-body">
        <!-- Tab Navigation -->
        <ul class="nav nav-tabs" id="projectTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="basic-details-tab" data-toggle="tab" href="#basic-details" role="tab" aria-controls="basic-details" aria-selected="true">
                    Basic Details
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pre-tender-tab" data-toggle="tab" href="#pre-tender" role="tab" aria-controls="pre-tender" aria-selected="false">
                    Pre-Tender
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="project-team-tab" data-toggle="tab" href="#project-team" role="tab" aria-controls="project-team" aria-selected="false">
                    Project Team
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="design-submission-tab" data-toggle="tab" href="#design-submission" role="tab" aria-controls="design-submission" aria-selected="false">
                    Design Submission
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tender-tab" data-toggle="tab" href="#tender" role="tab" aria-controls="tender" aria-selected="false">
                    Opening/Closing Tender
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tender-tab" data-toggle="tab" href="#tender" role="tab" aria-controls="tender" aria-selected="false">
                    Evaluation/Recommendation of Tender
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tender-tab" data-toggle="tab" href="#tender" role="tab" aria-controls="tender" aria-selected="false">
                    Approval of Award
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="contract-tab" data-toggle="tab" href="#contract" role="tab" aria-controls="contract" aria-selected="false">
                    Contract
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="contract-tab" data-toggle="tab" href="#contract" role="tab" aria-controls="contract" aria-selected="false">
                    Banker's Guarantee Form
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="contract-tab" data-toggle="tab" href="#contract" role="tab" aria-controls="contract" aria-selected="false">
                    Insurance Form
                </a>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="projectTabsContent">
            <!-- Basic Details Tab -->
            <div class="tab-pane fade show active" id="basic-details" role="tabpanel" aria-labelledby="basic-details-tab">
                @include('pages.form_details.view_basicdetails', ['project' => $project])
                <a href="froms" class="btn btn-primary">Edit Basic Details</a>
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

            <!-- Contract Tab -->
            <div class="tab-pane fade" id="contract" role="tabpanel" aria-labelledby="contract-tab">
                @include('pages.form_details.view_contract', ['project' => $project])
            </div>
        </div>
    </div>
</div>

<!-- Include Bootstrap JS for tabs functionality -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@endsection
