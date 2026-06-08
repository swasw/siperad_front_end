@extends('admin.partials.main')

@section('container')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">{{ $title }}</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="{{ route('input-multiple.index') }}">Input Multiple</a></li>
                <li class="breadcrumb-item active">{{ $title }}</li>
            </ol>
            
            <div class="card mb-4 shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-info-circle me-1 text-primary"></i>
                        <strong>Status Upload Data</strong>
                    </div>
                    <div>
                        <a href="{{ route('input-multiple.index') }}" class="btn btn-sm btn-secondary"><i class="fas fa-arrow-left me-1"></i> Kembali</a>
                    </div>
                </div>
                <div class="card-body bg-light">
                    <div class="row pt-3 px-2">
                        @foreach ($results as $category => $status)
                            <div class="col-xl-3 col-md-6 mb-4">
                                <div class="card border-0 shadow h-100 py-2 border-start border-4 @if($status['success'] > 0 && $status['failed'] == 0) border-success @elseif($status['failed'] > 0) border-danger @else border-primary @endif">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs fw-bold text-uppercase mb-2 @if($status['success'] > 0 && $status['failed'] == 0) text-success @elseif($status['failed'] > 0) text-danger @else text-primary @endif">
                                                    {{ $category }}
                                                </div>
                                                <div class="h6 mb-0 font-weight-bold text-gray-800 mt-3">
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <span class="text-success small fw-bold"><i class="fas fa-check-circle"></i> Berhasil:</span>
                                                        <span class="badge bg-success rounded-pill px-3">{{ $status['success'] }}</span>
                                                    </div>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <span class="text-danger small fw-bold"><i class="fas fa-times-circle"></i> Gagal:</span>
                                                        <span class="badge bg-danger rounded-pill px-3">{{ $status['failed'] }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-auto ms-3 d-flex align-items-center opacity-50">
                                                <i class="fas fa-database fa-2x"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        
                        @if(empty($results))
                            <div class="col-12 text-center py-5">
                                <i class="fas fa-folder-open fa-3x text-muted mb-3"></i>
                                <h5 class="text-muted">Tidak ada data valid yang berhasil diproses.</h5>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </main>
@endsection
