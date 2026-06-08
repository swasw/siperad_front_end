@extends('admin.partials.main');

@section('container')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">{{ $title }}</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active"><a href="{{ route('admin.home') }}">Dashboard</a> > <a
                        href="{{ route('jadwal-ruangan.index') }}">Data Jadwal Ruangan</a> > {{ $title }}</li>
            </ol>
            <div class="card mb-4">
                <div class="card-body">
                    <h6>Berikut adalah form {{ Str::lower($title) }}.</h6>
                </div>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <div class="alert-title">
                        <h4>Whoops!</h4>
                    </div>
                    There are some problems with your input.
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    {{ $title }}
                </div>
                <div class="card-body">
                    <form action="{{ route('jadwal-ruangan.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group mb-2">
                            <label for="ruang_id">Nama Ruang</label>
                            <select class="form-select" name="ruang_id">
                                <option selected disabled>Nama Ruang</option>
                                @foreach ($ruang as $r)
                                    <option value="{{ $r->id }}">{{ $r->nama_ruang }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label for="mata_kuliah">Mata Kuliah</label>
                            <input type="text" class="form-control" name="mata_kuliah" placeholder="Mata Kuliah" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="dosen">Dosen</label>
                            <input type="text" class="form-control" name="dosen" placeholder="Nama Dosen" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="hari">Hari</label>
                            <select name="hari" data-placeholder="Pilih Hari" class="form-select form-select-solid">
                                <option value="senin">Senin</option>
                                <option value="selasa">Selasa</option>
                                <option value="rabu">Rabu</option>
                                <option value="kamis">Kamis</option>
                                <option value="jumat">Jumat</option>
                            </select>
                        </div>

                        <div class="form-group mb-2">
                            <label for="jam_mulai_ke">Jam Mulai</label>
                            <select class="form-select" name="jam_mulai_ke">
                                <option selected disabled>Pilih Jam Mulai</option>
                                @for ($i = 1; $i <= 16; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label for="jam_selesai_ke">Jam Selesai</label>
                            <select class="form-select" name="jam_selesai_ke">
                                <option selected disabled>Pilih Jam Selesai</option>
                                @for ($i = 1; $i <= 16; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label for="prodi">Program Studi</label>
                            <input type="text" class="form-control" name="prodi" placeholder="Program Studi" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="angkatan">Angkatan</label>
                            <input type="number" class="form-control" name="angkatan" placeholder="Tahun Angkatan" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="kelas">Kelas</label>
                            <input type="text" class="form-control" name="kelas" placeholder="Misal: A, B, atau isi dengan -">
                        </div>
                        <div class="form-group mb-2">
                            <label for="">Status Ruang</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status_ruang" id="tersedia"
                                    value="{{ 1 }}" checked>
                                <label class="form-check-label" for="tersedia">
                                    Tersedia
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status_ruang" id="tidak_tersedia"
                                    value="{{ 0 }}">
                                <label class="form-check-label" for="tidak_tersedia">
                                    Tidak Tersedia
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </form>
                </div>
            </div>

        </div>
    </main>
@endsection
