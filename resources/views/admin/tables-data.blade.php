<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Dashboard</title>
    <link href="{{ asset('admin/assets/img/favicon.png') }}" rel="icon">
    <link href="{{ asset('admin/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin/assets/css/style.css') }}" rel="stylesheet">
    <style>
      /* Global Styles */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f8f9fa; /* Light background */
    color: #333;
}

header {
    background-color: #6f42c1; /* Purple color */
    padding: 20px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

footer {
    background-color: #6f42c1;
    color: white;
    text-align: center;
    padding: 10px;
}

#sidebar {
    background-color: #343a40; /* Dark background for sidebar */
    color: white;
    width: 250px;
    min-height: 100vh;
}

#sidebar .sidebar-nav {
    padding-left: 0;
}

#sidebar .nav-item {  
    list-style-type: none;
}

#sidebar .nav-item .nav-link {
    color:rgb(65, 1, 194);
    padding: 10px 20px;
    display: block;
    text-transform: uppercase;
}

#sidebar .nav-item .nav-link:hover {
    background-color: #495057;
    color: white;
}

#main {
    margin-left: 270px;
    padding: 20px;
}

/* Card Styles */
.card {
    border-radius: 10px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    background-color: #ffffff;
}

.card-title {
    font-size: 20px;
    font-weight: bold;
    color: #6f42c1;
}

.card-body {
    padding: 20px;
}

/* Table Styles */
.table {
    border: none;
    width: 100%;
    margin-top: 20px;
    border-collapse: collapse;
}

.table th, .table td {
    padding: 15px;
    border: 1px solid #ddd;
    text-align: center;
}

.table-striped tbody tr:nth-child(odd) {
    background-color: #f8f9fa;
}

.table-striped tbody tr:hover {
    background-color: #f1f1f1;
}

.table th {
    background-color: #6f42c1;
    color: white;
    text-transform: uppercase;
}

/* Button Styles */
.btn {
    border-radius: 5px;
    padding: 8px 20px;
    font-size: 14px;
    font-weight: bold;
    transition: all 0.3s ease;
}

.btn-success {
    background-color: #28a745;
    color: white;
}

.btn-danger {
    background-color: #dc3545;
    color: white;
}

.btn-warning {
    background-color: #ffc107;
    color: white;
}

.btn:hover {
    transform: scale(1.05);
}

.btn-success:hover {
    background-color: #218838;
}

.btn-danger:hover {
    background-color: #c82333;
}

.btn-warning:hover {
    background-color: #e0a800;
}

    </style>
</head>

<body>
    <header id="header" class="header fixed-top d-flex align-items-center">
        <div class="d-flex align-items-center justify-content-between">
            <a href="{{ url('/') }}" class="logo d-flex align-items-center">
                <img src="{{ asset('admin/assets/img/logo.png') }}" alt="">
                <span class="d-none d-lg-block">Admin Dashboard</span>
            </a>
        </div>
    </header>

    <!-- Sidebar -->
    <aside id="sidebar" class="sidebar">
        <ul class="sidebar-nav" id="sidebar-nav">
            <li class="nav-item">
                <a class="nav-link" href="/indexadmin">
                    <i class="bi bi-house-door"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="kelola-menu">
                    <i class="bi bi-list"></i>
                    <span>Kelola Menu</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="kelola-about">
                    <i class="bi bi-info-circle"></i>
                    <span>Kelola About</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="kelola-event">
                    <i class="bi bi-calendar-event"></i>
                    <span>Kelola Event</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/tables-data">
                    <i class="bi bi-table"></i>
                    <span>Manage Table</span>
                </a>
            </li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main id="main" class="main">
        <div class="pagetitle">
            <h1>Kelola Booking Tabel</h1>
        </div>

        <section class="section dashboard">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Daftar Booking Tabel | Hari Ini</h5>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Pengguna</th>
                                        <th>Kursi</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                        <th>Bukti Pembayaran</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if(count($bookings) > 0)
                                    @foreach ($bookings as $booking)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $booking->user->name }}</td>
                                        <td>{{ implode(', ', json_decode($booking->seats)) }}</td>
                                        <td>{{ $booking->created_at }}</td>
                                        <td>{{ $booking->status }}</td>
                                        <td>
                                            @if($booking->payment)
                                            <a href="{{ asset('uploads/payments/' . $booking->payment->proof_of_payment) }}"
                                                target="_blank">Lihat Bukti</a>
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{ route('admin.booking.confirm', $booking->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-success">Konfirmasi</button>
                                            </form>
                                            <form action="{{ route('admin.booking.cancel', $booking->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-danger">Tolak</button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="7" class="text-center">Tidak ada data booking</td>
                                    </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer id="footer" class="footer">
        <div class="copyright">
            &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
        </div>
    </footer>

</body>

</html>
