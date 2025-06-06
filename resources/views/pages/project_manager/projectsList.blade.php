@extends('layouts.app', ['pageSlug' => 'projectsList'])

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
<style>
    .form-control:focus {
        color: #000;
    }
    .form-control:not(:placeholder-shown) {
        color: #000;
    }

    .table-responsive {
        overflow-x: visible;
    }

    .table {
        width: 100%;
        table-layout: fixed;
    }

    .table td {
        white-space: normal;
        word-wrap: break-word;
        vertical-align: middle;
        overflow: hidden;
    }

    .table td.project-title {
        width: 60%;
        padding-right: 15px;
    }

    .table td.progress-column {
        width: 10%;
    }

    .table td.action-buttons {
        width: 30%;
        white-space: nowrap;
    }

    /* animation for notif */
    .alert {
        box-shadow: 0 4px 20px 0 rgba(0,0,0,.14),
                    0 7px 10px -5px rgba(0,188,212,.4);
        border: 0;
        transition: all 0.3s ease;
        position: relative;
        display: inline-block;
        margin-bottom: 10px;
        width: auto;
    }

    .alert-success {
        background-color: #00d25b;
        color: #fff;
    }

    .alert-danger {
        background-color: #fc424a;
        color: #fff;
    }

    .alert .close {
        color: #fff;
        opacity: .9;
        text-shadow: none;
        line-height: 0;
        outline: 0;
    }

    body {
        opacity: 1;
        transition: opacity 300ms ease-in-out;
    }
    body.fade-out {
        opacity: 0;
        transition: none;
    }
</style>
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-primary d-flex justify-content-between align-items-center">
                <h2 class="card-title m-0">PROJECT LIST</h2>

                <button type="button" class="btn btn-success btn-round animation-on-hover" data-bs-toggle="modal" data-bs-target="#addProjectModal">
                    <i class="tim-icons icon-simple-add"></i> Add New Project
                </button>
            </div>

            <div class="card-body">
                @if($projects->isEmpty())
                    <div class="alert alert-warning">
                        No projects available. Please create a new project.
                    </button>
                    </div>
                @else
                <div class="table-responsive">
                    <table class="table">
                        <thead class=" text-primary">
                            <tr>
                                <th style="width: 50%">Title</th>
                                <th style="width: 15%">Progress</th>
                                <th style="width: 35%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($projects as $project)

                                <!-- calculate progress -->
                                @php
                                        $milestones = $project->milestones;

                                        // calculate progress
                                        $totalMilestones = $milestones->count();
                                        $completedMilestones = $milestones->where('pivot.completed', true)->count();
                                        $progress = $totalMilestones > 0 ? round(($completedMilestones / $totalMilestones) * 100) : 0;
                                @endphp
                                <tr>
                                    <td class="project-title"> @if($project->parent_project_id)
                                            {{ $project->parentProject->title }} -
                                        @endif
                                        {{ $project->title }}

                                    </td>
                                    <td class="progress-column">
                                        <!-- progress bar -->
                                        <div class="progress" style="height: 20px;">
                                            <div id="formProgressBar" class="progress-bar" role="progressbar"
                                                style="width: {{ $progress }}%;" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
                                                {{ $progress }}%
                                            </div>
                                        </div>
                                    </td>
                                    <td class="action-buttons">
                                        <!-- view details button -->
                                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#projectDetailsModal{{ $project->id }}">
                                            <i class="tim-icons icon-zoom-split"></i> View Details
                                        </button>

                                        <!-- Project Details Modal -->
                                        <div class="modal fade" id="projectDetailsModal{{ $project->id }}" tabindex="-1" aria-labelledby="projectDetailsModalLabel{{ $project->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-xl modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <style>
                                                        .modal-xl {
                                                            max-width: 85%;
                                                            margin: 2.5rem auto;
                                                        }
                                                        .modal-dialog-scrollable {
                                                            max-height: calc(100vh - 5rem);
                                                        }
                                                        .modal-dialog-scrollable .modal-content {
                                                            border-radius: 15px;
                                                        }
                                                        .modal-dialog-scrollable .modal-body {
                                                            overflow-y: auto;
                                                            padding: 25px 35px;
                                                        }
                                                        .modal-header, .modal-footer {
                                                            flex-shrink: 0;
                                                            background: #fff;
                                                            padding: 1rem 2rem;
                                                        }
                                                        .section-title {
                                                            background: rgb(101, 56, 143);
                                                            color: white;
                                                            padding: 10px 15px;
                                                            margin: 20px 0 15px 0;
                                                            border-radius: 8px;
                                                            font-size: 1.1rem;
                                                            font-weight: 600;
                                                        }
                                                        .details-group {
                                                            display: grid;
                                                            grid-template-columns: repeat(1, 1fr);
                                                            gap: 8px;
                                                        }
                                                        .details-row {
                                                            background: #f8f9fa;
                                                            padding: 12px 20px;
                                                            margin-bottom: 8px;
                                                            border-radius: 5px;
                                                            border-left: 4px solid rgb(101, 56, 143);
                                                            display: flex;
                                                            flex-wrap: wrap;
                                                            gap: 30px;
                                                        }
                                                        .details-item {
                                                            flex: 1;
                                                            min-width: 300px;
                                                            display: flex;
                                                            align-items: center;
                                                        }
                                                        .details-item strong {
                                                            color: #444;
                                                            font-size: 0.9rem;
                                                            min-width: 180px;
                                                            margin-right: 10px;
                                                        }
                                                        .details-item div {
                                                            color: #000;
                                                            flex: 1;
                                                        }
                                                        .details-full {
                                                            flex: 0 0 100%;
                                                        }
                                                        .details-row img {
                                                            max-width: 100%;
                                                            height: auto;
                                                            margin-top: 10px;
                                                        }
                                                    </style>
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="projectDetailsModalLabel{{ $project->id }}">
                                                            <span style="font-weight: bold; color:rgb(101, 56, 143);">PROJECT DETAILS/SUMMARY REPORT</span>
                                                        </h4>
                                                        <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                            <i class="tim-icons icon-simple-remove"></i>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body text-dark" style="background: #fff;">
                                                        <div class="section-title">PROJECT TERMS OF REFERENCE</div>
                                                        <div class="details-group">
                                                            <div class="details-row">
                                                                <div class="details-item">
                                                                    <strong>Financial Year:</strong>
                                                                    <div>{{ $project->fy }}</div>
                                                                </div>
                                                                <div class="details-item">
                                                                    <strong>Vote No.:</strong>
                                                                    <div>{{ $project->voteNum }}</div>
                                                                </div>
                                                            </div>

                                                            @if($project->parent_project_id)
                                                            <div class="details-row">
                                                                <div class="details-item details-full">
                                                                    <strong>Parent Project:</strong>
                                                                    <div>{{ $project->parentProject->title ?? '' }}</div>
                                                                </div>
                                                            </div>
                                                            @endif

                                                            <div class="details-row">
                                                                <div class="details-item details-full">
                                                                    <strong>Title:</strong>
                                                                    <div>{{ $project->title }}</div>
                                                                </div>
                                                            </div>

                                                            <div class="details-row">
                                                                <div class="details-item">
                                                                    <strong>Scheme Value:</strong>
                                                                    <div>${{ $project->sv }}</div>
                                                                </div>
                                                                <div class="details-item">
                                                                    <strong>Allocation Value:</strong>
                                                                    <div>${{ $project->av }}</div>
                                                                </div>
                                                            </div>

                                                            <div class="details-row">
                                                                <div class="details-item">
                                                                    <strong>RKN:</strong>
                                                                    <div>{{ $project->rkn->name ?? '' }}</div>
                                                                </div>
                                                                <div class="details-item">
                                                                    <strong>Client Ministry:</strong>
                                                                    <div>{{ $project->clientMinistry->name ?? '' }}</div>
                                                                </div>
                                                            </div>

                                                            <div class="details-row">
                                                                <div class="details-item">
                                                                    <strong>Location:</strong>
                                                                    <div>{{ $project->location }}</div>
                                                                </div>
                                                                <div class="details-item">
                                                                    <strong>Scope:</strong>
                                                                    <div>{{ $project->scope }}</div>
                                                                </div>
                                                            </div>

                                                            <div class="details-row">
                                                                <div class="details-item">
                                                                    <strong>Site Gazette:</strong>
                                                                    <div>{{ $project->siteGazette }}</div>
                                                                </div>
                                                                <div class="details-item">
                                                                    <strong>Handover Date:</strong>
                                                                    <div>{{ $project->handoverDate }}</div>
                                                                </div>
                                                            </div>

                                                            @if($project->img)
                                                            <div class="details-row details-full">
                                                                <strong>Image:</strong>
                                                                <div><img src="{{ asset('storage/' . $project->img) }}" alt="Project Image" style="max-width:100%;height:auto;margin-top:10px;"></div>
                                                            </div>
                                                            @endif
                                                        </div>

                                                        <div class="section-title">PROJECT TEAM</div>
                                                        <div class="details-group">
                                                            <div class="details-row">
                                                                <div class="details-item">
                                                                    <strong>Officer in Charge:</strong>
                                                                    <div>{{ $project->projectTeam->officerInCharge->name ?? '' }}</div>
                                                                </div>
                                                                <div class="details-item">
                                                                    <strong>Architect:</strong>
                                                                    <div>{{ $project->projectTeam->architect->name ?? '' }}</div>
                                                                </div>
                                                            </div>

                                                            <div class="details-row">
                                                                <div class="details-item">
                                                                    <strong>M/E Engineer:</strong>
                                                                    <div>{{ $project->projectTeam->mechanicalElectrical->name ?? '' }}</div>
                                                                </div>
                                                                <div class="details-item">
                                                                    <strong>C/S Engineer:</strong>
                                                                    <div>{{ $project->projectTeam->civilStructural->name ?? '' }}</div>
                                                                </div>
                                                            </div>

                                                            <div class="details-row">
                                                                <div class="details-item">
                                                                    <strong>Quantity Surveyor:</strong>
                                                                    <div>{{ $project->projectTeam->quantitySurveyor->name ?? '' }}</div>
                                                                </div>
                                                                <div class="details-item">
                                                                    <strong>Others:</strong>
                                                                    <div>{{ $project->projectTeam->others->name ?? '' }}</div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="section-title">PRE-DESIGN DETAILS</div>
                                                        <div class="details-group">
                                                            <div class="details-row">
                                                                <div class="details-item">
                                                                    <strong>RFP/RFQ Number:</strong>
                                                                    <div>{{ $project->preTender->rfpRfqNum ?? '' }}</div>
                                                                </div>
                                                                <div class="details-item">
                                                                    <strong>RFQ Title:</strong>
                                                                    <div>{{ $project->preTender->rfqTitle ?? '' }}</div>
                                                                </div>
                                                            </div>

                                                            <div class="details-row">
                                                                <div class="details-item">
                                                                    <strong>RFQ Fee:</strong>
                                                                    <div>{{ $project->preTender->rfqFee ?? '' }}</div>
                                                                </div>
                                                                <div class="details-item">
                                                                    <strong>Tender Number:</strong>
                                                                    <div>{{ $project->tender->tenderNum ?? '' }}</div>
                                                                </div>
                                                            </div>

                                                            <div class="details-row">
                                                                <div class="details-item">
                                                                    <strong>Cost Amount:</strong>
                                                                    <div>{{ $project->tender->costAmt ?? '' }}</div>
                                                                </div>
                                                                <div class="details-item">
                                                                    <strong>Cost Date:</strong>
                                                                    <div>{{ $project->tender->costDate ?? '' }}</div>
                                                                </div>
                                                            </div>

                                                            <div class="details-row">
                                                                <div class="details-item">
                                                                    <strong>Confirmed Fund Date:</strong>
                                                                    <div>{{ $project->tender->confirmFund ?? '' }}</div>
                                                                </div>
                                                                <div class="details-item">
                                                                    <strong>Opened Date:</strong>
                                                                    <div>{{ $project->preTender->opened ?? '' }}</div>
                                                                </div>
                                                            </div>

                                                            <div class="details-row">
                                                                <div class="details-item">
                                                                    <strong>Closed Date:</strong>
                                                                    <div>{{ $project->preTender->closed ?? '' }}</div>
                                                                </div>
                                                                <div class="details-item">
                                                                    <strong>Extension Date:</strong>
                                                                    <div>{{ $project->preTender->ext ?? '' }}</div>
                                                                </div>
                                                            </div>

                                                            <div class="details-row">
                                                                <div class="details-item">
                                                                    <strong>Validity Extension:</strong>
                                                                    <div>{{ $project->preTender->validity_ext ?? '' }}</div>
                                                                </div>
                                                                <div class="details-item">
                                                                    <strong>JKMKKP Recommendation:</strong>
                                                                    <div>{{ $project->preTender->jkmkkp_recomm ?? '' }}</div>
                                                                </div>
                                                            </div>

                                                            <div class="details-row">
                                                                <div class="details-item">
                                                                    <strong>JKMKKP Approval:</strong>
                                                                    <div>{{ $project->preTender->jkmkkp_approval ?? '' }}</div>
                                                                </div>
                                                                <div class="details-item">
                                                                    <strong>LOA Date:</strong>
                                                                    <div>{{ $project->preTender->loa ?? '' }}</div>
                                                                </div>
                                                            </div>

                                                            <div class="details-row">
                                                                <div class="details-item">
                                                                    <strong>AAC Date:</strong>
                                                                    <div>{{ $project->preTender->aac ?? '' }}</div>
                                                                </div>
                                                                <div class="details-item">
                                                                    <strong>Soil Investigation:</strong>
                                                                    <div>{{ $project->preTender->soilInv ?? '' }}</div>
                                                                </div>
                                                            </div>

                                                            <div class="details-row">
                                                                <div class="details-item">
                                                                    <strong>Topographical Survey:</strong>
                                                                    <div>{{ $project->preTender->topoSurvey ?? '' }}</div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="section-title">DESIGN SUBMISSION DETAILS</div>
                                                        <div class="details-group">
                                                            <div class="details-row">
                                                                <div class="details-item">
                                                                    <strong>KOM Date:</strong>
                                                                    <div>{{ $project->designSubmission->kom ?? '' }}</div>
                                                                </div>
                                                                <div class="details-item">
                                                                    <strong>Concept Approval:</strong>
                                                                    <div>{{ $project->designSubmission->conAppr ?? '' }}</div>
                                                                </div>
                                                            </div>

                                                            <div class="details-row">
                                                                <div class="details-item">
                                                                    <strong>Design Review:</strong>
                                                                    <div>{{ $project->designSubmission->designRev ?? '' }}</div>
                                                                </div>
                                                                <div class="details-item">
                                                                    <strong>Detailed Review:</strong>
                                                                    <div>{{ $project->designSubmission->detailedRev ?? '' }}</div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="section-title">TENDER DETAILS</div>
                                                        <div class="details-group">
                                                            <div class="details-row">
                                                                <div class="details-item">
                                                                    <strong>To Consultant:</strong>
                                                                    <div>{{ $project->tenderRecommendation->toConsultant ?? '' }}</div>
                                                                </div>
                                                                <div class="details-item">
                                                                    <strong>From Consultant:</strong>
                                                                    <div>{{ $project->tenderRecommendation->fromConsultant ?? '' }}</div>
                                                                </div>
                                                            </div>

                                                            <div class="details-row">
                                                                <div class="details-item">
                                                                    <strong>From BPP:</strong>
                                                                    <div>{{ $project->tenderRecommendation->fromBPP ?? '' }}</div>
                                                                </div>
                                                                <div class="details-item">
                                                                    <strong>To DG:</strong>
                                                                    <div>{{ $project->tenderRecommendation->toDG ?? '' }}</div>
                                                                </div>
                                                            </div>

                                                            <div class="details-row">
                                                                <div class="details-item">
                                                                    <strong>To LTK:</strong>
                                                                    <div>{{ $project->tenderRecommendation->toLTK ?? '' }}</div>
                                                                </div>
                                                                <div class="details-item">
                                                                    <strong>LTK Approval:</strong>
                                                                    <div>{{ $project->tenderRecommendation->ltkApproval ?? '' }}</div>
                                                                </div>
                                                            </div>

                                                            <div class="details-row">
                                                                <div class="details-item">
                                                                    <strong>Discount Letter:</strong>
                                                                    <div>{{ $project->tenderRecommendation->discLetter ?? '' }}</div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="section-title">CONTRACT DETAILS</div>
                                                        <div class="details-group">
                                                            <div class="details-row">
                                                                <div class="details-item">
                                                                    <strong>Contractor:</strong>
                                                                    <div>{{ $project->contract->contractor->name ?? '' }}</div>
                                                                </div>
                                                                <div class="details-item">
                                                                    <strong>Contract Number:</strong>
                                                                    <div>{{ $project->contract->contractorNum ?? '' }}</div>
                                                                </div>
                                                            </div>

                                                            <div class="details-row">
                                                                <div class="details-item">
                                                                    <strong>Contract Start Date:</strong>
                                                                    <div>{{ $project->contract->start ?? '' }}</div>
                                                                </div>
                                                                <div class="details-item">
                                                                    <strong>Contract End Date:</strong>
                                                                    <div>{{ $project->contract->end ?? '' }}</div>
                                                                </div>
                                                            </div>

                                                            <div class="details-row">
                                                                <div class="details-item">
                                                                    <strong>Contract Period:</strong>
                                                                    <div>{{ $project->contract->period ?? '' }}</div>
                                                                </div>
                                                                <div class="details-item">
                                                                    <strong>Contract Sum:</strong>
                                                                    <div>{{ $project->contract->sum ?? '' }}</div>
                                                                </div>
                                                            </div>

                                                            <div class="details-row">
                                                                <div class="details-item">
                                                                    <strong>Revised Sum:</strong>
                                                                    <div>{{ $project->contract->revSum ?? '' }}</div>
                                                                </div>
                                                                <div class="details-item">
                                                                    <strong>LAD:</strong>
                                                                    <div>{{ $project->contract->lad ?? '' }}</div>
                                                                </div>
                                                            </div>

                                                            <div class="details-row">
                                                                <div class="details-item">
                                                                    <strong>Total LAD:</strong>
                                                                    <div>{{ $project->contract->totalLad ?? '' }}</div>
                                                                </div>
                                                                <div class="details-item">
                                                                    <strong>CNC:</strong>
                                                                    <div>{{ $project->contract->cnc ?? '' }}</div>
                                                                </div>
                                                            </div>

                                                            <div class="details-row">
                                                                <div class="details-item">
                                                                    <strong>Revised Completion:</strong>
                                                                    <div>{{ $project->contract->revComp ?? '' }}</div>
                                                                </div>
                                                                <div class="details-item">
                                                                    <strong>Actual Completion:</strong>
                                                                    <div>{{ $project->contract->actualComp ?? '' }}</div>
                                                                </div>
                                                            </div>

                                                            <div class="details-row">
                                                                <div class="details-item">
                                                                    <strong>CPC:</strong>
                                                                    <div>{{ $project->contract->cpc ?? '' }}</div>
                                                                </div>
                                                                <div class="details-item">
                                                                    <strong>EDLP:</strong>
                                                                    <div>{{ $project->contract->edlp ?? '' }}</div>
                                                                </div>
                                                            </div>

                                                            <div class="details-row">
                                                                <div class="details-item">
                                                                    <strong>CMGD:</strong>
                                                                    <div>{{ $project->contract->cmgd ?? '' }}</div>
                                                                </div>
                                                                <div class="details-item">
                                                                    <strong>LSK:</strong>
                                                                    <div>{{ $project->contract->lsk ?? '' }}</div>
                                                                </div>
                                                            </div>

                                                            <div class="details-row">
                                                                <div class="details-item">
                                                                    <strong>Penalty Amount:</strong>
                                                                    <div>{{ $project->contract->penAmt ?? '' }}</div>
                                                                </div>
                                                                <div class="details-item">
                                                                    <strong>Retention Amount:</strong>
                                                                    <div>{{ $project->contract->retAmt ?? '' }}</div>
                                                                </div>
                                                            </div>

                                                            <div class="details-row">
                                                                <div class="details-item">
                                                                    <strong>Statutory Declaration:</strong>
                                                                    <div>{{ $project->contract->statDec ?? '' }}</div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="section-title">INSURANCE DETAILS</div>
                                                        <div class="details-group">
                                                            <div class="details-row">
                                                                <div class="details-item">
                                                                    <strong>Insurance Type:</strong>
                                                                    <div>{{ $project->insurance->insuranceType->name ?? '' }}</div>
                                                                </div>
                                                                <div class="details-item">
                                                                    <strong>Insurance Issued:</strong>
                                                                    <div>{{ $project->insurance->insIssued ?? '' }}</div>
                                                                </div>
                                                            </div>

                                                            <div class="details-row">
                                                                <div class="details-item">
                                                                    <strong>Insurance Expiry:</strong>
                                                                    <div>{{ $project->insurance->insExpiry ?? '' }}</div>
                                                                </div>
                                                                <div class="details-item">
                                                                    <strong>Insurance Extension:</strong>
                                                                    <div>{{ $project->insurance->insExt ?? '' }}</div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="section-title">BANKERS GUARANTEE DETAILS</div>
                                                        <div class="details-group">
                                                            <div class="details-row">
                                                                <div class="details-item">
                                                                    <strong>Bankers Guarantee Amount:</strong>
                                                                    <div>{{ $project->bankersGuarantee->bgAmt ?? '' }}</div>
                                                                </div>
                                                                <div class="details-item">
                                                                    <strong>BG Issued:</strong>
                                                                    <div>{{ $project->bankersGuarantee->bgIssued ?? '' }}</div>
                                                                </div>
                                                            </div>

                                                            <div class="details-row">
                                                                <div class="details-item">
                                                                    <strong>BG Expiry:</strong>
                                                                    <div>{{ $project->bankersGuarantee->bgExpiry ?? '' }}</div>
                                                                </div>
                                                                <div class="details-item">
                                                                    <strong>BG Extension:</strong>
                                                                    <div>{{ $project->bankersGuarantee->bgExt ?? '' }}</div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="modal-footer" style="background: #fff; position:sticky; bottom:0; z-index:1020;">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            <a href="{{ route('projects.downloadPDF', $project->id) }}" class="btn btn-primary" target="_blank">
                                                                <i class="fa fa-file-pdf-o"></i> Download PDF
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- edit forms button -->
                                        <a href="{{ route('pages.project_manager.forms.basicdetails', $project->id) }}" class="btn btn-primary btn-sm">
                                            <i class="tim-icons icon-pencil"></i> Edit
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- add project modal -->
 <div class="modal fade" id="addProjectModal" tabindex="-1" aria-labelledby="addProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProjectModalLabel">Add New Project</h5>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <i class="tim-icons icon-simple-remove"></i>
                </button>
            </div>
            <form action="{{ route('projects.store') }}" method="post">
                @csrf
                <div class="modal-body">

                <!-- financial year -->
                <div class="row mb-3">
                    <label for="fy" class="col-sm-2 col-form-label">Financial Year</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="fy" id="fy" placeholder="2020/2021"
                            maxlength="9" oninput="formatFinancialYear(this)"
                            value="{{ old('fy', isset($project) ? $project->fy : '') }}">
                        </div>
                </div>

                <div class="row mb-3">
                    <label for="sv" class="col-sm-2 col-form-label">Scheme Value</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="sv" id="sv"
                            placeholder="$20,000,000.00"
                            value="{{ old('sv', isset($project) ? $project->sv : '') }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="av" class="col-sm-2 col-form-label">Allocation Value</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="av" id="av"
                            placeholder="$3,901,420.00"
                            value="{{ old('av', isset($project) ? $project->av : '') }}">
                    </div>
                </div>

                <input type="hidden" name="parent_project_id" value="{{ old('parent_project_id', isset($project) ? $project->parent_project_id : '') }}">

                <div class="row mb-3">
                    <label for="parent_project_id" class="col-sm-2 col-form-label">Parent Project (Optional)</label>
                    <div class="col-sm-10">
                        <select id="parent_project_id" name="parent_project_id" class="form-control">
                            <option value="">No Parent (New Main Project)</option>
                            @foreach($mainProjects as $parentProject)
                                <option value="{{ $parentProject->id }}"
                                    {{ old('parent_project_id', isset($project) ? $project->parent_project_id : '') == $parentProject->id ? 'selected' : '' }}>
                                    {{ $parentProject->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>


                <div class="row mb-3">
                    <label for="voteNum" class="col-sm-2 col-form-label">Vote No.</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="voteNum" id="voteNum" placeholder="1105-005"
                            value="{{ old('voteNum', isset($project) ? $project->voteNum : '') }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="title" class="col-sm-2 col-form-label">Project Title</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="title" id="title" placeholder="Pembinaan Semula Sekolah Menengah Sultan Hassan Bangar Temburong"
                            value="{{ old('title', isset($project) ? $project->title : '') }}">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Project</button>
                </div>

            </form>
        </div>
    </div>
 </div>

<script>
    function setDeleteUrl(url) {
        document.getElementById('deleteForm').action = url;
    }

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

    // Add fade-out class before page unload
    window.addEventListener('beforeunload', function() {
        document.body.classList.add('fade-out');
    });

// Auto-dismiss after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');

    alerts.forEach(alert => {
        // Manual close
        alert.querySelector('.close').addEventListener('click', function() {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        });

        // Auto-dismiss
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        }, 5000);
    });
});


    // javascript to load the voteNum dynamically
    document.addEventListener('DOMContentLoaded', function () {
        let voteNum = document.getElementById('voteNum');
        let parentProjectSelect = document.getElementById('parent_project_id');

        function updateVoteNum() {
            let parentId = parentProjectSelect.value;

            if (parentId) {
                fetch(`/admin/projects/${parentId}/getVoteNum`) // fetch voteNum from parent
                    .then(response => response.json())
                    .then(data => {
                        voteNum.value = data.voteNum; // set parent voteNum
                        voteNum.setAttribute('readonly', 'readonly'); // disable input
                    })
                    .catch(error => console.error('Error fetching voteNum:', error));
            } else {
                voteNum.value = ''; // clear field
                voteNum.removeAttribute('readonly'); // enable input for manual entry
            }
        }

        parentProjectSelect.addEventListener('change', updateVoteNum);

        updateVoteNum();
    });

</script>

@endsection
