<?php $isLoggedIn = !empty($_SESSION['user'] ?? null); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📱 Phone Store</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<!-- Navbar -->
<nav class="navbar-modern navbar navbar-expand-lg">
    <div class="container-fluid px-3 px-lg-4">
        <a href="index.php" class="brand navbar-brand me-3">
            <i class="fas fa-mobile-alt"></i>
            <span>PhoneStore</span>
        </a>
        <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
            <ul class="navbar-nav align-items-lg-center gap-1">
                <?php if ($isLoggedIn): ?>
                    <li class="nav-item">
                        <a href="index.php" class="nav-link-custom nav-link">
                            <i class="fas fa-th-list"></i> All Products
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="create.php" class="nav-link-custom nav-link">
                            <i class="fas fa-plus-circle"></i> Add New
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="logout.php" class="nav-link-custom nav-link">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a href="login.php" class="nav-link-custom nav-link">
                            <i class="fas fa-sign-in-alt"></i> Login
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<main class="container-fluid px-3 px-lg-4 py-4">

<!-- Alert Messages -->
<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-modern alert-modern-success alert-dismissible fade show animate-in" role="alert">
        <i class="fas fa-check-circle me-2"></i> <?= $_SESSION['success'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-modern alert-modern-danger alert-dismissible fade show animate-in" role="alert">
        <i class="fas fa-exclamation-circle me-2"></i> <?= $_SESSION['error'] ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>