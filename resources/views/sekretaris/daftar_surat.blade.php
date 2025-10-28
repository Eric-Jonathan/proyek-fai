@extends('layouts.app')

@section('title', 'Daftar Surat Tugas')

@section('content')
<div class="container mt-4">
    <h3 class="mb-4"><i class="fa fa-file-alt me-2"></i>Daftar Surat Tugas</h3>

    {{-- Tombol refresh atau filter --}}
    <div class="d-flex justify-content-between mb-3">
        <div>
            <button class="btn btn-sm btn-outline-primary">
                <i class="fa fa-sync-alt"></i> Refresh
            </button>
        </div>
        <div>
            <input type="text" class="form-control form-control-sm" style="width: 250px;"
                   placeholder="Cari surat...">
        </div>
    </div>


</div>
@endsection
