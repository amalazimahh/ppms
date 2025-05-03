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
            border: 1px solid #eee;
        }
        .title {
            font-size: 36px;
            color: #4caf50;
        }
    </style>
</head>
<body>
    <div class="invoice-box">
        <div class="title">Project Summary Details</div>
        <hr>
        <p><strong>Financial Year:</strong> {{ $project->fy }}</p>
        <p><strong>Vote No.:</strong> {{ $project->voteNum }}</p>
        @if($project->parent_project_id)
            <p><strong>Parent Project:</strong> {{ $project->parentProject->title }}</p>
        @endif
        <p><strong>Title:</strong> {{ $project->title }}</p>
        <p><strong>Scheme Value: $</strong> {{ $project->sv }}</p>
        <p><strong>Allocation Value: $</strong> {{ $project->av }}</p>
    </div>
</body>
</html>
