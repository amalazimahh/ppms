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
            <h1 class="card-title">CONTRACT DETAILS</h1>
        </div>
        <div class="card-body">
            <form action="" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row mb-3">
                    <label for="start" class="col-sm-2 col-form-label">Contract Start Date</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="start" id="start">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="end" class="col-sm-2 col-form-label">Contract End Date</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="end" id="end">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="period" class="col-sm-2 col-form-label">Contract Period</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="period" id="period">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="sum" class="col-sm-2 col-form-label">Contract Sum</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="sum" id="sum">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="revSum" class="col-sm-2 col-form-label">Revised Contract Sum</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="revSum" id="revSum">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="lad" class="col-sm-2 col-form-label">Liquidated Ascertained Damages</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="lad" id="lad">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="totalLad" class="col-sm-2 col-form-label">Total Liquidated Ascertained Damages</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="totalLad" id="totalLad">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="cnc" class="col-sm-2 col-form-label">Certificate of Non-Completion (CNC)</label>
                    <div class="col-sm-10">
                        <input type="date" name="cnc" class="form-control" id="cnc">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="revComp" class="col-sm-2 col-form-label">Revised Completion</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="revComp" id="revComp">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="actualComp" class="col-sm-2 col-form-label">Actual Completion</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="actualComp" id="actualComp">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="cpc" class="col-sm-2 col-form-label">Certificate of Practical Completion (CPC)</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="cpc" id="cpc">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="edlp" class="col-sm-2 col-form-label">End of Defects Liability Period</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="edlp" id="edlp">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="cmgd" class="col-sm-2 col-form-label">Certificate of Making Good Defects</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="cmgd" id="cmgd">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="lsk" class="col-sm-2 col-form-label">Laporan Siap Kerja</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="lsk" id="lsk">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="penAmt" class="col-sm-2 col-form-label">Penultimate Amount</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="penAmt" id="penAmt">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="retAmt" class="col-sm-2 col-form-label">Retention Amount</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="retAmt" id="retAmt">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="statDec" class="col-sm-2 col-form-label">Statutory Declaration</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="statDec" id="statDec">
                    </div>
                </div>

                <h3>BANKER'S GUARANTEE</h3>

                <div class="row mb-3">
                    <label for="bgAmt" class="col-sm-2 col-form-label">Banker's Guarantee Amount</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="bgAmt" id="bgAmt">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="bgIssued" class="col-sm-2 col-form-label">Banker's Guarantee Issued</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="bgIssued" id="bgIssued">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="bgExpiry" class="col-sm-2 col-form-label">Banker's Guarantee Expiry</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="bgExpiry" id="bgExpiry">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="bgExt" class="col-sm-2 col-form-label">Banker's Guarantee Extended</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="bgExt" id="bgExt">
                    </div>
                </div>

                <h3>INSURANCE</h3>

                <div class="row mb-3">
                    <label for="insType" class="col-sm-2 col-form-label">Insurance Type</label>
                    <div class="col-sm-10">
                        <!-- dropdown selection here -->
                        <input type="text" class="form-control" name="insType" id="insType">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="insIssued" class="col-sm-2 col-form-label">Insurance Issued</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="insIssued" id="insIssued">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="insExpiry" class="col-sm-2 col-form-label">Insurance Expiry</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="insExpiry" id="insExpiry">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="insExt" class="col-sm-2 col-form-label">Insurance Extended</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="insExt" id="insExt">
                    </div>
                </div>

                <a href="{{ route('projects.tender', $project->id) }}" class="btn btn-primary">Back</a>
                <button type="submit" class="btn btn-primary">SAVE</button>
            </form>
        </div>
    </div>

    <!-- handles financial year, amount user enters -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        new Cleave('#sum', {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand',
            prefix: '$',
            numeralDecimalScale: 2,
            numeralPositiveOnly: true,
        });

        new Cleave('#revSum', {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand',
            prefix: '$',
            numeralDecimalScale: 2,
            numeralPositiveOnly: true,
        });

        new Cleave('#lad', {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand',
            prefix: '$',
            numeralDecimalScale: 2,
            numeralPositiveOnly: true,
        });

        new Cleave('#totalLad', {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand',
            prefix: '$',
            numeralDecimalScale: 2,
            numeralPositiveOnly: true,
        });

        new Cleave('#penAmt', {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand',
            prefix: '$',
            numeralDecimalScale: 2,
            numeralPositiveOnly: true,
        });

        new Cleave('#retAmt', {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand',
            prefix: '$',
            numeralDecimalScale: 2,
            numeralPositiveOnly: true,
        });

        new Cleave('#bgAmt', {
            numeral: true,
            numeralThousandsGroupStyle: 'thousand',
            prefix: '$',
            numeralDecimalScale: 2,
            numeralPositiveOnly: true,
        });
    });
</script>
@endsection
