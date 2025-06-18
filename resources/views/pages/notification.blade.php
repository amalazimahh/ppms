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
                        <button class="btn btn-danger btn-sm delete-notification" data-id="{{ $notification->id }}" data-bs-toggle="modal" data-bs-target="#deleteModal">
                          Delete
                        </button>
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

            <!-- Delete All Notifications -->
            <button class="btn btn-danger mt-3" id="deleteAll">Delete All</button>
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
        Are you sure you want to delete this notification? This action cannot be undone.
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

@endsection

@section('scripts')
<script>
$(document).ready(function () {

    // Delete single notification
    $('.delete-notification').click(function () {
        var id = $(this).data('id');
        var $row = $(this).closest('tr');

        $.ajax({
            url: "{{ route('pages.notification.destroy', '') }}/" + id,
            type: 'DELETE',
            data: { _token: "{{ csrf_token() }}" },
            success: function () {
                $row.remove();
            }
        });
    });

    // Delete all notifications
    $('#deleteAll').click(function () {
        if (confirm("Are you sure you want to delete all notifications?")) {
            $.ajax({
                url: "{{ route('pages.notification.destroyAll') }}",
                type: 'DELETE',
                data: { _token: "{{ csrf_token() }}" },
                success: function () {
                    location.reload();
                }
            });
        }
    });
});
</script>
@endsection
