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
            <h1 class="card-title">DESIGN SUBMISSION DETAILS</h1>
        </div>
        <div class="card-body">
            <form action="" method="POST" enctype="multipart/form-data">
                @csrf
                <!-- first row -->
                <!-- <div class="form-row"> -->
                    <!-- financial year -->
                    <div class="row mb-3">
                    <label for="kom" class="col-sm-2 col-form-label">Kick Off Meeting</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="kom" id="kom">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="conAppr" class="col-sm-2 col-form-label">Concept Approval</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="conAppr" id="conAppr">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="designRev" class="col-sm-2 col-form-label">Design Review</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="designRev" id="designRev">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="detailedRev" class="col-sm-2 col-form-label">Detailed Design Review</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="detailedRev" id="detailedRev">
                    </div>
                </div>

                <a href="{{ route('projects.pre_tender', $project->id) }}" class="btn btn-primary">Back</a>
                <button type="submit" class="btn btn-primary">SAVE</button>
                <a href="{{ route('projects.tender', $project->id) }}" class="btn btn-primary">Next</a>
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
