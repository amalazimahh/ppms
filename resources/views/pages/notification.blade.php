@extends('layouts.app', ['page'=>__('Notifications'), 'pageSlug' => 'notifications'])


@section('content')
<!-- apply styling for dropdown -->
<style>
        select {
            background-color: #f6f9fc;
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
            <h2 class="card-title m-0">Notifications</h2>

          </div>

          <div class="card-body">
            <!-- Filter dropdown -->
            <div class="mb-3">
            @php
                $role = session('roles');
                $typeOptions = [];

                if ($role == 1) { // Admin
                    $typeOptions = [
                        'new_project' => 'New Projects',
                        'new_user' => 'New Users',
                        'reset_password' => 'Reset Password Request',
                        'upcoming_deadline' => 'Upcoming Deadline Projects',
                        'update_project_details' => 'Project Details Updates',
                        'update_project_status' => 'Project Status Updates',
                        'overbudget' => 'Overbudget Projects',
                        'overdue' => 'Overdue Projects',
                    ];
                } elseif ($role == 2) { // Project Manager
                    $typeOptions = [
                        'upcoming_deadline' => 'Upcoming Deadline Projects',
                        'update_project_details' => 'Project Details Updates',
                        'update_project_status' => 'Project Status Updates',
                        'overbudget' => 'Overbudget Projects',
                        'overdue' => 'Overdue Projects',
                    ];
                } elseif ($role == 3) { // Executive
                    $typeOptions = [
                        'upcoming_deadline' => 'Upcoming Deadline Projects',
                        'update_project_status' => 'Project Status Updates',
                        'overbudget' => 'Overbudget Projects',
                        'overdue' => 'Overdue Projects',
                    ];
                }
            @endphp
            <select id="filterType" class="form-control" onchange="window.location.href = this.value">
                <option value="{{ route('pages.notification.index') }}" {{ !request()->has('type') ? 'selected' : '' }}>All Notifications</option>
                @foreach($typeOptions as $type => $label)
                    <option value="{{ route('pages.notification.index', ['type' => $type]) }}" {{ request('type') == $type ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            </div>

            <!-- Notifications List -->
            <div class="table-responsive">
              <table class="table">
                <thead class="text-primary">
                  <tr>
                    <th style="width: 60%">Message</th>
                    <th style="width: 10%">Status</th>
                    <th style="width: 25%">Action</th>
                  </tr>
                </thead>
                <tbody id="notificationsTable">
                  @forelse ($notifications as $notification)
                    <tr class="{{ !$notification->read ? : '' }}">
                      <td>{{ $notification->message }}</td>
                      <td>
                        @if (!$notification->read)
                          <span class="badge badge-warning">Unread</span>
                        @else
                          <span class="badge badge-success">Read</span>
                        @endif
                      </td>
                      <td>
                        <!-- Mark as Read Button -->
                        <form action="{{ route('notifications.mark-read', $notification->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-success">
                                Mark as Read
                            </button>
                        </form>

                        <!-- Delete Button -->
                        <form action="{{ route('pages.notification.destroy', $notification->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure you want to delete this notification?');">
                                Delete
                            </button>
                        </form>
                      </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center">
                            @if(request()->has('type'))
                                No notifications found for
                                <strong>{{ ucfirst(str_replace('_', ' ', request('type'))) }}</strong>
                            @else
                                No notifications found
                            @endif
                        </td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>

            <!-- Pagination -->
            <div class="mt-3 d-flex justify-content-center">
              {{ $notifications->links('pagination::bootstrap-5') }}
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection

