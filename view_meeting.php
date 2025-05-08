<?php
session_start();
require 'config.php';

// Cek apakah pengguna sudah login dan peran
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$role = mysqli_fetch_assoc(mysqli_query($conn, "SELECT role FROM users WHERE id = " . $_SESSION['user_id']))['role'];

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

// Proses edit penuh (hanya Admin)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit']) && $role == 'Admin') {
    $theme = mysqli_real_escape_string($conn, $_POST['theme']);
    $meeting_date = $_POST['meeting_date'];
    $meeting_time = $_POST['meeting_time'];
    $status = $_POST['status'];
    $attendees = mysqli_real_escape_string($conn, $_POST['attendees']);
    $notes = mysqli_real_escape_string($conn, $_POST['notes']);
    $meeting_link = mysqli_real_escape_string($conn, $_POST['meeting_link']);
    $leader = mysqli_real_escape_string($conn, $_POST['leader']);
    $file_path = $meeting['file_path'];

    if (isset($_FILES['meeting_file']) && $_FILES['meeting_file']['error'] == 0) {
        $target_dir = "uploads/";
        if (!file_exists($target_dir)) mkdir($target_dir, 0777, true);
        $file_path = $target_dir . basename($_FILES['meeting_file']['name']);
        move_uploaded_file($_FILES['meeting_file']['tmp_name'], $file_path);
    }

    $query = "UPDATE meetings SET theme='$theme', meeting_date='$meeting_date', meeting_time='$meeting_time', status='$status', attendees='$attendees', notes='$notes', meeting_link='$meeting_link', file_path='$file_path', leader='$leader' WHERE id=$id";
    if (mysqli_query($conn, $query)) {
        $success = "Rapat berhasil diperbarui!";
        $meeting = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM meetings WHERE id = $id"));
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}

// Proses edit notulensi (semua pengguna)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_notes'])) {
    $notes = mysqli_real_escape_string($conn, $_POST['notes']);
    $query = "UPDATE meetings SET notes='$notes' WHERE id=$id";
    if (mysqli_query($conn, $query)) {
        $success = "Notulensi berhasil diperbarui!";
        $meeting = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM meetings WHERE id = $id"));
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}

// Proses hapus (hanya Admin)
if (isset($_GET['delete']) && $_GET['delete'] == 1 && $role == 'Admin') {
    $query = "DELETE FROM meetings WHERE id=$id";
    if (mysqli_query($conn, $query)) {
        if (file_exists($meeting['file_path'])) unlink($meeting['file_path']);
        header("Location: index.php");
        exit();
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
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

// Download Notulensi
if (isset($_GET['download_notes'])) {
    header('Content-Type: text/plain');
    header('Content-Disposition: attachment; filename="notulensi_' . $meeting['theme'] . '.txt"');
    echo $meeting['notes'];
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
                    <a class="nav-link" href="logout.php"><i class="fas fa-sign-out-alt me-1"></i>Logout (<?php echo htmlspecialchars($_SESSION['user_id']); ?>)</a>
                </div>
            </div>
        </div>
    </nav>

    <div class="container">
        <h2 class="my-4"><i class="fas fa-info-circle me-2"></i>Detail Rapat: <?php echo htmlspecialchars($meeting['theme']); ?></h2>
        <?php if (isset($success)) echo "<div class='alert alert-success alert-dismissible fade show' role='alert'><i class='fas fa-check-circle me-2'></i>$success <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>"; ?>
        <?php if (isset($error)) echo "<div class='alert alert-danger alert-dismissible fade show' role='alert'><i class='fas fa-exclamation-triangle me-2'></i>$error <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>"; ?>
        <div class="card p-4">
            <div class="card-body">
                <p><strong><i class="fas fa-tag me-2"></i>Tema:</strong> <?php echo htmlspecialchars($meeting['theme']); ?></p>
                <p><strong><i class="fas fa-user-tie me-2"></i>Pimpinan Rapat:</strong> <?php echo htmlspecialchars($meeting['leader']); ?></p>
                <p><strong><i class="fas fa-calendar-day me-2"></i>Tanggal:</strong> <?php echo date('d-m-Y', strtotime($meeting['meeting_date'])); ?></p>
                <p><strong><i class="fas fa-clock me-2"></i>Waktu:</strong> <?php echo htmlspecialchars($meeting['meeting_time']); ?></p>
                <p><strong><i class="fas fa-globe me-2"></i>Status:</strong> <?php echo htmlspecialchars($meeting['status']); ?></p>
                <?php if ($meeting['meeting_link']) echo "<p><strong><i class='fas fa-link me-2'></i>Link Rapat:</strong> <a href='" . htmlspecialchars($meeting['meeting_link']) . "' target='_blank'>" . htmlspecialchars($meeting['meeting_link']) . "</a></p>"; ?>
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
                <?php if ($meeting['file_path'] && file_exists($meeting['file_path'])) echo "<p><strong><i class='fas fa-file me-2'></i>Dokumen:</strong> <a href='" . htmlspecialchars($meeting['file_path']) . "' download class='btn btn-success btn-sm'>Unduh</a></p>"; ?>
                <div class="mt-3">
                    <a href="view_meeting.php?id=<?php echo $id; ?>&download=1" class="btn btn-success me-2"><i class="fas fa-download me-1"></i>Unduh Daftar Hadir (CSV)</a>
                    <a href="view_meeting.php?id=<?php echo $id; ?>&download_notes=1" class="btn btn-success me-2"><i class="fas fa-download me-1"></i>Unduh Notulensi (TXT)</a>
                    <?php if ($role == 'Admin'): ?>
                        <button type="button" class="btn btn-warning me-2" data-bs-toggle="modal" data-bs-target="#editModal"><i class="fas fa-edit me-1"></i>Edit Rapat</button>
                        <a href="view_meeting.php?id=<?php echo $id; ?>&delete=1" class="btn btn-danger me-2" onclick="return confirm('Yakin ingin menghapus rapat ini?')"><i class="fas fa-trash me-1"></i>Hapus</a>
                    <?php endif; ?>
                    <button type="button" class="btn btn-warning me-2" data-bs-toggle="modal" data-bs-target="#editNotesModal"><i class="fas fa-edit me-1"></i>Edit Notulensi</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Rapat (Admin) -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel"><i class="fas fa-edit me-2"></i>Edit Rapat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label for="theme" class="form-label">Tema Rapat</label>
                            <input type="text" class="form-control" id="theme" name="theme" value="<?php echo htmlspecialchars($meeting['theme']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="leader" class="form-label">Pimpinan Rapat</label>
                            <input type="text" class="form-control" id="leader" name="leader" value="<?php echo htmlspecialchars($meeting['leader']); ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="meeting_date" class="form-label">Tanggal Rapat</label>
                            <input type="date" class="form-control" id="meeting_date" name="meeting_date" value="<?php echo $meeting['meeting_date']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="meeting_time" class="form-label">Waktu Rapat</label>
                            <input type="time" class="form-control" id="meeting_time" name="meeting_time" value="<?php echo $meeting['meeting_time']; ?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status Rapat</label>
                            <select class="form-control" id="status" name="status" required>
                                <option value="Online" <?php echo $meeting['status'] == 'Online' ? 'selected' : ''; ?>>Online</option>
                                <option value="Offline" <?php echo $meeting['status'] == 'Offline' ? 'selected' : ''; ?>>Offline</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="meeting_link" class="form-label">Link Rapat (untuk Online)</label>
                            <input type="url" class="form-control" id="meeting_link" name="meeting_link" value="<?php echo htmlspecialchars($meeting['meeting_link']); ?>" placeholder="https://example.com">
                        </div>
                        <div class="mb-3">
                            <label for="attendees" class="form-label">Daftar Hadir (pisahkan dengan koma)</label>
                            <textarea class="form-control" id="attendees" name="attendees" rows="4" required><?php echo htmlspecialchars($meeting['attendees']); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="notes" class="form-label">Notulensi Rapat</label>
                            <textarea class="form-control" id="notes" name="notes" rows="6" required><?php echo htmlspecialchars($meeting['notes']); ?></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="meeting_file" class="form-label">Unggah Dokumen Baru (kosongkan jika tidak ingin ganti)</label>
                            <input type="file" class="custom-file-input" id="meeting_file" name="meeting_file" accept=".pdf,.doc,.docx">
                            <label for="meeting_file" class="custom-file-label"><i class="fas fa-upload"></i> Pilih File</label>
                        </div>
                        <button type="submit" name="edit" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan Perubahan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Notulensi (Semua Pengguna) -->
    <div class="modal fade" id="editNotesModal" tabindex="-1" aria-labelledby="editNotesModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editNotesModalLabel"><i class="fas fa-edit me-2"></i>Edit Notulensi</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label for="notes" class="form-label">Notulensi Rapat</label>
                            <textarea class="form-control" id="notes" name="notes" rows="6" required><?php echo htmlspecialchars($meeting['notes']); ?></textarea>
                        </div>
                        <button type="submit" name="edit_notes" class="btn btn-primary"><i class="fas fa-save me-1"></i>Simpan Perubahan</button>
                    </form>
                </div>
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