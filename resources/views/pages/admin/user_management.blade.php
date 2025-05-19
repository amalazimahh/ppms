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
</style>
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-primary d-flex justify-content-between align-items-center">
                <h2 class="card-title m-0">USERS LIST</h2>
            </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table">
                <thead class=" text-primary">
                  <th> ID </th>
                  <th> Name </th>
                  <th> Role </th>
                  <th> Date Joined </th>
                  <th> Action </th>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td> {{ $user->id }} </td>
                            <td> {{ $user->name }}</td>
                            <td>
                                @php
                                    $roleName = DB::table('roles')->where('id', $user->roles_id)->value('name');
                                    $badgeClass = 'badge-secondary'; // default
                                    if ($roleName === 'Admin') $badgeClass = 'badge-success';
                                    elseif ($roleName === 'Project Manager') $badgeClass = 'badge-primary';
                                    elseif ($roleName === 'Executive') $badgeClass = 'badge-warning';
                                @endphp
                                @if($user->roles_id)
                                    <span class="badge {{ $badgeClass }} role-badge">
                                        {{ $roleName }}
                                    </span>
                                @else
                                    <form action="{{ route('admin.assignRole', $user->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <select class="form-control" name="roles_id" required onchange="this.form.submit()" style="width: 150px;">
                                            <option value="">No role assigned</option>
                                            <option value="1">Admin</option>
                                            <option value="2">Project Manager</option>
                                            <option value="3">Executive</option>
                                        </select>
                                    </form>
                                @endif
                            </td>
                            <td> {{ \Carbon\Carbon::parse($user->created_at)->format('d-m-Y') }} </td>
                            <td>
                                <!-- edit and delete button -->
                                <a href="" class="btn btn-info btn-sm">
                                    <i class="tim-icons icon-pencil"></i> Edit
                                </a>

                                <!-- delete button -->
                                <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal">
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
@endsection
