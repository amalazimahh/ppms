@if(session('role_pending'))
<!-- Modal -->
<div class="modal fade show" id="rolePendingModal" tabindex="-1" role="dialog" aria-labelledby="rolePendingModalLabel" aria-modal="true" style="display:block;">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="rolePendingModalLabel">Role Pending</h5>
      </div>
      <div class="modal-body">
        Your account does not have a role assigned yet.<br>
        Please wait for an administrator to assign your role.<br>
        You will remain on the landing page as a guest.
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" onclick="document.getElementById('rolePendingModal').style.display='none';">OK</button>
      </div>
    </div>
  </div>
</div>
<script>
document.body.classList.add('modal-open');
</script>
@endif
@extends('layouts.app')

@section('content')
    <div class="header py-7 py-lg-8">
        <div class="container">
            <div class="header-body text-center mb-7">
                <div class="row justify-content-center">
                    <div class="col-lg-5 col-md-6">
                        <h1 class="text-white">{{ __('Welcome!') }}</h1>
                        <p class="text-lead text-light">
                            {{ __('Project Progress Monitoring System for DoD, PWD') }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
