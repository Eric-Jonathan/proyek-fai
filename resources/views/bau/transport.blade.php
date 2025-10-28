@extends('layouts.app')

@section('title', 'Transportasi BAU')

@section('content')
<div class="container mt-4">
    <h4 class="fw-bold mb-3"><i class="fa fa-truck me-2"></i>Transportasi / Logistik</h4>

    <div class="card shadow-sm table-responsive">
        <table class="table table-bordered table-hover align-middle text-center">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Kendaraan</th>
                    <th>Sopir</th>
                    <th>Jadwal</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <tr onclick="window.location='{{ route('bau.transport_detail', 1) }}'" style="cursor: pointer;">
                    <td>1</td>
                    <td>Avanza 2022</td>
                    <td>Budi Santoso</td>
                    <td>10 Nov 2025</td>
                    <td><span class="badge bg-success">Tersedia</span></td>
                </tr>
                <tr onclick="window.location='{{ route('bau.transport_detail', 1) }}'" style="cursor: pointer;">
                    <td>2</td>
                    <td>Innova 2021</td>
                    <td>Siti Rahma</td>
                    <td>11 Nov 2025</td>
                    <td><span class="badge bg-warning text-dark">Dalam Perjalanan</span></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
@endsection
