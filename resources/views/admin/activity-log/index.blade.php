@extends('admin.partials.main')

@section('container')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">Activity Log</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">Activity Log</li>
        </ol>

        <div class="row">
            <div class="col-xl-8 col-lg-10 mx-auto">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                        <div>
                            <i class="fas fa-list-ul me-1"></i>
                            Riwayat Aktivitas Admin
                        </div>
                        <span class="badge bg-light text-primary rounded-pill">{{ count($logs) }} / 50 Data</span>
                    </div>
                    <div class="card-body bg-light">
                        @if(count($logs) > 0)
                            <div class="activity-stack">
                                @foreach($logs as $log)
                                    <div class="card mb-3 border-0 shadow-sm activity-card" style="border-left: 4px solid #0d6efd !important;">
                                        <div class="card-body py-2 px-3">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <h6 class="card-title mb-0 fw-bold text-primary">
                                                    <i class="fas fa-user-circle me-1"></i> {{ $log->admin_name }}
                                                </h6>
                                                <small class="text-muted">
                                                    <i class="far fa-clock me-1"></i> {{ $log->created_at->diffForHumans() }}
                                                </small>
                                            </div>
                                            <p class="card-text text-secondary mb-0" style="font-size: 0.95rem;">
                                                {!! $log->action !!}
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-5 text-muted">
                                <i class="fas fa-inbox fa-3x mb-3 text-secondary"></i>
                                <h5>Belum ada aktivitas yang terekam</h5>
                                <p>Aktivitas admin seperti menambah, menghapus, atau import data akan muncul di sini.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
    /* Styling for the book stack appearance */
    .activity-stack {
        position: relative;
        padding-top: 10px;
    }
    
    .activity-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        position: relative;
        z-index: 1;
        margin-bottom: -15px !important; /* Stack effect */
        border-radius: 8px;
    }
    
    .activity-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
        z-index: 10; /* Bring hovered card to top */
    }

    /* Last card doesn't need negative margin */
    .activity-card:last-child {
        margin-bottom: 0 !important;
    }
</style>
@endsection
