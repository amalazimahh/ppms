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

<div class="container">
    <h3>Notifications</h3>

    <!-- Filter dropdown -->
    <div class="mb-3">
        <select id="filterType" class="form-control">
            <option value="all">All Notifications</option>
            <option value="update_project_details">Project Updates</option>
            <option value="new_project">New Projects</option>
            <option value="new_user">New Users</option>
            <option value="overbudget_project">Overbudget Projects</option>
        </select>
    </div>

    <!-- Notifications List -->
    <ul class="list-group">
        @forelse($notifications as $notification)
            <li class="list-group-item d-flex justify-content-between align-items-center {{ !$notification->read ? 'font-weight-bold bg-light' : '' }}">
                <span class="notification-text" data-id="{{ $notification->id }}">
                    {{ $notification->message }}
                </span>
                <div>
                    <button class="btn btn-sm btn-outline-primary mark-as-read" data-id="{{ $notification->id }}">Mark as Read</button>
                    <button class="btn btn-sm btn-outline-danger delete-notification" data-id="{{ $notification->id }}">Delete</button>
                </div>
            </li>
        @empty
            <li class="list-group-item text-center">No notifications available.</li>
        @endforelse
    </ul>

    <!-- Pagination -->
    <div class="mt-3">
        {{ $notifications->links() }}
    </div>

    <!-- Delete All Notifications -->
    <button class="btn btn-danger mt-3" id="deleteAll">Delete All</button>
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
