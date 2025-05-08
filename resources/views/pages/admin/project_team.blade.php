@extends('layouts.app', ['page'=>__('Project Team'), 'pageSlug' => 'Project Team'])

@section('content')

<style>
    .member-card {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 2px 8px #000000;
        padding: 20px 16px;
        margin-bottom: 24px;
        display: flex;
        align-items: center;
        min-height: 120px;
    }
    .member-avatar {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 16px;
        border: 2px solid #675ee4;
    }
    .member-info {
        flex: 1;
    }
    .member-name {
        font-weight: 600;
        font-size: 16px;
    }
    .member-country {
        color: #8898aa;
        font-size: 14px;
    }
</style>

<div class="content">
  <div class="container-fluid">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs mb-3" id="teamTabs" role="tablist">
      <li class="nav-item">
        <a class="nav-link active" id="architects-tab" data-toggle="tab" href="#architects" role="tab" data-discipline="architects">Architects</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="civils-tab" data-toggle="tab" href="#civils" role="tab" data-discipline="civils">Civil Engineers</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="mechanicals-tab" data-toggle="tab" href="#mechanicals" role="tab" data-discipline="mechanicals">Mechanical Engineers</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" id="surveyors-tab" data-toggle="tab" href="#surveyors" role="tab" data-discipline="surveyors">Quantity Surveyors</a>
      </li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <div class="tab-pane fade show active" id="architects" role="tabpanel">
        <div class="row">
          <!-- Add Discipline Card -->
          <div class="col-md-4 col-sm-6">
            <div class="member-card d-flex justify-content-center align-items-center" style="cursor:pointer; background:#f6f9fc; border:2px dashed #675ee4;">
              <a href="#" class="w-100 h-100 d-flex flex-column justify-content-center align-items-center text-decoration-none" style="color:#675ee4;" data-toggle="modal" data-target="#addDisciplineModal" data-discipline="architects">
                <span style="font-size:2.5rem; font-weight:bold;">+</span>
                <span style="font-size:1rem; font-weight:600;">Add Discipline</span>
              </a>
            </div>
          </div>
          @foreach($architects as $architect)
          <div class="col-md-4 col-sm-6">
            <div class="member-card position-relative">
              <img src="{{ $architect->profile_photo_url ?? asset('images/default-avatar.jpg') }}" class="member-avatar" alt="Profile">
              <div class="member-info">
                <div class="member-name">{{ $architect->name }}</div>
                <div class="member-country">Date Created: {{ $architect->formatted_created_at ?? 'N/A' }}</div>
              </div>
              <button type="button"
                class="btn btn-link text-danger position-absolute"
                style="top:10px; right:10px; font-size:1.2rem;"
                data-toggle="modal"
                data-target="#deleteDisciplineModal"
                data-id="{{ $architect->id }}"
                data-discipline="architects"
                title="Delete">
                <i class="fas fa-trash"></i>
              </button>
            </div>
          </div>
          @endforeach
        </div>
      </div>
      <div class="tab-pane fade" id="civils" role="tabpanel">
        <div class="row">
          <!-- Add Discipline Card -->
          <div class="col-md-4 col-sm-6">
            <div class="member-card d-flex justify-content-center align-items-center" style="cursor:pointer; background:#f6f9fc; border:2px dashed #675ee4;">
              <a href="#" class="w-100 h-100 d-flex flex-column justify-content-center align-items-center text-decoration-none" style="color:#675ee4;" data-toggle="modal" data-target="#addDisciplineModal" data-discipline="civils">
                <span style="font-size:2.5rem; font-weight:bold;">+</span>
                <span style="font-size:1rem; font-weight:600;">Add Discipline</span>
              </a>
            </div>
          </div>
          @foreach($civilEngineers as $ce)
          <div class="col-md-4 col-sm-6">
            <div class="member-card">
              <img src="{{ $ce->profile_photo_url ?? asset('images/default-avatar.jpg') }}" class="member-avatar" alt="Profile">
              <div class="member-info">
                <div class="member-name">{{ $ce->name }}</div>
                <div class="member-country">Date Created: {{ $ce->formatted_created_at ?? 'N/A' }}</div>
              </div>
              <button type="button"
                class="btn btn-link text-danger position-absolute"
                style="top:10px; right:10px; font-size:1.2rem;"
                data-toggle="modal"
                data-target="#deleteDisciplineModal"
                data-id="{{ $ce->id }}"
                data-discipline="civils"
                title="Delete">
                <i class="fas fa-trash"></i>
              </button>
            </div>
          </div>
          @endforeach
        </div>
      </div>
      <div class="tab-pane fade" id="mechanicals" role="tabpanel">
        <div class="row">
          <!-- Add Discipline Card -->
          <div class="col-md-4 col-sm-6">
            <div class="member-card d-flex justify-content-center align-items-center" style="cursor:pointer; background:#f6f9fc; border:2px dashed #675ee4;">
              <a href="#" class="w-100 h-100 d-flex flex-column justify-content-center align-items-center text-decoration-none" style="color:#675ee4;" data-toggle="modal" data-target="#addDisciplineModal" data-discipline="mechanicals">
                <span style="font-size:2.5rem; font-weight:bold;">+</span>
                <span style="font-size:1rem; font-weight:600;">Add Discipline</span>
              </a>
            </div>
          </div>
          @foreach($mechanicalElectricals as $me)
          <div class="col-md-4 col-sm-6">
            <div class="member-card">
              <img src="{{ $me->profile_photo_url ?? asset('images/default-avatar.jpg') }}" class="member-avatar" alt="Profile">
              <div class="member-info">
                <div class="member-name">{{ $me->name }}</div>
                <div class="member-country">Date Created: {{ $me->formatted_created_at ?? 'N/A' }}</div>
              </div>
              <button type="button"
                class="btn btn-link text-danger position-absolute"
                style="top:10px; right:10px; font-size:1.2rem;"
                data-toggle="modal"
                data-target="#deleteDisciplineModal"
                data-id="{{ $me->id }}"
                data-discipline="mechanicals"
                title="Delete">
                <i class="fas fa-trash"></i>
              </button>
            </div>
          </div>
          @endforeach
        </div>
      </div>
      <div class="tab-pane fade" id="surveyors" role="tabpanel">
        <div class="row">
          <!-- Add Discipline Card -->
          <div class="col-md-4 col-sm-6">
            <div class="member-card d-flex justify-content-center align-items-center" style="cursor:pointer; background:#f6f9fc; border:2px dashed #675ee4;">
              <a href="#" class="w-100 h-100 d-flex flex-column justify-content-center align-items-center text-decoration-none" style="color:#675ee4;" data-toggle="modal" data-target="#addDisciplineModal" data-discipline="surveyors">
                <span style="font-size:2.5rem; font-weight:bold;">+</span>
                <span style="font-size:1rem; font-weight:600;">Add Discipline</span>
              </a>
            </div>
          </div>
          @foreach($quantitySurveyors as $qs)
          <div class="col-md-4 col-sm-6">
            <div class="member-card">
              <img src="{{ $qs->profile_photo_url ?? asset('images/default-avatar.jpg') }}" class="member-avatar" alt="Profile">
              <div class="member-info">
                <div class="member-name">{{ $qs->name }}</div>
                <div class="member-country">Date Created: {{ $qs->formatted_created_at ?? 'N/A' }}</div>
              </div>
              <button type="button"
                class="btn btn-link text-danger position-absolute"
                style="top:10px; right:10px; font-size:1.2rem;"
                data-toggle="modal"
                data-target="#deleteDisciplineModal"
                data-id="{{ $qs->id }}"
                data-discipline="surveyors"
                title="Delete">
                <i class="fas fa-trash"></i>
              </button>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="addDisciplineModal" tabindex="-1" role="dialog" aria-labelledby="addDisciplineModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form id="addDisciplineForm" method="POST" action="{{ route('admin.project_team.addDiscipline') }}">
      @csrf
      <input type="hidden" name="discipline" id="disciplineInput" value="">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addDisciplineModalLabel">Add New Discipline Member</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label for="memberName">Name</label>
            <input type="text" class="form-control" id="memberName" name="name" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Add</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Delete Discipline Modal -->
<div class="modal fade" id="deleteDisciplineModal" tabindex="-1" role="dialog" aria-labelledby="deleteDisciplineModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <form id="deleteDisciplineForm" method="POST" action="{{ route('admin.project_team.deleteDiscipline') }}">
        @csrf
        @method('DELETE')
        <div class="modal-header">
          <h5 class="modal-title" id="deleteDisciplineModalLabel">Delete Member</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          Are you sure you want to delete this member from <span id="disciplineName"></span>?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-danger">Delete</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  $('#deleteDisciplineModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');
    var discipline = button.data('discipline');
    var modal = $(this);
    modal.find('#disciplineName').text(discipline.charAt(0).toUpperCase() + discipline.slice(1));
    // Set the form action dynamically (update the route as needed)
    modal.find('#deleteDisciplineForm').attr('action', '/admin/project-team/' + discipline + '/' + id);
  });
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
  // Set discipline type for Add Discipline modal
  document.querySelectorAll('[data-target="#addDisciplineModal"]').forEach(function(btn) {
    btn.addEventListener('click', function() {
      var discipline = btn.getAttribute('data-discipline');
      document.getElementById('disciplineInput').value = discipline;
    });
  });

  // Handle delete button click for all cards
  $('#deleteDisciplineModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var id = button.data('id');
    var discipline = button.data('discipline');
    var action = "{{ url('/admin/project-team/delete-discipline') }}/" + discipline + "/" + id;
    $('#deleteDisciplineForm').attr('action', action);
  });
});
</script>
@endsection

