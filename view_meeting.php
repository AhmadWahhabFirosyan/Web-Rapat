<?php
session_start();
require 'config.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$id = intval($_GET['id']);
$query = "SELECT * FROM meetings WHERE id = $id";
$result = mysqli_query($conn, $query);
$meeting = mysqli_fetch_assoc($result);

if (!$meeting) {
    header("Location: index.php");
    exit();
}

// Download CSV
if (isset($_GET['download'])) {
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="daftar_hadir_' . $meeting['theme'] . '.csv"');
    $output = fopen('php://output', 'w');
    fputcsv($output, ['Nama']);
    $attendees = explode(',', $meeting['attendees']);
    foreach ($attendees as $attendee) {
        fputcsv($output, [trim($attendee)]);
    }
    fclose($output);
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Rapat</title>
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
                    <a class="nav-link" href="index.php"><i class="fas fa-arrow-left me-1"></i>Kembali</a>
                    <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt me-1"></i>Logout (<?php echo htmlspecialchars($_SESSION['username']); ?>)</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        <h2 class="my-4"><i class="fas fa-info-circle me-2"></i>Detail Rapat: <?php echo htmlspecialchars($meeting['theme']); ?></h2>
        <div class="card p-4">
            <div class="card-body">
                <p><strong><i class="fas fa-tag me-2"></i>Tema:</strong> <?php echo htmlspecialchars($meeting['theme']); ?></p>
                <p><strong><i class="fas fa-calendar-day me-2"></i>Tanggal:</strong> <?php echo date('d-m-Y', strtotime($meeting['meeting_date'])); ?></p>
                <p><strong><i class="fas fa-clock me-2"></i>Waktu:</strong> <?php echo htmlspecialchars($meeting['meeting_time']); ?></p>
                <p><strong><i class="fas fa-globe me-2"></i>Status:</strong> <?php echo htmlspecialchars($meeting['status']); ?></p>
                <p><strong><i class="fas fa-users me-2"></i>Daftar Hadir:</strong></p>
                <ul class="list-group list-group-flush mb-3">
                    <?php
                    $attendees = explode(',', $meeting['attendees']);
                    foreach ($attendees as $attendee) {
                        echo "<li class='list-group-item'>" . htmlspecialchars(trim($attendee)) . "</li>";
                    }
                    ?>
                </ul>
                <p><strong><i class="fas fa-notes-medical me-2"></i>Notulensi:</strong></p>
                <p class="border p-3 rounded"><?php echo nl2br(htmlspecialchars($meeting['notes'])); ?></p>
                <a href="view_meeting.php?id=<?php echo $id; ?>&download=1" class="btn btn-success"><i class="fas fa-download me-1"></i>Unduh Daftar Hadir (CSV)</a>
            </div>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p>&copy; 2025 Manajemen Rapat. All rights reserved.</p>
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