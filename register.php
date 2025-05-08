<?php
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $department = $_POST['department'];

    $query = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
    $result = mysqli_query($conn, $query);
    if (mysqli_num_rows($result) > 0) {
        $error = "Username atau email sudah terdaftar.";
    } else {
        $query = "INSERT INTO users (username, password, email, role, department) VALUES ('$username', '$password', '$email', 'Peserta', '$department')";
        if (mysqli_query($conn, $query)) {
            header("Location: login.php?success=Registrasi berhasil, silakan login.");
            exit();
        } else {
            $error = "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrasi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 form-container">
                <h2 class="my-4 text-center"><i class="fas fa-user-plus me-2"></i>Registrasi Akun</h2>
                <div class="card p-4">
                    <?php if (isset($error)) echo "<div class='alert alert-danger'><i class='fas fa-exclamation-triangle me-2'></i>$error</div>"; ?>
                    <form id="registerForm" method="POST" onsubmit="return validateRegisterForm()">
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="department" class="form-label">Bidang</label>
                            <select class="form-control" id="department" name="department" required>
                                <option value="">Pilih Bidang</option>
                                <option value="IT">IT</option>
                                <option value="Marketing">Marketing</option>
                                <option value="HR">HR</option>
                                <option value="Keuangan">Keuangan</option>
                                <option value="Produksi">Produksi</option>
                                <option value="Sales">Sales</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100"><i class="fas fa-user-plus me-1"></i>Daftar</button>
                        <p class="mt-3 text-center">Sudah punya akun? <a href="login.php">Login di sini</a></p>
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
    <script src="scripts.js"></script>
</body>
</html>