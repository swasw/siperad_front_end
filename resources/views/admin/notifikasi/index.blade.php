@extends('admin.partials.main')

@section('container')
<main>
    <div class="container-fluid px-4">
        <h1 class="mt-4">{{ $title }}</h1>
        <ol class="breadcrumb mb-4">
            <li class="breadcrumb-item"><a href="{{ route('admin.home') }}">Dashboard</a></li>
            <li class="breadcrumb-item active">{{ $title }}</li>
        </ol>

        <div class="card mb-4 shadow-sm border-0">
            <div class="card-header bg-primary text-white">
                <i class="fas fa-table me-1"></i>
                Data Riwayat Konfirmasi Penggunaan Ruangan oleh PJ
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="datatablesSimple" class="table table-bordered table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>No</th>
                                <th>Mata Kuliah</th>
                                <th>Ruang</th>
                                <th>Tanggal Pertemuan</th>
                                <th>Waktu Kelas</th>
                                <th>PJ / Dosen</th>
                                <th>Status Konfirmasi</th>
                                <th>Waktu Jawab</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($notifikasis as $index => $notif)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $notif['jadwal_ruangan']['mata_kuliah'] ?? '-' }}</td>
                                <td>{{ $notif['jadwal_ruangan']['ruang']['nama_ruang'] ?? '-' }}</td>
                                <td><span class="badge bg-info text-dark">{{ \Carbon\Carbon::parse($notif['tanggal'])->translatedFormat('d M Y') }}</span></td>
                                <td>{{ ucfirst($notif['jadwal_ruangan']['hari'] ?? '-') }}, {{ substr($notif['jadwal_ruangan']['jam_mulai'] ?? '00:00', 0, 5) }} - {{ substr($notif['jadwal_ruangan']['jam_selesai'] ?? '00:00', 0, 5) }}</td>
                                <td>{{ $notif['jadwal_ruangan']['penanggungjawab']['name'] ?? $notif['jadwal_ruangan']['dosen'] ?? 'Tidak Ada PJ' }}</td>
                                <td>
                                    @if($notif['status'] === 'pending')
                                        <span class="badge bg-warning text-dark"><i class="fas fa-clock"></i> Pending (Belum Dijawab)</span>
                                    @elseif($notif['status'] === 'dilaksanakan')
                                        <span class="badge bg-success"><i class="fas fa-check"></i> Dilaksanakan</span>
                                    @else
                                        <span class="badge bg-danger"><i class="fas fa-times"></i> Tidak Dilaksanakan</span>
                                    @endif
                                </td>
                                <td>
                                    {{ $notif['waktu_konfirmasi'] ? \Carbon\Carbon::parse($notif['waktu_konfirmasi'])->translatedFormat('d M Y H:i') : '-' }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
