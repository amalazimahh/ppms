@extends('layouts.app', ['activePage' => 'table', 'titlePage' => __('Table List')])

@section('content')
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
                            <td> <span class="badge badge-primary">{{ $user->roles_id ? DB::table('roles')->where('id', $user->roles_id)->value('name') : 'No Role Assigned' }} </span></td>
                            <td> {{ $user->created_at }} </td>
                            <td>
                                <!-- edit and delete buton should be here -->
                                <a href="" class="btn btn-info btn-sm">
                                            <i class="tim-icons icon-pencil"></i> Edit
                                         </a>

                                         <!-- Delete Button -->
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
