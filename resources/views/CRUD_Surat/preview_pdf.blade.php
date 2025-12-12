@extends('layouts.app')

@section('custom_css')
    <style>
        body { background: #f5f5f5; }
        .pdf-frame { height: 90vh; border: 1px solid #ccc; }
        iframe { width: 100%; height: 100%; border: none; }
    </style>
@endsection

@section('content')
    <h4 class="mb-3">Preview Surat Tugas</h4>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="pdf-frame">
                <iframe src="{{ asset('storage/'.$fileName) }}"></iframe>
            </div>
        </div>
    </div>

    <div class="mt-3 text-end">
        <a href="{{ route('cetak-surat', $surat->id) }}" class="btn btn-secondary-outline">
            Download PDF
        </a>
    </div>
@endsection