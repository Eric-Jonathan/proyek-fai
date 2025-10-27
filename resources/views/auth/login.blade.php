<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Surat Penugasan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #74b9ff, #0984e3);
            font-family: 'Segoe UI', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            background: #fff;
            border-radius: 15px;
            padding: 40px 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 400px;
        }
        .login-card h4 {
            text-align: center;
            margin-bottom: 30px;
            font-weight: 600;
            color: #2d3436;
        }
        .form-control {
            border-radius: 10px;
        }
        .btn-login {
            background-color: #0984e3;
            border: none;
            border-radius: 10px;
            width: 100%;
            padding: 10px;
            color: #fff;
            font-weight: 500;
        }
        .btn-login:hover {
            background-color: #74b9ff;
        }
        .footer-text {
            text-align: center;
            margin-top: 15px;
            font-size: 13px;
            color: #636e72;
        }
    </style>
</head>
<body>

    <div class="login-card">
        <h4><i class="fa fa-envelope me-2"></i>Sistem Surat Penugasan</h4>
        <form action="{{ url('/sekretaris') }}" method="GET">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" placeholder="Masukkan username">
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" placeholder="Masukkan password" >
            </div>
            <button type="submit" class="btn-login mt-2">Masuk</button>
        </form>
        <p class="footer-text mt-3">© 2025 Sistem Surat Penugasan</p>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/js/all.min.js"></script>
</body>
</html>
