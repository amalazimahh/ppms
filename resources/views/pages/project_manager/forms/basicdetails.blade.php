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
            <h1 class="card-title">BASIC PROJECT DETAILS</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- first row -->
                <!-- <div class="form-row"> -->
                    <!-- financial year -->
                    <div class="row mb-3">
                    <label for="fy" class="col-sm-2 col-form-label">Financial Year</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="fy" id="fy" placeholder="2020/2021" maxlength="9" oninput="formatFinancialYear(this)">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="sv" class="col-sm-2 col-form-label">Scheme Value</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="sv" id="sv" placeholder="$20,000,000.00">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="av" class="col-sm-2 col-form-label">Allocation Value</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="av" id="av" placeholder="$3,901,420.00">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="status" class="col-sm-2 col-form-label">Status</label>
                    <div class="col-sm-10">
                        <select id="status" name="status" class="form-control">
                            <option selected>-- Choose status stage --</option>
                            @foreach($statuses as $status)
                                <option value="{{ $status->id }}">{{ $status->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="voteNum" class="col-sm-2 col-form-label">Vote No.</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="voteNum" id="voteNum" placeholder="1105-005">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="title" class="col-sm-2 col-form-label">Project Title</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="title" id="title" placeholder="Pembinaan Semula Sekolah Menengah Sultan Hassan Bangar Temburong">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="oic" class="col-sm-2 col-form-label">Officer in Charge</label>
                    <div class="col-sm-10">
                        <select id="oic" name="oic" class="form-control">
                            <option selected>-- Choose Project Managers--</option>
                            @foreach($projectManagers as $manager)
                                <option value="{{ $manager->id }}">{{ $manager->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="contractor" class="col-sm-2 col-form-label">Main Contractor</label>
                    <div class="col-sm-10">
                        <input type="text" name="contractor" class="form-control" id="contractor" placeholder="LCY Development">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="contractorNum" class="col-sm-2 col-form-label">Contractor No.</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="contractorNum" id="contractorNum" placeholder="BSB/DOD/VI.1/2021">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="siteGazette" class="col-sm-2 col-form-label">Site Gazette</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="siteGazette" id="siteGazette" placeholder="Gaz Lot 4054 EDR11247">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="soilInv" class="col-sm-2 col-form-label">Soil Investigation</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="soilInv" id="soilInv">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="topoSurvey" class="col-sm-2 col-form-label">Topo Survey</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="topoSurvey" id="topoSurvey">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="handover" class="col-sm-2 col-form-label">Handover Project</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="handover" id="handover">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="scope" class="col-sm-2 col-form-label">Scope</label>
                    <div class="col-sm-10">
                        <textarea class="form-control" name="scope" id="scope" rows="4" placeholder="Construction of school campus including MPH, cafeteria, academic and admin blocks."></textarea>
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="location" class="col-sm-2 col-form-label">Location</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="location" id="location" placeholder="https://goo.gl/maps/Qktu9RDd3hKWc8Av8">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="img" class="col-sm-2 col-form-label">Upload Image</label>
                    <div class="col-sm-10">
                        <input type="file" class="form-control-file" name="img" id="img">
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">SUBMIT</button>
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
</script>

@endsection
