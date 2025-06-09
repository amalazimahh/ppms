@extends('layouts.app', ['page'=>__('Password Reset Request'), 'page'=>__('Password Reset Requests'), 'pageSlug' => 'password-reset-requests'])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary d-flex justify-content-between align-items-center">
            <h2 class="card-title m-0">Password Reset Requests</h2>
          </div>

          <div class="card-body">
            @include('alerts.success')

            <!-- Requests List -->
            <div class="table-responsive">
              <table class="table">
                <thead class="text-primary">
                  <tr>
                    <th>User</th>
                    <th>Email</th>
                    <th>Requested At</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse ($requests as $request)
                    <tr>
                      <td>{{ $request->user->name }}</td>
                      <td>{{ $request->email }}</td>
                      <td>{{ $request->created_at->format('Y-m-d H:i') }}</td>
                      <td>
                        <div class="d-flex">
                          <form action="{{ route('pages.admin.password-reset-requests.approve', $request->id) }}" method="POST" class="mr-2">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success">Approve</button>
                          </form>

                          <form action="{{ route('pages.admin.password-reset-requests.reject', $request->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-danger">Reject</button>
                          </form>
                        </div>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="4" class="text-center">No pending password reset requests</td>
                    </tr>
                  @endforelse
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
