<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Project Report</title>
    <style>
        @page {
            size: A3 landscape;
            margin: 0.5cm;
        }
        * {
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 9pt;
            line-height: 1.2;
            margin: 0;
            padding: 0;
        }
        .header {
            position: relative;
            text-align: center;
            margin-bottom: 10px;
            height: 50px;
        }
        .logos {
            position: absolute;
            top: 0;
            right: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .logo {
            max-height: 60px;
        }
        .report-title {
            font-size: 14pt;
            font-weight: bold;
            color: rgb(101, 56, 143);
            padding-top: 10px;
        }
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            text-align: center;
            font-size: 8pt;
            color: #666;
            padding: 5px;
            border-top: 1px solid #ccc;
        }
        .section {
            background: rgb(101, 56, 143);
            color: white;
            font-weight: bold;
            padding: 4px 8px;
            font-size: 9pt;
        }
        td {
            padding: 4px 8px;
            border: 1px solid #ccc;
            vertical-align: top;
        }
        .label {
            width: 120px;
            font-weight: normal;
        }
        .value {
            background: #fff;
        }
        .progress-container {
            display: flex;
            gap: 10px;
            margin-top: 5px;
        }
        .progress-chart {
            flex: 1;
            height: 100px;
            border: 1px solid #ccc;
            padding: 5px;
            position: relative;
        }
        .chart-title {
            text-align: center;
            font-weight: bold;
            margin-bottom: 5px;
            color: rgb(101, 56, 143);
        }
        .bar-container {
            display: flex;
            height: 60px;
            align-items: flex-end;
            gap: 20px;
            justify-content: center;
        }
        .bar-group {
            width: 30px;
            text-align: center;
        }
        .bar {
            width: 100%;
            background-color: #1d8cf8;
            margin-bottom: 5px;
        }
        .bar.actual {
            background-color: #00f2c3;
        }
        .bar-label {
            font-size: 8pt;
        }
        .y-axis {
            position: absolute;
            left: 5px;
            top: 20px;
            bottom: 20px;
            width: 20px;
            border-right: 1px solid #ccc;
        }
        .y-label {
            position: absolute;
            right: 25px;
            transform: translateY(-50%);
            font-size: 8pt;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logos">
            <img src="{{ public_path('images/dod_logo.png') }}" alt="Logo DOD" class="logo">
            <img src="{{ public_path('images/pwd_logo.png') }}" alt="Logo PWD" class="logo">
        </div>
        <div class="report-title">PROJECT DETAILS/SUMMARY REPORT</div>
    </div>

    <!-- ROW 1: Terms of Reference + Pre-Design + Project Team -->
    <table style="width: 100%; table-layout: fixed;">
        <tr>
            <td style="width: 35%; vertical-align: top;">
                <table width="100%">
                    <tr><td colspan="4" class="section"><span>1.</span>PROJECT TERMS OF REFERENCE</td></tr>
                    <tr>
                        <td class="label">RKN</td><td class="value">{{ $project->rkn->name ?? '' }}</td>
                        <td class="label">Financial Year</td><td class="value">{{ $project->fy }}</td>
                    </tr>
                    <tr>
                        <td class="label">Scheme Value</td><td class="value">${{ $project->sv }}</td>
                        <td class="label">Allocation Value</td><td class="value">${{ $project->av }}</td>
                    </tr>
                    <tr>
                        <td class="label">Vote No.</td><td class="value">{{ $project->voteNum }}</td>
                        <td class="label">Title</td><td class="value">{{ $project->title }}</td>
                    </tr>
                    <tr><td class="label">Client Ministry</td><td colspan="4" class="value">{{ $project->clientMinistry->name ?? '' }}</td></tr>
                    <tr>
                        <td class="label">Project Handover (to DOD)</td><td class="value">{{ $project->handoverDate ?? '' }}</td>
                        <td class="label">Site Gazette</td><td class="value">{{ $project->siteGazette }}</td>
                    </tr>
                    <tr><td class="label">Scope</td><td colspan="4" class="value">{{ $project->scope }}</td></tr>
                    <tr><td class="label">Location</td><td colspan="4" class="value">{{ $project->location }}</td></tr>
                </table>
            </td>
            <td style="width: 40%; vertical-align: top;">
                <table width="100%">
                    <tr><td colspan="4" class="section"><span>2.</span>PRE-DESIGN DETAILS</td></tr>
                    <tr>
                        <td class="label">RFP/RFQ No</td><td class="value">{{ $project->preTender->rfpRfqNum ?? '' }}</td>
                        <td class="label">RFQ Fee</td><td class="value">{{ $project->preTender->rfqFee ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Opened</td><td class="value">{{ $project->preTender->opened ?? '' }}</td>
                        <td class="label">Closed</td><td class="value">{{ $project->preTender->closed ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Extended</td><td class="value">{{ $project->preTender->ext ?? '' }}</td>
                        <td class="label">Validity Extended</td><td class="value">{{ $project->preTender->validity_extext ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Recommendation to JKMKKP</td><td class="value">{{ $project->preTender->jkmkkp_recomm ?? '' }}</td>
                        <td class="label">JKMKKP Approval</td><td class="value">{{ $project->preTender->jkmkkp_approval ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Letter of Award (LOA)</td><td class="value">{{ $project->preTender->loa ?? '' }}</td>
                        <td class="label">Agreement for Appointment of Consultant (AAC)</td><td class="value">{{ $project->preTender->aac ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Soil Investigation</td><td class="value">{{ $project->preTender->soilInv ?? '' }}</td>
                        <td class="label">Topological Survey</td><td class="value">{{ $project->preTender->topoSurvey ?? '' }}</td>
                    </tr>
                </table>
            </td>
            <td style="width: 25%; vertical-align: top;">
                <table width="100%">
                    <tr><td colspan="2" class="section"><span>3.</span>PROJECT TEAM DETAILS</td></tr>
                    <tr><td class="label">Officer-in-Charge</td><td class="value">{{ $project->projectTeam->officerInCharge->name ?? '' }}</td></tr>
                    <tr><td class="label">Architect</td><td class="value">{{ $project->projectTeam->architect->name ?? '' }}</td></tr>
                    <tr><td class="label">Civil & Structural</td><td class="value">{{ $project->projectTeam->civilStructural->name ?? '' }}</td></tr>
                    <tr><td class="label">Mechanical & Electrical</td><td class="value">{{ $project->projectTeam->mechanicalElectrical->name ?? '' }}</td></tr>
                    <tr><td class="label">Quantity Surveyor</td><td class="value">{{ $project->projectTeam->quantitySurveyor->name ?? '' }}</td></tr>
                    <tr><td class="label">Specialist</td><td class="value">{{ $project->projectTeam->others->name ?? '' }}</td></tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- ROW 2: Design Submission + Tender Details -->
    <table style="width: 100%; table-layout: fixed;">
        <tr>
            <td style="width: 20%; vertical-align: top;">
                <table width="100%">
                    <tr><td colspan="2" class="section"><span>4.</span>DESIGN SUBMISSION DETAILS</td></tr>
                    <tr>
                        <td class="label">Kick-off Meeting</td>
                        <td class="value">{{ $project->designSubmission->kom ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Concept Approval</td>
                        <td class="value">{{ $project->designSubmission->conAppr ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Design Review</td>
                        <td class="value">{{ $project->designSubmission->designRev ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Detailed Design Review</td>
                        <td class="value">{{ $project->designSubmission->detailedRev ?? '' }}</td>
                    </tr>
                </table>
            </td>
            <td style="width: 80%; vertical-align: top;">
                <table width="100%">
                    <tr><td colspan="12" class="section"><span>5.</span>TENDER DETAILS</td></tr>
                    <tr>
                        <td colspan="4" style="text-align: center; background: #f8f9fa;">Opening/Closing Tender</td>
                        <td colspan="4" style="text-align: center; background: #f8f9fa;">Tender Recommendation/Evaluation</td>
                        <td colspan="4" style="text-align: center; background: #f8f9fa;">Approval of Award</td>
                    </tr>
                    <tr>
                        <td class="label">Confirmation Fund</td>
                        <td class="value">{{ $project->tender->confirmationFund ?? '' }}</td>
                        <td class="label">Cost Estimate</td>
                        <td class="value">{{ $project->tender->costAmt ?? '' }}</td>
                        <td class="label">Recommendation to Consultant</td>
                        <td class="value">{{ $project->tender_recommendation->toConsultant ?? '' }}</td>
                        <td class="label">From Consultant</td>
                        <td class="value">{{ $project->tender_recommendation->fromConsultant ?? '' }}</td>
                        <td class="label">Letter of Award Issued</td>
                        <td colspan="3" class="value">{{ $project->award->loaIssued ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Cost Estimate Date</td>
                        <td class="value">{{ $project->tender->costDate ?? '' }}</td>
                        <td class="label">Tender No.</td>
                        <td class="value">{{ $project->tender->tenderNum ?? '' }}</td>
                        <td class="label">From BPP</td>
                        <td colspan="3" class="value">{{ $project->tender_recommendation->fromBPP ?? '' }}</td>
                        <td class="label">Letter of Award</td>
                        <td colspan="3" class="value">{{ $project->award->loa ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Opened (1st)</td>
                        <td class="value">{{ $project->tender->openedFirst ?? '' }}</td>
                        <td class="label">Opened (2nd)</td>
                        <td class="value">{{ $project->tender->openedSec ?? '' }}</td>
                        <td class="label">To DG</td>
                        <td colspan="3" class="value">{{ $project->tender_recommendation->toDG ?? '' }}</td>
                        <td class="label">LAD</td>
                        <td colspan="3" class="value">{{ $project->award->ladDay ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Closed</td>
                        <td class="value">{{ $project->tender->closed ?? '' }}</td>
                        <td class="label">Extended</td>
                        <td class="value">{{ $project->tender->ext ?? '' }}</td>
                        <td class="label">To LTK</td>
                        <td colspan="3" class="value">{{ $project->tender_recommendation->toLTK ?? '' }}</td>
                        <td class="label">Doc Preparation</td>
                        <td colspan="3" class="value">{{ $project->award->docPrep ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Validity</td>
                        <td class="value">{{ $project->tender->validity ?? '' }}</td>
                        <td class="label">Validity Extended</td>
                        <td class="value">{{ $project->tender->validity_ext ?? '' }}</td>
                        <td class="label">LTK Approval</td>
                        <td colspan="3" class="value">{{ $project->tender_recommendation->ltkApproval ?? '' }}</td>
                        <td class="label">Contract Signed</td>
                        <td colspan="3" class="value">{{ $project->award->conSigned ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Cancelled</td>
                        <td colspan="3" class="value">{{ $project->tender->cancelled ?? '' }}</td>
                        <td class="label">Discount Letter</td>
                        <td colspan="3" class="value">{{ $project->tender_recommendation->discLetter ?? '' }}</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <!-- ROW 3: Contract Details + Progress Charts -->
    <table style="width: 100%; table-layout: fixed;">
        <tr>
            <td style="width: 70%; vertical-align: top;">
                <table width="100%">
                    <tr><td colspan="12" class="section"><span>6.</span>CONTRACT DETAILS</td></tr>
                    <!-- contract details -->
                    <tr><td colspan="12" style="text-align: center; background: #f8f9fa;">Contract Information</td></tr>
                    <tr>
                        <td class="label">Contractor</td>
                        <td colspan="5" class="value">{{ $project->contract->contractor->name ?? '' }}</td>
                        <td class="label">Contract No.</td>
                        <td colspan="5" class="value">{{ $project->contract->contractNum ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Start Date</td>
                        <td colspan="3" class="value">{{ $project->contract->start ?? '' }}</td>
                        <td class="label">End Date</td>
                        <td colspan="3" class="value">{{ $project->contract->end ?? '' }}</td>
                        <td class="label">Period</td>
                        <td colspan="3" class="value">{{ $project->contract->period ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Contract Sum</td>
                        <td colspan="3" class="value">{{ $project->contract->sum ?? '' }}</td>
                        <td class="label">Revised Sum</td>
                        <td colspan="3" class="value">{{ $project->contract->revSum ?? '' }}</td>
                        <td class="label">LAD</td>
                        <td colspan="3" class="value">{{ $project->contract->lad ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Total LAD</td>
                        <td colspan="3" class="value">{{ $project->contract->totalLad ?? '' }}</td>
                        <td class="label">CNC</td>
                        <td colspan="3" class="value">{{ $project->contract->cnc ?? '' }}</td>
                        <td class="label">Rev. Completion</td>
                        <td colspan="3" class="value">{{ $project->contract->revComp ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Actual Completion</td>
                        <td colspan="3" class="value">{{ $project->contract->actualComp ?? '' }}</td>
                        <td class="label">CPC</td>
                        <td colspan="3" class="value">{{ $project->contract->cpc ?? '' }}</td>
                        <td class="label">EDLP</td>
                        <td colspan="3" class="value">{{ $project->contract->edlp ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="label">CMGD</td>
                        <td colspan="3" class="value">{{ $project->contract->cmgd ?? '' }}</td>
                        <td class="label">LSK</td>
                        <td colspan="3" class="value">{{ $project->contract->lsk ?? '' }}</td>
                        <td class="label">Penultimate</td>
                        <td colspan="3" class="value">{{ $project->contract->penAmt ?? '' }}</td>
                    </tr>
                    <tr>
                        <td class="label">Retention</td>
                        <td colspan="5" class="value">{{ $project->contract->retAmt ?? '' }}</td>
                        <td class="label">Statutory Dec.</td>
                        <td colspan="5" class="value">{{ $project->contract->statDec ?? '' }}</td>
                    </tr>

                    <!-- banker's guarantee details -->
                    <tr><td colspan="12" style="text-align: center; background: #f8f9fa;">Banker's Guarantee</td></tr>
                    <tr>
                        <td class="label">Amount</td>
                        <td colspan="2" class="value">{{ $project->bankersGuarantee->bgAmt ?? '' }}</td>
                        <td class="label">Issued</td>
                        <td colspan="2" class="value">{{ $project->bankersGuarantee->bgIssued ?? '' }}</td>
                        <td class="label">Expiry</td>
                        <td colspan="2" class="value">{{ $project->bankersGuarantee->bgExpiry ?? '' }}</td>
                        <td class="label">Extended</td>
                        <td colspan="2" class="value">{{ $project->bankersGuarantee->bgExt ?? '' }}</td>
                    </tr>

                    <!-- insurance details -->
                    <tr><td colspan="12" style="text-align: center; background: #f8f9fa;">Insurance</td></tr>
                    <tr>
                        <td class="label">Type</td>
                        <td colspan="2" class="value">{{ $project->insurance->insuranceType->name ?? '' }}</td>
                        <td class="label">Issued</td>
                        <td colspan="2" class="value">{{ $project->insurance->insIssued ?? '' }}</td>
                        <td class="label">Expiry</td>
                        <td colspan="2" class="value">{{ $project->insurance->insExpiry ?? '' }}</td>
                        <td class="label">Extended</td>
                        <td colspan="2" class="value">{{ $project->insurance->insExt ?? '' }}</td>
                    </tr>
                </table>
            </td>
            <td style="width: 30%; vertical-align: top;">
                <div class="progress-container">
                    <div class="progress-chart">
                        <div class="chart-title">Physical Progress</div>
                        <div class="y-axis">
                            <div class="y-label" style="top: 0">100%</div>
                            <div class="y-label" style="top: 50%">50%</div>
                            <div class="y-label" style="top: 100%">0%</div>
                        </div>
                        <div class="bar-container">
                            <div class="bar-group">
                                <div class="bar" style="height: {{ $project->physical_status ? $project->physical_status->scheduled : 0 }}%"></div>
                                <div class="bar-label">Expected</div>
                            </div>
                            <div class="bar-group">
                                <div class="bar actual" style="height: {{ $project->physical_status ? $project->physical_status->actual : 0 }}%"></div>
                                <div class="bar-label">Actual</div>
                            </div>
                        </div>
                    </div>
                    <div class="progress-chart">
                        <div class="chart-title">Financial Progress</div>
                        <div class="y-axis">
                            <div class="y-label" style="top: 0">100%</div>
                            <div class="y-label" style="top: 50%">50%</div>
                            <div class="y-label" style="top: 100%">0%</div>
                        </div>
                        <div class="bar-container">
                            <div class="bar-group">
                                <div class="bar" style="height: {{ $project->financial_status ? $project->financial_status->scheduled : 0 }}%"></div>
                                <div class="bar-label">Expected</div>
                            </div>
                            <div class="bar-group">
                                <div class="bar actual" style="height: {{ $project->financial_status ? $project->financial_status->actual : 0 }}%"></div>
                                <div class="bar-label">Actual</div>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <div class="footer">
        Generated by: {{ auth()->user()->name }} | {{ date('d/m/Y H:i:s') }}
    </div>
</body>
</html>
