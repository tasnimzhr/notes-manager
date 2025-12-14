<?php
session_start();
require 'db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = trim($_POST['email']);
    $passwordInput = trim($_POST['password']);

   
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :e");
    $stmt->execute([':e' => $email]);
    $user = $stmt->fetch();

    if ($user) {
        $dbPassword = $user['password'];
        $loginSuccess = false;

        
        if (strlen($dbPassword) > 20 && password_verify($passwordInput, $dbPassword)) {
            $loginSuccess = true;
        }

       
        if ($dbPassword === $passwordInput) { 
            $loginSuccess = true;
        }

        if ($loginSuccess) {
            $_SESSION['user'] = $user['fullname'];
            $_SESSION['email'] = $user['email'];

            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Invalid email or password.";
        }
    } else {
        $error = "Email not found.";
    }
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login • Notes Manager</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <!-- Bootstrap Icons (for eye icon) -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="/notes_manager/assets/style.css">

</head>

<body class="bg-gradient-primary d-flex align-items-center justify-content-center min-vh-100">

<div class="card shadow-lg login-card">
    <div class="card-body p-4 p-md-5">

        <h3 class="text-center mb-4 fw-bold">Notes Manager Login</h3>

        <?php if ($error): ?>
            <div class="alert alert-danger small"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="post" novalidate>

            <!-- EMAIL INPUT -->
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email"
                       class="form-control" placeholder="Enter email" required>
            </div>

            <!-- PASSWORD INPUT WITH EYE ICON -->
            <div class="mb-3">
                <label class="form-label">Password</label>

                <div class="input-group">
                    <input type="password" name="password" id="passwordField"
                           class="form-control" placeholder="Enter password" required>

                    <span class="input-group-text" id="togglePassword" style="cursor:pointer;">
                        <i class="bi bi-eye-slash" id="eyeIcon"></i>
                    </span>
                </div>
            </div>

            <button type="submit" class="btn btn-primary w-100 mt-2">Login</button>
        </form>

        <p class="text-center mt-3">
            <a href="register.php" class="register-link">Create an account</a>
        </p>

    </div>
</div>

<!-- PASSWORD SHOW/HIDE SCRIPT -->
<script>
document.getElementById('togglePassword').addEventListener('click', function () {
    const passwordField = document.getElementById('passwordField');
    const eyeIcon = document.getElementById('eyeIcon');

    if (passwordField.type === "password") {
        passwordField.type = "text";
        eyeIcon.classList.remove("bi-eye-slash");
        eyeIcon.classList.add("bi-eye");
    } else {
        passwordField.type = "password";
        eyeIcon.classList.remove("bi-eye");
        eyeIcon.classList.add("bi-eye-slash");
    }
});
</script>

</body>
</html>
