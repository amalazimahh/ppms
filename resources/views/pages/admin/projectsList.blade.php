@extends('layouts.app', ['activePage' => 'table', 'titlePage' => __('Table List')])

<!-- @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif -->

@section('content')
<style>
.form-control:focus {
    color: #000; /* Black text when focused */
}
.form-control:not(:placeholder-shown) {
    color: #000; /* Black text when not empty */
}
</style>
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-primary d-flex justify-content-between align-items-center">
                <h2 class="card-title m-0">PROJECT LIST</h2>

                <button type="button" class="btn btn-success btn-round animation-on-hover" data-bs-toggle="modal" data-bs-target="#addProjectModal">
                    <i class="tim-icons icon-simple-add"></i> Add New Project
                </button>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead class=" text-primary">
                            <th> Financial Year </th>
                            <th> Project Vote </th>
                            <th> Title </th>
                            <th> Officer in Charge </th>
                            <th> Action </th>
                        </thead>
                        <tbody>
                            @foreach ($projects as $project)
                                <tr>
                                    <td> {{ $project->fy }} </td>
                                    <td> {{ $project->voteNum }} </td>
                                    <td> {{ $project->title }} </td>
                                    <td></td>
                                    <td>
                                        <!-- edit and delete buton should be here -->
                                         <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-info btn-sm">
                                            <i class="tim-icons icon-pencil"></i> Edit
                                         </a>

                                         <!-- Delete Button -->
                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="setDeleteUrl('{{ route('projects.destroy', $project->id) }}')">
                                            <i class="tim-icons icon-trash-simple"></i> Delete
                                        </button>



                                    </td>
                                    <!-- <td>${{ $project->sv }} </td> -->
                                    <!-- <td>${{ $project->av }} </td> -->
                                    <!-- <td> {{ $project->client }} </td> -->
                                    <!-- <td> {{ $project->status }} </td> -->
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- add project modal -->
 <div class="modal fade" id="addProjectModal" tabindex="-1" aria-labelledby="addProjectModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProjectModalLabel">Add New Project</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('projects.store') }}" method="post">
                @csrf
                <div class="modal-body">

                    <!-- financial year -->
                <div class="row mb-3">
                    <label for="fy" class="col-sm-2 col-form-label">Financial Year</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="fy" id="fy" placeholder="2020/2021"
                            maxlength="9" oninput="formatFinancialYear(this)"
                            value="{{ old('fy', isset($project) ? $project->fy : '') }}">
                        </div>
                </div>

                <div class="row mb-3">
                    <label for="sv" class="col-sm-2 col-form-label">Scheme Value</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="sv" id="sv"
                            placeholder="$20,000,000.00"
                            value="{{ old('sv', isset($project) ? $project->sv : '') }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="av" class="col-sm-2 col-form-label">Allocation Value</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="av" id="av"
                            placeholder="$3,901,420.00"
                            value="{{ old('av', isset($project) ? $project->av : '') }}">
                    </div>
                </div>

                <input type="hidden" name="parent_project_id" value="{{ old('parent_project_id', isset($project) ? $project->parent_project_id : '') }}">

                <div class="row mb-3">
                    <label for="parent_project_id" class="col-sm-2 col-form-label">Parent Project (Optional)</label>
                    <div class="col-sm-10">
                        <select id="parent_project_id" name="parent_project_id" class="form-control">
                            <option value="">No Parent (New Main Project)</option>
                            @foreach($mainProjects as $parentProject)
                                <option value="{{ $parentProject->id }}"
                                    {{ old('parent_project_id', isset($project) ? $project->parent_project_id : '') == $parentProject->id ? 'selected' : '' }}>
                                    {{ $parentProject->title }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>


                <div class="row mb-3">
                    <label for="voteNum" class="col-sm-2 col-form-label">Vote No.</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="voteNum" id="voteNum" placeholder="1105-005"
                            value="{{ old('voteNum', isset($project) ? $project->voteNum : '') }}">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="title" class="col-sm-2 col-form-label">Project Title</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="title" id="title" placeholder="Pembinaan Semula Sekolah Menengah Sultan Hassan Bangar Temburong"
                            value="{{ old('title', isset($project) ? $project->title : '') }}">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Project</button>
                </div>

            </form>
        </div>
    </div>
 </div>

<!-- bootstrap delete modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this project? This action cannot be undone.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>

        <!-- Delete Form -->
        <form id="deleteForm" method="POST" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Yes, Delete</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
    function setDeleteUrl(url) {
        document.getElementById('deleteForm').action = url;
    }

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


    // javascript to load the voteNum dynamically
    document.addEventListener('DOMContentLoaded', function () {
        let voteNum = document.getElementById('voteNum');
        let parentProjectSelect = document.getElementById('parent_project_id');

        function updateVoteNum() {
            let parentId = parentProjectSelect.value;

            if (parentId) {
                fetch(`/admin/projects/${parentId}/getVoteNum`) // fetch voteNum from parent
                    .then(response => response.json())
                    .then(data => {
                        voteNum.value = data.voteNum; // set parent voteNum
                        voteNum.setAttribute('readonly', 'readonly'); // disable input
                    })
                    .catch(error => console.error('Error fetching voteNum:', error));
            } else {
                voteNum.value = ''; // clear field
                voteNum.removeAttribute('readonly'); // enable input for manual entry
            }
        }

        parentProjectSelect.addEventListener('change', updateVoteNum);

        updateVoteNum();
    });

</script>

@endsection
