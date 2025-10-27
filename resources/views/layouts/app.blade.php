<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Surat Penugasan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #f5f6fa;
            overflow-x: hidden;
        }
        .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            background-color: #2f3542;
            color: #fff;
        }
        .sidebar .profile {
            text-align: center;
            padding: 30px 10px;
            border-bottom: 1px solid #444;
        }
        .sidebar .profile img {
            width: 90px;
            border-radius: 50%;
            margin-bottom: 10px;
        }
        .sidebar .menu a {
            display: block;
            padding: 12px 20px;
            color: #dcdde1;
            text-decoration: none;
            transition: 0.2s;
        }
        .sidebar .menu a:hover, .sidebar .menu a.active {
            background-color: #57606f;
            color: #fff;
        }
        .content {
            margin-left: 250px;
            padding: 20px;
        }
        .topbar {
            background-color: #2f3542;
            color: #fff;
            padding: 10px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .topbar .user {
            font-weight: 500;
        }
        .card-info {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px;
            border-radius: 10px;
            color: #fff;
        }
        .card-purple { background: #6c5ce7; }
        .card-blue { background: #0984e3; }
        .card-gray { background: #636e72; }
        .chart {
            height: 250px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            padding: 15px;
        }
    </style>
</head>
<body>

    {{-- Sidebar --}}
    <div class="sidebar">
        <div class="profile">
            <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" alt="User">
            <h5>Hi Admin</h5>
            <small>Administrator</small>
        </div>
        <div class="menu">
            <a href="#" class="active"><i class="fa fa-home me-2"></i>Home</a>
            <a href="#"><i class="fa fa-users me-2"></i>Pengguna</a>
            <a href="#"><i class="fa fa-envelope me-2"></i>Surat Masuk</a>
            <a href="#"><i class="fa fa-paper-plane me-2"></i>Surat Keluar</a>
            <a href="#"><i class="fa fa-cog me-2"></i>Pengaturan</a>
        </div>
    </div>

    {{-- Content --}}
    <div class="content">
        <div class="topbar">
            <h4>Arsip Surat</h4>
            <div class="user">
                <i class="fa fa-user-circle me-2"></i>Hi Admin!
            </div>
        </div>

        <div class="container-fluid mt-4">
            <h5 class="mb-3">The Dashboard</h5>
            <div class="row g-3">
                <div class="col-md-4">
                    <div class="card-info card-purple">
                        <div><strong>Pengguna</strong><br>2 Total</div>
                        <i class="fa fa-user fa-2x"></i>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card-info card-blue">
                        <div><strong>Jumlah Admin</strong><br>1</div>
                        <i class="fa fa-user-shield fa-2x"></i>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card-info card-gray">
                        <div><strong>Jumlah User</strong><br>1</div>
                        <i class="fa fa-users fa-2x"></i>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-6">
                    <div class="chart">
                        <h6>Data Surat Masuk</h6>
                        <canvas id="chartMasuk"></canvas>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="chart">
                        <h6>Data Surat Keluar</h6>
                        <canvas id="chartKeluar"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx1 = document.getElementById('chartMasuk');
        new Chart(ctx1, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar'],
                datasets: [{ label: 'Surat Masuk', data: [2, 3, 1], backgroundColor: '#ffa502' }]
            }
        });

        const ctx2 = document.getElementById('chartKeluar');
        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar'],
                datasets: [{ label: 'Surat Keluar', data: [1, 2, 3], backgroundColor: '#2ed573' }]
            }
        });
    </script>
</body>
</html>
