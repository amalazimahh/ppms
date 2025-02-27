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
            <h1 class="card-title">TENDER DETAILS</h1>
        </div>
        <div class="card-body">
            <form action="" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row mb-3">
                    <label for="confirmFund" class="col-sm-2 col-form-label">Confirmation Fund</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="confirmFund" id="confirmFund">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="costAmt" class="col-sm-2 col-form-label">Cost Estimate Amount</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="costAmt" id="costAmt" placeholder="$490,760.00">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="costDate" class="col-sm-2 col-form-label">Cost Estimate Date</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="costDate" id="costDate">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="tenderNum" class="col-sm-2 col-form-label">Tender No.</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="tenderNum" id="tenderNum" placeholder="JKR/DOD/1/2019">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="openedFirst" class="col-sm-2 col-form-label">Tender Opened First</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="openedFirst" id="openedFirst">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="openedSec" class="col-sm-2 col-form-label">Tender Opened Second</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="openedSec" id="openedSec">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="closed" class="col-sm-2 col-form-label">Tender Closed</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="closed" id="closed">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="ext" class="col-sm-2 col-form-label">Tender Extended</label>
                    <div class="col-sm-10">
                        <input type="date" name="ext" class="form-control" id="ext">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="validity" class="col-sm-2 col-form-label">Tender Validity</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="validity" id="validity">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="validity_ext" class="col-sm-2 col-form-label">Tender Validity Extended</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="validity_ext" id="validity_ext">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="cancelled" class="col-sm-2 col-form-label">Tender Cancelled</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="cancelled" id="cancelled">
                    </div>
                </div>

                <h3>TENDER RECOMMENDATION</h3>

                <div class="row mb-3">
                    <label for="toConsultant" class="col-sm-2 col-form-label">Recommendation to Consultant</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="toConsultant" id="toConsultant">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="fromConsultant" class="col-sm-2 col-form-label">Recommendation from Consultant</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="fromConsultant" id="fromConsultant">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="fromBPP" class="col-sm-2 col-form-label">Recommendation from BPP</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="fromBPP" id="fromBPP">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="toDG" class="col-sm-2 col-form-label">Recommendation to DG</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="toDG" id="toDG">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="toLTK" class="col-sm-2 col-form-label">Recommendation to LTK</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="toLTK" id="toLTK">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="ltkApproval" class="col-sm-2 col-form-label">LTK Approval</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="ltkApproval" id="ltkApproval">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="discLetter" class="col-sm-2 col-form-label">Discount Letter</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="discLetter" id="discLetter">
                    </div>
                </div>

                <h3>AWARD</h3>

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

                <a href="{{ route('projects.design_submission', $project->id) }}" class="btn btn-primary">Back</a>
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
