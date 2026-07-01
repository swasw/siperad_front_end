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
                    <form action="{{ route('jadwal-ruangan.update', $data['id']) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-2">
                            <label for="ruang_id">Nama Ruang</label>
                            <select class="form-select" name="ruang_id">
                                @foreach ($ruang as $r)
                                    <option value="{{ $r->id }}"
                                        {{ $r->id == $data['ruang_id'] ? 'selected' : '' }}>
                                        {{ $r->nama_ruang }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label for="mata_kuliah">Mata Kuliah</label>
                            <input type="text" class="form-control" name="mata_kuliah" value="{{ $data['mata_kuliah'] }}" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="dosen">Dosen</label>
                            <input type="text" class="form-control" name="dosen" value="{{ $data['dosen'] }}" required>
                        </div>

                        <div class="form-group mb-2">
                            <label for="hari">Hari</label>
                            <select name="hari" data-placeholder="Pilih Hari" class="form-select form-select-solid">
                                <option value="Senin" <?php if (strtolower($data['hari']) == 'senin') {
                                    echo 'selected';
                                } ?>>Senin</option>
                                <option value="Selasa" <?php if (strtolower($data['hari']) == 'selasa') {
                                    echo 'selected';
                                } ?>>Selasa</option>
                                <option value="Rabu" <?php if (strtolower($data['hari']) == 'rabu') {
                                    echo 'selected';
                                } ?>>Rabu</option>
                                <option value="Kamis" <?php if (strtolower($data['hari']) == 'kamis') {
                                    echo 'selected';
                                } ?>>Kamis</option>
                                <option value="Jumat" <?php if (strtolower($data['hari']) == 'jumat') {
                                    echo 'selected';
                                } ?>>Jumat</option>
                            </select>
                        </div>


                        <div class="form-group mb-2">
                            <label for="jam_mulai_ke">Jam Mulai</label>
                            <select class="form-select" name="jam_mulai_ke">
                                @for ($i = 1; $i <= 16; $i++)
                                    <option value="{{ $i }}" {{ $i == $data['jam_mulai_ke'] ? 'selected' : '' }}>
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label for="jam_selesai_ke">Jam Selesai</label>
                            <select class="form-select" name="jam_selesai_ke">
                                @for ($i = 1; $i <= 16; $i++)
                                    <option value="{{ $i }}" {{ $i == $data['jam_selesai_ke'] ? 'selected' : '' }}>
                                        {{ $i }}
                                    </option>
                                @endfor
                            </select>
                        </div>
                        <div class="form-group mb-2">
                            <label for="prodi">Program Studi</label>
                            <input type="text" class="form-control" name="prodi" value="{{ $data['prodi'] }}" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="angkatan">Angkatan</label>
                            <input type="number" class="form-control" name="angkatan" value="{{ $data['angkatan'] }}" required>
                        </div>
                        <div class="form-group mb-2">
                            <label for="kelas">Kelas</label>
                            <input type="text" class="form-control" name="kelas" value="{{ $data['kelas'] }}">
                        </div>


                        <div class="form-group mb-2">
                            <label for="user_id_input">Penanggungjawab (PJ)</label>
                            
                            @php
                                $pjText = '';
                                if(isset($data['penanggungjawab'])) {
                                    $pjText = $data['penanggungjawab']['username'] . ' - ' . $data['penanggungjawab']['name'];
                                }
                            @endphp

                            <input list="users-list" id="user_id_input" class="form-control" placeholder="Ketik untuk mencari username..." value="{{ $pjText }}">
                            <datalist id="users-list">
                                @foreach ($users as $u)
                                    <option value="{{ $u->username }} - {{ $u->name }}" data-id="{{ $u->id }}"></option>
                                @endforeach
                            </datalist>
                            <input type="hidden" name="user_id" id="user_id_hidden" value="{{ $data['user_id'] ?? '' }}">
                        </div>

                        <div class="form-group mb-2">
                            <label for="">Status Ruang</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status_ruang" id="tersedia"
                                    value="{{ 1 }}" {{ $data['status_ruang'] == 1 ? 'Checked' : '' }}>
                                <label class="form-check-label" for="tersedia">
                                    Tersedia
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="status_ruang" id="tidak_tersedia"
                                    value="{{ 0 }}" {{ $data['status_ruang'] == 0 ? 'Checked' : '' }}>
                                <label class="form-check-label" for="tidak_tersedia">
                                    Tidak Tersedia
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Ubah</button>
                    </form>
                </div>
            </div>

        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const input = document.getElementById('user_id_input');
            const hidden = document.getElementById('user_id_hidden');
            const options = document.querySelectorAll('#users-list option');

            input.addEventListener('input', function() {
                let found = false;
                for (let i = 0; i < options.length; i++) {
                    if (options[i].value === input.value) {
                        hidden.value = options[i].getAttribute('data-id');
                        found = true;
                        break;
                    }
                }
                if (!found && input.value.trim() === '') {
                    hidden.value = ''; // Kosongkan jika dihapus
                }
            });
        });
    </script>
@endsection
