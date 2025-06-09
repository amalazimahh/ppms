@extends('layouts.app', ['activePage' => 'table', 'page'=>__('RKN List'), 'titlePage' => __('Table List')])

@if(session('success') || session('error'))
<div style="position: fixed; top: 80px; right: 20px; z-index: 9999; min-width: 300px;">
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
            <i class="tim-icons icon-simple-remove"></i>
        </button>
        <span><b>Success - </b> {!! session('success') !!}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <button type="button" aria-hidden="true" class="close" data-dismiss="alert" aria-label="Close">
            <i class="tim-icons icon-simple-remove"></i>
        </button>
        <span><b>Error - </b> {{ session('error') }}</span>
    </div>
    @endif
</div>
@endif

@section('content')
<style>
    .form-control:focus {
        color: #000;
    }
    .form-control:not(:placeholder-shown) {
        color: #000;
    }

    /* animation for notif */
    .alert {
        box-shadow: 0 4px 20px 0 rgba(0,0,0,.14),
                    0 7px 10px -5px rgba(0,188,212,.4);
        border: 0;
        transition: all 0.3s ease;
        position: relative;
        display: inline-block;
        margin-bottom: 10px;
        width: auto;
    }

    .alert-success {
        background-color: #00d25b;
        color: #fff;
    }

    .alert-danger {
        background-color: #fc424a;
        color: #fff;
    }

    .alert .close {
        color: #fff;
        opacity: .9;
        text-shadow: none;
        line-height: 0;
        outline: 0;
    }

    body {
        opacity: 1;
        transition: opacity 300ms ease-in-out;
    }
    body.fade-out {
        opacity: 0;
        transition: none;
    }
</style>
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
            <div class="card-header card-header-primary d-flex justify-content-between align-items-center">
                <h2 class="card-title m-0">Rancangan Kemajuan Negara</h2>

                <button type="button" class="btn btn-success btn-round animation-on-hover" data-bs-toggle="modal" data-bs-target="#addRKNModal">
                    <i class="tim-icons icon-simple-add"></i> Add New RKN
                </button>
            </div>

            <div class="card-body">
                @if($rkns->isEmpty())
                    <div class="alert alert-warning">
                        No RKN available. Please create a new one.
                    </button>
                    </div>
                @else
                <div class="table-responsive">
                    <table class="table">
                        <thead class=" text-primary">
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rkns as $rkn)
                            <tr>
                                <td>{{ $rkn->id }}</td>
                                <td>{{ $rkn->rknNum }}</td>
                                <td>{{ $rkn->startDate }}</td>
                                <td>{{ $rkn->endDate }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- add RKN modal -->
 <div class="modal fade" id="addRKNModal" tabindex="-1" aria-labelledby="addRKNModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addRKNModalLabel">Add New RKN</h5>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <i class="tim-icons icon-simple-remove"></i>
                </button>
            </div>
            <form action="{{ route('pages.admin.rkn.store') }}" method="post">
                @csrf
                <div class="modal-body">

                <!-- rkn number -->
                <div class="row mb-3">
                    <label for="fy" class="col-sm-2 col-form-label">RKN No. </label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="rknNum" id="rknNum" placeholder="e.g. RKN12" maxlength="9">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="startDate" class="col-sm-2 col-form-label">Start Date</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="startDate" id="startDate">
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="endDate" class="col-sm-2 col-form-label">End Date</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" name="endDate" id="endDate">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>

            </form>
        </div>
    </div>
 </div>

@endsection
