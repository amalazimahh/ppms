@extends('layouts.app', ['activePage' => 'table', 'titlePage' => __('Table List')])

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
<style>
    .form-control:focus {
        color: #000;
    }
    .form-control:not(:placeholder-shown) {
        color: #000;
    }

    /* animation for notif */
    .alert {
        box-shadow: 0 4px 20px 0 rgba(0,0,0,.14),
                    0 7px 10px -5px rgba(0,188,212,.4);
        border: 0;
        transition: all 0.3s ease;
        position: relative;
        display: inline-block;
        margin-bottom: 10px;
        width: auto;
    }

    .alert-success {
        background-color: #00d25b;
        color: #fff;
    }

    .alert-danger {
        background-color: #fc424a;
        color: #fff;
    }

    .alert .close {
        color: #fff;
        opacity: .9;
        text-shadow: none;
        line-height: 0;
        outline: 0;
    }

    body {
        opacity: 1;
        transition: opacity 300ms ease-in-out;
    }
    body.fade-out {
        opacity: 0;
        transition: none;
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
                @if($projects->isEmpty())
                    <div class="alert alert-warning">
                        No projects available. Please create a new project.
                    </button>
                    </div>
                @else
                <div class="table-responsive">
                    <table class="table">
                        <thead class=" text-primary">
                            <tr>
                                <th>Financial Year</th>
                                <th>Title</th>
                                <th>Progress</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($projects as $project)

                                <!-- calculate progress -->
                                @php
                                        $milestones = $project->milestones;

                                        // calculate progress
                                        $totalMilestones = $milestones->count();
                                        $completedMilestones = $milestones->where('pivot.completed', true)->count();
                                        $progress = $totalMilestones > 0 ? round(($completedMilestones / $totalMilestones) * 100) : 0;
                                @endphp
                                <tr>
                                    <td> {{ $project->fy }} </td>
                                    <td> @if($project->parent_project_id)
                                            {{ $project->parentProject->title }} -
                                        @endif
                                        {{ $project->title }}

                                    </td>
                                    <td>
                                        <!-- progress bar -->
                                        <div class="progress" style="height: 20px;">
                                            <div id="formProgressBar" class="progress-bar" role="progressbar"
                                                style="width: {{ $progress }}%;" aria-valuenow="{{ $progress }}" aria-valuemin="0" aria-valuemax="100">
                                                {{ $progress }}%
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <!-- view details button -->
                                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#projectDetailsModal{{ $project->id }}">
                                            <i class="tim-icons icon-zoom-split"></i> View Details
                                        </button>

                                        <!-- Project Details Modal -->
                                        <div class="modal fade" id="projectDetailsModal{{ $project->id }}" tabindex="-1" aria-labelledby="projectDetailsModalLabel{{ $project->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-xl modal-dialog-centered modal-dialog-scrollable">
                                                <div class="modal-content" style="border-radius: 12px;">
                                                    <div class="modal-header" style="border-bottom: 2px solid #8bc34a;">
                                                        <h4 class="modal-title" id="projectDetailsModalLabel{{ $project->id }}">
                                                            <span style="font-weight: bold; color: #4caf50;">Project Details</span>
                                                        </h4>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="icon-simple-remove"></button>
                                                    </div>
                                                    <div class="modal-body text-dark" style="background: #f9f9f9;">
                                                        <div class="container">
                                                            <div class="row mb-3">
                                                                <div class="col-6">
                                                                    <strong>Financial Year:</strong>
                                                                    <div>{{ $project->fy }}</div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <strong>Vote No.:</strong>
                                                                    <div>{{ $project->voteNum }}</div>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-12">
                                                                    <strong>Title:</strong>
                                                                    <div>{{ $project->title }}</div>
                                                                </div>
                                                            </div>
                                                            <div class="row mb-3">
                                                                <div class="col-6">
                                                                    <strong>Scheme Value:</strong>
                                                                    <div>{{ $project->sv }}</div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <strong>Allocation Value:</strong>
                                                                    <div>{{ $project->av }}</div>
                                                                </div>
                                                            </div>
                                                            @if($project->parent_project_id)
                                                            <div class="row mb-3">
                                                                <div class="col-12">
                                                                    <strong>Parent Project:</strong>
                                                                    <div>{{ $project->parentProject->title }}</div>
                                                                </div>
                                                            </div>
                                                            @endif
                                                            <div class="modal-footer" style="border-top: 2px solid #8bc34a;">
                                                                <a href="{{ route('projects.downloadPDF', $project->id) }}" class="btn btn-danger" target="_blank">
                                                                    <i class="fa fa-file-pdf-o"></i> Download PDF
                                                                </a>
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- edit forms button -->
                                        <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-primary btn-sm">
                                            <i class="tim-icons icon-pencil"></i> Edit
                                        </a>

                                         <!-- Delete Button -->
                                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal" onclick="setDeleteUrl('{{ route('projects.destroy', $project->id) }}')">
                                            <i class="tim-icons icon-trash-simple"></i> Delete
                                        </button>

                                        <!-- bootstrap delete modal -->
                                        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="deleteModalLabel">Confirm Deletion</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-dark">
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
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
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
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <i class="tim-icons icon-simple-remove"></i>
                </button>
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

    // Add fade-out class before page unload
    window.addEventListener('beforeunload', function() {
        document.body.classList.add('fade-out');
    });

// Auto-dismiss after 5 seconds
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');

    alerts.forEach(alert => {
        // Manual close
        alert.querySelector('.close').addEventListener('click', function() {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        });

        // Auto-dismiss
        setTimeout(() => {
            alert.style.opacity = '0';
            setTimeout(() => alert.remove(), 300);
        }, 5000);
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
