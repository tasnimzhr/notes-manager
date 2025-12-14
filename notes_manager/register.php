<?php
require 'db.php';
session_start();

$success = "";
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if ($fullname === "" || $email === "" || $password === "") {
        $error = "All fields are required!";
    } else {

       
        $check = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $check->execute([':email' => $email]);

        if ($check->rowCount() > 0) {
            $error = "Email already exists!";
        } else {

            
            $stmt = $pdo->prepare("
                INSERT INTO users (fullname, email, password, created_at)
                VALUES (:fn, :em, :pw, NOW())
            ");

            $stmt->execute([
                ':fn' => $fullname,
                ':em' => $email,
                ':pw' => $password
            ]);

            $success = "Registration successful! You may login now.";
        }
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register • Notes Manager</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons (eye icon) -->
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <link rel="stylesheet" href="/notes_manager/assets/style.css">
</head>

<body class="bg-gradient-primary d-flex justify-content-center align-items-center min-vh-100">

<div class="card shadow p-4 login-card">
    <h3 class="text-center mb-4">Register</h3>

    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert alert-success"><?php echo $success; ?></div>
    <?php endif; ?>

    <form method="POST">

        <label class="form-label">Full Name</label>
        <input type="text" name="fullname" class="form-control mb-3" required>

        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control mb-3" required>

        <label class="form-label">Password</label>

        <div class="input-group mb-3">
            <input type="password" name="password" id="regPassword"
                   class="form-control" placeholder="Enter password" required>
            <span class="input-group-text" id="toggleRegPassword" style="cursor:pointer;">
                <i class="bi bi-eye-slash" id="regEyeIcon"></i>
            </span>
        </div>

        <button class="btn btn-primary w-100">Register</button>
    </form>

    <p class="text-center mt-3">
        Already have an account? <a href="index.php" class="fw-bold">Login</a>
    </p>
</div>


<script>
document.getElementById('toggleRegPassword').addEventListener('click', function () {
    const passField = document.getElementById('regPassword');
    const icon = document.getElementById('regEyeIcon');

    if (passField.type === "password") {
        passField.type = "text";
        icon.classList.remove("bi-eye-slash");
        icon.classList.add("bi-eye");
    } else {
        passField.type = "password";
        icon.classList.remove("bi-eye");
        icon.classList.add("bi-eye-slash");
    }
});
</script>

</body>
</html>
