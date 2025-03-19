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

    <div class="card">
        <div class="card-header mb-2">
            <h1 class="card-title">PRE-TENDER DETAILS</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('pre_tender.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row mb-3">
                    <label for="rfpRfqNum" class="col-sm-2 col-form-label">RFP/RFQ No.</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="rfpRfqNum" id="rfpRfqNum" placeholder="JKR/RFQ/DOD/01/2021">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="rfqTitle" class="col-sm-2 col-form-label">RFQ Title</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="rfqTitle" id="rfqTitle" placeholder="">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="rfqFee" class="col-sm-2 col-form-label">RFQ Fee</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="rfqFee" id="rfqFee" placeholder="$3,901,420.00">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="opened" class="col-sm-2 col-form-label">Opened</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="opened" id="opened">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="closed" class="col-sm-2 col-form-label">Closed</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="closed" id="closed">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="ext" class="col-sm-2 col-form-label">Extended</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="ext" id="ext">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="validity_ext" class="col-sm-2 col-form-label">Validity Extended</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="validity_ext" id="validity_ext">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="jkmkkp_recomm" class="col-sm-2 col-form-label">Recommendation to JKMKKP</label>
                    <div class="col-sm-10">
                        <input type="date" name="jkmkkp_recomm" class="form-control" id="jkmkkp_recomm">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="jkmkkp_approval" class="col-sm-2 col-form-label">JKMKKP Approval</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="jkmkkp_approval" id="jkmkkp_approval" placeholder="BSB/DOD/VI.1/2021">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="loa" class="col-sm-2 col-form-label">Letter of Award (LOA)</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="loa" id="loa">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="aac" class="col-sm-2 col-form-label">Agreement for Appointment of Consultant (AAC)</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="aac" id="aac">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="soilInv" class="col-sm-2 col-form-label">Soil Investigation</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="soilInv" id="soilInv"
                            value="{{ old('soilInv', isset($project) ? $project->soilInv : '') }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="topoSurvey" class="col-sm-2 col-form-label">Topo Survey</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="topoSurvey" id="topoSurvey"
                            value="{{ old('topoSurvey', isset($project) ? $project->topoSurvey : '') }}">
                    </div>
                </div>

                <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-primary">Back</a>
                <button type="submit" class="btn btn-primary">SAVE</button>
                <a href="{{ route('projects.design_submission', $project->id) }}" class="btn btn-primary">Next</a>
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
        new Cleave('#rfqFee', {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand',
            prefix: '$',
            numeralDecimalScale: 2,
            numeralPositiveOnly: true,
        });
    });
</script>
@endsection
