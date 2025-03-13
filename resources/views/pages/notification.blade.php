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
              <select id="filterType" class="form-control">
                <option value="all">All Notifications</option>
                <option value="new_project">New Projects</option>
                <option value="new_user">New Users</option>
                <option value="overbudget_project">Reset Password Request</option>
                <option value="overbudget_project">Upcoming Deadline Projects</option>
                <option value="update_project_details">Project Details Updates</option>
                <option value="update_project_details">Project Status Updates</option>
                <option value="overbudget_project">Overbudget Projects</option>
                <option value="overbudget_project">Overdue Projects</option>
              </select>
            </div>

            <!-- Notifications List -->
            <div class="table-responsive">
              <table class="table">
                <thead class="text-primary">
                  <tr>
                    <th>Message</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @forelse($notifications as $notification)
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
                        <button class="btn btn-success btn-sm mark-as-read" data-id="{{ $notification->id }}">
                          Mark as Read
                        </button>

                        <!-- Delete Button -->
                        <button class="btn btn-danger btn-sm delete-notification" data-id="{{ $notification->id }}">
                          Delete
                        </button>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="4" class="text-center">No notifications available.</td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>

            <!-- Pagination -->
            <div class="mt-3">
              {{ $notifications->links() }}
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
        // Mark as read
        $('.notification-text').click(function () {
            var id = $(this).data('id');
            var $parent = $(this).closest('li');

            $.post("{{ route('pages.notification.markAsRead', '') }}/" + id, {
                _token: "{{ csrf_token() }}"
            }).done(function () {
                $parent.removeClass('font-weight-bold bg-light');
            });
        });

        // Delete single notification
        $('.delete-notification').click(function () {
            var id = $(this).data('id');
            var $parent = $(this).closest('li');

            $.ajax({
                url: "{{ route('pages.notification.destroy', '') }}/" + id,
                type: 'DELETE',
                data: { _token: "{{ csrf_token() }}" },
                success: function () {
                    $parent.remove();
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

        // Filter notifications by type
        $('#filterType').change(function () {
            window.location.href = "{{ route('pages.notification.index') }}?type=" + $(this).val();
        });
    });
</script>
@endsection
