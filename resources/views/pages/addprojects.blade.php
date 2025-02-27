@if(session('success'))
    <script>
        window.onload = function() {
            demo.showNotification('top', 'right', "{{ session('success') }}");
        };
    </script>
@endif

@extends('layouts.app', ['pageSlug' => 'addprojects'])

@section('content')
    <div class="card">
        <div class="card-header mb-2">
          <h1 class="card-title">BASIC PROJECT DETAILS</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- first row -->
                <div class="form-row">
                    <!-- financial year -->
                    <div class="form-group col-md-2">
                        <label for="fy">Financial Year</label>
                        <input type="text" class="form-control" name="fy" id="fy" placeholder="2020/2021">
                    </div>

                    <!-- scheme value -->
                    <div class="form-group col-md-3">
                        <label for="sv">Scheme Value</label>
                        <input type="number" class="form-control" name="sv" id="sv" placeholder="$20,000,000.00">
                    </div>

                    <!-- allocation value -->
                    <div class="form-group col-md-3">
                        <label for="av">Allocation Value</label>
                        <input type="number" class="form-control" name="av" id="av" placeholder="$3,901,420.00">
                    </div>

                    <!-- status -->
                    <div class="form-group col-md-4">
                        <label for="status">Status</label>
                        <select id="status" name="status" class="form-control">
                            <option selected>-- Choose status stage --</option>
                            <option value="S01">Pre-Design</option>
                            <option value="S02">Design</option>
                            <option value="S03">Tender</option>
                            <option value="S04">Ongoing</option>
                            <option value="S05">Post-Completion</option>
                        </select>
                    </div>
                </div>

                <!-- second row -->
                <div class="form-row">
                    <!-- vote number -->
                    <div class="form-group col-md-2">
                        <label for="voteNum">Vote No.</label>
                        <input type="text" class="form-control" name="voteNum" id="voteNum" placeholder="1105-005">
                    </div>

                    <!-- project title -->
                    <div class="form-group col-md-10">
                        <label for="title">Project Title</label>
                        <input type="text" class="form-control" name="title" id="title" placeholder="Pembinaan Semula Sekolah Menengah Sultan Hassan Bangar Temburong">
                    </div>
                </div>

                <!-- third row -->
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="oic">Officer in Charge</label>
                        <select id="oic" name="oic" class="form-control">
                            <option value="pm1">Project Manager 1</option>
                            <option value="pm2">Project Manager 2</option>
                            <option value="pm3">Project Manager 3</option>
                        </select>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="contractor">Main Contractor</label>
                        <input type="text" name="contractor" class="form-control" id="contractor" placeholder="LCY Development">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="contractorNum">Contractor No.</label>
                        <input type="text" class="form-control" name="contractorNum" id="contractorNum" placeholder="BSB/DOD/VI.1/2021">
                    </div>
                </div>

                <!-- fourth row -->
                <div class="form-row">
                    <div class="form-group col-md-8">
                        <label for="location">Location</label>
                        <input type="text" class="form-control" name="location" id="location" placeholder="https://goo.gl/maps/Qktu9RDd3hKWc8Av8">
                    </div>
                    <div class="form-group col-md-4">
                        <label for="img">Upload Image</label>
                        <input type="file" class="form-control-file d-none" name="img" id="img">
                    </div>
                </div>
                <div class="form-group">
                    <label for="scope">Scope</label>
                    <input type="text" class="form-control" name="scope" id="scope" placeholder="Construction of school campus including MPH, cafeteria, academic and admin blocks.">
                </div>

                <!-- fifth row -->
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <label for="siteGazette">Site Gazette</label>
                        <input type="text" class="form-control" name="siteGazette" id="siteGazette" placeholder="Gaz Lot 4054 EDR11247">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="soilInv">Soil Investigation</label>
                        <input type="date" class="form-control" name="soilInv" id="soilInv">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="topoSurvey">Topo Survey</label>
                        <input type="date" class="form-control" name="topoSurvey" id="topoSurvey">
                    </div>
                    <div class="form-group col-md-3">
                        <label for="handover">Handover Project</label>
                        <input type="date" class="form-control" name="handover" id="handover">
                    </div>
                </div>

            <button type="submit" class="btn btn-primary">SUBMIT</button>
            </form>
        </div>
    </div>
@endsection
