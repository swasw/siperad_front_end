@extends('user.layouts.frontend')

@section('content')
<main id="main">
    <section class="breadcrumbs">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <h2>Notifikasi Konfirmasi Ruangan</h2>
                <ol>
                    <li><a href="{{ route('user.home') }}">Home</a></li>
                    <li>Notifikasi</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="inner-page">
        <div class="container">
            <div class="row">
                <div class="col-md-10 mx-auto">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    @forelse($notifikasis as $notif)
                        <div class="card mb-4 shadow-sm border-0 @if($notif['status'] === 'pending') border-start border-primary border-4 @else border-start border-secondary border-4 @endif">
                            <div class="card-header @if($notif['status'] === 'pending') bg-primary text-white @else bg-light text-dark @endif d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="icofont-notification me-2"></i>
                                    <strong>Konfirmasi Penggunaan Ruangan</strong>
                                </div>
                                <small class="@if($notif['status'] === 'pending') text-white-50 @else text-muted @endif">
                                    {{ \Carbon\Carbon::parse($notif['created_at'])->diffForHumans() }}
                                </small>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title fw-bold text-primary">{{ $notif['jadwal_ruangan']['mata_kuliah'] }}</h5>
                                <div class="row mb-3 mt-3">
                                    <div class="col-md-6">
                                        <p class="mb-1 text-muted small">Ruangan</p>
                                        <p class="fw-bold"><i class="icofont-location-pin text-danger"></i> {{ $notif['jadwal_ruangan']['ruang']['nama_ruang'] }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="mb-1 text-muted small">Waktu Kelas</p>
                                        <p class="fw-bold"><i class="icofont-clock-time text-success"></i> {{ ucfirst($notif['jadwal_ruangan']['hari']) }}, {{ substr($notif['jadwal_ruangan']['jam_mulai'], 0, 5) }} - {{ substr($notif['jadwal_ruangan']['jam_selesai'], 0, 5) }}</p>
                                    </div>
                                    <div class="col-md-12 mt-2">
                                        <p class="mb-1 text-muted small">Tanggal Pertemuan</p>
                                        <p class="badge bg-warning text-dark fs-6 px-3 py-2"><i class="icofont-ui-calendar"></i> {{ \Carbon\Carbon::parse($notif['tanggal'])->translatedFormat('l, d F Y') }}</p>
                                    </div>
                                </div>
                                
                                <hr>
                                
                                @if($notif['status'] === 'pending')
                                <p class="fw-bold text-center mb-4">Apakah ruangan ini akan digunakan sesuai jadwal pertemuan tersebut?</p>
                                <div class="d-flex justify-content-center gap-3">
                                    <form action="{{ route('user.notifikasi.jawab') }}" method="POST" class="m-0">
                                        @csrf
                                        <input type="hidden" name="jadwal_ruangan_id" value="{{ $notif['jadwal_ruangan_id'] }}">
                                        <input type="hidden" name="tanggal" value="{{ $notif['tanggal'] }}">
                                        <input type="hidden" name="status" value="dilaksanakan">
                                        <button type="submit" class="btn btn-success px-4 py-2"><i class="icofont-check-circled"></i> Ya, Ruangan Digunakan</button>
                                    </form>
                                    <form action="{{ route('user.notifikasi.jawab') }}" method="POST" class="m-0">
                                        @csrf
                                        <input type="hidden" name="jadwal_ruangan_id" value="{{ $notif['jadwal_ruangan_id'] }}">
                                        <input type="hidden" name="tanggal" value="{{ $notif['tanggal'] }}">
                                        <input type="hidden" name="status" value="tidak_dilaksanakan">
                                        <button type="submit" class="btn btn-danger px-4 py-2"><i class="icofont-close-circled"></i> Tidak Digunakan</button>
                                    </form>
                                </div>
                                @else
                                    <div class="alert {{ $notif['status'] === 'dilaksanakan' ? 'alert-success' : 'alert-secondary' }} mb-0 text-center">
                                        Status Konfirmasi: <strong>{{ $notif['status'] === 'dilaksanakan' ? 'YA, RUANGAN DIGUNAKAN' : 'TIDAK DILAKSANAKAN' }}</strong>
                                        <br><small class="text-muted">Telah dijawab pada: {{ \Carbon\Carbon::parse($notif['waktu_konfirmasi'])->translatedFormat('d M Y H:i') }}</small>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5">
                            <i class="icofont-ui-messaging text-muted" style="font-size: 5rem;"></i>
                            <h4 class="text-muted mt-4 fw-bold">Belum Ada Notifikasi</h4>
                            <p class="text-muted">Tidak ada konfirmasi ruangan yang perlu Anda jawab saat ini.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
</main>

<style>
    .gap-3 { gap: 1rem; }
    .border-start { border-left: var(--bs-border-width) var(--bs-border-style) var(--bs-border-color) !important; }
    .border-4 { border-left-width: 4px !important; }
    .fs-6 { font-size: 1rem !important; }
</style>
@endsection
