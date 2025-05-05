<?php
session_start();
require 'config.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $theme = mysqli_real_escape_string($conn, $_POST['theme']);
    $meeting_date = $_POST['meeting_date'];
    $meeting_time = $_POST['meeting_time'];
    $status = $_POST['status'];
    $attendees = mysqli_real_escape_string($conn, $_POST['attendees']);
    $notes = mysqli_real_escape_string($conn, $_POST['notes']);

    $query = "INSERT INTO meetings (theme, meeting_date, meeting_time, status, attendees, notes) 
              VALUES ('$theme', '$meeting_date', '$meeting_time', '$status', '$attendees', '$notes')";
    if (mysqli_query($conn, $query)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Rapat</title>
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
        <h2 class="my-4"><i class="fas fa-plus-circle me-2"></i>Tambah Rapat Baru</h2>
        <div class="card p-4">
            <form id="meetingForm" method="POST" onsubmit="return validateForm()">
                <div class="mb-3">
                    <label for="theme" class="form-label">Tema Rapat</label>
                    <input type="text" class="form-control" id="theme" name="theme" required>
                </div>
                <div class="mb-3">
                    <label for="meeting_date" class="form-label">Tanggal Rapat</label>
                    <input type="date" class="form-control" id="meeting_date" name="meeting_date" required>
                </div>
                <div class="mb-3">
                    <label for="meeting_time" class="form-label">Waktu Rapat</label>
                    <input type="time" class="form-control" id="meeting_time" name="meeting_time" required>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status Rapat</label>
                    <select class="form-control" id="status" name="status" required>
                        <option value="Online">Online</option>
                        <option value="Offline">Offline</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="attendees" class="form-label">Daftar Hadir (pisahkan dengan koma)</label>
                    <textarea class="form-control" id="attendees" name="attendees" rows="4" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="notes" class="form-label">Notulensi Rapat</label>
                    <textarea class="form-control" id="notes" name="notes" rows="6" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan Rapat</button>
            </form>
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
    <script src="scripts.js"></script>
</body>
</html>