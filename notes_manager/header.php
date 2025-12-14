<?php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


if (empty($_SESSION['email'])) {
    header("Location: index.php");
    exit;
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Notes Manager</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/style.css">

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-light">

<!-- NAVBAR -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container-fluid">

        <!-- Brand -->
        <a class="navbar-brand fw-bold" href="dashboard.php">
            <i class="bi bi-journal-text me-1"></i>
            NotesManager
        </a>

        <!-- Mobile Toggle -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu -->
        <div class="collapse navbar-collapse" id="mainNavbar">

            <!-- Left Menu -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">
                        <i class="bi bi-speedometer2 me-1"></i> Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="notes-list.php">
                        <i class="bi bi-stickies-fill me-1"></i> Notes
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="categories.php">
                        <i class="bi bi-tags-fill me-1"></i> Categories
                    </a>
                </li>

            </ul>

            <!-- Right side -->
            <div class="d-flex align-items-center">

                <!-- Display logged in fullname -->
                <span class="navbar-text text-light me-3">
                    Hello, <strong><?php echo htmlspecialchars($_SESSION['user']); ?></strong>
                </span>

                <!-- Logout Button -->
                <a href="logout.php" class="btn btn-outline-light btn-sm">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </div>

        </div>
    </div>
</nav>

<!-- MAIN CONTENT WRAPPER -->
<div class="container py-4">
