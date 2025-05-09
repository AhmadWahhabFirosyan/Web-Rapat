<?php
session_start();
require 'config.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Ambil department dan role pengguna
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT role, department FROM users WHERE id = " . $_SESSION['user_id']));
$user_role = $user['role'];
$user_department = $user['department'];

// Query untuk filter dan pencarian
$filter_date = isset($_GET['filter_date']) ? $_GET['filter_date'] : '';
$filter_status = isset($_GET['filter_status']) ? $_GET['filter_status'] : '';
$search_theme = isset($_GET['search_theme']) ? mysqli_real_escape_string($conn, $_GET['search_theme']) : '';
$query = "SELECT * FROM meetings WHERE 1=1";
if ($user_role == 'Peserta') {
    $query .= " AND department = '$user_department'";
}
if ($filter_date) {
    $query .= " AND DATE(meeting_date) = '$filter_date'";
}
if ($filter_status) {
    $query .= " AND status = '$filter_status'";
}
if ($search_theme) {
    $query .= " AND theme LIKE '%$search_theme%'";
}
$query .= " ORDER BY meeting_date DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Rapat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php"><i class="fas fa-calendar-alt me-2"></i>Manajemen Rapat</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <div class="navbar-nav ms-auto">
                    <a class="nav-link" href="add_meeting.php"><i class="fas fa-plus me-1"></i>Tambah Rapat</a>
                    <span class="nav-link disabled">Role: <?php echo htmlspecialchars($user_role); ?></span>
                    <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt me-1"></i>Logout (<?php echo htmlspecialchars($_SESSION['user_id']); ?>)</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        <h2 class="my-4 text-center"><i class="fas fa-list me-2 text-primary"></i>Daftar Rapat (Bidang: <?php echo htmlspecialchars($user_department); ?>)</h2>
        <div class="card p-4 mb-4">
            <form method="GET">
                <div class="row g-3 align-items-center">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text bg-primary text-white"><i class="fas fa-calendar-day"></i></span>
                            <input type="date" name="filter_date" class="form-control" value="<?php echo isset($_GET['filter_date']) ? $_GET['filter_date'] : ''; ?>">
                        </div>
                    </div>
                    <div class="col-md-3">
                        <select name="filter_status" class="form-control">
                            <option value="">Semua Status</option>
                            <option value="Online" <?php echo isset($_GET['filter_status']) && $_GET['filter_status'] == 'Online' ? 'selected' : ''; ?>>Online</option>
                            <option value="Offline" <?php echo isset($_GET['filter_status']) && $_GET['filter_status'] == 'Offline' ? 'selected' : ''; ?>>Offline</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="search_theme" class="form-control" placeholder="Cari berdasarkan tema..." value="<?php echo isset($_GET['search_theme']) ? $_GET['search_theme'] : ''; ?>">
                    </div>
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter me-1"></i>Filter</button>
                    </div>
                </div>
            </form>
        </div>

        <div class="card">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Tema</th>
                            <th>Tanggal</th>
                            <th>Waktu</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            $status_class = $row['status'] == 'Online' ? 'text-success' : 'text-warning';
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['theme']) . "</td>";
                            echo "<td>" . date('d-m-Y', strtotime($row['meeting_date'])) . "</td>";
                            echo "<td>" . htmlspecialchars($row['meeting_time']) . "</td>";
                            echo "<td class='$status_class'>" . htmlspecialchars($row['status']) . "</td>";
                            echo "<td><a href='view_meeting.php?id=" . $row['id'] . "' class='btn btn-info btn-sm'><i class='fas fa-eye me-1'></i>Lihat</a></td>";
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p>© 2025 Manajemen Rapat. All rights reserved.</p>
            <div>
                <a href="#"><i class="fab fa-twitter"></i></a>
                <a href="#"><i class="fab fa-linkedin"></i></a>
                <a href="#"><i class="fab fa-github"></i></a>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>