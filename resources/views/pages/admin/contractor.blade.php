@extends('layouts.app', ['activePage' => 'table', 'titlePage' => __('Table List')])

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

    .form-control:focus {
        color: #000;
    }
    .form-control:not(:placeholder-shown) {
        color: #000;
    }
</style>
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-primary d-flex justify-content-between align-items-center">
                <h2 class="card-title m-0">CONTRACTORS LIST</h2>

                <button type="button" class="btn btn-success btn-round animation-on-hover" data-bs-toggle="modal" data-bs-target="#addContractorModal">
                    <i class="tim-icons icon-simple-add"></i> Add New Contractor
                </button>
                <!-- add new contractor modal -->
                <div class="modal fade" id="addContractorModal" tabindex="-1" aria-labelledby="addContractorModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addProjectModalLabel">Add New Contractor</h5>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <i class="tim-icons icon-simple-remove"></i>
                                </button>
                            </div>
                            <form action="{{ route('pages.admin.contractors.store') }}" method="post">
                                @csrf
                                <div class="modal-body">

                                    <div class="row mb-3">
                                        <label for="name" class="col-sm-3 col-form-label" style="color: #000;">Contractor Name</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" name="name" id="name">
                                            </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save Project</button>
                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table">
                <thead class=" text-primary">
                  <th> ID </th>
                  <th> Name </th>
                  <th> Action </th>
                </thead>
                <tbody>
                    @foreach ($contractors as $contractor)
                        <tr>
                            <td> {{ $contractor->id }} </td>
                            <td> {{ $contractor->name }}</td>
                            <td>
                                <!-- edit button -->
                                <a href="" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editContractorModal">
                                    <i class="tim-icons icon-pencil"></i> Edit
                                </a>

                                <!-- Delete Form -->
                                <form id="deleteForm" action="{{ route('pages.admin.contractors.delete', $contractor->id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                </form>

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

<!-- edit contractor modal -->
<div class="modal fade" id="editContractorModal" tabindex="-1" aria-labelledby="editContractorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editProjectModalLabel">Edit Contractor</h5>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <i class="tim-icons icon-simple-remove"></i>
                    </button>
            </div>
            <form action="{{ route('pages.admin.contractors.update', $contractor->id) }}" method="post">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row mb-3">
                        <label for="name" class="col-sm-3 col-form-label">Contractor Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="name" id="name">
                        </div>
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
</script>
@endsection
