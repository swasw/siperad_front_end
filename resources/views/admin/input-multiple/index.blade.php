@extends('admin.partials.main')

@section('container')
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">{{ $title }}</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active"><a href="{{ route('admin.home') }}">Dashboard</a> > {{ $title }}
                </li>
            </ol>
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif
            @if ($message = Session::get('error'))
                <div class="alert alert-danger">
                    <p>{{ $message }}</p>
                </div>
            @endif
            <div class="card mb-4">
                <div class="card-body">
                    <h6>template untuk input (kosongkan data jika tidak perlu input) ---> berisi excel dengan berbagai section untuk masing2 entitas</h6>
                    <a href="{{ asset('template_input_multiple.xlsx') }}" class="btn btn-sm btn-success mt-2" download><i class="fas fa-download me-1"></i> Download Template Excel</a>
                </div>
            </div>
            <div id="loadingOverlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 9999; justify-content: center; align-items: center; flex-direction: column;">
                <div class="spinner-border text-light" style="width: 3rem; height: 3rem;" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
                <h4 class="text-white mt-3">This process might take a while, please wait...</h4>
            </div>

            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between">
                    <div>
                        <i class="fas fa-upload me-1"></i>
                        Silahkan upload file disini untuk input data
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('input-multiple.store') }}" method="POST" enctype="multipart/form-data" onsubmit="document.getElementById('loadingOverlay').style.display = 'flex';">
                        @csrf
                        <div class="mb-3">
                            <label for="fileUpload" class="form-label">Upload File Excel (.xlsx, .xls)</label>
                            <input class="form-control" type="file" id="fileUpload" name="file" accept=".xlsx, .xls" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>

        </div>
    </main>
@endsection
