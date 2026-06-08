@extends('user.layouts.frontend')

@section('content')
    @if (session('alert'))
        <script>
            Swal.fire({
                title: '{{ session('alert.title') }}',
                text: '{{ session('alert.text') }}',
                icon: '{{ session('alert.icon') }}',
                confirmButtonText: 'OK'
            });
        </script>
    @endif
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
    <div class="container">
        <div class="content pt-4 pt-lg-0">
            </br></br>
            <h5>FORM PEMINJAMAN RUANG</h5>
            </br>
            <form action="{{ route('user.peminjaman-ruang.store') }}" method="POST" enctype="multipart/form-data">
                {{ csrf_field() }}
                
                <div class="mb-3">
                    <label class="form-label">Tanggal Peminjaman</label>
                    <input type="date" name="tgl_peminjaman" class="form-control" value="{{ date('Y-m-d') }}"
                        min="{{ date('Y-m-d') }}" required>
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Nama Peminjam</label>
                    <input type="text" name="nama_peminjam" class="form-control"
                        value="{{ auth()->user()->name }}" required>
                </div>

                <div class="mb-3">
                    <label for="mata_kuliah" class="form-label">Mata Kuliah</label>
                    <input type="text" class="form-control" name="mata_kuliah" id="mata_kuliah" placeholder="Mata Kuliah" required>
                </div>

                <div class="mb-3">
                    <label for="dosen" class="form-label">Nama Dosen</label>
                    <input type="text" class="form-control" name="dosen" id="dosen" placeholder="Nama Dosen" required>
                </div>

                <div class="mb-3">
                    <label for="prodi" class="form-label">Program Studi</label>
                    <input type="text" class="form-control" name="prodi" id="prodi" placeholder="Program Studi" required>
                </div>

                <div class="mb-3">
                    <label for="angkatan" class="form-label">Angkatan</label>
                    <input type="number" class="form-control" name="angkatan" id="angkatan" placeholder="Tahun Angkatan" required>
                </div>
                
                <div class="mb-3">
                    <label for="jam_mulai_id" class="form-label">Jam Mulai</label>
                    <select class="form-select" name="jam_mulai_id" required>
                        <option selected disabled>Jam Mulai</option>
                        @foreach ($jam_mulai as $jm)
                            <option value="{{ $jm->id }}">{{ substr($jm->jam, 0, 5) }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="mb-3">
                    <label for="jam_selesai_id" class="form-label">Jam Selesai</label>
                    <select class="form-select" name="jam_selesai_id" required>
                        <option selected disabled>Jam Selesai</option>
                        @foreach ($jam_selesai as $js)
                            <option value="{{ $js->id }}">{{ substr($js->jam, 0, 5) }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label for="ruang_id" class="form-label">Ruang</label>
                    <select class="form-select" name="ruang_id" required>
                        <option selected disabled>Pilih Ruang</option>
                        @foreach ($ruang as $r)
                            <option value="{{ $r->id }}">{{ $r->nama_ruang }}</option>
                        @endforeach
                    </select>
                </div>

                <input type="hidden" name="status_peminjaman" value="0">
                
                <div class="modal-footer mt-4">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
@stop
