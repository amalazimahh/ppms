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
                    <tr><td class="label">M&E</td><td class="value">{{ $project->projectTeam->mechanicalElectrical->name ?? '' }}</td></tr>
                    <tr><td class="label">Quantity Surveyor</td><td class="value">{{ $project->projectTeam->quantitySurveyor->name ?? '' }}</td></tr>
                </table>
            </td>
        </tr>
    </table>

    <div class="footer">
        Generated by {{ auth()->user()->name }} (Project Manager) on {{ now()->format('d/m/Y H:i:s') }}
    </div>
</body>
</html> 