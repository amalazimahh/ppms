@extends('layouts.app', ['pageSlug' => 'basicdetails'])

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

<!-- dropdown style -->
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

     <!-- progress bar -->
     <div class="progress" style="height: 20px;">
        <div id="formProgressBar" class="progress-bar" role="progressbar"
             style="width: {{ $progress }}%;" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
            {{ $progress }}%
        </div>
    </div>

    <hr>

    <!-- project title -->
    <div class="row mb-2">
        <label for="projectTitle" class="col-sm-2 col-form-label">Project Title: </label>
        <div class="col-sm-10">
            <input type="text" name="projectTitle" id="projectTitle" value="{{ $project->title }}" class="form-control text-white" disabled>
        </div>
     </div>


    <!-- dropdown navigation -->
    <div class="row mb-3">
        <label for="formNavigation" class="col-sm-2 col-form-label">Navigate to Form: </label>
        <div class="col-sm-10">
            <select id="formNavigation" class="form-control" onchange="window.location.href=this.value">
                <option disabled {{ Route::currentRouteName() === null ? 'selected' : '' }}>-- Select Form --</option>
                <option value="{{ route('projects.status', $project->id) }}" {{ Route::currentRouteName() === 'projects.status' ? 'selected' : '' }}>1. Project Status</option>
                <option value="{{ route('pages.admin.forms.basicdetails', $project->id) }}" {{ Route::currentRouteName() === 'pages.admin.forms.basicdetails' ? 'selected' : '' }}>2. Project Terms of Reference Form</option>
                <option value="{{ route('projects.pre_tender', $project->id) }}" {{ Route::currentRouteName() === 'projects.pre_tender' ? 'selected' : '' }}>3. Pre-Design Form</option>
                <option value="{{ route('projects.project_team', $project->id) }}" {{ Route::currentRouteName() === 'projects.project_team' ? 'selected' : '' }}>4. Project Team Form</option>
                <option value="{{ route('projects.design_submission', $project->id) }}" {{ Route::currentRouteName() === 'projects.design_submission' ? 'selected' : '' }}>5. Design Submission Form</option>
                <option value="{{ route('projects.tender', $project->id) }}" {{ Route::currentRouteName() === 'projects.tender' ? 'selected' : '' }}>6. Opening/Closing Tender Form</option>
                <option value="{{ route('projects.tender_recommendation', $project->id) }}" {{ Route::currentRouteName() === 'projects.tender_recommendation' ? 'selected' : '' }}>6.1 Evaluation/Recommendation of Tender Form</option>
                <option value="{{ route('projects.approval_award', $project->id) }}" {{ Route::currentRouteName() === 'projects.approval_award' ? 'selected' : '' }}>6.2 Approval of Award Form</option>
                <option value="{{ route('projects.contract', $project->id) }}" {{ Route::currentRouteName() === 'projects.contract' ? 'selected' : '' }}>7. Contract Form</option>
                <option value="{{ route('projects.bankers_guarantee', $project->id) }}" {{ Route::currentRouteName() === 'projects.bankers_guarantee' ? 'selected' : '' }}>7.1 Banker's Guarantee Form</option>
                <option value="{{ route('projects.insurance', $project->id) }}" {{ Route::currentRouteName() === 'projects.insurance' ? 'selected' : '' }}>7.2 Insurance Form</option>
                <option value="{{ route('projects.project_health', $project->id) }}" {{ Route::currentRouteName() === 'projects.project_health' ? 'selected' : '' }}>8. Project Progress Status</option>
            </select>
        </div>
    </div>

    <div class="card">
        <div class="card-header mb-2">
            <h1 class="card-title">Pre-Design Form</h1>
        </div>
        <div class="card-body">
            <form action="{{ route('projects.pre_tender.update', $project->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @if(isset($project))
                    @method('PUT')
                @endif

                <div class="row mb-3">
                    <label for="rfpRfqNum" class="col-sm-2 col-form-label">RFP/RFQ No.</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="rfpRfqNum" id="rfpRfqNum" placeholder="JKR/RFQ/DOD/01/2021" value="{{ old('rfpRfqNum', $preTender->rfpRfqNum ?? '') }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="rfqTitle" class="col-sm-2 col-form-label">RFQ Title</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="rfqTitle" id="rfqTitle" placeholder="" value="{{ old('rfqTitle', $preTender->rfqTitle ?? '') }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="rfqFee" class="col-sm-2 col-form-label">RFQ Fee</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="rfqFee" id="rfqFee" placeholder="$3,901,420.00" value="{{ old('rfqFee', $preTender->rfqFee ?? '') }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="opened" class="col-sm-2 col-form-label">Opened</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="opened" id="opened" value="{{ old('opened', $preTender->opened ?? '') }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="closed" class="col-sm-2 col-form-label">Closed</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="closed" id="closed" value="{{ old('closed', $preTender->closed ?? '') }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="ext" class="col-sm-2 col-form-label">Extended</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="ext" id="ext" value="{{ old('ext', $preTender->ext ?? '') }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="validity_ext" class="col-sm-2 col-form-label">Validity Extended</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="validity_ext" id="validity_ext" value="{{ old('validity_ext', $preTender->validity_ext ?? '') }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="jkmkkp_recomm" class="col-sm-2 col-form-label">Recommendation to JKMKKP</label>
                    <div class="col-sm-10">
                        <input type="date" name="jkmkkp_recomm" class="form-control" id="jkmkkp_recomm" value="{{ old('jkmkkp_recomm', $preTender->jkmkkp_recomm ?? '') }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="jkmkkp_approval" class="col-sm-2 col-form-label">JKMKKP Approval</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="jkmkkp_approval" id="jkmkkp_approval" placeholder="BSB/DOD/VI.1/2021" value="{{ old('jkmkkp_approval', $preTender->jkmkkp_approval ?? '') }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="loa" class="col-sm-2 col-form-label">Letter of Award (LOA)</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="loa" id="loa" value="{{ old('loa', $preTender->loa ?? '') }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="aac" class="col-sm-2 col-form-label">Agreement for Appointment of Consultant (AAC)</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="aac" id="aac" value="{{ old('aac', $preTender->aac ?? '') }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="soilInv" class="col-sm-2 col-form-label">Soil Investigation</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="soilInv" id="soilInv"
                            value="{{ old('soilInv', $preTender->soilInv ?? '') }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="topoSurvey" class="col-sm-2 col-form-label">Topo Survey</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="topoSurvey" id="topoSurvey"
                            value="{{ old('topoSurvey', $preTender->topoSurvey ?? '') }}">
                    </div>
                </div>


                <button type="submit" class="btn btn-primary">SAVE</button>

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
