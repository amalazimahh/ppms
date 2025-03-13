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
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-primary d-flex justify-content-between align-items-center">
                <h2 class="card-title m-0">PROJECT LIST</h2>
                <a href="{{ route('pages.admin.forms.basicdetails') }}" class="btn btn-success btn-round animation-on-hover">
                    <i class="tim-icons icon-simple-add"></i> Add New Project
                </a>
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
                            <!-- <th> Scheme Value </th> -->
                            <!-- <th> Allocation Value </th> -->
                            <!-- <th> Client Department </th> not yet added on DB -->
                        </thead>
                        <tbody>
                            @foreach ($projects as $project)
                                <tr>
                                    <td> {{ $project->fy }} </td>
                                    <td> {{ $project->voteNum }} </td>
                                    <td> {{ $project->title }} </td>
                                    <td> {{ $project->oicUser->name }} </td>
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

<!-- Bootstrap Delete Confirmation Modal -->
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
</script>

@endsection
