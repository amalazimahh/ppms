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
              <select id="filterType" class="form-control" onchange="window.location.href = this.value">
                <option value="{{ route('pages.notification.index') }}" {{ !request()->has('type') ? 'selected' : '' }}>All Notifications</option>
                <option value="{{ route('pages.notification.index', ['type' => 'new_project']) }}" {{ request('type') == 'new_project' ? 'selected' : '' }}>New Projects</option>
                <option value="{{ route('pages.notification.index', ['type' => 'new_user']) }}" {{ request('type') == 'new_user' ? 'selected' : '' }}>New Users</option>
                <option value="{{ route('pages.notification.index', ['type' => 'reset_password']) }}" {{ request('type') == 'reset_password' ? 'selected' : '' }}>Reset Password Request</option>
                <option value="{{ route('pages.notification.index', ['type' => 'upcoming_deadline']) }}" {{ request('type') == 'upcoming_deadline' ? 'selected' : '' }}>Upcoming Deadline Projects</option>
                <option value="{{ route('pages.notification.index', ['type' => 'update_project_details']) }}" {{ request('type') == 'update_project_details' ? 'selected' : '' }}>Project Details Updates</option>
                <option value="{{ route('pages.notification.index', ['type' => 'update_project_status']) }}" {{ request('type') == 'update_project_status' ? 'selected' : '' }}>Project Status Updates</option>
                <option value="{{ route('pages.notification.index', ['type' => 'overbudget']) }}" {{ request('type') == 'overbudget' ? 'selected' : '' }}>Overbudget Projects</option>
                <option value="{{ route('pages.notification.index', ['type' => 'overdue']) }}" {{ request('type') == 'overdue' ? 'selected' : '' }}>Overdue Projects</option>
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
    });

</script>
@endsection
