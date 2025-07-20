<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Karyawan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(to right top, #f1edf9, #fce7ef);
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
        }
        .sidebar {
            height: 100vh;
            position: fixed;
            background-color: #1f2937;
            color: white;
            width: 220px;
            padding-top: 30px;
        }
        .sidebar a {
            color: #d1d5db;
            padding: 12px 20px;
            display: block;
            text-decoration: none;
            transition: 0.3s;
        }
        .sidebar a:hover,
        .sidebar a.active {
            background-color: #374151;
            color: #fff;
        }
        .sidebar .brand {
            font-size: 1.4rem;
            font-weight: 600;
            margin-bottom: 20px;
            text-align: center;
        }
        .main {
            margin-left: 220px;
            padding: 30px;
        }
        .card-custom {
            border-radius: 1rem;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
            padding: 30px;
            background: #fff;
            animation: fadeIn 0.5s ease-in-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>

    <div class="sidebar">
        <div class="brand">📊 Absensi</div>
        <a href="/employee" class="{{ request()->is('employee') ? 'active' : '' }}"><i class="bi bi-people-fill me-2"></i>Karyawan</a>
        <a href="/department" class="{{ request()->is('department') ? 'active' : '' }}"><i class="bi bi-diagram-3-fill me-2"></i>Departemen</a>
        <a href="/attendance" class="{{ request()->is('attendance') ? 'active' : '' }}"><i class="bi bi-calendar-check-fill me-2"></i>Absen</a>
        <a href="/attendance_history" class="{{ request()->is('attendance_history') ? 'active' : '' }}"><i class="bi bi-clock-history me-2"></i>Log Absensi</a>
    </div>

    <div class="main">
        <div class="card card-custom">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
