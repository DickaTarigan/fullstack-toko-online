<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>403 — Akses Ditolak</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', sans-serif;
            background: #f8fafc;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .container {
            text-align: center;
            padding: 2rem;
            max-width: 480px;
        }
        .emoji { font-size: 5rem; margin-bottom: 1rem; }
        .code {
            font-size: 6rem;
            font-weight: 800;
            color: #ef4444;
            line-height: 1;
        }
        .title {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e293b;
            margin: 1rem 0 0.5rem;
        }
        .desc {
            color: #64748b;
            font-size: 0.95rem;
            margin-bottom: 2rem;
            line-height: 1.6;
        }
        .btn {
            display: inline-block;
            background: #2563eb;
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 0.5rem;
            text-decoration: none;
            font-weight: 600;
            font-size: 0.95rem;
            transition: background 0.2s;
        }
        .btn:hover { background: #1d4ed8; }
    </style>
</head>
<body>
    <div class="container">
        <div class="emoji">🚫</div>
        <div class="code">403</div>
        <h1 class="title">Akses Ditolak</h1>
        <p class="desc">
            Anda tidak memiliki izin untuk mengakses halaman ini.<br>
            Pastikan Anda login dengan akun yang sesuai.
        </p>
        <a href="/" class="btn">← Kembali ke Beranda</a>
    </div>
</body>
</html>