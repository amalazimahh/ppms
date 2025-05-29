<!DOCTYPE html>
<html>
<head>
    <title>Project Summary Details</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
        }
        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
        }
        .title {
            font-size: 26px;
            color:rgb(165, 22, 170);
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        <div class="title">PROJECT DETAILS/SUMMARY REPORT</div>
        <table class="table" width="100%" style="border-collapse: collapse; margin-top: 20px;">
            <tr>
                <td style="border: 1px solid #000; padding: 4px;"><strong>RKN:</strong> {{ $project->rkn_id->rknNum ?? '' }}</td>
                <td style="border: 1px solid #000; padding: 4px;"><strong>Financial Year:</strong> {{ $project->fy }}</td>
                <td style="border: 1px solid #000; padding: 4px;"><strong>Vote No.:</strong> {{ $project->voteNum }}</td>
            </tr>
            <tr>
                <td style="border: 1px solid #000; padding: 4px;" colspan="3">
                    @if($project->parent_project_id)
                        <strong>Parent Project:</strong> {{ $project->parentProject->title }}<br>
                    @endif
                    <strong>Title:</strong> {{ $project->title }}
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
