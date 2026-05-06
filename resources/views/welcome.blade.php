<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMART BMN</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: radial-gradient(circle at top, #1e293b, #0f172a);
            color: white;
            overflow: hidden;
        }

        .bg-blur {
            position: absolute;
            width: 400px;
            height: 400px;
            background: #f59e0b;
            filter: blur(120px);
            opacity: 0.25;
            top: -100px;
            left: -100px;
        }

        .container {
            text-align: center;
            z-index: 10;
            max-width: 600px;
        }

        .logo {
            width: 90px;
            height: 90px;
            object-fit: contain;
            margin-bottom: 15px;
        }

        .title {
            font-size: 52px;
            font-weight: 700;
            letter-spacing: 2px;
            margin: 0;
        }

        .subtitle {
            margin-top: 8px;
            color: #cbd5e1;
            font-size: 16px;
        }

        .instansi {
            margin-top: 5px;
            font-size: 14px;
            color: #94a3b8;
        }

        .card {
            margin-top: 30px;
            padding: 28px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.06);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .buttons {
            margin-top: 20px;
        }

        .btn {
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 600;
            text-decoration: none;
            transition: 0.3s;
            display: inline-block;
        }

        .btn-primary {
            background: #f59e0b;
            color: #111827;
        }

        .btn-primary:hover {
            background: #d97706;
        }

        .footer {
            margin-top: 25px;
            font-size: 12px;
            color: #64748b;
        }
    </style>
</head>

<body>

    <div class="bg-blur"></div>

    <div class="container">

        <!-- LOGO BAWASLU -->
        <img src="{{ asset('storage/logo.png') }}" class="logo" alt="Bawaslu">

        <h1 class="title">SMART BMN</h1>

        <div class="subtitle">
            Sistem Manajemen Aset Barang Milik Negara
        </div>

        <div class="instansi">
            Bawaslu Kabupaten Lamongan
        </div>

        <div class="card">

            <div style="font-size:13px; color:#cbd5e1;">
                Monitoring • Inventory • Maintenance • Reporting
            </div>

            <div class="buttons">
                <a href="/admin" class="btn btn-primary">Masuk Aplikasi</a>
            </div>

        </div>

        <div class="footer">
            © {{ date('Y') }} SMART BMN - Bawaslu Kabupaten Lamongan
        </div>

    </div>

</body>

</html>